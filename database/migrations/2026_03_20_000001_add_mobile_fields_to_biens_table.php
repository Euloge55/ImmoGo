<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Ajoute les champs nécessaires pour l'application mobile :
 * - type_transaction : 'location' | 'vente' (pour les onglets mobiles)
 * - nombre_pieces    : nombre de pièces (filtre "Pièces" de la maquette)
 * - nombre_salles_bain : nombre de salles de bain (affiché sur les cartes)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('biens', function (Blueprint $table) {
            $table->enum('type_transaction', ['location', 'vente'])
                  ->nullable()
                  ->after('statut')
                  ->comment('Type de transaction : location ou vente');

            $table->unsignedTinyInteger('nombre_pieces')
                  ->nullable()
                  ->after('type_transaction')
                  ->comment('Nombre de pièces / chambres');

            $table->unsignedTinyInteger('nombre_salles_bain')
                  ->nullable()
                  ->after('nombre_pieces')
                  ->comment('Nombre de salles de bain');
        });
    }

    public function down(): void
    {
        Schema::table('biens', function (Blueprint $table) {
            $table->dropColumn(['type_transaction', 'nombre_pieces', 'nombre_salles_bain']);
        });
    }
};
