<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $table = 'teachers';

    protected $fillable = [
        'user_id',
        'name',
        'sex',
        'nip',
        'nuptk',
        'phone',
        'religion',
        'birth_date',
        'place_of_birth',
        'address',
        'postal_code',
        'date_joined',
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

    public function getDateJoinedAttribute($value)
    {
        return $value
            ? \Carbon\Carbon::parse($value)->format('Y-m-d')
            : null;
    }

    public function photoUrl()
    {
        return $this->photo
            ? asset('storage/' . $this->photo)
            : asset('static/ryoogen/default/NO-IMAGE.png');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id')->withDefault();
    }
}
