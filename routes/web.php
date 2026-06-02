<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KnnController;
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [KnnController::class, 'index'])->name('knn.index');
    Route::post('/data-training/import', [KnnController::class, 'importTraining'])->middleware('role:admin')->name('knn.training.import');
    Route::post('/prediksi', [KnnController::class, 'predict'])->middleware('role:siswa')->name('knn.predict');
    Route::get('/flowchart', [KnnController::class, 'flowchart'])->name('knn.flowchart');
});
