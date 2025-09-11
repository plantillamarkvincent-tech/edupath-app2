<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\EnrollmentRequestController;
use App\Http\Controllers\Admin\AdminEnrollmentRequestController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProgramController;
use App\Http\Controllers\Admin\AdminStudentController;
use App\Http\Controllers\Admin\AdminCourseController;

Route::get('/', [CareerController::class, 'landing'])->name('landing');

Route::get('/career', [CareerController::class, 'index'])->name('career.index');
Route::get('/career/{program}', [CareerController::class, 'show'])->name('career.show');

Route::get('/enroll/{program}', [EnrollmentRequestController::class, 'create'])->name('enrollment.create');
Route::post('/enroll', [EnrollmentRequestController::class, 'store'])->name('enrollment.store');

Route::get('/dashboard', function () {
	return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/student/dashboard', [App\Http\Controllers\StudentController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('student.dashboard');

Route::middleware('auth')->group(function () {
	Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
	Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
	Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Admin routes
Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/enrollment-requests', [AdminEnrollmentRequestController::class, 'index'])->name('enrollment_requests.index');
    Route::get('/enrollment-requests/{enrollmentRequest}', [AdminEnrollmentRequestController::class, 'show'])->name('enrollment_requests.show');
    Route::post('/enrollment-requests/{enrollmentRequest}/approve', [AdminEnrollmentRequestController::class, 'approve'])->name('enrollment_requests.approve');
    Route::post('/enrollment-requests/{enrollmentRequest}/reject', [AdminEnrollmentRequestController::class, 'reject'])->name('enrollment_requests.reject');
    Route::post('/enrollment-requests/bulk-action', [AdminEnrollmentRequestController::class, 'bulkAction'])->name('enrollment_requests.bulk_action');

    // Programs management
    Route::get('/programs', [AdminProgramController::class, 'index'])->name('programs.index');
    Route::get('/programs/create', [AdminProgramController::class, 'create'])->name('programs.create');
    Route::post('/programs', [AdminProgramController::class, 'store'])->name('programs.store');
    Route::get('/programs/{program}/edit', [AdminProgramController::class, 'edit'])->name('programs.edit');
    Route::put('/programs/{program}', [AdminProgramController::class, 'update'])->name('programs.update');
    Route::delete('/programs/{program}', [AdminProgramController::class, 'destroy'])->name('programs.destroy');

    // Students management
    Route::get('/students', [AdminStudentController::class, 'index'])->name('students.index');

    // Courses management (disabled)
});
