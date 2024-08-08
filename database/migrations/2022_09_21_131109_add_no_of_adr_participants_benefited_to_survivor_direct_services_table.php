<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNoOfAdrParticipantsBenefitedToSurvivorDirectServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('survivor_direct_services', function (Blueprint $table) {
            $table->integer('no_of_adr_participants_benefited')->after('money_recovered_through_adr')->nullable($value=true);
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
            //
        });
    }
}
