<?php

namespace App\Http\Controllers;

use App\Models\PatientAnalyst;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PatientAnalystController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return response(PatientAnalyst::all()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PatientAnalyst  $patientAnalyst
     * @return Response
     */
    public function show(PatientAnalyst $patientAnalyst)
    {
        return response($patientAnalyst);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \App\Models\PatientAnalyst  $patientAnalyst
     * @return Response
     */
    public function update(Request $request, PatientAnalyst $patientAnalyst)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PatientAnalyst  $patientAnalyst
     * @return Response
     */
    public function destroy(PatientAnalyst $patientAnalyst)
    {
        //
    }
}
