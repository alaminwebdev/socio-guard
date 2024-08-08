<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmInitiativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cm_initiatives', function (Blueprint $table) {
            $table->id();
            $table->integer('swapnosarothi_profile_id');
            $table->string('initiative');
            $table->integer('prevention_type')->nullable();
            $table->integer('prevention_by')->nullable();
            $table->string('age')->nullable();
            $table->date('date')->nullable();
            $table->integer('status')->default(1);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('cm_initiatives');
    }
}
