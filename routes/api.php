<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Di sini kamu bisa mendefinisikan semua route API untuk aplikasi kamu.
| Route ini akan dimuat oleh RouteServiceProvider dan otomatis diberi prefix "api".
|
*/

Route::get('/ping', function () {
    return response()->json(['message' => 'API aktif ✅']);
});
