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
            $table->foreignId('patientAnalyst_id');
            $table->string('doctor');
            $table->string('name');
            $table->date('birthday');
            $table->integer('gender');
            $table->string('job');
            $table->string('address');
            $table->integer('landline');
            $table->integer('mobileNumber');
            $table->string('bloodType');
            $table->double('height')->nullable();
            $table->double('weight')->nullable();

            // second part
            $table->integer('symptomDaysBeforeAdmission')->nullable();
            $table->string('reasonOfAdmission')->nullable();
            $table->boolean('hasFever')->nullable();
            $table->double('temperature')->nullable();
            $table->integer('daysOfPreAdmissionFever')->nullable();
            $table->boolean('responseToCetamol')->nullable();
            $table->boolean('fatigue')->nullable();
            $table->boolean('dryThroat')->nullable();
            $table->boolean('sweating')->nullable();
            $table->boolean('dehydration')->nullable();
            $table->boolean('lossOfSmellAndTaste')->nullable();
            $table->string('neuralSymptoms')->nullable();
            $table->string('structuralSymptoms')->nullable();
            $table->string('cardiacSymptoms')->nullable();
            $table->string('digestiveSymptoms')->nullable();
            $table->string('vascularSymptoms')->nullable();
            $table->string('urinarySymptoms')->nullable();
            $table->string('skinSymptoms')->nullable();
            $table->string('ocularSymptoms')->nullable();
            $table->string('chestListening')->nullable();
            $table->string('oxygenationUponAdmission')->nullable();

            // female stuff
            $table->boolean('reproductiveActivity')->nullable();
            $table->boolean('isPregnant')->nullable();
            $table->integer('ageOfFetus')->nullable();

            $table->string('bloodGasUponAdmission')->nullable();

            // bloodPressure
            $table->boolean('arterialHypertension')->nullable();
            $table->string('arterialHypertensionMedications')->nullable();

            // diabetes stuff
            $table->boolean('diabetes')->nullable();
            $table->string('diabetesOralTreatment')->nullable();
            $table->boolean('diabetesInsulinTreatment')->nullable();
            $table->string('diabetesInsulinType')->nullable();
            $table->string('diabetesMixedOralAndInsulinTreatment')->nullable();

            // cholesterol and triglycerides
            $table->boolean('highCholesterolAndTriglycerides')->nullable();
            $table->string('cholesterolAndTriglycerides')->nullable();

            // renal insufficiency
            $table->boolean('renalInsufficiency')->nullable();
            $table->boolean('renalInsufficiencyTests')->nullable();

            // antecedents of coronal metaphors or expansions
            $table->boolean('hasAntecedentsOfCoronalMetaphorsRrExpansions')->nullable();
            $table->string('antecedentsOfCoronalMetaphorsRrExpansionsMedications')->nullable();

            // breathing difficulties or asthma
            $table->boolean('BreathingDifficultiesOrAsthma')->nullable();
            $table->string('BreathingDifficultiesOrAsthmaTreatment')->nullable();
            $table->string('otherRespiratoryProblems')->nullable();

            // arthritis
            $table->boolean('arthritis')->nullable();
            $table->string('arthritisMedications')->nullable();

            // osteoporosis
            $table->boolean('osteoporosis')->nullable();
            $table->string('osteoporosisMedications')->nullable();

            // liver disease
            $table->boolean('hasLiverDisease')->nullable();
            $table->string('liverDisease')->nullable();

            // depression or anxiety
            $table->boolean('hasDepressionOrAnxiety')->nullable();
            $table->string('depressionOrAnxietyMedications')->nullable();

            $table->string('otherDiseases')->nullable();
            $table->string('otherMedications')->nullable();

            // smoking
            $table->boolean('isSmoker')->nullable();
            $table->string('smokingQuantityAndDuration')->nullable();
            $table->boolean('smokingQuitter')->nullable();
            $table->string('smokingQuitterQuantityAndDuration')->nullable();
            $table->boolean('hookah')->nullable();
            $table->boolean('hookahType')->nullable(); // true for private false for public

            // alcohol
            $table->boolean('alcoholic')->nullable();
            $table->string('hasDiet')->nullable();
            $table->string('diet')->nullable();

            // physical sports
            $table->boolean('physicalSports')->nullable();
            $table->string('physicalSportsType')->nullable();
            $table->string('physicalSportsPace')->nullable();

            // precautionary measures
            $table->boolean('woreFaceMask')->nullable();
            $table->boolean('handWashing')->nullable();
            $table->boolean('avoidCrowds')->nullable();

            // family
            $table->integer('contactedFamilyMembers')->nullable();
            $table->integer('familyMembersWithCovidSymptoms')->nullable();

            // part 3
            $table->string('treatmentCourse')->nullable();
            $table->boolean('givenAntivirus')->nullable();
            $table->string('givenAntivirusType')->nullable();

            $table->string('ctReport')->nullable();
            $table->string('tests')->nullable();

            $table->boolean('pcrResult')->nullable();
            $table->boolean('requiredVentilation')->nullable();
            $table->integer('ventilationDuration')->nullable();

            $table->boolean('clinicalImprovement')->nullable();
            $table->integer('daysOfFever')->nullable();

            $table->string('mixing')->nullable();

            // part 4
            $table->boolean('death')->nullable();
            $table->dateTime('deathDateTime')->nullable();

            $table->boolean('release')->nullable();
            $table->dateTime('releaseDateTime')->nullable();
            $table->string('statusUponRelease')->nullable();
            $table->string('bloodGasUponRelease')->nullable();
            $table->string('wbc')->nullable();
            $table->string('crp')->nullable();
            $table->string('residencyPeriod')->nullable();

            // part 5
            $table->date('returnToWorkOrNormalLife')->nullable();
            $table->boolean('dyspnea')->nullable();
            $table->boolean('laborOnLightOrMediumEfforts')->nullable();
            $table->string('otherDemonstrations')->nullable();

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
