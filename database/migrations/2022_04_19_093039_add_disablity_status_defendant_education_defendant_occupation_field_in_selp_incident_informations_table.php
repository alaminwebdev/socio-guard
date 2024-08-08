<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDisablityStatusDefendantEducationDefendantOccupationFieldInSelpIncidentInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('selp_incident_informations', function (Blueprint $table) {
            $table->integer('survivor_disability_status')->nullable()->after('violence_place_id');
            $table->integer('defendant_education_id')->nullable()->after('survivor_disability_status');
            $table->integer('defendant_occupation_id')->nullable()->after('defendant_education_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('selp_incident_informations', function (Blueprint $table) {
            //
        });
    }
}
