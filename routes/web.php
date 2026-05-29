<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KnnController;

Route::get('/', [KnnController::class, 'index'])->name('knn.index');
Route::post('/data-training/import', [KnnController::class, 'importTraining'])->name('knn.training.import');
Route::post('/prediksi', [KnnController::class, 'predict'])->name('knn.predict');
Route::get('/flowchart', [KnnController::class, 'flowchart'])->name('knn.flowchart');
