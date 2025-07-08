<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappConfig extends Model
{
    use HasFactory;

    protected $table = 'whatsapp_configs';

    protected $fillable = [
        'url',
        'port',
        'phone_number',
    ];
}
