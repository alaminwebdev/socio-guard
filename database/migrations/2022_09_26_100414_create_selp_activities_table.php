<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSelpActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('selp_activities', function (Blueprint $table) {
            $table->id();
            $table->date('reporting_date')->nullable($value=true);
            $table->string('selp_activity_ref',100);
            $table->integer('employee_id');
            $table->integer('employee_pin')->nullable($value=true);
            $table->string('employee_name',100)->nullable($value=true);
            $table->string('employee_mobile_number',50)->nullable($value=true);
            $table->string('employee_designation')->nullable($value=true);
            $table->integer('employee_zone_id');
            $table->integer('employee_division_id')->nullable($value=true);
            $table->integer('employee_district_id')->nullable($value=true);
            $table->integer('employee_upazila_id')->nullable($value=true);
            $table->smallInteger('status')->default(0)->nullable($value=true)->comment('0 = Draft, 1 = Submitted for approval, 2 = DM approved');
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
        Schema::dropIfExists('selp_activities');
    }
}
