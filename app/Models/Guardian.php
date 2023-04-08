<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    use HasFactory; //without this, we cannot use factories to seed

    protected $fillable = [
        'user_id',
        'guardian_code',
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function rules()
    {
        return [
            'user_id' => 'required|unique:guardians',
            'guardian_code' => 'required',
        ];
    }
}
