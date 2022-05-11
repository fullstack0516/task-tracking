<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::middleware(['web', 'guest'])->group(function () {
    Route::get('/clients/{uuid}', \App\Http\Livewire\Clients\Overview::class)->name('clients.overview');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::prefix('clients')->name('clients.')->group(function () {
        Route::get('/', \App\Http\Livewire\Clients\Index::class)->name('index');
        Route::get('/{client}/view', \App\Http\Livewire\Clients\Show::class)->name('show');
    });

    Route::prefix('time-entries')->name('time-entries.')->group(function () {
        Route::get('/{client?}', \App\Http\Livewire\TimeEntries\Index::class)->name('index');
    });

    Route::prefix('projects')->name('projects.')->group(function () {
        Route::get('/', \App\Http\Livewire\Projects\Index::class)->name('index');
        Route::get('/{project}/overview', \App\Http\Livewire\Projects\Overview::class)->name('overview');
    });

    Route::prefix('crm')->name('crm.')->group(function () {
        Route::get('/', \App\Http\Livewire\Crm\Dashboard::class)->name('dashboard');

        Route::prefix('prospects')->name('prospects.')->group(function () {
            Route::get('/', \App\Http\Livewire\Crm\Prospects\Index::class)->name('index');
            Route::get('/{prospect}', \App\Http\Livewire\Crm\Prospects\Show::class)->name('show');
        });
    });

    Route::prefix('credentials')->name('credentials.')->group(function () {
        Route::get('/', \App\Http\Livewire\Credentials\Index::class)->name('index');
    });
});
