<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePollisomajTheatreCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pollisomaj_theatre_category', function (Blueprint $table) {
            $table->id();
            $table->string('pollisomaj_ref_id');
            $table->integer('pollisomaj_data_id');
            $table->string('spot_name')->nullable($value=true);
            $table->integer('theatre_theme')->nullable($value=true);
            $table->integer('theatre_category')->nullable($value=true);
            $table->integer('par_girl')->nullable($value=true);
            $table->integer('par_boy')->nullable($value=true);
            $table->integer('par_women')->nullable($value=true);
            $table->integer('par_men')->nullable($value=true);
            $table->integer('par_transgender')->nullable($value=true);
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
        Schema::dropIfExists('pollisomaj_theatre_category');
    }
}
