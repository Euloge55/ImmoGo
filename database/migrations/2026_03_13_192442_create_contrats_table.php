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
        Schema::create('contrats', function (Blueprint $table) {
            $table->id('id_contrat');
            $table->unsignedBigInteger('id_client');
            $table->foreign('id_client')->references('id_client')->on('clients')->onDelete('cascade');
            $table->unsignedBigInteger('id_bien');
            $table->foreign('id_bien')->references('id_bien')->on('biens')->onDelete('cascade');
            $table->enum('type_contrat', ['location', 'vente']);
            $table->enum('statut_contrat', ['en_attente', 'confirme', 'annule'])->default('en_attente');
            $table->date('date_location')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contrats');
    }
};
