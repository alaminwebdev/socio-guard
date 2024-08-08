<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdrFieldsToSelpIncidentInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('selp_incident_informations', function (Blueprint $table) {
            $table->integer('direct_service_type')->nullable($value=true)->after('selp_initiative');
            $table->date('direct_service_date')->nullable($value=true)->after('direct_service_type');
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
            $table->dropColumn('direct_service_type');
            $table->dropColumn('direct_service_date');
        });
    }
}
