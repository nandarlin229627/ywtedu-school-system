<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class StudentAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $classes = SchoolClass::orderBy('class_name', 'asc')->get();
        $selectedClassId = $request->input('class_id');
        $attendanceDate = $request->input('date') ?? Carbon::today()->toDateString();

        $students = collect();
        $existingAttendance = collect();

        // Stat Card တွေအတွက် Default Value ကို 0 သတ်မှတ်ထားမယ်
        $presentCount = 0;
        $absentCount = 0;
        $lateCount = 0;
        $attendanceRate = 0;

        if ($selectedClassId) {
            // 🟢 စည်းကမ်းချက် - Active ဖြစ်နေတဲ့ ကျောင်းသားတွေကိုပဲ စစ်ထုတ်ယူမယ် (where status = active)
            $students = Student::whereHas('classes', function ($q) use ($selectedClassId) {
                $q->where('school_classes.id', $selectedClassId);
            })
            ->where('status', 'active') 
            ->orderBy('name', 'asc')
            ->get();

            if ($students->isNotEmpty()) {
                $existingAttendance = Attendance::whereIn(
                    'student_id',
                    $students->pluck('id')
                )
                ->where('date', $attendanceDate)
                ->get()
                ->keyBy('student_id');

                foreach ($students as $student) {
                    if ($existingAttendance->has($student->id)) {
                        $student->current_status = $existingAttendance[$student->id]->status;
                        $student->current_remark = $existingAttendance[$student->id]->remark;
                    } else {
                        // DB ထဲမှာ မရှိသေးရင် ဘာမှ Active မဖြစ်စေဘဲ null ပေးထားမယ်
                        $student->current_status = null;
                        $student->current_remark = '';
                    }
                }

                // ရွေးချယ်ထားတဲ့ Class & Date အလိုက် တကယ့် Count တွေကို စစ်ထုတ်တွက်ချက်မယ်
                $presentCount = $existingAttendance->where('status', 'Present')->count();
                $absentCount = $existingAttendance->where('status', 'Absent')->count();
                $lateCount = $existingAttendance->where('status', 'Late')->count();

                // Attendance Rate တွက်ချက်ခြင်း (%)
                $totalRecorded = $existingAttendance->count();
                if ($totalRecorded > 0) {
                    $attendanceRate = round((($presentCount + $lateCount) / $totalRecorded) * 100);
                } else {
                    $attendanceRate = 0;
                }
            }
        } // <-- if ($selectedClassId) အပိတ်

        // 🟢 တွန့်ကွင်းတည်နေရာကို ညှိလိုက်ပြီး return view ကို index function အထဲမှာပဲ မှန်မှန်ကန်ကန် ထားရှိပေးလိုက်ပါပြီ
        return view('admin.attendance.student', compact(
            'classes',
            'students',
            'selectedClassId',
            'attendanceDate',
            'existingAttendance',
            'presentCount',
            'absentCount',
            'lateCount',
            'attendanceRate'
        ));
    } // <-- index function အပိတ်

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'attendance' => 'nullable|array',
        ]);

        $date = $request->date;
        $teacherId = auth()->id();
        $remarks = $request->input('remark', []);

        if (!$request->has('attendance') || empty($request->attendance)) {
            return back()->with('error', 'Please select attendance status for students.');
        }

        foreach ($request->attendance as $studentId => $status) {
            if (!in_array($status, ['Present', 'Absent', 'Late'])) {
                continue;
            }

            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'date' => $date
                ],
                [
                    'status' => $status,
                    'remark' => $remarks[$studentId] ?? null,
                    'teacher_id' => $teacherId
                ]
            );
        }

        return back()->with('success', 'Attendance saved successfully.');
    }

    public function monthlyReport(Request $request)
    {
        $classes = SchoolClass::orderBy('class_name', 'asc')->get();
        $selectedClassId = $request->input('class_id');
        
        $selectedMonth = $request->input('month', Carbon::today()->format('Y-m'));
        
        $startOfMonth = Carbon::parse($selectedMonth . '-01')->startOfMonth();
        $endOfMonth = Carbon::parse($selectedMonth . '-01')->endOfMonth();
        
        $daysInMonth = CarbonPeriod::create($startOfMonth, $endOfMonth);

        $students = collect();
        $reportData = [];

        if ($selectedClassId) {
            $students = Student::whereHas('classes', function ($q) use ($selectedClassId) {
                $q->where('school_classes.id', $selectedClassId);
            })
            ->where('status', 'active') // 🟢 ဒီနေရာမှာလည်း active ကျောင်းသားပဲ ယူစေရန် ထည့်သွင်းထားပါတယ်
            ->orderBy('name', 'asc')
            ->get();

            $attendances = Attendance::whereIn('student_id', $students->pluck('id'))
                ->whereBetween('date', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
                ->get()
                ->groupBy('student_id');

            foreach ($students as $student) {
                $studentAttendances = $attendances->get($student->id, collect());
                
                $presentCount = $studentAttendances->where('status', 'Present')->count();
                $lateCount = $studentAttendances->where('status', 'Late')->count();
                $absentCount = $studentAttendances->where('status', 'Absent')->count();
                $totalRecorded = $studentAttendances->count();

                $percentage = 100;
                if ($totalRecorded > 0) {
                    $percentage = round((($presentCount + $lateCount) / $totalRecorded) * 100);
                }

                $reportData[$student->id] = [
                    'records' => $studentAttendances->keyBy('date'),
                    'present' => $presentCount,
                    'late' => $lateCount,
                    'absent' => $absentCount,
                    'percentage' => $percentage
                ];
            }
        }

        return view('admin.attendance.studentmonthly', compact(
            'classes',
            'students',
            'selectedClassId',
            'selectedMonth',
            'daysInMonth',
            'reportData'
        ));
    }
}