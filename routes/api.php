<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\PajakController;
use App\Http\Controllers\TilangController;
use App\Http\Controllers\ServiceController;

Route::group([
  'prefix' => 'auth'
], function () {
  Route::post('register', [AuthController::class, 'register']);
  Route::post('login', [AuthController::class, 'login']);
  Route::group([
    'middleware' => 'auth:api'
  ], function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);
    Route::get('list-user', [AuthController::class, 'listUser']);
    Route::post('update-users/{id}', [AuthController::class, 'resetPassword']);
    Route::post('update-pw/{id}', [AuthController::class, 'updatePw']);
    Route::delete('delete-user/{id}', [AuthController::class, 'deleteUser']);
    Route::post('delete-users', [AuthController::class, 'deleteUsers']);
    Route::post('ganti-password', [AuthController::class, 'ubahPassword']);
    Route::get('active-token/{id}', [AuthController::class, 'getActiveToken']);
  });
});




Route::group([
  'prefix' => 'mobile'
], function () {
  Route::group([
    'middleware' => 'auth:api',
  ], function () {
    Route::get('/list', [MobilController::class, 'listMobile']);
    Route::post('/create', [MobilController::class, 'createMobile']);
    Route::post('/update/{id}', [MobilController::class, 'updateMobile']);
    Route::delete('/delete/{id}', [MobilController::class, 'deleteMobile']);
  });
});

Route::group([
  'prefix' => 'pajak'
], function () {
  Route::group([
    'middleware' => 'auth:api',
  ], function () {
    Route::get('/list', [PajakController::class, 'listPajak']);
    Route::post('/create', [PajakController::class, 'createPajak']);
    Route::post('/update/{id}', [PajakController::class, 'updatePajak']);
    Route::delete('/delete/{id}', [PajakController::class, 'deletePajak']);
  });
});

Route::group([
  'prefix' => 'tilang'
], function () {
  Route::group([
    'middleware' => 'auth:api',
  ], function () {
    Route::get('/list', [TilangController::class, 'listTilang']);
    Route::post('/create', [TilangController::class, 'createTilang']);
    Route::post('/update/{id}', [TilangController::class, 'updateTilang']);
    Route::delete('/delete/{id}', [TilangController::class, 'deleteTilang']);
  });
});

Route::group([
  'prefix' => 'service'
], function () {
  Route::group([
    'middleware' => 'auth:api',
  ], function () {
    Route::get('/service', [ServiceController::class, 'listService']);
    Route::post('/service', [ServiceController::class, 'createService']);
    Route::post('/service/{id}', [ServiceController::class, 'updateService']);
    Route::delete('/service/{id}', [ServiceController::class, 'deleteService']);
  });
});
