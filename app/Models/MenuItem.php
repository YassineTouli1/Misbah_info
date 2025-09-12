<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable=[
        'name',
        'price',
        'image',
        'category_id',
    ];

    public function menus() {
        return $this->belongsToMany(Menu::class,'menu_menu_item');
    }
    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'ingredient_menu_item') ->withPivot('quantity')
            ->withTimestamps();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function commandes(){
        return $this->belongsToMany(Commande::class, 'commande_menu_item', 'menuItem_id', 'commande_id')
            ->withPivot('quantity','price')
            ->withTimestamps();
    }

}
