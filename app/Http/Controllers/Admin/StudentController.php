<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class StudentController extends Controller
{
    /**
     * ==============================
     * STUDENT LIST
     * ==============================
     */
    public function index(Request $request)
    {
        $classes = SchoolClass::all();

        $query = Student::with('classes');

        // Search
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('student_no', 'LIKE', "%{$search}%");

            });
        }

        // Filter By Grade
        $selectedGrade = 'All Grades';

        if ($request->filled('grade') && $request->grade !== 'All Grades') {

            $selectedGrade = trim($request->grade);

            $query->where('grade', $selectedGrade);
        }

        $students = $query
            ->latest()
            ->paginate(10)
            ->appends($request->query());

        // Dashboard Statistics
        $stats = Student::select(
            DB::raw('COUNT(*) as total'),
            DB::raw("SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active"),
            DB::raw("SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending"),
            DB::raw("SUM(CASE WHEN status = 'inactive' THEN 1 ELSE 0 END) as inactive")
        )->first();

        // Grade Statistics
        if ($selectedGrade !== 'All Grades') {

            $gradeStats = Student::where('grade', $selectedGrade)
                ->select(
                    DB::raw('COUNT(*) as total_count'),
                    DB::raw("SUM(CASE WHEN LOWER(gender) = 'male' THEN 1 ELSE 0 END) as male_count"),
                    DB::raw("SUM(CASE WHEN LOWER(gender) = 'female' THEN 1 ELSE 0 END) as female_count")
                )
                ->first();

            $sections = SchoolClass::where('class_name', $selectedGrade)
                ->withCount('students')
                ->get();

        } else {

            $gradeStats = Student::select(
                DB::raw('COUNT(*) as total_count'),
                DB::raw("SUM(CASE WHEN LOWER(gender) = 'male' THEN 1 ELSE 0 END) as male_count"),
                DB::raw("SUM(CASE WHEN LOWER(gender) = 'female' THEN 1 ELSE 0 END) as female_count")
            )->first();

            $sections = SchoolClass::withCount('students')->get();
        }

        $statuses = ['active', 'pending', 'inactive'];

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

            'currentGradeName'   => $selectedGrade,

            'sections'           => $sections,

            'statuses'           => $statuses
        ]);
    }

    /**
     * ==============================
     * CREATE PAGE
     * ==============================
     */
    public function create()
    {
        $classes = SchoolClass::all();

        return view('admin.students.create', compact('classes'));
    }

    /**
     * ==============================
     * STORE STUDENT
     * ==============================
     */
    public function store(Request $request)
    {
        $request->validate([

            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',

            'email'      => 'required|email|unique:students,email|unique:users,email',

            'class_id'   => 'required|exists:school_classes,id',

            'password'   => 'required|min:6',

            'photo'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Full Name
        $fullName = trim(
            $request->first_name . ' ' . $request->last_name
        );

        // Password Hash
        $password = Hash::make($request->password);

        // Selected Class
        $class = SchoolClass::find($request->class_id);

        $gradeName = $class ? $class->class_name : null;

        // Upload Photo
        $photoPath = null;

        if ($request->hasFile('photo')) {

            $file = $request->file('photo');

            $filename = time() . '_' . uniqid() . '.' .
                $file->getClientOriginalExtension();

            $file->move(
                public_path('uploads/students'),
                $filename
            );

            $photoPath = 'uploads/students/' . $filename;
        }

        // Generate Student Number
        if ($request->filled('student_no')) {

            $studentNo = $request->student_no;

        } else {

            $lastStudent = Student::where(
                'student_no',
                'LIKE',
                'STU-%'
            )->latest()->first();

            if ($lastStudent) {

                $lastNumber = (int) str_replace(
                    'STU-',
                    '',
                    $lastStudent->student_no
                );

                $nextNumber = $lastNumber + 1;

            } else {

                $nextNumber = 1;
            }

            $studentNo = 'STU-' .
                str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        }

        DB::transaction(function () use (
            $request,
            $fullName,
            $password,
            $photoPath,
            $studentNo,
            $gradeName
        ) {

            // Create User
            $user = User::create([

                'name'     => $fullName,
                'email'    => $request->email,
                'password' => $password,
                'role'     => 'student',
            ]);

            // Create Student
            $student = Student::create([

                'user_id' => $user->id,

                'name' => $fullName,

                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,

                'email' => $request->email,
                'phone' => $request->phone,

                'dob'    => $request->dob,
                'gender' => $request->gender,

                'address' => $request->address,

                'guardian_name'  => $request->guardian_name,
                'relationship'   => $request->relationship,
                'guardian_phone' => $request->guardian_phone,
                'guardian_email' => $request->guardian_email,

                'previous_school' => $request->previous_school,

                'student_no' => $studentNo,

                'password' => $password,

                'photo' => $photoPath,

                'grade' => $gradeName,

                'status' => 'active',
            ]);

            // Attach Class
            $student->classes()->attach($request->class_id);
        });

        return redirect()
            ->route('admin.students.index')
            ->with(
                'success',
                'Student enrolled successfully.'
            );
    }
public function show($id)
{
    $student = Student::with(['classes', 'user'])->findOrFail($id);

    // Wrapping in 'data' makes the JS 'response.data' work perfectly
    return response()->json([
        'data' => [
            'id' => $student->id,
            'name' => $student->name,
            'student_no' => $student->student_no,
            'email' => $student->email,
            'phone' => $student->phone,
            'gender' => $student->gender,
            'dob' => $student->dob,
            'address' => $student->address,
            'status' => $student->status,
            'grade' => $student->grade,
            'photo' => $student->photo,
            'classes' => $student->classes,
            'guardian_name' => $student->guardian_name,
            'guardian_phone' => $student->guardian_phone,
        ]
    ]);
}
    /**
     * ==============================
     * EDIT PAGE
     * ==============================
     */
    public function edit($id)
    {
        $student = Student::with('classes')
            ->findOrFail($id);

        $classes = SchoolClass::all();

        return view(
            'admin.students.edit',
            compact('student', 'classes')
        );
    }

    /**
     * ==============================
     * UPDATE STUDENT
     * ==============================
     */
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $request->validate([

            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',

            'email' => 'required|email|unique:students,email,' .
                $student->id .
                '|unique:users,email,' .
                $student->user_id,

            'class_id' => 'required|exists:school_classes,id',

            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $fullName = trim(
            $request->first_name . ' ' . $request->last_name
        );

        $class = SchoolClass::find($request->class_id);

        $gradeName = $class ? $class->class_name : null;

        $data = [

            'name' => $fullName,

            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,

            'email' => $request->email,
            'phone' => $request->phone,

            'dob'    => $request->dob,
            'gender' => $request->gender,

            'address' => $request->address,

            'guardian_name'  => $request->guardian_name,
            'relationship'   => $request->relationship,
            'guardian_phone' => $request->guardian_phone,
            'guardian_email' => $request->guardian_email,

            'previous_school' => $request->previous_school,

            'grade' => $gradeName,
        ];

        // Update Photo
        if ($request->hasFile('photo')) {

            if (
                $student->photo &&
                file_exists(public_path($student->photo))
            ) {
                @unlink(public_path($student->photo));
            }

            $file = $request->file('photo');

            $filename = time() . '_' . uniqid() . '.' .
                $file->getClientOriginalExtension();

            $file->move(
                public_path('uploads/students'),
                $filename
            );

            $data['photo'] = 'uploads/students/' . $filename;
        }

        DB::transaction(function () use (
            $student,
            $data,
            $request,
            $fullName
        ) {

            // Update Student
            $student->update($data);

            // Update User
            if ($student->user_id) {

                User::where(
                    'id',
                    $student->user_id
                )->update([

                    'name'  => $fullName,
                    'email' => $request->email
                ]);
            }

            // Sync Class
            $student->classes()->sync([
                $request->class_id
            ]);
        });

        return redirect()
            ->route('admin.students.index')
            ->with(
                'success',
                'Student updated successfully.'
            );
    }

    /**
     * ==============================
     * DELETE STUDENT
     * ==============================
     */
    public function destroy(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        // Delete Photo
        if (
            $student->photo &&
            file_exists(public_path($student->photo))
        ) {
            @unlink(public_path($student->photo));
        }

        DB::transaction(function () use ($student) {

            // Delete User
            if ($student->user_id) {
                User::where(
                    'id',
                    $student->user_id
                )->delete();
            }

            // Detach Classes
            $student->classes()->detach();

            // Delete Student
            $student->delete();
        });

        // Redirect back to index with existing query parameters (search, grade, etc.)
        return redirect()
            ->route('admin.students.index', $request->query())
            ->with(
                'success',
                'Student deleted successfully.'
            );
    }
    /**
     * ==============================
     * UPDATE STATUS
     * ==============================
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([

            'status' => 'required|in:active,pending,inactive'
        ]);

        try {

            $student = Student::findOrFail($id);

            $student->update([
                'status' => $request->status
            ]);

            return response()->json([

                'success' => true,

                'message' =>
                    'Student status updated successfully.'
            ]);

        } catch (\Exception $e) {

            return response()->json([

                'success' => false,

                'message' =>
                    'Something went wrong: ' .
                    $e->getMessage()

            ], 500);
        }
    }
}