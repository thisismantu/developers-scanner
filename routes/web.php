<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

Route::Redirect('/','dashboard');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');



    Route::prefix('manage')->group(function(){

        Route::resource('users',UserController::class);
        Route::get('project-mapping',[UserController::class,'projectMapping'])->name('projectMapping');
        Route::post('project-mapping-update/{id}',[UserController::class,'projectMappingUpdate'])->name('project-mapping.update');

        

    });

    Route::resource('companies',CompanyController::class);
    Route::resource('projects',ProjectController::class);
    Route::get('projects-scaning/{id}',[ProjectController::class,'Scanning'])->name('projects.scaning');

    


});

require __DIR__.'/auth.php';
require __DIR__.'/inertia.php';
