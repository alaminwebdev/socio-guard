<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNoOfSessionsToPollisomajDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pollisomaj_data', function (Blueprint $table) {
            $table->integer('no_of_session_with_men')->after('iga_training_without_ps_mem_pwd_total')->nullable($value=true);
            $table->integer('no_of_session_with_women')->after('session_with_men_pwd_total')->nullable($value=true);
            $table->integer('no_of_session_with_adolescent')->after('session_with_women_pwd_total')->nullable($value=true);
            $table->integer('no_of_session_with_ps')->after('session_with_adolescent_pwd_total')->nullable($value=true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pollisomaj_data', function (Blueprint $table) {
            //
        });
    }
}
