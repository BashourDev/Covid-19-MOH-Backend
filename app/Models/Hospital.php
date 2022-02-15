<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;

    protected $with = ['patientAnalyst:id,name,username', 'hospitalAnalyst:id,name,username'];

    const HOSPITAL_PUBLIC = 0;
    const HOSPITAL_PRIVATE = 1;

    protected $fillable = ['name', 'type', 'emergencyBeds', 'emergencyReservedBeds', 'intensiveCareBeds', 'intensiveCareReservedBeds', 'ventilators', 'reservedVentilators'];


    public function patients()
    {
        return $this->hasMany(Patient::class, 'hospital_id', 'id');
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

}
