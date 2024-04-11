<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\PreferenceController;
use App\Http\Controllers\ThemeController;
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
  // Dashboard
  Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
  Route::get('/chart/{type}', [DashboardController::class, 'getChart'])->name('chart');

  // Theme
  Route::post('/theme/toggle', [ThemeController::class, 'toggle'])->name('theme.toggle');

  // Party views
  Route::get('/party/new/{game}', [PartyController::class, 'new'])->name('party.new');
  Route::get('/party/{id}', [PartyController::class, 'play'])->name('party.play');
  Route::get('/party/{id}/results', [PartyController::class, 'results'])->name('party.results');
  Route::get('/party/{id}/chart', [PartyController::class, 'getChart'])->name('chart.winner');

  // Party actions
  Route::post('/party', [PartyController::class, 'store'])->name('party.store');
  Route::post('/party/{id}/next', [PartyController::class, 'next'])->name('party.next');
  Route::post('/party/{id}/previous', [PartyController::class, 'previous'])->name('party.previous');
  Route::delete('/party/{id}/destroy', [PartyController::class, 'destroy'])->name('party.destroy');

  // Game views
  Route::get('/game', [GameController::class, 'index'])->name('game.index');
  Route::get('/game/create', [GameController::class, 'create'])->name('game.create');
  Route::get('/game/{id}/edit', [GameController::class, 'edit'])->name('game.edit');

  // Game actions
  Route::post('/game', [GameController::class, 'store'])->name('game.store');
  Route::post('/game/{id}', [GameController::class, 'update'])->name('game.update');
  Route::delete('/game/{id}/destroy', [GameController::class, 'destroy'])->name('game.destroy');

  // User views
  Route::get('/user', [UserController::class, 'index'])->name('user.index');
  Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
  Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
  Route::get('/user/{id}/detail', [UserController::class, 'detail'])->name('user.detail');
  Route::get('/user/get', [UserController::class, 'get'])->name('user.get');

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

  // Option views
  Route::get('/option', [OptionController::class, 'index'])->name('option.index');
  Route::get('/option/create', [OptionController::class, 'create'])->name('option.create');
  Route::get('/option/{id}/edit', [OptionController::class, 'edit'])->name('option.edit');

  // Option actions
  Route::post('/option', [OptionController::class, 'store'])->name('option.store');
  Route::post('/option/{id}', [OptionController::class, 'update'])->name('option.update');
  Route::delete('/option/{id}/destroy', [OptionController::class, 'destroy'])->name('option.destroy');
});