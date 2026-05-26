<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        $staffs = Staff::latest()->get();

        $totalStaff = Staff::count();
        $activeStaff = Staff::where('status', 'active')->count();
        $leaveStaff = Staff::where('status', 'leave')->count();

        return view('admin.staff.index', compact(
            'staffs',
            'totalStaff',
            'activeStaff',
            'leaveStaff'
        ));
    }

    public function create()
    {
        return view('admin.staff.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'role' => 'required',
            'salary' => 'required',
            'status' => 'required',
        ]);

        $staffNo = 'STF-' . rand(1000, 9999);

        Staff::create([
            'staff_no' => $staffNo,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'department' => $request->department,
            'experience' => $request->experience,
            'salary' => $request->salary,
            'status' => $request->status,
            'attendance' => $request->attendance,
            'address' => $request->address,
        ]);

        return redirect()
            ->route('admin.staff.index')
            ->with('success', 'Staff Created Successfully');
    }

    public function show($id)
    {
        $staff = Staff::findOrFail($id);

        return view('admin.staff.profile', compact('staff'));
    }

    public function edit($id)
    {
        $staff = Staff::findOrFail($id);

        return view('admin.staff.edit', compact('staff'));
    }

    public function update(Request $request, $id)
    {
        $staff = Staff::findOrFail($id);

        $staff->update($request->only([
            'name',
            'email',
            'phone',
            'role',
            'department',
            'experience',
            'salary',
            'status',
            'attendance',
            'address',
        ]));

        return redirect()
            ->route('admin.staff.index')
            ->with('success', 'Staff Updated Successfully');
    }

    public function destroy($id)
    {
        Staff::destroy($id);

        return redirect()
            ->route('admin.staff.index')
            ->with('success', 'Staff Deleted Successfully');
    }
}