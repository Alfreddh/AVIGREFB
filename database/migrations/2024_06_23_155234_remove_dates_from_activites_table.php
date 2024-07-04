<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveDatesFromActivitesTable extends Migration
{
    public function up()
    {
        Schema::table('activites', function (Blueprint $table) {
            $table->enum('status', ['Non debutée', 'En cours', 'Terminée'])->default('Non débutée');
            $table->dropColumn(['date_debut', 'date_fin_estime']);
        });
    }

    public function down()
    {
        Schema::table('activites', function (Blueprint $table) {
            $table->date('date_debut')->nullable();
            $table->date('date_fin_estime')->nullable();
        });
    }
};

