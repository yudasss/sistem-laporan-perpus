<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanPerpusController;

Route::get('/', function () {
    return redirect('/perpus-laporan');
});

Route::prefix('perpus-laporan')->group(function () {
    Route::get('/', [LaporanPerpusController::class, 'index']);
    Route::get('/pdf', [LaporanPerpusController::class, 'exportPdf']);
    Route::get('/excel', [LaporanPerpusController::class, 'exportExcel']);
});