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
        Schema::create('ventes', function (Blueprint $table) {
            $table->id('id_vente');
            $table->unsignedBigInteger('id_contrat');
            $table->foreign('id_contrat')->references('id_contrat')->on('contrats')->onDelete('cascade');
            $table->decimal('montant_total_vente', 15, 2);
            $table->dateTime('date_reserv_vente');
            $table->dateTime('date_limite_solde_vente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventes');
    }
};
