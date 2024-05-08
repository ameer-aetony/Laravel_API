<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminDashboard\AdminNotificationController;
use App\Http\Controllers\AdminDashboard\PostStatusController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClinetOrderController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\WorkerController;
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

Route::prefix('auth')->group(function () {

    Route::controller(AdminController::class)->prefix('admin')->group(
        function () {
            Route::post('/login',  'login');
            Route::post('/register',  'register');
            Route::post('/logout',  'logout');
            Route::post('/refresh',  'refresh');
            Route::get('/user-profile',  'userProfile');
        }
    );


    Route::controller(WorkerController::class)->prefix('worker')->group(
        function () {
            Route::post('/login',  'login');
            Route::post('/register',  'register');
            Route::post('/logout',  'logout');
            Route::post('/veirfy/{token}',  'veirfy');
            Route::post('/refresh',  'refresh');
            Route::get('/user-profile',  'userProfile');
        }
    );
    Route::prefix('client')->group(function () {
        Route::controller(ClientController::class)->group(
            function () {
                Route::post('/login',  'login');
                Route::post('/register',  'register');
                Route::post('/logout',  'logout');
                Route::post('/refresh',  'refresh');
                Route::get('/user-profile',  'userProfile');
            }
        );
        Route::controller(ClinetOrderController::class)->prefix('order')->group(
            function () {
                Route::post('/request',  'addOrder')->middleware('auth:client');
                Route::post('/update',  'update')->middleware('auth:client');
                Route::get('/show',  'workerOrder')->middleware('auth:client');
            }
        );
    });

    Route::get('/unauthorized', function () {
        return response()->json([
            'message' => 'unauthorized'
        ], 401);
    })->name('login');
});

Route::controller(PostController::class)->prefix('worker/post')->group(function () {
    Route::post('/add', 'store')->middleware('auth:worker');
    Route::get('/all', 'index')->middleware('auth:admin');
    Route::get('/approved', 'approved');
});
Route::controller(PostStatusController::class)->prefix('admin/post')->group(function () {
    Route::post('/change', 'changeStatus');
});

Route::controller(AdminNotificationController::class)->prefix('admin/Notifications')->group(function () {
    Route::get('/all', 'index');
    Route::get('/unread', 'unread');
    Route::get('/markRead', 'markRead');
    Route::get('/deleteAll', 'deleteAll');
    Route::delete('/delete/{id}', 'delete');
});
