<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if (!$user) {
            return redirect('/login');
        }

        return match ($user->role) {

            // ADMIN DASHBOARD
            'admin' => view('admin.index', [

                'students' => User::where('role', 'student')->count(),

                'teachers' => User::where('role', 'teacher')->count(),

                'parents' => User::where('role', 'parent')->count(),

                'staffs' => User::where('role', 'staff')->count(),

            ]),

            // TEACHER DASHBOARD
            'teacher' => view('teacher.index'),

            // STUDENT DASHBOARD
            'student' => view('student.index'),

            // PARENT DASHBOARD
            'parent' => view('parent.index'),

            default => abort(403),
        };
    }
}