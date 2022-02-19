<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalSummary extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospital_id', 'id');
    }

    public function hospitalAnalyst()
    {
        return $this->belongsTo(HospitalAnalyst::class, 'hospitalAnalyst_id', 'id');
    }

}
