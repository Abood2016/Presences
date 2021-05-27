<?php

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

Route::get( '/create-presences', [presencesController::class, 'create'])->name('create-presences');
Route::post('/add-presences' ,   [presencesController::class,'store'])->name('add-presences');