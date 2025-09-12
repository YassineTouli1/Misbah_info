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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['ajout', 'tirage', 'livraison', 'retour']); // Type de transaction
            $table->decimal('montant', 10, 2); // Montant de la transaction
            $table->decimal('solde_avant', 10, 2); // Solde avant la transaction
            $table->decimal('solde_apres', 10, 2); // Solde après la transaction
            $table->text('description'); // Description de la transaction
            $table->unsignedBigInteger('user_id'); // Utilisateur qui a effectué la transaction
            $table->unsignedBigInteger('commande_id')->nullable(); // ID de la commande si liée
            $table->string('reference')->nullable(); // Référence unique de la transaction
            $table->timestamps();
            
            // Index pour optimiser les requêtes
            $table->index(['type', 'created_at']);
            $table->index('user_id');
            $table->index('commande_id');
            
            // Clés étrangères
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // Clé étrangère pour commande (optionnelle car les ajouts/tirages n'ont pas de commande)
            if (Schema::hasTable('commande')) {
                $table->foreign('commande_id')->references('id')->on('commande')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
