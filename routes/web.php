<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\TimetableController; // ✅ Added Timetable Controller
use App\Http\Controllers\Admin\ParentController;
use App\Http\Controllers\Admin\TeacherAttendanceController;
use App\Http\Controllers\Admin\StudentAttendanceController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/logout', function (Request $request) {

    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');

})->name('logout');

// Teacher dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/teacher/dashboard', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');
});

// Main dashboard + profile
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

// Teacher CRUD + profile
Route::middleware(['auth'])->group(function () {

    Route::resource('teachers', TeacherController::class);

    Route::get('/teachers/{id}/profile', [TeacherController::class, 'profile'])->name('teachers.profile');
});

// Admin routes
Route::prefix('admin')->middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Teacher routes
    Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers.index');
    Route::post('/teachers', [TeacherController::class, 'store'])->name('teachers.store');
    Route::delete('/teachers/{id}', [TeacherController::class, 'destroy'])->name('teachers.destroy');

     // ✅ Timetable Routes
    Route::resource('timetables', TimetableController::class);
    Route::get('/timetables/frame', [TimetableController::class, 'frame'])->name('timetables.frame');
    
    
   

});


Route::middleware(['auth'])->group(function () {

    Route::resource('timetables', TimetableController::class);

});

Route::resource('parents', ParentController::class);

Route::get('/parents/profile/{id}',
    [ParentController::class, 'profile'])
    ->name('parents.profile');

/*
|--------------------------------------------------------------------------
| Teacher Attendance
|--------------------------------------------------------------------------
*/

Route::get('/teacher-attendance',
    [TeacherAttendanceController::class, 'index'])
    ->name('teacher.attendance');

Route::post('/teacher-attendance/store',
    [TeacherAttendanceController::class, 'store'])
    ->name('teacher.attendance.store');

/*
|--------------------------------------------------------------------------
| Student Attendance
|--------------------------------------------------------------------------
*/

/*
|-----------------------------------------
| Student Attendance
|-----------------------------------------
*/

Route::get('/student-attendance', 
    [StudentAttendanceController::class, 'index']
)->name('student.attendance');

Route::post('/student-attendance/store', 
    [StudentAttendanceController::class, 'store']
)->name('student.attendance.store');

Route::post('/student-attendance/ajax-save', 
    [StudentAttendanceController::class, 'ajaxStore']
)->name('student.attendance.ajax');


Route::prefix('admin')->middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'show'])
        ->name('admin.profile');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])
        ->name('admin.profile.edit');

    Route::patch('/profile/update', [ProfileController::class, 'update'])
        ->name('admin.profile.update');

});

require __DIR__.'/auth.php';