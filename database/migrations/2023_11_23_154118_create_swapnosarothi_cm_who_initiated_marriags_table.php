<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSwapnosarothiCmWhoInitiatedMarriagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('swapnosarothi_cm_who_initiated_marriags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('status')->default(1);
            $table->timestamps();
        });
        DB::table('swapnosarothi_cm_who_initiated_marriags')->insert([
            ['name' => 'Father'],
            ['name' => 'Mother'],
            ['name' => 'Brother'],
            ['name' => 'Sister'],
            ['name' => 'Uncle'],
            ['name' => 'Grand father'],
            ['name' => 'Grand mother'],
            ['name' => 'Others family members'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('swapnosarothi_cm_who_initiated_marriags');
    }
}
