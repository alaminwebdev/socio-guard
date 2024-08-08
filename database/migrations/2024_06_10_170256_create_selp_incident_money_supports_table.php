<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSelpIncidentMoneySupportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('selp_incident_money_supports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('selp_incident_information_id');
            $table->integer('amount_of_money_received')->nullable();
            $table->date('money_receive_date');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('selp_incident_money_supports');
    }
}
