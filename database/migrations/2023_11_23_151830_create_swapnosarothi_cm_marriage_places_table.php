<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSwapnosarothiCmMarriagePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('swapnosarothi_cm_marriage_places', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('status')->default(1);
            $table->timestamps();
        });
        DB::table('swapnosarothi_cm_marriage_places')->insert([
            ['name' => 'Bride\'s house'],
            ['name' => 'Grroms house'],
            ['name' => 'Marriage register office'],
            ['name' => 'Notary/Court marriage with increasing age'],
            ['name' => 'Away from home'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('swapnosarothi_cm_marriage_places');
    }
}
