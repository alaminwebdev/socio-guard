<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlternativeDisputeResolutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alternative_dispute_resolutions', function (Blueprint $table) {
            $table->id();
            $table->string('title',100)->nullable($value=false);
            $table->tinyInteger('status')->nullable($value=true)->default($value=1);
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
        Schema::dropIfExists('alternative_dispute_resolutions');
    }
}
