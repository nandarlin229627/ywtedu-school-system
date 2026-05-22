<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolClass;
use App\Models\Teacher;
use App\Models\Room;

class SchoolClassController extends Controller
{
    public function index()
    {
        $classes = SchoolClass::with(['teacher', 'room'])->latest()->get();

        return view('admin.classes.index', compact('classes'));
    }

    public function create()
    {
        // IMPORTANT
        $teachers = Teacher::latest()->get();
        $rooms = Room::latest()->get();

        return view('admin.classes.create', compact('teachers', 'rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_name' => 'required',
            'teacher_id' => 'nullable',
            'room_id' => 'nullable',
        ]);

        SchoolClass::create([
            'class_name' => $request->class_name,
            'teacher_id' => $request->teacher_id,
            'room_id' => $request->room_id,
        ]);

        return redirect()->route('admin.classes.index')
            ->with('success', 'Class Created Successfully');
    }

    public function edit(SchoolClass $class)
    {
        $teachers = Teacher::latest()->get();
        $rooms = Room::latest()->get();

        return view('admin.classes.edit', compact('class', 'teachers', 'rooms'));
    }

    public function update(Request $request, SchoolClass $class)
    {
        $class->update([
            'class_name' => $request->class_name,
            'teacher_id' => $request->teacher_id,
            'room_id' => $request->room_id,
        ]);

        return redirect()->route('admin.classes.index')
            ->with('success', 'Class Updated Successfully');
    }

    public function destroy(SchoolClass $class)
    {
        $class->delete();

        return back()->with('success', 'Deleted Successfully');
    }
}