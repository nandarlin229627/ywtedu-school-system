<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Attendance;

class StudentAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $today = date('Y-m-d');

        $query = Student::with('user');

        // 🔍 Filter by class
        if ($request->class_id) {
            $query->where('class_id', $request->class_id);
        }

        // 🔍 Search by name
        if ($request->search) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $students = $query->get();

        $attendances = Attendance::whereDate('date', $today)
            ->whereNotNull('student_id')
            ->get()
            ->keyBy('student_id');

        // 📊 COUNTS
        $present = $attendances->where('status', 'Present')->count();
        $absent  = $attendances->where('status', 'Absent')->count();
        $late    = $attendances->where('status', 'Late')->count();

        return view('admin.attendance.student', compact(
            'students',
            'attendances',
            'today',
            'present',
            'absent',
            'late'
        ));
    }


        public function monthly(Request $request)
    {
        $month = $request->month ?? date('Y-m');

        $attendances = Attendance::where('date', 'like', $month . '%')
            ->whereNotNull('student_id')
            ->with('student.user')
            ->get();

        return view('admin.attendance.monthly', compact('attendances', 'month'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'attendance' => 'required|array',
        ]);

        foreach ($request->attendance as $studentId => $status) {

            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'date' => $request->date,
                ],
                [
                    'status' => $status,
                ]
            );
        }

        return redirect()->back()->with('success', 'Student Attendance Saved');
    }
}