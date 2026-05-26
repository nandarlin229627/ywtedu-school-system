<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\TimetableController;
use App\Http\Controllers\Admin\ParentController;
use App\Http\Controllers\Admin\TeacherAttendanceController;
use App\Http\Controllers\Admin\StudentAttendanceController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\SchoolClassController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Parent\DashboardController as ParentDashboardController;
use App\Http\Controllers\Admin\StaffController;

// Public Frontpage
Route::get('/', function () {
    return view('welcome');
});

// Authentication System
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// Authenticated Application Shell
Route::middleware(['auth'])->group(function () {

    // General Fallback Dashboard & Profiles
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Role-Based Portals (Teacher & Parent)
    Route::get('/teacher/dashboard', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');
    Route::get('/parent/dashboard', [ParentDashboardController::class, 'index'])->name('parent.dashboard');

    // Global Features (Attendance & Utilities)
    Route::get('/teacher-attendance', [TeacherAttendanceController::class, 'index'])->name('teacher.attendance');
    Route::post('/teacher-attendance/store', [TeacherAttendanceController::class, 'store'])->name('teacher.attendance.store');
    Route::get('/student-attendance', [StudentAttendanceController::class, 'index'])->name('student.attendance');
    Route::post('/student-attendance/store', [StudentAttendanceController::class, 'store'])->name('student.attendance.store');
    Route::post('/student-attendance/ajax-save', [StudentAttendanceController::class, 'ajaxStore'])->name('student.attendance.ajax');

    Route::get('/parents/profile/{id}', [ParentController::class, 'profile'])->name('parents.profile');

    /*
    |--------------------------------------------------------------------------
    | Admin Management Operations Area
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->group(function () {
        
       Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // STAFF MANAGEMENT
        Route::resource('staff', StaffController::class);


        // Administration Core Resources
        Route::resource('teachers', TeacherController::class);
        Route::get('/teachers/{id}/profile', [TeacherController::class, 'profile'])->name('teachers.profile');
        Route::get('/teacher/{id}/subjects', [TeacherController::class, 'getSubjects'])->name('teachers.subjects');

        // --- FIXED: Single definition for Students ---
        Route::resource('students', StudentController::class);
        Route::patch('students/{id}/update-status', [StudentController::class, 'updateStatus'])
            ->name('students.update-status');
        // ----------------------------------------------

        Route::resource('subjects', SubjectController::class);
        Route::resource('rooms', RoomController::class);
        Route::resource('classes', SchoolClassController::class);

        // Timetable Management System
        Route::resource('timetables', TimetableController::class);
        Route::get('/timetables/frame', [TimetableController::class, 'frame'])->name('timetables.frame');
        Route::get('/timetable/available-slots', [TimetableController::class, 'availableSlots'])->name('timetables.slots');

        // Admin Profile Management
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

        // Student Attendance Sub-System for Admin
        Route::prefix('attendance')->name('attendance.')->group(function() {
            Route::get('/', [StudentAttendanceController::class, 'index']); 
            Route::get('/student', [StudentAttendanceController::class, 'index'])->name('index');
            Route::post('/student', [StudentAttendanceController::class, 'store'])->name('store');
        Route::get('/studentmonthly', [StudentAttendanceController::class, 'monthlyReport'])->name('studentmonthly');

        //teacher
        Route::get('/teacher', [TeacherAttendanceController::class, 'index'])->name('teacher.index');
            Route::post('/teacher', [TeacherAttendanceController::class, 'store'])->name('teacher.store');
        });
            });
        });

require __DIR__.'/auth.php';