<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowUpInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follow_up_infos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('selp_incident_id');
            $table->string('selp_incident_ref');
            $table->integer('followup_number');
            $table->integer('followup_type')->nullable();
            $table->integer('followup_findings')->nullable();
            $table->date('followup_date')->nullable();
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
        Schema::dropIfExists('follow_up_infos');
    }
}
