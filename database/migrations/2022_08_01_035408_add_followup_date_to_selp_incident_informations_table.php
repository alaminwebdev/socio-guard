<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFollowupDateToSelpIncidentInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('selp_incident_informations', function (Blueprint $table) {
            $table->date('followup_date')->nullable($value=true)->after('followup_id');
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
