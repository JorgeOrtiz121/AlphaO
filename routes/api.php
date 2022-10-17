<?php

use App\Http\Controllers\Account\AvatarController;
use App\Http\Controllers\Account\ProfileController;
use App\Http\Controllers\Banner\BannerController;
use App\Http\Controllers\Contactanos\ContactanosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('alpha')->group(function ()
{
    require __DIR__ . '/auth.php';
    Route::middleware(['auth:sanctum'])->group(function ()
    {
        // Se hace uso de grupo de rutas
        Route::prefix('profile')->group(function ()
        {
            Route::controller(ProfileController::class)->group(function ()
            {
                Route::get('/', 'show')->name('profile');
                Route::post('/', 'store')->name('profile.store');
            });
            Route::controller(AvatarController::class)->group(function()
            {
                Route::post('/avatar','store')->name('profile.avatar');
            });
        });

        
        Route::prefix("banner")->group(function ()
        {
            Route::controller(BannerController::class)->group(function () {
                Route::get('/fotos', 'index');
                Route::post('/create', 'store');
                Route::get('/{banner}/destroy', 'destroy');
            });
        });
        Route::prefix("contactos")->group(function ()
        {
            Route::controller(ContactanosController::class)->group(function () {
                Route::get('/', 'index');
                Route::post('/create', 'store');
                Route::get('/{contactanos}', 'show');
                Route::post('/{contactanos}/update', 'update');
                Route::get('/{contactanos}/destroy', 'destroy');
            });
        });
    });

});
