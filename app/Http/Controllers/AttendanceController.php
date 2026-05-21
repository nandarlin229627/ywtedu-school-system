<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with('student', 'teacher')
                        ->latest()
                        ->get();

        return view('attendance.index', compact('attendances'));
    }

    public function create()
    {
        $students = Student::all();
        $teachers = Teacher::all();

        return view('attendance.create', compact('students', 'teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'nullable|exists:students,id',
            'teacher_id' => 'nullable|exists:teachers,id',
            'date' => 'required|date',
            'status' => 'required',
        ]);

        Attendance::create([
            'student_id' => $request->student_id,
            'teacher_id' => $request->teacher_id,
            'date' => $request->date,
            'status' => $request->status,
        ]);

        return redirect()->route('attendance.index')
            ->with('success', 'Attendance Added Successfully');
    }
}