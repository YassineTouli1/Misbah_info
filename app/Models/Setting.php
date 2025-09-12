<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';
    protected $fillable = [
        'logo_path',
        'hero-title',
        'hero-subtitle',
        'facebook_link',
        'instagram_link',
        'whatsapp_link',
        'phone',
        'adresse',
        'disponibilite',
    ];
}
