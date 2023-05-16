<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class User extends Model implements AuthenticatableContract
{
    use HasApiTokens, HasFactory, Authenticatable;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'phone_number'
    ];

    protected $hidden = [
        "password", "remember_token"
    ];

    public function guardian()
    {
        return $this->hasOne(Guardian::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    //mutator function
    public function setBcryptPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }
}
