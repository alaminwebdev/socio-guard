<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoneyRecoveredThroughAdrToSurvivorDirectServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('survivor_direct_services', function (Blueprint $table) {
            $table->integer('amount_of_money_received')->after('alternative_dispute_resolution_id')->nullable($value=true);
            $table->integer('money_recovered_through_adr')->after('alternative_dispute_resolution_id')->nullable($value=true);
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
