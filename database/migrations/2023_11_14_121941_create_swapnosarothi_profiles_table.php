<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSwapnosarothiProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('swapnosarothi_profiles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('profile_id')->nullable();
            $table->bigInteger('employee_zone_id')->nullable();
            $table->bigInteger('employee_division_id')->nullable();
            $table->bigInteger('employee_district_id')->nullable();
            $table->bigInteger('employee_upazila_id')->nullable();
            $table->bigInteger('employee_union_id')->nullable();
            $table->bigInteger('disability_type')->nullable();
            $table->bigInteger('group_id')->nullable();
            $table->date('start_date')->nullable();
            $table->string('name')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('age')->nullable();
            $table->date('age_completion_date')->nullable();
            $table->string('phone')->nullable();
            $table->string('landmark')->nullable();
            $table->bigInteger('division_id')->nullable();
            $table->bigInteger('district_id')->nullable();
            $table->bigInteger('upazila_id')->nullable();
            $table->bigInteger('union_id')->nullable();
            $table->bigInteger('village_id')->nullable();
            $table->string('fathers_name')->nullable();
            $table->string('mothers_name')->nullable();
            $table->string('guardian_name')->nullable();
            $table->string('total_family_member')->nullable();
            $table->string('father_phone')->nullable();
            $table->string('mother_phone')->nullable();
            $table->string('father_occupation')->nullable();
            $table->string('father_income')->nullable();
            $table->string('mother_occupation')->nullable();
            $table->string('mother_income')->nullable();
            $table->string('other_occupation')->nullable();
            $table->string('other_income')->nullable();
            $table->string('amount_money')->nullable();
            $table->tinyInteger('cash_support_type')->nullable()->comment('1 = Low Cash, 2 = Medium Cash');
            $table->string('group_status')->nullable();
            $table->date('status_date')->nullable();
            $table->string('reason')->nullable();
            $table->bigInteger('craeted_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('swapnosarothi_profiles');
    }
}
