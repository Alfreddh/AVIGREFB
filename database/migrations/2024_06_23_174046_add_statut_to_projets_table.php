<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('projets', function (Blueprint $table) {
            $table->enum('statut', ['En cours', 'Terminé'])->default('En cours');
        });
    }

    public function down()
    {
        Schema::table('projets', function (Blueprint $table) {
            $table->dropColumn('statut');
        });
    }

};
