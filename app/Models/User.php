<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    public function School() {
        return $this->belongsTo(School::class, 'school_id');
    }

    //mutator function
    public function setBcryptPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }
}
