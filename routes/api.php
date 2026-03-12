<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VideoController;

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

// video ===========================================
Route::post('/video/add-video', [VideoController::class, 'addVideo']);
Route::post('/video/user/show-all', [VideoController::class, 'userGetAllVideo']);
Route::post('/video/view/search', [VideoController::class, 'videoViewSearch']);
Route::post('/video/viral', [VideoController::class, 'videoViral']);
Route::post('/video/add-comment', [VideoController::class, 'addComment']);
Route::post('/video/delete-comment', [VideoController::class, 'deleteComment']);
Route::post('/video/get-comment', [VideoController::class, 'getComment']);
Route::post('/video/view', [VideoController::class, 'viewVideo']);
Route::post('/video/get-full-info-video', [VideoController::class, 'getFullInfoVideo']);
Route::post('/video/add-like-video', [VideoController::class, 'addLikeVideo']);
Route::post('/video/un-like-video', [VideoController::class, 'unLikeVideo']);
