<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientAnalyst extends User
{
    use HasFactory;

    protected $table = 'users';

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('patientAnalysts', function (Builder $builder) {
            $builder->where('role', '=',User::ROLE_PATIENT_ANALYST);
        });
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospital_id', 'id');
    }

    public function patients()
    {
        return $this->hasMany(Patient::class, 'patientAnalyst_id', 'id');
    }
}
