<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;
    protected $table = 'ingredients';
    protected $fillable = [
        'name',
        'quantite',
        'price',
        'fournisseur',
        'image'
    ];

    public function stock()
    {
        return $this->hasOne(Stock::class);
    }

    protected static function booted()
    {
        static::created(function ($ingredient) {
            $ingredient->stock()->create();
        });
    }

    public function menuItems(){
        return $this->belongsToMany(MenuItem::class)->withPivot('quantity');
    }
}
