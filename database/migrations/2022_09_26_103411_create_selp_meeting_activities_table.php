<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSelpMeetingActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('selp_meeting_activities', function (Blueprint $table) {
            $table->id();
            $table->integer('selp_activities_id');
            $table->string('selp_activity_ref');
            $table->integer('event_id')->nullable();
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
        Schema::dropIfExists('selp_meeting_activities');
    }
}
