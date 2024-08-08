<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurvivorDirectServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survivor_direct_services', function (Blueprint $table) {
            $table->id();
            $table->integer('selp_incident_information_id');
            $table->integer('alternative_dispute_resolution_id')->nullable($value=true);
            $table->date('starting_date')->nullable($value=true);
            $table->date('closing_date')->nullable($value=true);
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
        Schema::dropIfExists('survivor_direct_services');
    }
}
