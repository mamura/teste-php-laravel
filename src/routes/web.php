<?php

use App\Http\Controllers\DocumentsController;
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
Route::get('/', [DocumentsController::class, 'index'])->name('documents');
Route::post('files/upload', [DocumentsController::class, 'store'])->name('upload');