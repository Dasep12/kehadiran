<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'sys_users';
    protected $fillable = [
        'name',
        'email',
        'password',
        'company_id',
        'employee_id'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }
}
