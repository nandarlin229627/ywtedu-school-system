<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * READ (All Students Directory with filters)
     */
    public function index(Request $request)
    {
        $classes = SchoolClass::all();
        $query = Student::with('classes');

        // Search Engine matching Name or Registration Numbers
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('student_no', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Dropdown Grade Filtering
        $selectedGrade = 'All Grades';
        if ($request->filled('grade')) {
            $selectedGrade = $request->grade;
            $query->where('grade', 'LIKE', "%{$selectedGrade}%");
        }

        $students = $query->latest()->paginate(10)->appends($request->query());

        // Platform Summary Counters
        $stats = Student::select(
            DB::raw('COUNT(*) as total'),
            DB::raw("SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active"),
            DB::raw("SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending"),
            DB::raw("SUM(CASE WHEN status = 'inactive' THEN 1 ELSE 0 END) as inactive")
        )->first();

        $currentGradeName = $request->filled('grade') ? $request->grade : 'Grade 10';

        // Right-Sidebar Structural Context Metrics
        $gradeStats = Student::where('grade', 'LIKE', "%{$currentGradeName}%")
            ->select(
                DB::raw('COUNT(*) as total_count'),
                DB::raw("SUM(CASE WHEN gender = 'Male' THEN 1 ELSE 0 END) as male_count"),
                DB::raw("SUM(CASE WHEN gender = 'Female' THEN 1 ELSE 0 END) as female_count")
            )->first();

        $sections = SchoolClass::where('class_name', 'LIKE', "%{$currentGradeName}%")
            ->withCount('students')
            ->get();

        return view('admin.students.index', [
            'students'           => $students,
            'classes'            => $classes,
            'totalStudents'      => $stats->total ?? 0,
            'activeStudents'     => $stats->active ?? 0,
            'pendingStudents'    => $stats->pending ?? 0,
            'inactiveStudents'   => $stats->inactive ?? 0,
            'selectedGrade'      => $selectedGrade,
            'gradeTotalStudents' => $gradeStats->total_count ?? 0,
            'gradeMales'         => $gradeStats->male_count ?? 0,
            'gradeFemales'       => $gradeStats->female_count ?? 0,
            'currentGradeName'   => $currentGradeName,
            'sections'           => $sections,
        ]);
    }

    /**
     * CREATE (Display Form View)
     */
    public function create()
    {
        $classes = SchoolClass::all();
        return view('admin.students.create', compact('classes'));
    }

    /**
     * STORE (Insert New Entry)
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:students,email|unique:users,email',
            'grade'      => 'required|string',
            'class_id'   => 'nullable|exists:school_classes,id',
            'password'   => 'required|min:6',
        ]);

        $fullName = trim($request->first_name . ' ' . $request->last_name);
        $password = Hash::make($request->password);

        DB::transaction(function () use ($request, $fullName, $password) {
            $student = Student::create(array_merge($request->all(), [
                'name'       => $fullName,
                'password'   => $password,
                'student_no' => $request->student_no ?? 'STU-' . strtoupper(uniqid()),
            ]));

            User::create([
                'name'     => $fullName,
                'email'    => $request->email,
                'password' => $password,
                'role'     => 'student'
            ]);

            if ($request->class_id) {
                $student->classes()->attach($request->class_id);
            }
        });

        return redirect()->route('admin.students.index')->with('success', 'Student created successfully.');
    }

    /**
     * SHOW (Profile Viewer JSON Output)
     */
    public function show($id)
    {
        $student = Student::with('classes')->findOrFail($id);
        return response()->json(['success' => true, 'data' => $student]);
    }

    /**
     * EDIT (Display Data Populate Form View)
     */
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $classes = SchoolClass::all();
        return view('admin.students.edit', compact('student', 'classes'));
    }

    /**
     * UPDATE (Save Modifications)
     */
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        
        // Find corresponding user account to ignore its own record in validation rules
        $user = User::where('email', $student->getOriginal('email'))->first();
        $userId = $user ? $user->id : 'NULL';

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:students,email,' . $student->id . '|unique:users,email,' . $userId,
            'grade'      => 'required|string',
            'class_id'   => 'nullable|exists:school_classes,id',
        ]);

        $fullName = trim($request->first_name . ' ' . $request->last_name);
        
        DB::transaction(function () use ($request, $student, $fullName) {
            $student->update(array_merge($request->all(), [
                'name' => $fullName
            ]));

            // Synchronize linked login account details
            User::where('email', $student->getOriginal('email'))->update([
                'name'  => $fullName,
                'email' => $request->email
            ]);

            if ($request->has('class_id')) {
                $student->classes()->sync($request->class_id ? [$request->class_id] : []);
            }
        });

        return redirect()->route('admin.students.index')->with('success', 'Student profile updated successfully.');
    }

    /**
     * DESTROY (Removes Entity and safely redirects back)
     */
    public function destroy($id)
    {
        $student = Student::findOrFail($id);

        DB::transaction(function () use ($student) {
            // Delete associated user authentication table details
            if ($student->email) {
                User::where('email', $student->email)->delete();
            }

            // Decouple pivot relationships before structural item deletion
            $student->classes()->detach();
            $student->delete();
        });

        return redirect()->route('admin.students.index')
            ->with('success', 'Student record deleted successfully.');
    }
}