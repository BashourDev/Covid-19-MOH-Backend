<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use App\Models\HospitalSummary;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HospitalSummaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Hospital $hospital
     * @return Response
     */
    public function index(Hospital $hospital)
    {
        return response($hospital->hospitalSummaries()->orderByDesc('updated_at')->get());
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
     * @param  \App\Models\HospitalSummary  $hospitalSummary
     * @return Response
     */
    public function show(HospitalSummary $hospitalSummary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \App\Models\HospitalSummary  $hospitalSummary
     * @return Response
     */
    public function update(Request $request, HospitalSummary $hospitalSummary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HospitalSummary  $hospitalSummary
     * @return Response
     */
    public function destroy(HospitalSummary $hospitalSummary)
    {
        //
    }
}