<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Timetable;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
class TimetableController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | TIMETABLE LIST
    |--------------------------------------------------------------------------
    */

   public function index(Request $request)
{
    $query = Timetable::with([
        'teacher.user',
        'subject',
        'schoolClass'   // ✅ FIXED (NO classRoom)
    ]);

    if ($request->class_id) {
        $query->where('class_id', $request->class_id);
    }

    if ($request->teacher_id) {
        $query->where('teacher_id', $request->teacher_id);
    }

    $timetables = $query->get();

    $teachers = Teacher::with('user')->get();
    $classes = SchoolClass::all();

    return view('admin.timetables.index', compact(
        'timetables',
        'teachers',
        'classes'
    ));
}

    /*
    |--------------------------------------------------------------------------
    | CREATE FORM
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $teachers = Teacher::with('user')->get();

        $subjects = Subject::all();

        $classes = SchoolClass::all();

        return view('admin.timetables.create', compact(
            'teachers',
            'subjects',
            'classes'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

       
    public function store(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required',
            'class_id'   => 'required',
            'subject_id' => 'required',
            'day'        => 'required',
            'time'       => 'required',
        ]);

        // 🔴 CONFLICT CHECK
        if (!Timetable::isTeacherAvailable(
            $request->teacher_id,
            $request->day,
            $request->time
        )) {
            return back()->with('error', '❌ Teacher is already busy in this time slot!');
        }

        Timetable::create($request->all());

        return redirect()
            ->route('admin.timetables.index')
            ->with('success', '✅ Timetable created successfully!');
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $timetable = Timetable::findOrFail($id);

        $teachers = Teacher::with('user')->get();

        $subjects = Subject::all();

        $classes = SchoolClass::all();

        return view('admin.timetables.edit', compact(
            'timetable',
            'teachers',
            'subjects',
            'classes'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

        public function update(Request $request, $id)
    {
        $request->validate([
            'teacher_id' => 'required',
            'class_id'   => 'required',
            'subject_id' => 'required',
            'day'        => 'required',
            'time'       => 'required',
        ]);

        // 🔴 CONFLICT CHECK (ignore current record)
        if (!Timetable::isTeacherAvailable(
            $request->teacher_id,
            $request->day,
            $request->time,
            $id
        )) {
            return back()->with('error', '❌ Teacher already assigned to this slot!');
        }

        $timetable = Timetable::findOrFail($id);
        $timetable->update($request->all());

        return redirect()
            ->route('admin.timetables.index')
            ->with('success', '✅ Timetable updated successfully!');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        Timetable::destroy($id);

        return back()
            ->with('success', 'Deleted successfully');
    }

        public function availableSlots(Request $request)
    {
        $allSlots = [
            '09:00 - 09:45',
            '09:45 - 10:30',
            '10:30 - 11:15',
            '11:15 - 12:00',
            '12:00 - 01:45',
            '01:45 - 02:30',
            '02:30 - 03:15',
            '03:15 - 04:00',
        ];

        $classBusy = Timetable::where('class_id', $request->class_id)
            ->where('day', $request->day)
            ->pluck('time')
            ->toArray();

        $teacherBusy = Timetable::where('teacher_id', $request->teacher_id)
            ->where('day', $request->day)
            ->pluck('time')
            ->toArray();

        // ❌ REMOVE CONFLICT TIMES
        $available = array_values(array_diff($allSlots, $classBusy, $teacherBusy));

        return response()->json($available);
    }
}