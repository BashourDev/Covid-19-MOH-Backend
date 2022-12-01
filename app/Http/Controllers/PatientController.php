<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show(Patient $patient)
    {
        return response($patient);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patient $patient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {
        $this->authorize('update', [$patient]);
        return response($patient->delete());
    }

    public function hospitalPatients(Request $request)
    {
        return response(auth()->user()->cast()->hospital->patients()->with('patientAnalyst')->where('patients.name', 'like', '%'.$request->get('searchKey').'%')->orderByDesc('id')->paginate(20, ['*'], '', $request->get('pageNum')));
    }

    public function firstStep(Request $request)
    {
            if ($request->get('id')) {
                $patient = Patient::query()->find($request->get('id'));
                $this->authorize('update', [$patient]);
                $patient->update([
                    'doctor' => $request->get('doctor'),
                    'name' => $request->get('name'),
                    'birthday' => $request->get('birthday'),
                    'gender' => $request->get('gender'),
                    'job' => $request->get('job'),
                    'address' => $request->get('address'),
                    'landline'  => $request->get('landline'),
                    'mobileNumber' => $request->get('mobileNumber'),
                    'bloodType' => $request->get('bloodType'),
                    'height' => $request->get('height'),
                    'weight' => $request->get('weight')
                ]);
                return response($patient);
            } else {
                return response(auth()->user()->cast()->hospital->patients()->create([
                    'step' => 2,
                    'patientAnalyst_id' => auth()->user()->id,
                    'doctor' => $request->get('doctor'),
                    'name' => $request->get('name'),
                    'birthday' => $request->get('birthday'),
                    'gender' => $request->get('gender'),
                    'job' => $request->get('job'),
                    'address' => $request->get('address'),
                    'landline'  => $request->get('landline'),
                    'mobileNumber' => $request->get('mobileNumber'),
                    'bloodType' => $request->get('bloodType'),
                    'height' => $request->get('height'),
                    'weight' => $request->get('weight')
                ]));
            }
    }

    public function secondStep(Request $request, Patient $patient)
    {
        $this->authorize('update', [$patient]);

        if ($patient->step < 3) {
            $patient->step = 3;
        }
        $patient->update($request->only(['symptomDaysBeforeAdmission',
                'reasonOfAdmission',
                'hasFever',
                'temperature',
                'daysOfPreAdmissionFever',
                'responseToCetamol',
                'fatigue',
                'dryThroat',
                'sweating',
                'dehydration',
                'lossOfSmellAndTaste',
                'neuralSymptoms',
                'structuralSymptoms',
                'cardiacSymptoms',
                'digestiveSymptoms',
                'vascularSymptoms',
                'urinarySymptoms',
                'skinSymptoms',
                'ocularSymptoms',
                'chestListening',
                'oxygenationUponAdmission',
                'reproductiveActivity',
                'isPregnant',
                'ageOfFetus',
                'bloodGasUponAdmission',
                'arterialHypertension',
                'arterialHypertensionMedications',
                'diabetes',
                'diabetesOralTreatment',
                'diabetesInsulinTreatment',
                'diabetesInsulinType',
                'diabetesMixedOralAndInsulinTreatment',
                'highCholesterolAndTriglycerides',
                'cholesterolAndTriglycerides',
                'renalInsufficiency',
                'renalInsufficiencyTests',
                'hasAntecedentsOfCoronalMetaphorsOrExpansions',
                'antecedentsOfCoronalMetaphorsOrExpansionsMedications',
                'BreathingDifficultiesOrAsthma',
                'BreathingDifficultiesOrAsthmaTreatment',
                'otherRespiratoryProblems',
                'arthritis',
                'arthritisMedications',
                'osteoporosis',
                'osteoporosisMedications',
                'hasLiverDisease',
                'liverDisease',
                'hasDepressionOrAnxiety',
                'depressionOrAnxietyMedications',
                'otherDiseases',
                'otherMedications',
                'isSmoker',
                'smokingQuantityAndDuration',
                'smokingQuitter',
                'smokingQuitterQuantityAndDuration',
                'privateHookah',
                'publicHookah',
                'alcoholic',
                'hasDiet',
                'diet',
                'physicalSports',
                'physicalSportsType',
                'physicalSportsPace',
                'woreFaceMask',
                'handWashing',
                'avoidCrowds',
                'contactedFamilyMembers',
                'familyMembersWithCovidSymptoms']));

        $patient = Patient::query()->find($patient->id);

        $res = Http::post('http://localhost:5000/predict_icu', [
            "sex" => (int) $patient->gender,
            "age" => Carbon::parse($patient->birthday)->age,
            "inmsupr" => (int) $patient->responseToCetamol,
            "pneumonia" => (int) $patient->chestListening,
            "diabetes" => (int) $patient->diabetes,
            "asthma" => (int) $patient->BreathingDifficultiesOrAsthma,
            "copd" => (int) $patient->BreathingDifficultiesOrAsthma,
            "hypertension" => (int) $patient->arterialHypertension,
            "cardiovascular" => (int) $patient->highCholesterolAndTriglycerides,
            "renal_chronic" => (int) $patient->renalInsufficiency,
            "obesity" => ((int) $patient->weight) >= 150 ? 1 : 0,
            "tobacco" => (int) $patient->isSmoker,
            "days_prior_to_treatment" => (int) $patient->daysOfPreAdmissionFever
        ]);

        $patient->require_icu = $res->json();
        $patient->save();

        return response($patient);
    }

    public function thirdStep(Request $request, Patient $patient)
    {
        $this->authorize('update', [$patient]);

        if ($patient->step < 4) {
            $patient->step = 4;
        }
        $patient->update($request->only(['treatmentCourse',
                'givenAntivirus',
                'givenAntivirusType',
                'ctReport',
                'tests',
                'pcrResult',
                'requiredICU',
                'requiredVentilation',
                'ventilationDuration',
                'clinicalImprovement',
                'daysOfFever',
                'mixing']));

        $patient = Patient::query()->find($patient->id);

        $res = Http::post('http://localhost:5000/predict_death', [
            "sex" => (int) $patient->gender,
            "age" => (int) Carbon::parse($patient->birthday)->age,
            "inmsupr" => (int) $patient->responseToCetamol,
            "pneumonia" => (int) $patient->chestListening,
            "diabetes" => (int) $patient->diabetes,
            "asthma" => (int) $patient->BreathingDifficultiesOrAsthma,
            "copd" => (int) $patient->BreathingDifficultiesOrAsthma,
            "hypertension" => (int) $patient->arterialHypertension,
            "cardiovascular" => (int) $patient->highCholesterolAndTriglycerides,
            "renal_chronic" => (int) $patient->renalInsufficiency,
            "obesity" => ((int) $patient->weight) >= 150 ? 1 : 0,
            "tobacco" => (int) $patient->isSmoker,
            "days_prior_to_treatment" => (int) $patient->daysOfPreAdmissionFever,
            "intubed" => (int) $patient->requiredVentilation,
            "icu" => (int) $patient->requiredICU
        ]);

        $patient->is_gtd = $res->json();
        $patient->save();

        return response($patient);
    }

    public function fourthStep(Request $request, Patient $patient)
    {
        $this->authorize('update', [$patient]);

        if ($patient->step < 5) {
            $patient->step = 5;
        }
        $patient->update($request->only(['death',
                'deathDateTime',
                'release',
                'releaseDateTime',
                'statusUponRelease',
                'bloodGasUponRelease',
                'bloodPressureUponRelease',
                'pulseUponRelease',
                'oxygenationUponRelease',
                'wbc',
                'crp',
                'residencyPeriod']));
        return response($patient);
    }

    public function fifthStep(Request $request, Patient $patient)
    {
        $this->authorize('update', [$patient]);

        if ($patient->step < 5) {
            $patient->step = 5;
        }
        $patient->update($request->only(['returnToWorkOrNormalLife',
                'dyspnea',
                'laborOnLightOrMediumEfforts',
                'otherDemonstrations']));
        return response($patient);
    }

}
