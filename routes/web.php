<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\EvidenceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get("/",[HomeController::class, 'welcome'])->name("welcome");



Auth::routes();
Route::middleware(['auth','user-role:user'])->group(function()
{
    Route::get("/home",[HomeController::class, 'userHome'])->name("home");
    Route::get('/create-data', [UserController::class, 'createData'])->name('create.data');
    Route::post('/create-data', [UserController::class, 'storeData'])->name('data');
    Route::get('/data', [UserController::class, 'showData'])->name('data.user');
    Route::get('/data/{evidence}/download/image', [UserController::class, 'downloadImage'])->name('data.download.image');
    Route::get('/data/{evidence}/download/pdf', [UserController::class, 'downloadPDF'])->name('data.download.pdf');
});

Route::middleware(['auth','user-role:admin'])->group(function()
{
    Route::get("/admin/dashboard",[HomeController::class, 'adminHome'])->name("admin.home");
    Route::resource('/admin/evidence', EvidenceController::class);
    Route::get('/files/{filename}', [FileController::class, 'show'])->name('files.show');
    Route::get('/admin/verif', [ProjectController::class, 'verif'])->name('admin.verif'); 
    Route::get('projects/status', [ProjectController::class, 'status'])->name('projects.status');
    Route::get('projects/pending', [ProjectController::class, 'pending'])->name('projects.pending');
    Route::get('projects/invalid', [ProjectController::class, 'invalid'])->name('projects.invalid');
    Route::get('/evidence/{evidence}/download/image', [EvidenceController::class, 'downloadImage'])->name('evidence.download.image');
    Route::get('/evidence/{evidence}/download/pdf', [EvidenceController::class, 'downloadPDF'])->name('evidence.download.pdf');
    
});

