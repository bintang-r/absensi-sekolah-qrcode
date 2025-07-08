<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSchedule extends Model
{
    use HasFactory;

    protected $table = 'class_schedules';

    protected $fillable = [
        'class_room_id',
        'teacher_id',
        'subject_study_id',
        'day_name',
        'start_time',
        'end_time',
        'description',
    ];

    protected $casts = [
        'class_room_id' => 'integer',
        'teacher_id' => 'integer',
        'subject_study_id' => 'integer',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    public function class_room()
    {
        return $this->belongsTo(ClassRoom::class,'class_room_id','id')->withDefault();
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class,'teacher_id','id')->withDefault();
    }

    public function subject_study()
    {
        return $this->belongsTo(SubjectStudy::class,'subject_study_id','id')->withDefault();
    }

    public function getStartTimeAttribute($value){
        return Carbon::parse($value)->format('H:i');
    }

    public function getEndTimeAttribute($value){
        return Carbon::parse($value)->format('H:i');
    }
}
