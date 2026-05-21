<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TeacherController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LIST TEACHERS
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = Teacher::with('user');

        // SEARCH BY NAME
        if ($request->search) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        // FILTER BY STATUS
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $teachers = $query->latest()->paginate(10);

        return view('admin.teachers.index', [
            'teachers'       => $teachers,
            'totalTeachers'  => Teacher::count(),
            'activeTeachers' => Teacher::where('status', 'active')->count(),
            'leaveTeachers'  => Teacher::where('status', 'leave')->count(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW CREATE FORM
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $subjects = Subject::all();

        return view('admin.teachers.create', compact('subjects'));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE TEACHER
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'teacher_no'    => 'required|string|unique:teachers,teacher_no',
            'phone'         => 'nullable|string|max:20',
            'qualification' => 'nullable|string|max:255',
            'hire_date'     => 'required|date',
            'salary'        => 'nullable|numeric|min:0',
            'subjects'      => 'nullable|array',
            'subjects.*'    => 'exists:subjects,id',
        ]);

        /*
        |--------------------------------------------------------------------------
        | CREATE USER ACCOUNT
        |--------------------------------------------------------------------------
        */
        $password = Str::random(8);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($password),
            'role'     => 'teacher',
        ]);

        /*
        |--------------------------------------------------------------------------
        | CREATE TEACHER
        |--------------------------------------------------------------------------
        */
        $teacher = Teacher::create([
            'user_id'       => $user->id,
            'teacher_no'    => $request->teacher_no,
            'phone'         => $request->phone,
            'qualification' => $request->qualification,
            'hire_date'     => $request->hire_date,
            'salary'        => $request->salary ?? 0,
            'status'        => 'active',
        ]);

        /*
        |--------------------------------------------------------------------------
        | ATTACH SUBJECTS
        |--------------------------------------------------------------------------
        */
        $teacher->subjects()->sync($request->subjects ?? []);

        return redirect()
            ->route('teachers.index')
            ->with('success', 'Teacher created successfully!');
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW EDIT FORM
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $teacher = Teacher::with('user', 'subjects')->findOrFail($id);

        $subjects = Subject::all();

        return view('admin.teachers.edit', compact('teacher', 'subjects'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE TEACHER
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);

        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $teacher->user_id,
            'teacher_no'    => 'required|string|unique:teachers,teacher_no,' . $teacher->id,
            'phone'         => 'nullable|string|max:20',
            'qualification' => 'nullable|string|max:255',
            'hire_date'     => 'required|date',
            'salary'        => 'nullable|numeric|min:0',
            'status'        => 'required|in:active,leave,inactive',
            'subjects'      => 'nullable|array',
            'subjects.*'    => 'exists:subjects,id',
        ]);

        /*
        |--------------------------------------------------------------------------
        | UPDATE USER
        |--------------------------------------------------------------------------
        */
        $teacher->user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        /*
        |--------------------------------------------------------------------------
        | UPDATE TEACHER
        |--------------------------------------------------------------------------
        */
        $teacher->update([
            'teacher_no'    => $request->teacher_no,
            'phone'         => $request->phone,
            'qualification' => $request->qualification,
            'hire_date'     => $request->hire_date,
            'salary'        => $request->salary ?? 0,
            'status'        => $request->status,
        ]);

        /*
        |--------------------------------------------------------------------------
        | UPDATE SUBJECTS
        |--------------------------------------------------------------------------
        */
        $teacher->subjects()->sync($request->subjects ?? []);

        return redirect()
            ->route('teachers.index')
            ->with('success', 'Teacher updated successfully!');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE TEACHER
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);

        // DELETE SUBJECT RELATION
        $teacher->subjects()->detach();

        // DELETE USER
        if ($teacher->user) {
            $teacher->user->delete();
        }

        // DELETE TEACHER
        $teacher->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Teacher deleted successfully!',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | TEACHER PROFILE
    |--------------------------------------------------------------------------
    */
    public function profile($id)
    {
        $teacher = Teacher::with('user', 'subjects')->findOrFail($id);

        return view('admin.teachers.profile', compact('teacher'));
    }
}