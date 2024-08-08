<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePollisomajSetupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pollisomaj_setup', function (Blueprint $table) {
            $table->id();
            $table->string('pollisomaj_name')->nullable($value=false);
            $table->integer('zone_id')->nullable($value=false);
            $table->integer('division_id')->nullable($value=false);
            $table->integer('district_id')->nullable($value=false);
            $table->integer('upazila_id')->nullable($value=false);
            $table->integer('union_id')->nullable($value=false);
            $table->integer('village_id')->nullable($value=true);
            $table->string('name_1')->nullable($value=false);
            $table->integer('mob_1')->nullable($value=false);
            $table->string('name_2')->nullable($value=true);
            $table->integer('mob_2')->nullable($value=true);
            $table->string('name_3')->nullable($value=true);
            $table->integer('mob_3')->nullable($value=true);
            $table->date('date_from')->nullable($value=true)->default($value=date('Y-m-d'));
            $table->date('date_to')->nullable($value=true);
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
        Schema::dropIfExists('pollisomaj_setup');
    }
}
