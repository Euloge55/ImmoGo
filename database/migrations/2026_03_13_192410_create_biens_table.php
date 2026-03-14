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
        Schema::create('biens', function (Blueprint $table) {
            $table->id('id_bien');
            $table->unsignedBigInteger('id_agence');
            $table->foreign('id_agence')->references('id_agence')->on('agences')->onDelete('cascade');
            $table->unsignedBigInteger('id_admin');
            $table->foreign('id_admin')->references('id_admin')->on('administrateurs')->onDelete('cascade');
            $table->unsignedBigInteger('id_typebien');
            $table->foreign('id_typebien')->references('id_typebien')->on('type_biens')->onDelete('cascade');
            $table->string('titre_bien');
            $table->text('description_bien');
            $table->decimal('prix', 15, 2);
            $table->float('superficie');
            $table->string('localisation');
            $table->enum('statut', ['disponible', 'reserve', 'loue', 'vendu'])->default('disponible');
            $table->json('photos')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biens');
    }
};
