<?php
  use App\Http\Controllers\Auth\AuthController;
  use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Comment\CommentsController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;








Route::post('/login', [AuthController::class, 'login'])->name('login');
// Ruta pública para el manejo del olvido de contraseña del usuario
Route::post('/forgot-password', [PasswordController::class, 'resendLink'])->name('password.resend-link');

// Ruta pública para la redirección del formulario y actualizar los datos
Route::get('/reset-password/{token}', [PasswordController::class, 'redirectReset'])->name('password.reset');
Route::post('/register',[ClientController::class,'store'])->name('registerclient');
Route::get('/commentpublic',[CommentsController::class,'index'])->name('publicoment');
// Ruta pública para el manejo del reseteo de la contraseña del usuario
Route::post('/reset-password', [PasswordController::class, 'restore'])->name('password.restore');
  Route::middleware(['auth:sanctum'])->group(function ()
{
    // Ruta para el cierre de sesión
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    // Ruta para el cambio de contraseña del usuario
    Route::post('/update-password', [PasswordController::class, 'update'])->name('password.update');

});

