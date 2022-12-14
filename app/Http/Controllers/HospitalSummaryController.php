<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use App\Models\HospitalSummary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class HospitalSummaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Hospital $hospital
     * @return Response
     */
    public function index()
    {
        return response(auth()->user()->cast()->hospital->hospitalSummaries()->with('hospitalAnalyst')->orderByDesc('updated_at')->get());
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
        $this->authorize('delete', [$hospitalSummary]);
        $lastSummary = auth()->user()->cast()->hospital->hospitalSummaries->last();

        if ($lastSummary->id === $hospitalSummary->id) {
            $hospitalSummary->delete();

            $lastSummary = auth()->user()->cast()->hospital->hospitalSummaries->last();

            if ($lastSummary) {
                auth()->user()->cast()->hospital->update([
                    'emergencyReservedBeds' => $lastSummary->emergencyReservedBeds,
                    'intensiveCareReservedBeds' => $lastSummary->intensiveCareReservedBeds,
                    'reservedVentilators' => $lastSummary->reservedVentilators
                ]);
            }
        } else {
            $hospitalSummary->delete();
        }

        return response('ok', 201);
    }

    public function allReports(Request $request)
    {
        $start = Carbon::parse($request->input('start'))->startOfDay();
        $end = Carbon::parse($request->input('end'))->endOfDay();

        if (auth()->user()->role === User::ROLE_PROVINCIAL_ADMIN) {
            return response(auth()->user()->cast()->hospitalsSummaries()->with(['hospitalAnalyst', 'hospital'])->whereBetween('hospital_summaries.created_at', [$start, $end])->orderByDesc('created_at')->get());

        }

        return response(HospitalSummary::query()->with(['hospitalAnalyst', 'hospital'])->whereBetween('hospital_summaries.created_at', [$start, $end])->orderByDesc('created_at')->get());
    }

}
