<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobCategoryController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



Route::middleware('auth')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Companies
    Route::resource('companies', CompanyController::class); // Make sure the controller name matches the route in views
    Route::put('companies/{id}/restore', [CompanyController::class, 'restore'])->name('companies.restore');
    // Route::put('companies/{id}/update', [CompanyController::class, 'update'])->name('companies.update');


    // Job Applications
    Route::resource('job-applications', JobApplicationController::class);

    // Job Categories
    Route::resource('job-categories', JobCategoryController::class);
    Route::put('job-categories/{id}/restore', [JobCategoryController::class, 'restore'])->name('job-categories.restore');

    // Job Vacancies
    Route::resource('job-vacancies', JobVacancyController::class);

    // Users
    Route::get('/users', [UserController::class, 'index'])->name('user.index');



    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
