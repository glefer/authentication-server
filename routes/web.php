<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\RealmController;
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

require __DIR__.'/auth.php';

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('realms', RealmController::class);
    Route::scopeBindings()->resource('realms.clients', ClientController::class);

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
