<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSwapnosarothiCmMarriageRegistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('swapnosarothi_cm_marriage_registers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        DB::table('swapnosarothi_cm_marriage_registers')->insert([
            ['name' => 'Marriage register'],
            ['name' => 'False Marriage register'],
            ['name' => 'Assistant of marriage register'],
            ['name' => 'Without registration'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('swapnosarothi_cm_marriage_registers');
    }
}
