<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageCaptureController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'checkRole:user',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::post('/image/upload', [ImageCaptureController::class, 'upload'])->name('image.upload');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'checkRole:admin',
])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin_dashboard');
    })->name('admin.dashboard');
});
