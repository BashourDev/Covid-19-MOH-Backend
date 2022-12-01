<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospitalSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospital_summaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained('hospitals')->onDelete('cascade');
            $table->foreignId('hospitalAnalyst_id')->constrained('users')->onDelete('cascade');
            $table->integer('emergencyBeds');
            $table->integer('emergencyReservedBeds');
            $table->integer('intensiveCareBeds');
            $table->integer('intensiveCareReservedBeds');
            $table->integer('ventilators');
            $table->integer('reservedVentilators');
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('hospital_summaries');
    }
}
