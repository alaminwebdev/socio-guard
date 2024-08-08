<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSwapnosarothiSetupGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('swapnosarothi_setup_groups', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('group_id');
            $table->bigInteger('zone_id');
            $table->bigInteger('division_id');
            $table->bigInteger('district_id');
            $table->bigInteger('upazila_id');
            $table->bigInteger('union_id');
            $table->bigInteger('village_id');
            $table->string('group_name');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('status')->default(1);
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
        Schema::dropIfExists('swapnosarothi_setup_groups');
    }
}
