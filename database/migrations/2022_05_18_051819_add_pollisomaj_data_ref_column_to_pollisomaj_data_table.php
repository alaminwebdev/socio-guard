<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPollisomajDataRefColumnToPollisomajDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pollisomaj_data', function (Blueprint $table) {
            $table->string('pollisomaj_data_ref')->after('id');
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
            $table->dropColumn('pollisomaj_data_ref');
        });
    }
}
