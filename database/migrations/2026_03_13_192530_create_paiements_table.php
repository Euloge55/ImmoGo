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
        Schema::create('paiements', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('id_contrat');
            $table->foreign('id_contrat')->references('id_contrat')->on('contrats')->onDelete('cascade');
            $table->unsignedBigInteger('id_mode_paiement');
            $table->foreign('id_mode_paiement')->references('id_mode_paiement')->on('mode_paiements')->onDelete('cascade');
            $table->decimal('montant', 15, 2);
            $table->dateTime('date_paiement');
            $table->enum('type_paiement', ['acompte', 'solde', 'complet']);
            $table->string('reference')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
