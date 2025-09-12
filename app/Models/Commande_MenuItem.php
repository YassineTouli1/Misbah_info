<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Commande_MenuItem extends Model
{
    protected $table = 'commande_menu_item';

    protected $fillable = [
        'commande_id',
        'menuItem_id',
        'quantity',
    ];
}
