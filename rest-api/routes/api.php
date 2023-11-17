<?php

use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\PegawaiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    // Route untuk menampilkan semua pegawai
    Route::get('/employees', [EmployeesController::class, 'index']);

    // Membuat route pegawai dengan method POST
    Route::post('/employees', [EmployeesController::class, 'store']);

    // Route untuk menampilkan pegawai sesuai dengan ID
    Route::get('/employees/{id}', [EmployeesController::class, 'show']);

    // Membuat route pegawai dengan method PUT
    Route::put('/employees/{id}', [EmployeesController::class, 'update']);

    // Membuat route pegawai dengan method DELETE
    Route::delete('/employees/{id}', [EmployeesController::class, 'destroy']);

    // Membuat route untuk mencari pegawai menggunakan nama
    Route::get('/employees/search/{name}', [EmployeesController::class, 'search']);

    // Membuat route untuk status Active
    Route::get('/active-employees', [EmployeesController::class, 'active']);

    // Membuat route untuk status Inactive
    Route::get('/inactive-employees', [EmployeesController::class, 'inactive']);

    // Membuat route untuk status Terminated
    Route::get('/termin-employees', [EmployeesController::class, 'terminated']);
});

// Membuat Route untuk Register dan Login
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);