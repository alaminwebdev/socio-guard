<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdrmoneyrecoversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adrmoneyrecovers', function (Blueprint $table) {
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
        Schema::dropIfExists('adrmoneyrecovers');
    }
}
