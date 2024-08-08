<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReasonIdToSwapnosarothiProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('swapnosarothi_profiles', function (Blueprint $table) {
            $table->tinyInteger('reason_id')->after('reason')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('swapnosarothi_profiles', function (Blueprint $table) {
            $table->dropColumn('reason_id');
        });
    }
}
