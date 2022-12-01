<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\HospitalSummaryController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\ProvincialAdminController;
use App\Models\Admin;
use App\Models\ProvincialAdmin;
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

Route::get('/provinces', [ProvinceController::class, 'index']);

Route::get('/landing/hospitals', [HospitalController::class, 'landing']);
Route::post('/hospitals/requests/create', [HospitalController::class, 'invitationRequest']);

Route::middleware('auth:sanctum')->group(function () {
    /*
     * for all logged in users
     */
    {
//        Route::get('/get-user', function () {
//            return response(get_class(auth()->user()->cast()) != Admin::class || get_class(auth()->user()->cast()) != ProvincialAdmin::class);
//        });
        Route::put('/update-current-user', [AuthController::class, 'update']);
        Route::get('/logout', [AuthController::class, 'logout']);

        Route::get('/hospitals/{hospital}/show-resident-count', [HospitalController::class, 'showResidentCount']);
    }

    /*
     * for system admin
     */
    {
        Route::middleware('is_admin')->group(function () {
            Route::prefix('/provinces')->group(function () {

                Route::post('/create', [ProvinceController::class, 'store']);
                Route::prefix('/{province}')->group(function () {
                    Route::get('/', [ProvinceController::class, 'show']);
                    Route::get('/hospitals', [ProvinceController::class, 'hospitals']);
                    Route::put('/update', [ProvinceController::class, 'update']);
                    Route::delete('/delete', [ProvinceController::class, 'destroy']);
                });
            });

            Route::prefix('/provincial-admins')->group(function () {
                Route::get('/', [ProvincialAdminController::class, 'index']);
                Route::post('/create', [ProvincialAdminController::class, 'store']);
                Route::prefix('/{provincialAdmin}')->group(function () {
                    Route::get('/', [ProvincialAdminController::class, 'show']);
                    Route::put('/update', [ProvincialAdminController::class, 'update']);
                    Route::delete('/delete', [ProvincialAdminController::class, 'destroy']);
                });
            });
        });
    }

    /*
     * for provincial admin and admin
     */
    {
        Route::middleware(['is_admin_or_provincial_admin'])->group(function () {

            Route::prefix('/hospitals')->group(function () {

                Route::get('/bar-chart-hospital-patients', [HospitalController::class, 'barChartPatients']);
                Route::get('/', [HospitalController::class, 'index']); // all hospitals
                Route::get('/private', [HospitalController::class, 'privateHospitals']); // private hospitals only
                Route::get('/public', [HospitalController::class, 'publicHospitals']); // public hospitals only
                Route::post('/create', [HospitalController::class, 'store']);
                Route::get('/requests', [HospitalController::class, 'requests']);

                Route::prefix('/{hospital}')->group(function () {
                    Route::get('/', [HospitalController::class, 'show']); // for showing a specific hospital
                    Route::put('/accept', [HospitalController::class, 'accept']);
                    Route::put('/update', [HospitalController::class, 'update']); // for updating an existing hospital and its staff
                    Route::delete('/delete', [HospitalController::class, 'destroy']); // for deleting a hospital and also its staff accounts
                    Route::get('/users', [HospitalController::class, 'viewUsers']);
                });

            });

            Route::get('/all-reports', [HospitalSummaryController::class, 'allReports']);

            Route::get('/provincial-admin/hospitals', [ProvincialAdminController::class, 'hospitals']);
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
