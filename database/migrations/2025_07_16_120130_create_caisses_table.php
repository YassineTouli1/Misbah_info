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
        Schema::create('caisses', function (Blueprint $table) {
            $table->id();
            $table->date('date')->unique(); // Date unique pour éviter les doublons
            $table->decimal('montant', 10, 2)->default(0); // Précision de 2 décimales
            $table->text('notes')->nullable(); // Notes optionnelles
            $table->timestamps();
            
            // Index pour les recherches par date
            $table->index('date');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('caisses');
    }
};
