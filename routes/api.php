<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResetPasswordCtl;

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
//pc
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


// Route::post('register', [AuthController::class, 'register']);
//dc

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login',  [ 'as' => 'login', 'uses' => 'AuthController@login']);
Route::post('register', [AuthController::class, 'register'])->name('register');

Route::middleware('auth:sanctum')->group(function () {
    // 1|8P3NTgeVPbLIYpYZnvUS9giz7716U5WK99iq4GnH
    // Route::get('me', [AuthController::class, 'me'])->name('me');
    
    Route::get('me', function(Request $request){
        return auth()->user();
    })->name('me');

    Route::post('change_password', [AuthController::class, 'register'])->name('register');
    Route::post('reset_password', [ResetPasswordCtl::class, 'resetpassword'])->name('reset_password');
});



// login / token


// me with token as authentication bearer fdfsdfsdfdsfsdf

