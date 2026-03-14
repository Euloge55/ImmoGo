<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('biens', function (Blueprint $table) {
            $table->unsignedBigInteger('id_departement')->nullable()->after('localisation');
            $table->unsignedBigInteger('id_ville')->nullable()->after('id_departement');
            $table->unsignedBigInteger('id_quartier')->nullable()->after('id_ville');

            $table->foreign('id_departement')
                  ->references('id_departement')
                  ->on('departements')
                  ->onDelete('set null');

            $table->foreign('id_ville')
                  ->references('id_ville')
                  ->on('villes')
                  ->onDelete('set null');

            $table->foreign('id_quartier')
                  ->references('id_quartier')
                  ->on('quartiers')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('biens', function (Blueprint $table) {
            $table->dropForeign(['id_departement']);
            $table->dropForeign(['id_ville']);
            $table->dropForeign(['id_quartier']);
            $table->dropColumn(['id_departement', 'id_ville', 'id_quartier']);
        });
    }
};