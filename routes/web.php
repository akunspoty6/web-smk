<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\PpdbController;
use App\Http\Controllers\AuthController;

Route::get('/', [PortalController::class, 'index'])->name('home');
Route::post('/ppdb/register', [PpdbController::class, 'store'])->name('ppdb.store');
Route::get('/ppdb/check', [PpdbController::class, 'checkStatus'])->name('ppdb.check');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
