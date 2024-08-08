<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSelpInformationRefInSurvivorCourtCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('survivor_court_cases', function (Blueprint $table) {
            $table->string('selp_incident_ref')->after('selp_incident_information_id');
            $table->integer('court_case_id')->nullable($value=true)->after('selp_incident_ref');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('survivor_court_cases', function (Blueprint $table) {
            $table->dropColumn('selp_incident_ref');
            $table->dropColumn('court_case_id');
        });
    }
}
