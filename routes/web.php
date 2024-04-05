<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PictureController;
use App\Http\Controllers\PreferenceController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UserController;

// Login
Route::get('/login', function () {
  return view('auth.login');
})->name('login');

// Logout
Route::get('/logout', function () {
  return view('auth.login');
})->name('logout');

// Auth
Route::controller(AuthController::class)->group(function () {
  Route::post('/login', 'login');
  Route::post('/logout', 'logout');
});

Route::middleware(['auth'])->group(function () {
  // Upload
  Route::post('/upload/pictures', [UploadController::class, 'pictures'])->name('upload.pictures');
  Route::get('/picture/{id}', [PictureController::class, 'src'])->name('picture.src');

  // Dashboard
  Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
  Route::get('/chart/{type}', [DashboardController::class, 'getChart'])->name('chart');

  // Theme
  Route::post('/theme/toggle', [ThemeController::class, 'toggle'])->name('theme.toggle');

  // User views
  Route::get('/user', [UserController::class, 'index'])->name('user.index');
  Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
  Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
  Route::get('/user/{id}/detail', [UserController::class, 'detail'])->name('user.detail');

  // User actions
  Route::post('/user', [UserController::class, 'store'])->name('user.store');
  Route::post('/user/{id}', [UserController::class, 'update'])->name('user.update');
  Route::delete('/user/{id}/destroy', [UserController::class, 'destroy'])->name('user.destroy');

  // Preference views
  Route::get('/preference', [PreferenceController::class, 'index'])->name('preference.index');
  Route::get('/preference/create', [PreferenceController::class, 'create'])->name('preference.create');
  Route::get('/preference/{id}/edit', [PreferenceController::class, 'edit'])->name('preference.edit');

  // Preference actions
  Route::post('/preference', [PreferenceController::class, 'store'])->name('preference.store');
  Route::post('/preference/{id}', [PreferenceController::class, 'update'])->name('preference.update');
  Route::delete('/preference/{id}/destroy', [PreferenceController::class, 'destroy'])->name('preference.destroy');
});
