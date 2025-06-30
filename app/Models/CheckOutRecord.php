<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckOutRecord extends Model
{
    use HasFactory;

    protected $table = 'check_out_records';

    protected $fillable = [
        'student_id',
        'check_in_time',
        'attendance_date',
        'remarks',
    ];

    protected $casts = [
        'student_id' => 'integer',
        'check_in_time' => 'datetime:H:i',
        'attendance_date' => 'date',
        'remarks' => 'string',
    ];

    public function student(){
        return $this->belongsTo(Student::class,'student_id','id')->withDefault();
    }

    public function getCheckInTimeAttribute($value){
        return $value->format('H:i');
    }

    public function getAttendanceDateAttribute($value){
        return $value->format('d/m/Y');
    }
}
