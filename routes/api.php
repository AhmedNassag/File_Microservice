<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

 // fetch files
 Route::get('/files', [FileController::class, 'index'])->name('files.index');

 // store a new file
 Route::post('/files', [FileController::class, 'store'])->name('files.store');

 // update an existing file
 Route::post('/files/{id}', [FileController::class, 'update'])->name('files.update');

 // delete a file
 Route::delete('/files/{id}', [FileController::class, 'destroy'])->name('files.destroy');

