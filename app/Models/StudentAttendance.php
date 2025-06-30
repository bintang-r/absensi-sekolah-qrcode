<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAttendance extends Model
{
    use HasFactory;

    protected $table = 'student_attendances';

    protected $fillable = [
        'class_attendance_id',
        'student_id',
        'status_attendance',
    ];

    protected $casts = [
        'class_attendance_id' => 'integer',
        'student_id' => 'integer',
        'status_attendance' => 'string',
    ];

    public function class_attendance(){
        return $this->belongsTo(ClassAttendance::class,'class_attendance_id','id')->withDefault();
    }

    public function student(){
        return $this->belongsTo(Student::class,'student_id','id');
    }
}
