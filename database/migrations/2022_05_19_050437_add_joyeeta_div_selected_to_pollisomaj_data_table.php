<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJoyeetaDivSelectedToPollisomajDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pollisomaj_data', function (Blueprint $table) {
            $table->integer('joyeeta_div_selected')->after('ps_mem_joyeeta_selected')->nullable($value=true);
            $table->smallInteger('flag')->after('production_workshop_other_date')->nullable($value=true);
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
            $table->dropColumn('joyeeta_div_selected');
            $table->dropColumn('flag');
        });
    }
}
