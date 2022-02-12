<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends User
{
    use HasFactory;

    protected $table = 'users';

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('admin', function (Builder $builder) {
            $builder->where('role', '=',User::ROLE_Admin);
        });
    }

}
