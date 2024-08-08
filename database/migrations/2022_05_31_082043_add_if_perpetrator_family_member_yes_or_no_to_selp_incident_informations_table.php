<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIfPerpetratorFamilyMemberYesOrNoToSelpIncidentInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('selp_incident_informations', function (Blueprint $table) {
            $table->smallInteger('if_perpetrator_family_member_yes_or_no')->after('defendant_family_member_id')->nullable($value=true);
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
            $table->dropColumn('if_perpetrator_family_member_yes_or_no');
        });
    }
}
