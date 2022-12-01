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
            $table->integer('step');
            $table->foreignId('hospital_id')->constrained('hospitals')->onDelete('cascade');
            $table->foreignId('patientAnalyst_id')->constrained('users')->onDelete('cascade');
            $table->string('doctor');
            $table->string('name');
            $table->date('birthday');
            $table->boolean('gender'); //false for male, true for female
            $table->string('job')->nullable();
            $table->string('address')->nullable();
            $table->string('landline')->nullable();
            $table->string('mobileNumber')->nullable();
            $table->string('bloodType');
            $table->string('height')->nullable();
            $table->string('weight')->nullable();

            // second part
            $table->string('symptomDaysBeforeAdmission')->default('')->nullable();
            $table->string('reasonOfAdmission')->default('')->nullable();
            $table->boolean('hasFever')->default(false);
            $table->double('temperature')->nullable();
            $table->string('daysOfPreAdmissionFever')->default('')->nullable();
            $table->boolean('responseToCetamol')->default(false);
            $table->boolean('fatigue')->default(false);
            $table->boolean('dryThroat')->default(false);
            $table->boolean('sweating')->default(false);
            $table->boolean('dehydration')->default(false);
            $table->boolean('lossOfSmellAndTaste')->default(false);
            $table->string('neuralSymptoms')->default('')->nullable();
            $table->string('structuralSymptoms')->default('')->nullable();
            $table->string('cardiacSymptoms')->default('')->nullable();
            $table->string('digestiveSymptoms')->default('')->nullable();
            $table->string('vascularSymptoms')->default('')->nullable();
            $table->string('urinarySymptoms')->default('')->nullable();
            $table->string('skinSymptoms')->default('')->nullable();
            $table->string('ocularSymptoms')->default('')->nullable();
            $table->string('chestListening')->default('')->nullable();
            $table->string('oxygenationUponAdmission')->default('')->nullable();

            // female stuff
            $table->boolean('reproductiveActivity')->default(false);
            $table->boolean('isPregnant')->default(false);
            $table->integer('ageOfFetus')->nullable();

            $table->string('bloodGasUponAdmission')->default('')->nullable();

            // bloodPressure
            $table->boolean('arterialHypertension')->default(false);
            $table->string('arterialHypertensionMedications')->default('')->nullable();

            // diabetes stuff
            $table->boolean('diabetes')->default(false);
            $table->string('diabetesOralTreatment')->default('')->nullable();
            $table->boolean('diabetesInsulinTreatment')->default(false);
            $table->string('diabetesInsulinType')->default('')->nullable();
            $table->string('diabetesMixedOralAndInsulinTreatment')->default('')->nullable();

            // cholesterol and triglycerides
            $table->boolean('highCholesterolAndTriglycerides')->default(false);
            $table->string('cholesterolAndTriglycerides')->default('')->nullable();

            // renal insufficiency
            $table->boolean('renalInsufficiency')->default(false);
            $table->boolean('renalInsufficiencyTests')->default(false);

            // antecedents of coronal metaphors or expansions
            $table->boolean('hasAntecedentsOfCoronalMetaphorsOrExpansions')->default(false);
            $table->string('antecedentsOfCoronalMetaphorsOrExpansionsMedications')->default('')->nullable();

            // breathing difficulties or asthma
            $table->boolean('BreathingDifficultiesOrAsthma')->default(false);
            $table->string('BreathingDifficultiesOrAsthmaTreatment')->default('')->nullable();
            $table->string('otherRespiratoryProblems')->default('')->nullable();

            // arthritis
            $table->boolean('arthritis')->default(false);
            $table->string('arthritisMedications')->default('')->nullable();

            // osteoporosis
            $table->boolean('osteoporosis')->default(false);
            $table->string('osteoporosisMedications')->default('')->nullable();

            // liver disease
            $table->boolean('hasLiverDisease')->default(false);
            $table->string('liverDisease')->default('')->nullable();

            // depression or anxiety
            $table->boolean('hasDepressionOrAnxiety')->default(false);
            $table->string('depressionOrAnxietyMedications')->default('')->nullable();

            $table->string('otherDiseases')->default('')->nullable();
            $table->string('otherMedications')->default('')->nullable();

            // smoking
            $table->boolean('isSmoker')->default(false);
            $table->string('smokingQuantityAndDuration')->default('')->nullable();
            $table->boolean('smokingQuitter')->default(false);
            $table->string('smokingQuitterQuantityAndDuration')->default('')->nullable();
            $table->boolean('privateHookah')->default(false);
            $table->boolean('publicHookah')->default(false);

            // alcohol
            $table->boolean('alcoholic')->default(false);
            $table->boolean('hasDiet')->default(false)->nullable();
            $table->string('diet')->default('')->nullable();

            // physical sports
            $table->boolean('physicalSports')->default(false);
            $table->string('physicalSportsType')->default('')->nullable();
            $table->string('physicalSportsPace')->default('')->nullable();

            // precautionary measures
            $table->boolean('woreFaceMask')->default(false);
            $table->boolean('handWashing')->default(false);
            $table->boolean('avoidCrowds')->default(false);

            // family
            $table->integer('contactedFamilyMembers')->nullable();
            $table->integer('familyMembersWithCovidSymptoms')->nullable();

            // part 3
            $table->string('treatmentCourse')->default('')->nullable();
            $table->boolean('givenAntivirus')->default(false);
            $table->string('givenAntivirusType')->default('')->nullable();

            $table->string('ctReport')->default('')->nullable();
            $table->string('tests')->default('')->nullable();

            $table->boolean('pcrResult')->default(false);
            $table->boolean('requiredICU')->default(false);
            $table->boolean('requiredVentilation')->default(false);
            $table->integer('ventilationDuration')->nullable();

            $table->boolean('clinicalImprovement')->default(false);
            $table->integer('daysOfFever')->nullable();

            $table->string('mixing')->default('')->nullable();

            // part 4
            $table->boolean('death')->default(false);
            $table->date('deathDateTime')->nullable();

            $table->boolean('release')->default(false);
            $table->date('releaseDateTime')->nullable();
            $table->string('statusUponRelease')->default('')->nullable();
            $table->string('bloodGasUponRelease')->default('')->nullable();
            $table->dateTime('bloodPressureUponRelease')->nullable();
            $table->string('pulseUponRelease')->default('')->nullable();
            $table->string('oxygenationUponRelease')->default('')->nullable();
            $table->string('wbc')->default('')->nullable();
            $table->string('crp')->default('')->nullable();
            $table->string('residencyPeriod')->default('')->nullable();

            // part 5
            $table->date('returnToWorkOrNormalLife')->nullable();
            $table->boolean('dyspnea')->default(false);
            $table->boolean('laborOnLightOrMediumEfforts')->default(false);
            $table->string('otherDemonstrations')->default('')->nullable();

            $table->boolean('require_icu')->nullable();
            $table->boolean('is_gtd')->nullable();

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
