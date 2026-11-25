<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BiodataController;

Route::get('/', [BiodataController::class, 'index'])->name('home');

Route::post('/biodata', [BiodataController::class, 'store'])
    ->name('biodata.store');

Route::put('/biodata/{biodata}', [BiodataController::class, 'update'])
    ->name('biodata.update');

Route::delete('/biodata/{biodata}', [BiodataController::class, 'destroy'])
    ->name('biodata.destroy');

require __DIR__.'/settings.php';