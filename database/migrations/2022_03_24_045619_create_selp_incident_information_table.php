<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSelpIncidentInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('selp_incident_informations', function (Blueprint $table) {
            $table->id();
            
            /**
             * Employee information column
             */
            $table->string('employee_name');
            $table->string('employee_cell')->nullable($value=true);
            $table->string('employee_designation')->nullable($value=true);
            $table->integer('employee_pin');
            $table->smallInteger('employee_selpzone_id')->nullable($value=false);
            $table->smallInteger('employee_division_id');
            $table->smallInteger('employee_district_id')->nullable($value=true);
            $table->smallInteger('employee_upazila_id')->nullable($value=true);
            $table->smallInteger('information_provider_source_id');
            $table->smallInteger('type_of_dispute');
            $table->tinyInteger('complain_against_gender_id')->nullable($value=true);
            $table->smallInteger('selp_first_initiative_id')->nullable($value=true);
            /**
             * Survivor information column
             */
            $table->integer('dispute_id')->nullable($value=true);
            $table->string('survivor_name');
            $table->string('survivor_father_name')->nullable($value=true);
            $table->string('survivor_mother_name')->nullable($value=true);
            $table->string('survivor_husband_name')->nullable($value=true);
            $table->string('survivor_1st_contact_no');
            $table->string('survivor_2nd_contact_no')->nullable($value=true);
            $table->smallInteger('survivor_age')->nullable($value=true);
            $table->tinyInteger('survivor_sex_id')->nullable($value=true);
            $table->smallInteger('survivor_education_id')->nullable($value=true);
            $table->tinyInteger('survivor_religion_id')->nullable($value=true);
            $table->smallInteger('survivor_householdtype_id')->nullable($value=true);
            $table->decimal('survivor_monthly_income')->nullable($value=true)->default($value=0);
            $table->smallInteger('survivor_violence_location_id')->nullable($value=true);
            $table->smallInteger('survivor_marital_status_id')->nullable($value=true);
            $table->smallInteger('survivor_age_of_marriage')->nullable($value=true);
            $table->smallInteger('survivor_organization_affiliation_id')->nullable($value=true);
            $table->string('survivor_nid')->nullable($value=true);
            $table->smallInteger('survivor_reason_of_violence_id')->nullable($value=true);
            $table->smallInteger('survivor_place_of_violence_id')->nullable($value=true);
            $table->tinyInteger('survivor_disability_status_id')->nullable($value=true);


            /**
             * Perpetrator information
             */

            $table->tinyInteger('number_of_perpetrator')->nullable($value=true);
            $table->smallInteger('relation_with_main_perpetrator_id')->nullable($value=true);
            $table->smallInteger('if_perpetrator_family_member_id')->nullable($value=true);
            $table->tinyInteger('perpetrator_gender_id')->nullable($value=true);
            $table->smallInteger('perpetrator_age')->nullable($value=true);
            $table->smallInteger('perpetrator_education_id')->nullable($value=true);
            $table->smallInteger('perpetrator_occupation_id')->nullable($value=true);

            /**
             * Initiative for this incident information
             */

            $table->tinyInteger('earlier_survivor_initiative')->nullable($value=true);
            $table->smallInteger('earlier_survivor_initiative_place_id')->nullable($value=true);
            $table->smallInteger('cause_of_failour_coming_to_selp_id')->nullable($value=true);
            $table->smallInteger('selp_types_of_initiatives')->nullable($value=true);
            $table->smallInteger('selp_referral_initiatives')->nullable($value=true);
            $table->smallInteger('selp_direct_support')->nullable($value=true);
            $table->smallInteger('selp_alternative_dispute_resolution_id')->nullable($value=true);
            $table->date('selp_support_start_date')->nullable($value=true);
            $table->date('selp_support_closing_date')->nullable($value=true);
            $table->tinyInteger('selp_adrmoneyrecover_id')->nullable($value=true);
            $table->decimal('selp_amount_of_money_from_adr')->nullable($value=true);
            $table->tinyInteger('selp_adr_money_recover_benifitiaries')->nullable($value=true);


            /**
             * Court/case information
             */

            $table->tinyInteger('case_type')->nullable($value=true);
            $table->smallInteger('civilcase_id')->nullable($value=true);
            $table->smallInteger('policecase_id')->nullable($value=true);
            $table->smallInteger('pititioncase_id')->nullable($value=true);
            $table->smallInteger('moneyrecover_id')->nullable($value=true);
            $table->smallInteger('judgementstatus_id')->nullable($value=true);
            $table->smallInteger('program_participent_followup')->nullable($value=true);
            $table->smallInteger('no_of_followup_madeby_selp_staff')->nullable($value=true);
            $table->smallInteger('followup_id')->nullable($value=true);
            $table->date('case_start_date')->nullable($value=true);
            $table->date('judgement_date')->nullable($value=true);


            /**
             * Survivor previous violence history
             */

            $table->tinyInteger('have_survivor_face_violence_before')->nullable($value=true);
            $table->smallInteger('survivor_first_violence_age')->nullable($value=true);
            $table->string('violence_type_multiple_list')->nullable($value=true);
            $table->tinyInteger('survivor_seek_support_from_brac')->nullable($value=true);
            $table->smallInteger('bracsupporttype_id')->nullable($value=true);
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
