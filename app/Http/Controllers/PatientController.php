<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use App\Models\Patient;
use Illuminate\Http\Request;

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
        return response($patient->delete());
    }

    public function hospitalPatients(Request $request)
    {
        return response(auth()->user()->cast()->hospital->patients()->with('patientAnalyst')->where('patients.name', 'like', '%'.$request->get('searchKey').'%')->orderByDesc('id')->get());
    }

    public function firstStep(Request $request)
    {
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

    public function secondStep(Request $request, Patient $patient)
    {
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
        return response($patient);
    }

    public function thirdStep(Request $request, Patient $patient)
    {
        if ($patient->step < 4) {
            $patient->step = 4;
        }
        $patient->update($request->only(['treatmentCourse',
                'givenAntivirus',
                'givenAntivirusType',
                'ctReport',
                'tests',
                'pcrResult',
                'requiredVentilation',
                'ventilationDuration',
                'clinicalImprovement',
                'daysOfFever',
                'mixing']));
        return response($patient);
    }

    public function fourthStep(Request $request, Patient $patient)
    {
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
