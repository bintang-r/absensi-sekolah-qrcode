<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassAdvisor extends Model
{
    use HasFactory;

    protected $table = 'class_advisors';

    protected $fillable = [
        'class_room_id',
        'teacher_id',
    ];

    protected $casts = [
        'class_room_id' => 'integer',
        'teacher_id' => 'integer',
    ];

    public function class_room(){
        return $this->belongsTo(ClassRoom::class,'class_room_id','id')->withDefault();
    }

    public function teacher(){
        return $this->belongsTo(Teacher::class,'teacher_id','id')->withDefault();
    }
}
