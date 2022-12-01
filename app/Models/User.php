<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ROLE_Admin = 0;
    const ROLE_PATIENT_ANALYST = 1;
    const ROLE_HOSPITAL_ANALYST = 2;
    const ROLE_PROVINCIAL_ADMIN = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'province_id',
        'name',
        'username',
        'password',
        'role',
        'plainPassword'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'plainPassword',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function cast()
    {
        $newClass = "App\\Models\\";
        switch ($this->role) {
            case User::ROLE_Admin:
                $newClass .= 'Admin';
                break;
            case User::ROLE_PATIENT_ANALYST:
                $newClass .= "PatientAnalyst";
                break;
            case User::ROLE_HOSPITAL_ANALYST:
                $newClass .= "HospitalAnalyst";
                break;
            case User::ROLE_PROVINCIAL_ADMIN:
                $newClass .= "ProvincialAdmin";
                break;
        }
        $obj = new $newClass;
        foreach (get_object_vars($this) as $key => $name) {
            $obj->$key = $name;
        }
        return $obj;
    }

}
