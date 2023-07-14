<?php

use App\Http\Controllers\ChildController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [ChildController::class, 'index'])->name('children.index');
Route::post('/', [ChildController::class, 'store'])->name('children.store');
Route::delete('/children/{child}', [ChildController::class, 'destroy'])->name('children.destroy');

// Route::post('/', function(){
//     return view()
// });
