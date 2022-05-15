<?php

use App\Http\Controllers\FilesController;
use App\Http\Controllers\TransfersController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin'       => Route::has('login'),
        'canRegister'    => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion'     => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/files', [FilesController::class, 'show'])->name('admin.files.index');

    Route::prefix('transfers')
        ->as('transfers.')
        ->group(function () {
            Route::get('/store', [TransfersController::class, 'store'])->name('store');
            Route::get('/{transfer}', [TransfersController::class, 'edit'])->name('edit');
            Route::get('/{transfer}/files', [TransfersController::class, 'getFiles'])->name('files');
            Route::patch('/{transfer}', [TransfersController::class, 'update'])->name('update');
            Route::post('/{transfer}/upload', [FilesController::class, 'store'])->name('upload');
        });

    Route::prefix('files')
        ->as('files.')
        ->group(function () {
            Route::delete('/{file}', [FilesController::class, 'destroy'])->name('destroy');
        });
});
