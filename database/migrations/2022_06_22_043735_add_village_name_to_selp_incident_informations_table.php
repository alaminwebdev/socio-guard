<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVillageNameToSelpIncidentInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('selp_incident_informations', function (Blueprint $table) {
            $table->string('applicant_village_name')->after('applicant_union_id')->nullable($value=true);
            $table->string('survivor_village_name')->after('survivor_union_id')->nullable($value=true);
            $table->string('defendant_village_name')->after('defendant_union_id')->nullable($value=true);
            $table->dropColumn('applicant_village_id');
            $table->dropColumn('survivor_village_id');
            $table->dropColumn('defendant_village_id');
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
            $table->dropColumn('applicant_village_name');
            $table->dropColumn('survivor_village_name');
            $table->dropColumn('defendant_village_name');
            $table->dropColumn('applicant_village_id');
            $table->dropColumn('survivor_village_id');
            $table->dropColumn('defendant_village_id');
        });
    }
}
