<?php

// database/migrations/xxxx_xx_xx_create_activites_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitesTable extends Migration
{
    public function up()
    {
        Schema::create('activites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('projet_id');
            $table->string('nom');
            $table->text('description');
            $table->date('date_debut');
            $table->date('date_fin_estime');
            $table->string('rapport')->nullable(); // Pour le fichier PDF
            $table->enum('status', ['Non debutée', 'En cours', 'Terminée'])->default('Non débutée');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('projet_id')->references('id')->on('projets')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('activites');
    }
};