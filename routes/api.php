<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;

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

//auth ============================================
Route::post('/add-user', [AuthController::class, 'addUser']);
Route::post('/get-user', [AuthController::class, 'getUser']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/reset-pass/get-code', [AuthController::class, 'getCodeResetPassword']);
Route::post('/reset-pass', [AuthController::class, 'resetPass']);

//user ==============================================
Route::post('/get-bank', [UserController::class, 'getBank']);
Route::post('/add-bank', [UserController::class, 'addBank']);
Route::post('/get-bank/user-id', [UserController::class, 'getBankByUserId']);
