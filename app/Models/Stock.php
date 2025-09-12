<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model{
    use HasFactory;
    protected $table = 'stocks';
    protected $fillable = [
        'ingredient_id',
    ];

    public function ingredient(){
        return $this->belongsTo(Ingredient::class);
    }
}
