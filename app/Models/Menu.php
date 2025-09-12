<?php

namespace App\Models;

use App\Models\Ingredient;
use Illuminate\Database\Eloquent\Model;
use App\Models\MenuItem;
class Menu extends Model
{
    protected $fillable=[
        'title',
        'available'
    ];


    public function menuItems()
    {
        return $this->belongsToMany(MenuItem::class, 'menu_menu_item','menu_id', 'menuItem_id')
            ->withTimestamps();
    }


}
