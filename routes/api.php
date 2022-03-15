<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\HospitalSummaryController;
use App\Http\Controllers\PatientController;
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
        Route::put('/update-current-user', [AuthController::class, 'update']);
        Route::get('/logout', [AuthController::class, 'logout']);
    }

    /*
     * for system admin
     */
    {
        Route::middleware('is_admin')->group(function () {
            Route::prefix('/hospitals')->group(function () {

                Route::get('/bar-chart-hospital-patients', [HospitalController::class, 'barChartPatients']);
                Route::get('/', [HospitalController::class, 'index']); // all hospitals
                Route::get('/private', [HospitalController::class, 'privateHospitals']); // private hospitals only
                Route::get('/public', [HospitalController::class, 'publicHospitals']); // public hospitals only
                Route::post('/create', [HospitalController::class, 'store']);

                Route::prefix('/{hospital}')->group(function () {
                    Route::get('/', [HospitalController::class, 'show']); // for showing a specific hospital
                    Route::put('/update', [HospitalController::class, 'update']); // for updating an existing hospital and its staff
                    Route::delete('/delete', [HospitalController::class, 'destroy']); // for deleting a hospital and also its staff accounts
                });

            });

            Route::get('/all-reports', [HospitalSummaryController::class, 'allReports']);

        });
    }

    /*
     * for Patient Analysts
     */
    {
        Route::middleware('is_patient_analyst')->group(function () {
            Route::prefix('/patients')->group(function () {
                Route::get('/hospital-patients', [PatientController::class, 'hospitalPatients']);
                Route::get('/{patient}', [PatientController::class, 'show']);
                Route::post('/first-step', [PatientController::class, 'firstStep']);
                Route::put('/second-step/{patient}', [PatientController::class, 'secondStep']);
                Route::put('/third-step/{patient}', [PatientController::class, 'thirdStep']);
                Route::put('/fourth-step/{patient}', [PatientController::class, 'fourthStep']);
                Route::put('/fifth-step/{patient}', [PatientController::class, 'fifthStep']);
                Route::delete('/{patient}/delete', [PatientController::class, 'destroy']);
            });
        });
    }

    /*
     * for Hospital Analysts
     */
    {
        Route::middleware('is_hospital_analyst')->group(function () {
            Route::prefix('/hospital-reports')->group(function () {
                Route::get('/', [HospitalSummaryController::class, 'index']); // for getting hospital Reports for a specific hospital
                Route::post('/add-report', [HospitalController::class, 'addReport']); // for updating the hospital report and creating a summary
                Route::delete('/delete/{hospitalSummary}', [HospitalSummaryController::class, 'destroy']);
            });
        });
    }

});
