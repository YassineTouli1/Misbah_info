<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('commande_menu_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commande_id')->references('id')->on('commandes')->onDelete('cascade');
            $table->foreignId('menuItem_id')->references('id')->on('menu_items')->onDelete('cascade');
            $table->Integer('quantity');
            $table->decimal('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commande_menu_item');
    }
};
