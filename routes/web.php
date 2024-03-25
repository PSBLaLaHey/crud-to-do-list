<?php

use App\Http\Controllers\C_todo;
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

Route::resource('/', C_todo::class);
Route::delete('/todo/{td_id}',[C_todo::class,'destroy']);
Route::put('/todo/{td_id}',[C_todo::class,'update']);
