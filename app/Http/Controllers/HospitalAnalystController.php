<?php

namespace App\Http\Controllers;

use App\Models\HospitalAnalyst;
use Illuminate\Http\Request;

class HospitalAnalystController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(HospitalAnalyst::all()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HospitalAnalyst  $hospitalAnalyst
     * @return \Illuminate\Http\Response
     */
    public function show(HospitalAnalyst $hospitalAnalyst)
    {
        return response($hospitalAnalyst);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HospitalAnalyst  $hospitalAnalyst
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HospitalAnalyst $hospitalAnalyst)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HospitalAnalyst  $hospitalAnalyst
     * @return \Illuminate\Http\Response
     */
    public function destroy(HospitalAnalyst $hospitalAnalyst)
    {
        //
    }
}
