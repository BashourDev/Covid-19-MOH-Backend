<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function hospitals()
    {
        return $this->hasMany(Hospital::class);
    }

    public function patients()
    {
        return $this->hasManyThrough(Patient::class, Hospital::class);
    }
}
