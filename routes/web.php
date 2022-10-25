<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\OpenId\OpenIdController;
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

// OPENID
Route::get('realms/{realm}', [OpenIdController::class, 'issuer'])->name('openid.realm_issuer');
Route::get('realms/{realm}/.well-known/openid-configuration', [OpenIdController::class, 'wellKnown'])->name('openid.well_known');
Route::get('realms/{realm}/protocol/openid-connect/auth', fn () => '')->name('openid.auth');
Route::get('realms/{realm}/protocol/openid-connect/token', fn () => '')->name('openid.token');
Route::get('realms/{realm}/protocol/openid-connect/userinfo', fn () => '')->name('openid.userinfo');
