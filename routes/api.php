<?php


use App\Http\Controllers\Api\Auth\LoginJwtController;
use App\Http\Controllers\Api\RealStateController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\RealStateSearchController;
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


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('v1')->group(function () {

    Route::post('login',[LoginJwtController::class,'login']);
    Route::post('logout',[LoginJwtController::class,'logout']);

    Route::get('/search',[RealStateSearchController::class,'index']);

    Route::group(['middleware' => ['jwt.auth'] ],function () {
        Route::name('real_states.')->group(function () {
            Route::resource('real-states',RealStateController::class);
        });

        Route::name('users.')->group(function () {
            Route::resource('users',UserController::class);
        });

        Route::name('categories.')->group(function (){
            Route::resource('categories',CategoryController::class);
            Route::get('/categories/{id}/real-states',[CategoryController::class,'realStates']);
        });
    });
});
