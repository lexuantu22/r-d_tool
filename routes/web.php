<?php

use App\Http\Controllers\ExcelController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ExcelController::class, 'showForm']);
Route::post('/upload-excel', [ExcelController::class, 'generateTestReport'])->name('report.export');
