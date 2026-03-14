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
        Schema::create('agences', function (Blueprint $table) {
            $table->id('id_agence');
            $table->unsignedBigInteger('id_superadmin');
            $table->foreign('id_superadmin')->references('id_superadmin')->on('super_admins')->onDelete('cascade');
            $table->string('nom_agence');
            $table->string('adresse_agence');
            $table->string('tel_agence');
            $table->string('email')->unique();
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agences');
    }
};
