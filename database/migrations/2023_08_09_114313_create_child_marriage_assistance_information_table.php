<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChildMarriageAssistanceInformationTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('child_marriage_assistance_information', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('child_marriage_information_id');
            $table->bigInteger('child_marriage_assistance_taken_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('child_marriage_assistance_information');
    }
}
