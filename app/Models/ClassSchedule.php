<?php

namespace App\Models;

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
        return $this->belongsTo(ClassRoom::class)->withDefault();
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class)->withDefault();
    }

    public function subject_study()
    {
        return $this->belongsTo(SubjectStudy::class)->withDefault();
    }
}
