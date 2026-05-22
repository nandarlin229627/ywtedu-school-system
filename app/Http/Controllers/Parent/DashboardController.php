<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\ParentModel; // your parents table model

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/login');
        }

        // STEP 1: find parent row from users.id
        $parent = \App\Models\ParentModel::where('user_id', $user->id)->first();

        if (!$parent) {
            return view('parent.index', ['students' => collect()]);
        }

        // STEP 2: get students using parents.id
        $students = Student::with(['attendances', 'marks', 'schoolClass'])
            ->where('parent_id', $parent->id)
            ->get();

        return view('parent.index', compact('students'));
    }
}