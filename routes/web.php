<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\ClassScheduleController;
use App\Http\Controllers\AcademicYearTermController;
use App\Http\Controllers\DesignationFacultyController;

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

Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::post('login', [UserController::class, 'login'])->name('login');
Route::post('logout', [UserController::class, 'logout'])->name('logout');
Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('manage-subjects', [SubjectController::class, 'index'])->name('manage-subjects');
    Route::get('show-subject/{subject}', [SubjectController::class, 'show'])->name('show-subject');
    Route::post('add-subject', [SubjectController::class, 'store'])->name('add-subject');
    Route::post('update-subject/{subject}', [SubjectController::class, 'update'])->name('update-subject');
    Route::post('delete-subject/{subject}', [SubjectController::class, 'destroy'])->name('delete-subject');

    Route::get('manage-rooms', [ClassroomController::class, 'index'])->name('manage-rooms');
    Route::post('add-room', [ClassroomController::class, 'store'])->name('add-room');
    Route::post('update-room/{classroom}', [ClassroomController::class, 'update'])->name('update-room');
    Route::post('delete-room/{classroom}', [ClassroomController::class, 'destroy'])->name('delete-room');

    Route::get('manage-faculty', [FacultyController::class, 'index'])->name('manage-faculty');
    Route::post('add-faculty', [FacultyController::class, 'store'])->name('add-faculty');
    Route::get('show-faculty/{faculty}/{academic_year_term?}', [FacultyController::class, 'show'])->name('show-faculty');
    Route::post('update-faculty/{faculty}', [FacultyController::class, 'update'])->name('update-faculty');
    Route::post('delete-faculty/{faculty}', [FacultyController::class, 'destroy'])->name('delete-faculty');

    Route::post('assign-designation/{faculty}/{academic_year_term}', [DesignationFacultyController::class, 'assignDesignation'])->name('assign-designation');
    Route::get('show-designation/{faculty}/{academic_year_term}', [DesignationFacultyController::class, 'showDesignation'])->name('show-designation');
    Route::post('remove-designation/{faculty}/{academic_year_term}/{designation}', [DesignationFacultyController::class, 'removeDesignation'])->name('remove-designation');

    Route::get('manage-designations', [DesignationController::class, 'index'])->name('manage-designations');
    Route::post('add-designation', [DesignationController::class, 'store'])->name('add-designation');

    Route::get('manage-admin', function () {
        return view('manage-admin');
    })->name('manage-admin');

    Route::get('schedule', [AcademicYearTermController::class, 'index'])->name('schedule');
    Route::post('create-academic-year-term', [AcademicYearTermController::class, 'store'])->name('create-academic-year-term');

    Route::get('create-schedule/{academic_year_term}', [ClassScheduleController::class, 'index'])->name('create-schedule');
    Route::post('create-class-schedule/{academic_year_term}', [ClassScheduleController::class, 'openClasses'])->name('open-classes');
    Route::post('assign-classes/{faculty}', [ClassScheduleController::class, 'assignClassSchedulesToFaculty'])->name('assign-classes');
    Route::post('unassign-class/{classSchedule}', [ClassScheduleController::class, 'unAssignClassScheduleFromFaculty'])->name('unassign-class');
    Route::get('show-faculty-load/{faculty}/{academicYearTerm}', [ClassScheduleController::class, 'show'])->name('show-faculty-load');
    Route::post('assign-time-room-day/{classSchedule}', [ClassScheduleController::class, 'assignTimeRoomDay'])->name('assign-time-room-day');
    Route::post('update-load-type/{classSchedule}', [ClassScheduleController::class, 'updateLoadType'])->name('update-load-type');
    Route::post('delete-time-room-day/{classSchedule}', [ClassScheduleController::class, 'deleteAssignedTimeRoomDay'])->name('delete-time-room-day');
    Route::post('update-student-count/{classSchedule}', [ClassScheduleController::class, 'updateNumberOfStudents'])->name('update-student-count');

    Route::post('export-plotted-schedule/{academic_year_term}', [ExportController::class, 'exportPlottedSchedule'])->name('export-plotted-schedule');
    Route::post('view-pdf/{faculty}/{academicYearTerm}', [ExportController::class, 'viewPDF'])->name('view-pdf');
});
