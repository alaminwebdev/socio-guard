<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSelpIncidentInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::dropIfExists('selp_incident_informations');
        Schema::create('selp_incident_informations', function (Blueprint $table) {
            
            $table->id();
            
            /**Employee information column */
            $table->bigInteger('complain_id')->comment('Complain ID or refer ID');
            $table->string('employee_name',100)->nullable($value=true);
            $table->string('employee_mobile_number')->nullable($value=true);
            $table->string('employee_designation')->nullable($value=true);
            $table->string('employee_pin')->nullable($value=true);
            $table->integer('employee_zone_id');
            $table->integer('employee_division_id');
            $table->integer('employee_district_id');
            $table->integer('employee_upazila_id');
            $table->integer('information_provider_source_id');
            $table->integer('brac_programe_name_id')->nullable($value=true);
            $table->string('referral_name')->nullable($value=true);
            $table->integer('referral_reletionship_id')->nullable($value=true);
            $table->smallInteger('gender_id')->nullable($value=true);
            $table->integer('occupation_id')->nullable($value=true);
            $table->integer('violence_reason_id')->nullable($value=true);

            /**Applicant information column */
            $table->tinyInteger('applicant_survivor_same')->nullable($value=true)->default($value=0)->comment('YES=1,NO=2');
            $table->string('applicant_name',100)->nullable($value=true);
            $table->string('applicant_father_name',100)->nullable($value=true);
            $table->string('applicant_mother_name',100)->nullable($value=true);
            $table->string('applicant_husband_name',100)->nullable($value=true);
            $table->smallInteger('applicant_age')->nullable($value=true);
            $table->string('applicant_mobile_number',20)->nullable($value=true);
            $table->string('applicant_mobile_number_on_request',20)->nullable($value=true);
            $table->smallInteger('applicant_gender_id')->nullable($value=true);
            $table->integer('applicant_education_id')->nullable($value=true);
            $table->smallInteger('applicant_religion_id')->nullable($value=true);
            $table->integer('applicant_division_id')->nullable($value=true);
            $table->integer('applicant_district_id')->nullable($value=true);
            $table->integer('applicant_upazila_id')->nullable($value=true);
            $table->integer('applicant_union_id')->nullable($value=true);
            $table->integer('applicant_village_id')->nullable($value=true);
            $table->string('applicant_ward',200)->nullable($value=true)->comment('ward');
            $table->integer('application_occupation_id')->nullable($value=true);
            
            /**Survivor information column */
            $table->string('survivor_name',100)->nullable($value=true);
            $table->string('survivor_father_name',100)->nullable($value=true);
            $table->string('survivor_mother_name',100)->nullable($value=true);
            $table->string('survivor_husband_name',100)->nullable($value=true);
            $table->smallInteger('survivor_age')->nullable($value=true);
            $table->string('survivor_mobile_number',20)->nullable($value=true);
            $table->string('survivor_mobile_number_on_request',20)->nullable($value=true);
            $table->smallInteger('survivor_gender_id')->nullable($value=true);
            $table->integer('survivor_education_id')->nullable($value=true);
            $table->smallInteger('survivor_religion_id')->nullable($value=true);
            $table->integer('survivor_division_id')->nullable($value=true);
            $table->integer('survivor_district_id')->nullable($value=true);
            $table->integer('survivor_upazila_id')->nullable($value=true);
            $table->integer('survivor_union_id')->nullable($value=true);
            $table->integer('survivor_village_id')->nullable($value=true);
            $table->string('survivor_ward',200)->nullable($value=true)->comment('ward');
            $table->integer('survivor_occupation_id')->nullable($value=true);


            /**Defendants information column */
            $table->smallInteger('number_of_defendants')->nullable($value=true);
            $table->string('main_defendants_name',100)->nullable($value=true);
            $table->integer('main_defendant_relation_id')->nullable($value=true);
            $table->smallInteger('main_defendant_gender_id')->nullable($value=true);
            $table->smallInteger('main_defendant_age')->nullable($value=true);
            $table->integer('defendant_division_id')->nullable($value=true);
            $table->integer('defendant_district_id')->nullable($value=true);
            $table->integer('defendant_upazila_id')->nullable($value=true);
            $table->integer('defendant_union_id')->nullable($value=true);
            $table->integer('defendant_village_id')->nullable($value=true);
            $table->string('defendant_ward',200)->nullable($value=true)->comment('ward');
            
            /**Selp information column */
            $table->integer('referral_no')->nullable($value=true);
            $table->string('referral',300)->nullable($value=true);
            $table->date('referral_date')->nullable($value=true);
            $table->integer('household_type_id')->nullable($value=true);
            $table->decimal('household_total_income',10,2)->nullable($value=true);
            $table->integer('violence_location_id')->nullable($value=true);
            $table->smallInteger('survivor_marital_status_id')->nullable($value=true);
            $table->smallInteger('survivor_age_of_marriage')->nullable($value=true);
            $table->integer('survivor_organization_affiliation_id')->nullable($value=true);
            $table->string('survivor_nid',100)->nullable($value=true);
            $table->integer('violence_place_id')->nullable($value=true);
            $table->integer('survivor_autistic_information_id')->nullable($value=true);
            $table->integer('defendant_family_member_id')->nullable($value=true);
            $table->integer('defendant_education_id')->nullable($value=true);
            $table->integer('defendant_occupation_id')->nullable($value=true);
            $table->string('earlier_survivor_initiative')->nullable($value=true);
            $table->integer('earlier_survivor_initiative_place')->nullable($value=true);
            $table->string('case_of_failour_coming_to_selp',200)->nullable($value=true);
            $table->tinyInteger('money_recovered_adr')->nullable($value=true)->comment('YES=1,NO=0');
            $table->decimal('amount_money_adr',10,2)->nullable($value=true);
            $table->decimal('money_from_adr',10,2)->nullable($value=true);
            $table->decimal('money_from_adr_boy',10,2)->nullable($value=true);
            $table->decimal('money_from_adr_girl',10,2)->nullable($value=true);
            $table->integer('case_type_id')->nullable($value=true);
            $table->integer('program_participant_followup')->nullable($value=true);
            $table->integer('followup_made_by_selp_staff')->nullable($value=true);
            $table->integer('followup_id')->nullable($value=true);
            $table->integer('referral_service_id')->nullable($value=true);
            $table->date('service_referral_date')->nullable($value=true);
            $table->tinyInteger('have_survivor_face_violence_before')->nullable($value=true)->comment('YES=1,NO=0');
            $table->smallInteger('survivor_first_face_violence_age')->nullable($value=true);
            $table->integer('survivor_first_face_violence_type')->nullable($value=true);
            $table->tinyInteger('survivor_seek_support_from_brac')->nullable($value=true)->comment('YES=1,NO=0');
            $table->integer('brac_supporttype_id')->nullable($value=true);
            $table->integer('user_created_by_id')->nullable($value=true);
            $table->integer('user_updated_by_id')->nullable($value=true);
            $table->smallInteger('flag_or_complain_status')->nullable($value=true);
            $table->tinyInteger('selp_initiative')->nullable($value=true)->comment('1=Advice and referral,2= Complain received');
            
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
        Schema::dropIfExists('selp_incident_informations');
    }
}
