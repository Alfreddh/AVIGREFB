<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToProjetsTable extends Migration
{
    public function up()
    {
        Schema::table('projets', function (Blueprint $table) {
            $table->string('status')->default('Non débuté')->after('datefin');
        });
    }

    public function down()
    {
        Schema::table('projets', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
