<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Attendance;
use Carbon\Carbon;

class TeacherAttendanceController extends Controller
{
    public function index(Request $request)
    {
        // Request မှ ရက်စွဲကိုယူမည်၊ မပါလျှင် ယနေ့ရက်စွဲကို Default ယူမည်
        $attendanceDate = $request->input('date') ?? Carbon::today()->toDateString();

        // 🟢 စည်းကမ်းချက် - Status 'active' ဖြစ်ပြီး User Data ပါရှိသော ဆရာ/ဆရာမများကိုသာ ယူမည်
        $teachers = Teacher::with('user')
            ->where('status', 'active')
            ->get();

        $existingAttendance = collect();
        
        $presentCount = 0;
        $absentCount = 0;
        $lateCount = 0;
        $attendanceRate = 0;

        if ($teachers->isNotEmpty()) {
            // ရွေးချယ်ထားသော ရက်စွဲရှိ ဆရာ/ဆရာမများ၏ Attendance ကို ဆွဲထုတ်ခြင်း
            $existingAttendance = Attendance::whereIn('teacher_id', $teachers->pluck('id'))
                ->where('date', $attendanceDate)
                ->get()
                ->keyBy('teacher_id');

            foreach ($teachers as $teacher) {
                if ($existingAttendance->has($teacher->id)) {
                    $teacher->current_status = $existingAttendance[$teacher->id]->status;
                    $teacher->current_remark = $existingAttendance[$teacher->id]->remark;
                } else {
                    // စစ်ဆေးခြင်းမပြုရသေးပါက Null အဖြစ် ထားရှိမည်
                    $teacher->current_status = null;
                    $teacher->current_remark = '';
                }
            }

            // Stat Cards များအတွက် အရေအတွက် တွက်ချက်ခြင်း
            $presentCount = $existingAttendance->where('status', 'Present')->count();
            $absentCount = $existingAttendance->where('status', 'Absent')->count();
            $lateCount = $existingAttendance->where('status', 'Late')->count();

            $totalRecorded = $existingAttendance->count();
            if ($totalRecorded > 0) {
                $attendanceRate = round((($presentCount + $lateCount) / $totalRecorded) * 100);
            }
        }

        return view('admin.attendance.teacher', compact(
            'teachers',
            'attendanceDate',
            'presentCount',
            'absentCount',
            'lateCount',
            'attendanceRate'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'attendance' => 'nullable|array',
        ]);

        $date = $request->date;
        $adminId = auth()->id(); // စစ်ဆေးပေးသော Admin ID
        $remarks = $request->input('remark', []);

        if (!$request->has('attendance') || empty($request->attendance)) {
            return back()->with('error', 'Please select attendance status for teachers.');
        }

        foreach ($request->attendance as $teacherId => $status) {
            if (!in_array($status, ['Present', 'Absent', 'Late'])) {
                continue;
            }

            Attendance::updateOrCreate(
                [
                    'teacher_id' => $teacherId,
                    'date' => $date
                ],
                [
                    'status' => $status,
                    'remark' => $remarks[$teacherId] ?? null,
                    'user_id' => $adminId // DB Design အလိုက် ပြောင်းလဲနိုင်သည် (e.g. checked_by)
                ]
            );
        }

        return back()->with('success', 'Teacher attendance saved successfully.');
    }
}