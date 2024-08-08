<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurvivorCourtCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survivor_court_cases', function (Blueprint $table) {
            $table->id();
            $table->integer('selp_incident_information_id');
            $table->integer('case_type')->nullable($value=true);
            $table->integer('civil_case_id')->nullable($value=true);
            $table->integer('policecase_case_id')->nullable($value=true);
            $table->integer('moneyrecover_case_id')->nullable($value=true);
            $table->integer('judjementstatus_id')->nullable($value=true);
            $table->date('case_start_date')->nullable($value=true);
            $table->date('case_judjement_date')->nullable($value=true);
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
        Schema::dropIfExists('survivor_court_cases');
    }
}
