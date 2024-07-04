<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjetutilisateursTable extends Migration
{
    public function up()
    {
        Schema::create('projetutilisateurs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idprojet');
            $table->unsignedBigInteger('idutilisateur');
            $table->timestamps();

            // Foreign key constraints (if necessary)
            $table->foreign('idprojet')->references('id')->on('projets')->onDelete('cascade');
            $table->foreign('idutilisateur')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('projetutilisateurs');
    }
};
