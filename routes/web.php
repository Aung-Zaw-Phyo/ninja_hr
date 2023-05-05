<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;

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


Auth::routes(['register' => false]);

Route::middleware(['auth'])->group(function () {
    Route::get('/', [PagesController::class, 'home'])->name('home');

    Route::resource('employee', EmployeeController::class);
    Route::get('employee/datatable/ssd', [EmployeeController::class, 'ssd']);

    Route::resource('department', DepartmentController::class);
    Route::get('department/datatable/ssd', [DepartmentController::class, 'ssd']);


    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile.profile');
});