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
        Schema::create('administrateurs', function (Blueprint $table) {
            $table->id('id_admin');
            $table->unsignedBigInteger('id_agence');
            $table->foreign('id_agence')->references('id_agence')->on('agences')->onDelete('cascade');
            $table->string('nom_admin');
            $table->string('prenom_admin');
            $table->string('email')->unique();
            $table->string('mot_de_passe');
            $table->boolean('est_principal')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('administrateurs');
    }
};
