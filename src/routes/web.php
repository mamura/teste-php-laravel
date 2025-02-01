<?php

use App\Http\Controllers\ImportsController;
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
Route::get('/', [ImportsController::class, 'index'])->name('index');
Route::post('files/upload', [ImportsController::class, 'store'])->name('upload');
Route::post('queue/process', [ImportsController::class, 'process'])->name('process-queue');
Route::get('queue/show', [ImportsController::class, 'show'])->name('show');
Route::get('queue/logs', [ImportsController::class, 'logs'])->name('logs');