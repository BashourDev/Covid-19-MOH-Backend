<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            // first part
            $table->id();
            $table->foreignId('hospital_id');
            $table->string('doctor');
            $table->string('name');
            $table->date('birthday');
            $table->integer('gender');
            $table->string('address');
            $table->integer('mobileNumber');
            $table->string('bloodType');
            $table->double('height');
            $table->double('weight');

            // second part
            $table->integer('symptomDaysBeforeAdmission');
            $table->string('reasonOfAdmission');
            $table->boolean('hasFever');
            $table->double('temperature');
            $table->integer('daysOfPreAdmissionFever');
            $table->boolean('responseToCetamol');
            $table->boolean('fatigue');
            $table->boolean('dryThroat');
            $table->boolean('sweating');
            $table->boolean('dehydration');
            $table->boolean('lossOfSmellAndTaste');
            $table->string('neuralSymptoms');
            $table->string('structuralSymptoms');
            $table->string('cardiacSymptoms');
            $table->string('digestiveSymptoms');
            $table->string('vascularSymptoms');
            $table->string('urinarySymptoms');
            $table->string('skinSymptoms');
            $table->string('ocularSymptoms');
            $table->string('chestListening');
            $table->string('oxygenationUponAdmission');

            // female stuff
            $table->boolean('reproductiveActivity')->nullable();
            $table->boolean('isPregnant')->nullable();
            $table->integer('ageOfFetus')->nullable();

            $table->string('bloodGasUponAdmission');

            // bloodPressure
            $table->boolean('arterialHypertension');
            $table->string('arterialHypertensionMedications')->nullable();

            // diabetes stuff
            $table->boolean('diabetes');
            $table->string('diabetesOralTreatment')->nullable();
            $table->boolean('diabetesInsulinTreatment')->nullable();
            $table->string('diabetesInsulinType')->nullable();
            $table->string('diabetesMixedOralAndInsulinTreatment')->nullable();

            // cholesterol and triglycerides
            $table->boolean('highCholesterolAndTriglycerides');
            $table->string('cholesterolAndTriglycerides');

            // renal insufficiency
            $table->boolean('renalInsufficiency');
            $table->boolean('renalInsufficiencyTests');

            // antecedents of coronal metaphors or expansions
            $table->boolean('hasAntecedentsOfCoronalMetaphorsRrExpansions');
            $table->string('antecedentsOfCoronalMetaphorsRrExpansionsMedications');

            // breathing difficulties or asthma
            $table->boolean('BreathingDifficultiesOrAsthma');
            $table->string('BreathingDifficultiesOrAsthmaTreatment');
            $table->string('otherRespiratoryProblems');

            // arthritis
            $table->boolean('arthritis');
            $table->string('arthritisMedications');

            // osteoporosis
            $table->boolean('osteoporosis');
            $table->string('osteoporosisMedications');

            // liver disease
            $table->boolean('hasLiverDisease');
            $table->string('liverDisease');

            // depression or anxiety
            $table->boolean('hasDepressionOrAnxiety');
            $table->string('depressionOrAnxietyMedications');

            $table->string('otherDiseases');
            $table->string('otherMedications');

            // smoking
            $table->boolean('isSmoker');
            $table->string('smokingQuantityAndDuration');
            $table->boolean('smokingQuitter');
            $table->string('smokingQuitterQuantityAndDuration');
            $table->boolean('hookah');
            $table->boolean('hookahType'); // true for private false for public

            // alcohol
            $table->boolean('alcoholic');
            $table->string('hasDiet');
            $table->string('diet');

            // physical sports
            $table->boolean('physicalSports');
            $table->string('physicalSportsType');
            $table->string('physicalSportsPace');

            // precautionary measures
            $table->boolean('woreFaceMask');
            $table->boolean('handWashing');
            $table->boolean('avoidCrowds');

            // family
            $table->integer('contactedFamilyMembers');
            $table->integer('familyMembersWithCovidSymptoms');

            // part 3
            $table->string('treatmentCourse');
            $table->boolean('givenAntivirus');
            $table->string('givenAntivirusType');

            $table->string('ctReport');
            $table->string('tests');

            $table->boolean('pcrResult');
            $table->boolean('requiredVentilation');
            $table->integer('ventilationDuration');

            $table->boolean('clinicalImprovement');
            $table->integer('daysOfFever');

            $table->string('mixing');

            // part 4
            $table->boolean('death');
            $table->dateTime('deathDateTime');

            $table->boolean('release');
            $table->dateTime('releaseDateTime');
            $table->string('statusUponRelease');
            $table->string('bloodGasUponRelease');
            $table->string('wbc');
            $table->string('crp');
            $table->string('residencyPeriod');

            // part 5
            $table->date('returnToWorkOrNormalLife');
            $table->boolean('dyspnea');
            $table->boolean('laborOnLightOrMediumEfforts');
            $table->string('otherDemonstrations');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
