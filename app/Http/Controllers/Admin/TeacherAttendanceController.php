<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Teacher;
use App\Models\Attendance;

class TeacherAttendanceController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with('user')->get();

        $today = date('Y-m-d');

        $attendances = Attendance::whereDate('date', $today)
            ->whereNotNull('teacher_id')
            ->get();

        return view('admin.attendance.teacher', compact(
            'teachers',
            'attendances',
            'today'
        ));
    }

    public function store(Request $request)
    {
        foreach ($request->attendance as $teacherId => $status) {

            Attendance::updateOrCreate(

                [
                    'teacher_id' => $teacherId,
                    'date' => $request->date,
                ],

                [
                    'status' => $status,
                ]

            );
        }

        return redirect()
            ->back()
            ->with('success', 'Teacher Attendance Saved');
    }
}