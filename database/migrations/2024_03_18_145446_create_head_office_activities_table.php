<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeadOfficeActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('head_office_activities', function (Blueprint $table) {
            $table->id();
            $table->string('ho_activity_ref');
            $table->integer('ho_event_id')->nullable();
            $table->integer('no_of_event')->nullable();
            $table->date('starting_date')->nullable();
            $table->date('ending_date')->nullable();
            $table->integer('participant_boys')->nullable();
            $table->integer('participant_girls')->nullable();
            $table->integer('participant_men')->nullable();
            $table->integer('participant_women')->nullable();
            $table->integer('participant_other_gender')->nullable();
            $table->integer('participant_total')->nullable();
            $table->integer('participant_pwd_boys')->nullable();
            $table->integer('participant_pwd_girls')->nullable();
            $table->integer('participant_pwd_men')->nullable();
            $table->integer('participant_pwd_women')->nullable();
            $table->integer('participant_pwd_other_gender')->nullable();
            $table->integer('participant_pwd_total')->nullable();
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
        Schema::dropIfExists('head_office_activities');
    }
}
