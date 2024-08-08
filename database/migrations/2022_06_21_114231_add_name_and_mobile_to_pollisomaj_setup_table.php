<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNameAndMobileToPollisomajSetupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pollisomaj_setup', function (Blueprint $table) {
            $table->string('mob_4')->after('mob_3')->nullable($value=true);
            $table->string('name_4')->after('mob_3')->nullable($value=true);
            $table->string('village_name')->after('union_id')->nullable($value=true);
            $table->string('pollisomaj_no')->after('id')->nullable($value=true);
            $table->dropColumn('village_id');
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
            //
        });
    }
}
