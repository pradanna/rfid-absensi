<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ScheduleSubjectController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::redirect('/', '/login');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');



Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard']);
    Route::get('/admin', [AdminController::class, 'dashboard']);

    Route::get('/attendance', [AttendanceController::class, 'index']);
    Route::get('/datatable-dashboard', [AttendanceController::class, 'datatableDashboard']);


    Route::get('/classroom', [ClassroomController::class, 'index'])->name('admin.classroom.index');
    Route::post('/classroom', [ClassroomController::class, 'store'])->name('admin.classroom.store');
    Route::put('/classroom/{id}', [ClassroomController::class, 'update'])->name('admin.classroom.update');
    Route::delete('/classroom/{id}', [ClassroomController::class, 'destroy'])->name('admin.classroom.destroy');

    Route::get('/subjects', [SubjectController::class, 'index'])->name('admin.subject.index');
    Route::post('/subjects', [SubjectController::class, 'store'])->name('admin.subject.store');
    Route::put('/subjects/{id}', [SubjectController::class, 'update'])->name('admin.subject.update');
    Route::delete('/subjects/{id}', [SubjectController::class, 'destroy'])->name('admin.subject.destroy');


    Route::get('/students', [StudentController::class, 'index'])->name('admin.student.index');
    Route::post('/students', [StudentController::class, 'store'])->name('admin.student.store');
    Route::put('/students/{id}', [StudentController::class, 'update'])->name('admin.student.update');
    Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('admin.student.destroy');

    Route::get('/teacher', [TeacherController::class, 'index'])->name('admin.teacher.index');
    Route::post('/teacher', [TeacherController::class, 'store'])->name('admin.teacher.store');
    Route::put('/teacher/{id}', [TeacherController::class, 'update'])->name('admin.teacher.update');
    Route::delete('/teacher/{id}', [TeacherController::class, 'destroy'])->name('admin.teacher.destroy');

    Route::get('/schedule-subjects', [ScheduleSubjectController::class, 'index'])->name('admin.schedule.index');
    Route::post('/schedule-subjects', [ScheduleSubjectController::class, 'store'])->name('admin.schedule.store');
    Route::put('/schedule-subjects/{id}', [ScheduleSubjectController::class, 'update'])->name('admin.schedule.update');
    Route::delete('/schedule-subjects/{id}', [ScheduleSubjectController::class, 'destroy'])->name('admin.schedule.destroy');

    Route::get('/attendances', [AttendanceController::class, 'index'])->name('admin.attendances.index');

    Route::get('/admin/attendance/export', [AttendanceController::class, 'export'])->name('admin.attendance.export');
});

Route::middleware(['auth', 'role:teacher'])->group(function () {
    Route::get('/dashboard/guru', function () {
        return view('guru.dashboard');
    })->middleware(['auth', 'role:teacher']);
});
