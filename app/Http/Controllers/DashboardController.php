<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\ParentModel;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/login');
        }

        return match ($user->role) {

            'admin' => view('admin.index', [
                'students' => User::where('role', 'student')->count(),
                'teachers' => User::where('role', 'teacher')->count(),
                'parents'  => User::where('role', 'parent')->count(),
                'staffs'   => User::where('role', 'staff')->count(),
            ]),

            'teacher' => view('teacher.index'),

            'student' => view('student.index'),

            // ✅ PARENT DASHBOARD FIXED
            'parent' => (function () use ($user) {

                $parent = ParentModel::where('user_id', $user->id)->first();

                if (!$parent) {
                    return view('parent.index', [
                        'students' => collect()
                    ]);
                }

                $students = Student::with([
                        'attendances',
                        'classes',
                        'results'
                    ])
                    ->where('parent_id', $parent->id)
                    ->get();

                return view('parent.index', compact('students'));

            })(),

            default => abort(403),
        };
    }
}