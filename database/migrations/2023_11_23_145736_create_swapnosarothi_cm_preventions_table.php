<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSwapnosarothiCmPreventionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('swapnosarothi_cm_preventions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('prevention_type_id')->nullable();
            $table->string('name')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        DB::table('swapnosarothi_cm_preventions')->insert([
            ['prevention_type_id' => 1, 'name' => 'Discussing with parents'],
            ['prevention_type_id' => 1, 'name' => 'By the help of Swapnosarothi'],
            ['prevention_type_id' => 1, 'name' => 'Educatinal Instituation'],
            ['prevention_type_id' => 1, 'name' => 'SELP staff'],
            ['prevention_type_id' => 1, 'name' => 'Police station'],
            ['prevention_type_id' => 1, 'name' => 'LG representative'],
            ['prevention_type_id' => 1, 'name' => 'Upazila Administration'],
            ['prevention_type_id' => 1, 'name' => '109'],
            ['prevention_type_id' => 1, 'name' => '999'],
            ['prevention_type_id' => 2, 'name' => 'Could not convinced parents'],
            ['prevention_type_id' => 2, 'name' => 'Forced marriage from parents'],
            ['prevention_type_id' => 2, 'name' => 'Took away forecely by groom'],
            ['prevention_type_id' => 3, 'name' => 'Due to own affairs'],
            ['prevention_type_id' => 3, 'name' => 'Not interested to study'],
            ['prevention_type_id' => 3, 'name' => 'Willing to marriage'],
            ['prevention_type_id' => 3, 'name' => 'Not good education'],
            ['prevention_type_id' => 3, 'name' => 'Poverty'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('swapnosarothi_cm_preventions');
    }
}
