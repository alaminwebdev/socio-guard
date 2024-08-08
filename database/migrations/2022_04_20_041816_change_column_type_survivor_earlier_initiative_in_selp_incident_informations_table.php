<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnTypeSurvivorEarlierInitiativeInSelpIncidentInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('selp_incident_informations', function (Blueprint $table) {
            $table->smallInteger('earlier_survivor_initiative')->nullable($value=true)->comment('YES=1,NO=2')->change();
            $table->integer('case_of_failour_coming_to_selp')->nullable($value=true)->change();
            $table->string('survivor_first_face_violence_type')->nullable($value=true)->change();
            $table->smallInteger('selp_adr_money_recover_benifitiaries')->nullable($value=true);
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
            $table->dropColumn('selp_adr_money_recover_benifitiaries');
        });
    }
}
