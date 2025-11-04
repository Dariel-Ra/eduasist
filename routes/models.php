<?php

use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\SchoolController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Schools routes
    Route::resource('schools', SchoolController::class);
    
    // Academic Years routes
    Route::resource('academic-years', AcademicYearController::class);
    Route::post('academic-years/{academicYear}/set-current', [AcademicYearController::class, 'setCurrent'])
        ->name('academic-years.set-current');
    
    // Courses routes
    Route::resource('courses', CourseController::class);
    Route::post('courses/{course}/toggle-active', [CourseController::class, 'toggleActive'])
        ->name('courses.toggle-active');
});