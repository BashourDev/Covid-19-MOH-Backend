<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospitalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospitals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('type'); // 0 for public, 1 for private
            $table->string('location');
            $table->integer('emergencyBeds');
            $table->integer('emergencyReservedBeds')->nullable();
            $table->integer('intensiveCareBeds');
            $table->integer('intensiveCareReservedBeds')->nullable();
            $table->integer('ventilators');
            $table->integer('reservedVentilators')->nullable();
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
        Schema::dropIfExists('hospitals');
    }
}
