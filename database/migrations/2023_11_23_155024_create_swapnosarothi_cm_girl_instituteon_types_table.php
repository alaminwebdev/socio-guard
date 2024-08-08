<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSwapnosarothiCmGirlInstituteonTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('swapnosarothi_cm_girl_instituteon_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        DB::table('swapnosarothi_cm_girl_instituteon_types')->insert([
            ['name' => 'Government School'],
            ['name' => 'Government college'],
            ['name' => 'Alia  Madrasa'],
            ['name' => 'Qawmi or Hafezia Madrasa'],
            ['name' => 'Non-government school'],
            ['name' => 'Non-government College'],
            ['name' => 'Vocational orTechnical Education'],
            ['name' => 'Open school or college'],
            ['name' => 'NGO or special school'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('swapnosarothi_cm_girl_instituteon_types');
    }
}
