<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use App\Models\HospitalSummary;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
//        $request->validate([
//            'hospitalAnalystUsername' => 'unique:users,username',
//            'patientAnalystUsername' => 'unique:users,username',
//        ]);
//
//        if ($request->get('hospitalAnalystUsername') === $request->get('patientAnalystUsername')) {
//            abort(422);
//        }

        $hospital = Hospital::query()->create($request->only(['name', 'type', 'location', 'emergencyBeds', 'intensiveCareBeds', 'ventilators']));

        $last_user = User::all()->last();

        $pap = Str::random(12);
        $hospital->patientAnalyst()->create([
            'role' => User::ROLE_PATIENT_ANALYST,
            'name' => "user".($last_user->id + 1),
            'username' => "user".($last_user->id + 1),
            'password' => bcrypt($pap),
            'plainPassword' => $pap
        ]);

        $hap = Str::random(12);
        $hospital->hospitalAnalyst()->create([
            'role' => User::ROLE_HOSPITAL_ANALYST,
            'name' => "user".($last_user->id + 2),
            'username' => "user".($last_user->id + 2),
            'password' => bcrypt($hap),
            'plainPassword' => $hap
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
        return response($hospital->load('patientAnalyst', 'hospitalAnalyst'));
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
        ]);
        $hospital->hospitalAnalyst()->first()->update([
                'name' => $request->get('hospitalAnalystName'),
                'username' => $request->get('hospitalAnalystUsername'),
        ]);

        if ($request->get('updatePAPassword')) {
            $hospital->patientAnalyst()->first()->update([
                'password' => bcrypt($request->get('patientAnalystPassword')),
                'plainPassword' => $request->get('patientAnalystPassword')
            ]);
        }

        if ($request->get('updateHAPassword')) {
            $hospital->hospitalAnalyst()->first()->update([
                'password' => bcrypt($request->get('hospitalAnalystPassword')),
                'plainPassword' => $request->get('hospitalAnalystPassword'),

            ]);
        }

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
        return response(Hospital::query()->where('type', '=', Hospital::HOSPITAL_PUBLIC)->where('name', 'like', '%'.$request->get('name').'%')->orderByDesc('updated_at')->paginate(20, ['*'], '', $request->get('pageNum')));
    }

    public function privateHospitals(Request $request)
    {
        return response(Hospital::query()->where('type', '=', Hospital::HOSPITAL_PRIVATE)->where('name', 'like', '%'.$request->get('name').'%')->orderByDesc('updated_at')->paginate(20, ['*'], '', $request->get('pageNum')));
    }

    public function addReport(Request $request)
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

    public function barChartPatients(Request $request)
    {
        $start = Carbon::parse($request->get('start'))->startOfDay();
        $end = Carbon::parse($request->get('end'))->endOfDay();

        return response(Hospital::query()->withCount([
            'diseasedPatients'=> function (Builder $query) use($start, $end) {
            $query->whereBetween('updated_at', [$start, $end]);
        }, 'releasedPatients'=> function (Builder $query) use($start, $end) {
            $query->whereBetween('updated_at', [$start, $end]);
        }, 'residentPatients'=> function (Builder $query) use($start, $end) {
            $query->whereBetween('updated_at', [$start, $end]);
        }
        ])->get());
    }

    public function viewUsers(Hospital $hospital)
    {
        $pa = $hospital->patientAnalyst()->get(['username', 'plainPassword'])->makeVisible(['plainPassword']);
        $ha = $hospital->hospitalAnalyst()->get(['username', 'plainPassword'])->makeVisible(['plainPassword']);

        return response(['patient_analyst' => $pa->last(), "hospital_analyst" => $ha->last()]);
    }

}
