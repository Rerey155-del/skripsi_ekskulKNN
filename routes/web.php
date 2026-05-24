<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KnnController;

Route::get('/', [KnnController::class, 'index'])->name('knn.index');
Route::get('/flowchart', [KnnController::class, 'flowchart'])->name('knn.flowchart');
