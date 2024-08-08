<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAmountOfMoneyReceivedToSurvivorCourtCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('survivor_court_cases', function (Blueprint $table) {
            $table->integer('amount_of_money_received')->after('moneyrecover_case_id')->nullable($value=true);
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
            //
        });
    }
}
