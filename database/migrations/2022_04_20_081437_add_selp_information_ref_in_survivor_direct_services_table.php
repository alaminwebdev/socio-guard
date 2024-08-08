<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSelpInformationRefInSurvivorDirectServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('survivor_direct_services', function (Blueprint $table) {
            $table->string('selp_incident_ref')->after('selp_incident_information_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('survivor_direct_services', function (Blueprint $table) {
            $table->dropColumn('selp_incident_ref');
        });
    }
}
