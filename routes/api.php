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

// Route::middleware(['auth.jwt'])->group(function () {
    
Route::group(['middleware' => 'JwtMiddleware'],function()
{
    // fetch files
    Route::get('/files', [FileController::class, 'index'])->name('files.index');
    
    // show an existing file
    Route::get('/files/{id}', [FileController::class, 'show'])->name('files.show');
    
    // store a new file
    Route::post('/files', [FileController::class, 'store'])->name('files.store');

    // update an existing file
    Route::post('/files/{id}', [FileController::class, 'update'])->name('files.update');

    // delete a file
    Route::delete('/files/{id}', [FileController::class, 'destroy'])->name('files.destroy');

});