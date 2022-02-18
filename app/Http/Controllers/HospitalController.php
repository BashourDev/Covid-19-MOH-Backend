<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use App\Models\HospitalSummary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HospitalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Hospital::all()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $hospital = Hospital::query()->create($request->only(['name', 'type', 'location', 'emergencyBeds', 'intensiveCareBeds', 'ventilators']));
        $hospital->patientAnalyst()->create([
            'role' => User::ROLE_PATIENT_ANALYST,
            'name' => $request->get('patientAnalystName'),
            'username' => $request->get('patientAnalystUsername'),
            'password' => bcrypt($request->get('patientAnalystPassword'))
        ]);
        $hospital->hospitalAnalyst()->create([
            'role' => User::ROLE_HOSPITAL_ANALYST,
            'name' => $request->get('hospitalAnalystName'),
            'username' => $request->get('hospitalAnalystUsername'),
            'password' => bcrypt($request->get('hospitalAnalystPassword'))
        ]);
        return response('created successfully', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hospital  $hospital
     * @return \Illuminate\Http\Response
     */
    public function show(Hospital $hospital)
    {
        return response($hospital->query()->with(['patientAnalyst', 'hospitalAnalyst'])->first());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \App\Models\Hospital  $hospital
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hospital $hospital)
    {
        $hospital->update($request->only(['name', 'type', 'location', 'emergencyBeds', 'intensiveCareReservedBeds', 'reservedVentilators']));
        $hospital->patientAnalyst()->first()->update([
            'name' => $request->get('patientAnalystName'),
            'username' => $request->get('patientAnalystUsername'),
            'password' => bcrypt($request->get('patientAnalystPassword'))
        ]);
        $hospital->hospitalAnalyst()->first()->update([
                'name' => $request->get('hospitalAnalystName'),
                'username' => $request->get('hospitalAnalystUsername'),
                'password' => bcrypt($request->get('hospitalAnalystPassword'))
        ]);
        return response('updated successfully', 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hospital  $hospital
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hospital $hospital)
    {
        return response($hospital->delete());
    }

    public function publicHospitals(Request $request)
    {
        return response(Hospital::query()->where('type', '=', Hospital::HOSPITAL_PUBLIC)->where('name', 'like', '%'.$request->get('name').'%')->get());
    }

    public function privateHospitals(Request $request)
    {
        return response(Hospital::query()->where('type', '=', Hospital::HOSPITAL_PRIVATE)->where('name', 'like', '%'.$request->get('name').'%')->get());
    }

    public function addReport(Request $request, Hospital $hospital)
    {
        auth()->user()->cast()->hospital->update([
            'emergencyReservedBeds' => $request->get('emergencyReservedBeds'),
            'intensiveCareReservedBeds' => $request->get('intensiveCareReservedBeds'),
            'reservedVentilators' => $request->get('reservedVentilators')
            ]);

        auth()->user()->cast()->hospital->hospitalSummaries()->create([
            'hospitalAnalyst_id' => auth()->user()->id,
            'emergencyBeds' => auth()->user()->cast()->hospital->emergencyBeds,
            'emergencyReservedBeds' => $request->get('emergencyReservedBeds'),
            'intensiveCareBeds' => auth()->user()->cast()->hospital->intensiveCareBeds,
            'intensiveCareReservedBeds' => $request->get('intensiveCareReservedBeds'),
            'ventilators' => auth()->user()->cast()->hospital->ventilators,
            'reservedVentilators' => $request->get('reservedVentilators')
        ]);

        return response('report created successfully', 201);
    }

    public function viewReports(Request $request)
    {
        $query = Hospital::query();
        if ($request->get('name')) {
            $query = $query->where('name', 'like', '%'.$request->get('name').'%');
        }
        if ($request->get('start') && $request->get('end')) {
            $query = $query->whereBetween('updated_at', [$request->get('start'), $request->get('end')]);
        }
        return response($query->get());
    }

}
