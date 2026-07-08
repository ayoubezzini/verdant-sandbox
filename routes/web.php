<?php

use App\Http\Controllers\DemoUsersController;
use Dennenboom\VerdantUI\Http\Controllers\TablePreferencesController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DemoUsersController::class, 'index'])->name('demo.users.index');
Route::get('/users/{user}/edit', [DemoUsersController::class, 'edit'])->name('demo.users.edit');
Route::put('/users/{user}', [DemoUsersController::class, 'update'])->name('demo.users.update');
Route::post('/users/bulk-update', [DemoUsersController::class, 'bulkUpdate'])->name('demo.users.bulk-update');
Route::post('/table-preferences/{key}', [TablePreferencesController::class, 'store'])->name('table-preferences.store');
