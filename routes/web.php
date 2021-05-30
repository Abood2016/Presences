<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\presencesController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get( '/presence', [presencesController::class, 'create'])->name('create-presences');
Route::post('/add-presences' ,   [presencesController::class,'store'])->name('add-presences');


Route::get('/employee',   [EmployeeController::class, 'index'])->name('employee.index')->middleware('auth');
Route::post( '/employee-store',   [EmployeeController::class, 'store'])->name('employee.store');
Route::post('/branch-store',   [EmployeeController::class, 'storeBranchToUser'])->name('branch.store');


Route::get('/login',   [LoginController::class, 'index'])->name('login');
Route::post('/login-store',   [LoginController::class, 'login'])->name('login.store');

