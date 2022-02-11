<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalAnalyst extends User
{
    use HasFactory;

    protected $table = 'users';

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('hospitalAnalysts', function (Builder $builder) {
            $builder->where('role', '=',User::ROLE_HOSPITAL_ANALYST);
        });
    }

}
