<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSwapnosarothiCmMarriagReasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('swapnosarothi_cm_marriag_reasons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        DB::table('swapnosarothi_cm_marriag_reasons')->insert([
            ['name' => 'Suitable groom'],
            ['name' => 'Grroms demanded no/less dowry'],
            ['name' => 'Poverty'],
            ['name' => 'Have to marry off her younger sister'],
            ['name' => 'Social insecurity'],
            ['name' => 'Not good at study'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('swapnosarothi_cm_marriag_reasons');
    }
}
