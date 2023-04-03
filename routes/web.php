<?php

use App\Util\KeyCloak;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (\Illuminate\Support\Facades\Auth::guest()) {
        return redirect()->route('login');
    }

    return redirect()->route('dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('admin')->group(function () {
        Route::get('campaigns', \App\Http\Livewire\Admin\Campaigns::class)->name('campaigns');
        Route::get('campaigns/{campaign}/managers', \App\Http\Livewire\Admin\Managers::class)->name('campaigns.managers');

        Route::get('logs', \App\Http\Livewire\Admin\Logs::class)->name('logs');
    });

    Route::get('campaigns/{campaign}/students', \App\Http\Livewire\Students::class)->name('campaigns.students');
    Route::get('campaigns/{campaign}/groups', \App\Http\Livewire\Groups::class)->name('campaigns.groups');
});

Route::get('/test', function () {
    $config = config('keycloak.baseurl');

    dd($config);
});
