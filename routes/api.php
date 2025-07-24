<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\PajakController;
use App\Http\Controllers\TilangController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\OliController;
use App\Http\Controllers\PerjalananController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\TujuanController;
use App\Http\Controllers\TujuanPerjalananController;

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
  'prefix' => 'mobil'
], function () {
  Route::group([
    'middleware' => 'auth:api',
  ], function () {
    Route::get('/detail/{id}', [MobilController::class, 'detailMobile']);
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
    Route::get('/detail/{id}', [PajakController::class, 'detailPajak']);
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
    Route::get('/detail/{id}', [TilangController::class, 'detailTilang']);
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
    Route::get('/detail/{id}', [ServiceController::class, 'detailService']);
    Route::get('/list', [ServiceController::class, 'listService']);
    Route::post('/create', [ServiceController::class, 'createService']);
    Route::post('/update/{id}', [ServiceController::class, 'updateService']);
    Route::delete('/delete/{id}', [ServiceController::class, 'deleteService']);
  });
});

Route::group([
  'prefix' => 'driver'
], function () {
  Route::group([
    'middleware' => 'auth:api',
  ], function () {
    Route::get('/detail/{id}', [DriverController::class, 'detailDriver']);
    Route::get('/list', [DriverController::class, 'listDriver']);
    Route::post('/create', [DriverController::class, 'createDriver']);
    Route::post('/update/{id}', [DriverController::class, 'updateDriver']);
    Route::delete('/delete/{id}', [DriverController::class, 'deleteDriver']);
  });
});


Route::group([
  'prefix' => 'oli'
], function () {
  Route::group([
    'middleware' => 'auth:api',
  ], function () {
    Route::get('/detail/{id}', [OliController::class, 'detailOli']);
    Route::get('/list', [OliController::class, 'listOli']);
    Route::post('/create', [OliController::class, 'createOli']);
    Route::post('/update/{id}', [OliController::class, 'updateOli']);
    Route::delete('/delete/{id}', [OliController::class, 'deleteOli']);
  });
});

Route::group([
  'prefix' => 'perjalanan'
], function () {
  Route::group([
    'middleware' => 'auth:api',
  ], function () {
    Route::get('/detail/{id}', [PerjalananController::class, 'detailPerjalanan']);
    Route::get('/list', [PerjalananController::class, 'listPerjalanan']);
    Route::post('/create', [PerjalananController::class, 'createPerjalanan']);
    Route::post('/update/{id}', [PerjalananController::class, 'updatePerjalanan']);
    Route::delete('/delete/{id}', [PerjalananController::class, 'deletePerjalanan']);
  });
});

Route::group([
  'prefix' => 'tracking'
], function () {
  Route::group([
    'middleware' => 'auth:api',
  ], function () {
    Route::get('/detail/{id}', [TrackingController::class, 'detailTracking']);
    Route::get('/list', [TrackingController::class, 'listTracking']);
    Route::post('/create', [TrackingController::class, 'createTracking']);
    Route::post('/update/{id}', [TrackingController::class, 'updateTracking']);
    Route::delete('/delete/{id}', [TrackingController::class, 'deleteTracking']);
  });
});

Route::group([
  'prefix' => 'tujuan'
], function () {
  Route::group([
    'middleware' => 'auth:api',
  ], function () {
    Route::get('/detail/{id}', [TujuanController::class, 'detailTujuan']);
    Route::get('/list', [TujuanController::class, 'listTujuan']);
    Route::post('/create', [TujuanController::class, 'createTujuan']);
    Route::post('/update/{id}', [TujuanController::class, 'updateTujuan']);
    Route::delete('/delete/{id}', [TujuanController::class, 'deleteTujuan']);
  });
});

Route::group([
  'prefix' => 'tujuan-perjalanan'
], function () {
  Route::group([
    'middleware' => 'auth:api',
  ], function () {
    Route::get('/detail/{id}', [TujuanPerjalananController::class, 'detailTujuanPerjalanan']);
    Route::get('/list', [TujuanPerjalananController::class, 'listTujuanPerjalanan']);
    Route::post('/create', [TujuanPerjalananController::class, 'createTujuanPerjalanan']);
    Route::post('/update/{id}', [TujuanPerjalananController::class, 'updateTujuanPerjalanan']);
    Route::delete('/delete/{id}', [TujuanPerjalananController::class, 'deleteTujuanPerjalanan']);
    Route::post('/create-aio', [TujuanPerjalananController::class, 'createTujuanPerjalananAIO']);
    Route::post('/update-aio/{id}', [TujuanPerjalananController::class, 'updateTujuanPerjalananAIO']);
    Route::delete('/delete-aio/{id}', [TujuanPerjalananController::class, 'deleteTujuanPerjalananAIO']);
  });
});
