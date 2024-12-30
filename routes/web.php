<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublishedPaperController;
use App\Http\Controllers\ScientistController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return redirect()->route('user.loginForm');
});

Route::get('/Login', [AuthController::class, 'showLoginForm'])->name('user.loginForm');
Route::post('/Login', [AuthController::class, 'login'])->name('user.login');

// User SignUp route(view and register)
Route::get('/User/SignUp', [AuthController::class, 'signUp'])->name('user.signUp');
Route::post('/User/register', [AuthController::class, 'register'])->name('user.register');

// Scientist SignUp route(view and register)
Route::get('/Scientist/SignUp', [ScientistController::class, 'signUp'])->name('scientist.signUp');
Route::post('/scientist/register', [ScientistController::class, 'register'])->name('scientist.register');

Route::middleware('user.authenticated')->group(function () {
    // Home route
    Route::get('/home', [ScientistController::class, 'home'])->name('scientist.home');

    // Published Papers route
    Route::get('/publishedPapers/search_PublishedPapersByTitle', [ScientistController::class, 'searchPublishedPapersByTitle'])->name('publishedpaper.search_title');
    Route::post('/publishedPapers/search_PublishedPapersByURL', [ScientistController::class, 'searchPublishedPapersByURL'])->name('publishedpaper.search_url');
    Route::post('/publishedPapers/save_PublishedPapers', [ScientistController::class, 'savePublishedPapers'])->name('publishedpaper.save');

    // WorkExp route
    Route::post('/scientist/create', [ScientistController::class, 'createWorkExp'])->name('workExp.create');

    // Education route
    Route::post('/education/create', [ScientistController::class, 'createEducation'])->name('education.create');

    // Project route
    Route::post('/project/create', [ScientistController::class, 'createProject'])->name('project.create');

    // Export CV route
    Route::get('/scientist/export/{id}', [ScientistController::class, 'exportCV'])->name('scientist.export');

    // Delete item
    Route::delete('/delete/{type}/{id}', [ScientistController::class, 'deleteItem'])->name('scientist.delete_item');

    // Logout
    Route::get('/Logout', [AuthController::class, 'logout'])->name('user.logout');

    // Update general info 
    Route::put('/scientist/update-general-info', [ScientistController::class, 'updateGeneralInfo'])->name('scientist.updateGeneralInfo');

});