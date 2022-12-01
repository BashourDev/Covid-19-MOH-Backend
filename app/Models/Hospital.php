<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Hospital extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $with = ['patientAnalyst:id,name,username', 'hospitalAnalyst:id,name,username'];

    const HOSPITAL_PUBLIC = 0;
    const HOSPITAL_PRIVATE = 1;

    protected $fillable = ['province_id', 'is_activated', 'name', 'type', 'location', 'emergencyBeds', 'emergencyReservedBeds', 'intensiveCareBeds', 'intensiveCareReservedBeds', 'ventilators', 'reservedVentilators'];

    public function profilePicture()
    {
        return $this->morphOne(config('media-library.media_model'), 'model');
    }

    public function patients()
    {
        return $this->hasMany(Patient::class, 'hospital_id', 'id');
    }

    public function diseasedPatients()
    {
        return $this->hasMany(Patient::class, 'hospital_id', 'id')->where('patients.death', '=', true);
    }

    public function releasedPatients()
    {
        return $this->hasMany(Patient::class, 'hospital_id', 'id')->where('patients.release', '=', true);
    }

    public function residentPatients()
    {
        return $this->hasMany(Patient::class, 'hospital_id', 'id')->where([['patients.release', '=', false], ['patients.death', '=', false]]);
    }

    public function reservedEmergencyBeds()
    {
        return $this->hasMany(Patient::class, 'hospital_id', 'id')->where([['patients.death', '=', false], ['patients.release', '=', false], ['patients.requiredICU', '=', false]]);
    }

    public function reservedICUBeds()
    {
        return $this->hasMany(Patient::class, 'hospital_id', 'id')->where([['patients.death', '=', false], ['patients.release', '=', false], ['patients.requiredICU', '=', true]]);
    }

    public function reservedVentilators()
    {
        return $this->hasMany(Patient::class, 'hospital_id', 'id')->where([['patients.death', '=', false], ['patients.release', '=', false], ['patients.requiredVentilation', '=', true]]);
    }

    public function patientAnalyst()
    {
        return $this->hasOne(PatientAnalyst::class, 'hospital_id', 'id');
    }

    public function hospitalAnalyst()
    {
        return $this->hasOne(HospitalAnalyst::class, 'hospital_id', 'id');
    }

    public function hospitalSummaries()
    {
        return $this->hasMany(HospitalSummary::class, 'hospital_id', 'id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

}
