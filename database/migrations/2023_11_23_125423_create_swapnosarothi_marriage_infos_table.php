<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSwapnosarothiMarriageInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('swapnosarothi_marriage_infos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('swapnosarothi_profile_id')->nullable();
            $table->bigInteger('cm_initiative_id')->nullable();
            $table->date('marriage_date')->nullable();
            $table->string('registration_completed')->nullable();
            $table->integer('who_registered')->nullable();
            $table->integer('marriage_place')->nullable();
            $table->integer('marriage_reason')->nullable();
            $table->string('asked_by_groom')->nullable();
            $table->decimal('dower_amount')->nullable();
            $table->integer('marriag_initiated_person')->nullable();
            $table->integer('girl_educational')->nullable();
            $table->string('studentship_status')->nullable();
            $table->integer('educatinal_institution')->nullable();
            $table->integer('girl_age')->nullable();
            $table->string('groom_age')->nullable();
            $table->integer('groom_profession')->nullable();
            $table->integer('groom_education')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('swapnosarothi_marriage_infos');
    }
}
