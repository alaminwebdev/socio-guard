<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChildMarriageInformationsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('child_marriage_informations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('complain_id')->nullable();
            $table->integer('child_marriage_initiative_id')->nullable();
            $table->integer('survivor_autistic_information_id')->nullable();
            $table->date('reporting_date');
            $table->string('employee_name')->nullable();
            $table->string('employee_mobile_number')->nullable();
            $table->string('employee_designation')->nullable();
            $table->string('employee_pin');
            $table->integer('employee_zone_id');
            $table->integer('employee_division_id');
            $table->integer('employee_district_id')->nullable();
            $table->integer('employee_upazila_id')->nullable();
            $table->string('child_name')->nullable();
            $table->integer('child_age')->nullable();
            $table->string('child_father_name')->nullable();
            $table->string('child_mother_name')->nullable();
            $table->string('child_mobile_number')->nullable();
            $table->integer('child_gender_id')->nullable();
            $table->integer('child_division_id')->nullable();
            $table->integer('child_district_id')->nullable();
            $table->integer('child_upazila_id')->nullable();
            $table->integer('child_union_id')->nullable();
            $table->string('child_village_name')->nullable();
            $table->string('person_name')->nullable();
            $table->string('person_mobile_number')->nullable();
            $table->integer('person_division_id')->nullable();
            $table->integer('person_district_id')->nullable();
            $table->integer('person_upazila_id')->nullable();
            $table->integer('person_union_id')->nullable();
            $table->string('person_village_name')->nullable();
            $table->integer('update_by')->nullable();
            $table->integer('status')->default(0)->comment('0=draft, 1=pending, 2=approved ');
            $table->dateTime('submited_at')->nullable()->comment('Final submit by FO');
            $table->dateTime('approved_at')->nullable()->comment('Final approved by DM');
            $table->integer('approved_by')->nullable()->comment('DM User Id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('child_marriage_informations');
    }
}
