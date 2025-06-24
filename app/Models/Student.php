<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'call_name',
        'sex',
        'nis',
        'phone',
        'religion',
        'origin_school',
        'birth_date',
        'place_of_birth',
        'address',
        'postal_code',
        'admission_year',
        'father_name',
        'mother_name',
        'father_job',
        'mother_job',
        'photo',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'admission_year' => 'year',
    ];

    public function getBirthDateAttribute($value)
    {
        return $value
            ? \Carbon\Carbon::parse($value)->format('Y-m-d')
            : null;
    }

    public function getAdmissionYearAttribute($value)
    {
        return $value
            ? \Carbon\Carbon::parse($value)->format('Y')
            : null;
    }

    public function photoUrl()
    {
        return $this->photo
            ? asset('storage/' . $this->photo)
            : asset('static/ryoogen/default/NO-IMAGE.png');
    }
}
