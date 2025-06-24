<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectStudy extends Model
{
    use HasFactory;

    protected $table = 'subject_studies';

    protected $fillable = [
        'name_subject',
        'description',
        'status_active',
    ];

    protected $casts = [
        'status_active' => 'boolean',
    ];
}
