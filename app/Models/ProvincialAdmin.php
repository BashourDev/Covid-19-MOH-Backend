<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProvincialAdmin extends User
{
    use HasFactory;

    protected $table = 'users';

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('provincialAdmins', function (Builder $builder) {
            $builder->where('role', '=',User::ROLE_PROVINCIAL_ADMIN);
        });
    }

    public function hospitals()
    {
        return $this->hasMany(Hospital::class, 'province_id', 'province_id');
    }

    public function hospitalsSummaries()
    {
        return $this->hasManyThrough(HospitalSummary::class, Hospital::class, 'province_id', 'hospital_id', 'id', 'id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}
