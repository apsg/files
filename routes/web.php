<?php

use App\Http\Controllers\FilesController;
use App\Http\Controllers\AdminTransfersController;
use App\Http\Controllers\TransfersController;
use App\Http\Middleware\CheckForExpiredTransferMiddleware;
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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])
    ->as('admin.')
    ->group(function () {
        Route::get('/dashboard', function () {
            return Inertia::render('Dashboard');
        })->name('dashboard');

        Route::get('/files', [FilesController::class, 'show'])->name('files.index');

        Route::prefix('transfers')
            ->as('transfers.')
            ->group(function () {
                Route::get('/store', [AdminTransfersController::class, 'store'])->name('store');
                Route::get('/{transfer}', [AdminTransfersController::class, 'edit'])->name('edit');
                Route::get('/{transfer}/files', [AdminTransfersController::class, 'getFiles'])->name('files');
                Route::patch('/{transfer}', [AdminTransfersController::class, 'update'])->name('update');
                Route::post('/{transfer}/upload', [FilesController::class, 'store'])->name('upload');
            });

        Route::prefix('files')
            ->as('files.')
            ->group(function () {
                Route::delete('/{file}', [FilesController::class, 'destroy'])->name('destroy');
            });
    });

Route::as('transfers.')
    ->middleware([
        CheckForExpiredTransferMiddleware::class,
    ])
    ->prefix('/t')
    ->group(function () {
        Route::get('/{transfer:hash}', [TransfersController::class, 'show'])->name('show');
        Route::post('/{transfer:hash}/verify', [TransfersController::class, 'verify'])->name('verify');
        Route::get('//{transfer:hash}/d/{file}', [TransfersController::class, 'download'])->name('download');
    });
