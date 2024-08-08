<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumnTypeInPollisomajSetupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pollisomaj_setup', function (Blueprint $table) {
            $table->string('mob_1')->change();
            $table->string('mob_2')->change();
            $table->string('mob_3')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pollisomaj_setup', function (Blueprint $table) {
            //$table->dropColumn(['mob_1', 'mob_2', 'mob_3']);
        });
    }
}
