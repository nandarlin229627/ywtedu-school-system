<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\SchoolClass; // change if your model name is different

class TeacherController extends Controller
{
    public function dashboard()
    {
        $totalStudents = Student::count();
        $totalClasses = SchoolClass::count();

        $todayClasses = SchoolClass::whereDate('created_at', now()->toDateString())->count();

        return view('teacher.dashboard', compact(
            'totalStudents',
            'totalClasses',
            'todayClasses'
        ));
    }
}