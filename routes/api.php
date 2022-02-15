<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HospitalController;
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

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    /*
     * for all logged in users
     */
    {
        Route::get('/logout', [AuthController::class, 'logout']);
    }

    /*
     * for system admin
     */
    {
        Route::middleware('is_admin')->group(function () {
            Route::prefix('/hospitals')->group(function () {
                Route::get('/', [HospitalController::class, 'index']); // all hospitals
                Route::get('/private', [HospitalController::class, 'privateHospitals']); // private hospitals only
                Route::get('/public', [HospitalController::class, 'publicHospitals']); // public hospitals only
                Route::post('/create', [HospitalController::class, 'store']);

                Route::prefix('/{hospital}')->group(function () {
                    Route::get('/', [HospitalController::class, 'show']); // for showing a specific hospital
                    Route::post('/add-report', [HospitalController::class, 'addReport']); // for updating the hospital report and creating a summary
                    Route::put('/update', [HospitalController::class, 'update']); // for updating an existing hospital and its staff
                    Route::delete('/delete', [HospitalController::class, 'destroy']); // for deleting a hospital and also its staff accounts
                });

            });

        });
    }
});
