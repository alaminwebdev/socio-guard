<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreviousViolenceCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('previous_violence_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name',100)->nullable($value=false);
            $table->tinyInteger('status')->nullable($value=true)->default($value=1);
            $table->integer('created_by')->nullable($value=false);
            $table->integer('updated_by')->nullable($value=false);
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
        Schema::dropIfExists('previous_violence_categories');
    }
}
