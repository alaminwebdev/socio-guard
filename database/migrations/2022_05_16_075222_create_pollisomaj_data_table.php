<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePollisomajDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pollisomaj_data', function (Blueprint $table) {
            $table->id();
            $table->string('pollisomaj_data_ref');
            
            /** Step 1 */
                $table->integer('zone_id')->nullable($value=true);
                $table->integer('division_id')->nullable($value=true);
                $table->integer('district_id')->nullable($value=true);
                $table->integer('upazilla_id')->nullable($value=true);
                $table->integer('union_id')->nullable($value=true);
                $table->integer('village_id')->nullable($value=true);
                $table->string('ward_no')->nullable($value=true);
                $table->integer('pollisomaj_id')->nullable($value=true);
                $table->string('pollisomaj_name')->nullable($value=true);
                $table->date('ps_reform_date')->nullable($value=true);
                $table->integer('member_girls')->nullable($value=true);
                $table->integer('member_boys')->nullable($value=true);
                $table->integer('member_female')->nullable($value=true);
                $table->integer('member_male')->nullable($value=true);
                $table->integer('member_transgender')->nullable($value=true);
                $table->integer('general_member_total')->nullable($value=true);
                $table->integer('member_girls_pwd')->nullable($value=true);
                $table->integer('member_boys_pwd')->nullable($value=true);
                $table->integer('member_female_pwd')->nullable($value=true);
                $table->integer('member_male_pwd')->nullable($value=true);
                $table->integer('member_transgender_pwd')->nullable($value=true);
                $table->integer('general_member_pwd_total')->nullable($value=true);
                $table->integer('p_number')->nullable($value=true);
                $table->integer('s_number')->nullable($value=true);
                $table->integer('c_number')->nullable($value=true);
                

                // $table->integer('zone_id')->nullable($value=true);
                // $table->integer('division_id')->nullable($value=true);
                // $table->integer('district_id')->nullable($value=true);
                // $table->integer('upazilla_id')->nullable($value=true);
                // $table->integer('union_id')->nullable($value=true);
                // $table->integer('village_id')->nullable($value=true);
                // $table->integer('ward_no')->nullable($value=true);
                // $table->date('date_of_pollisomaj_reformation')->nullable($value=true);
                // $table->integer('member_girls')->nullable($value=true);
                // $table->integer('member_boys')->nullable($value=true);
                // $table->integer('member_female')->nullable($value=true);
                // $table->integer('member_male')->nullable($value=true);
                // $table->integer('member_transgender')->nullable($value=true);
                // $table->integer('member_girls_pwd')->nullable($value=true);
                // $table->integer('member_boys_pwd')->nullable($value=true);
                // $table->integer('member_female_pwd')->nullable($value=true);
                // $table->integer('member_male_pwd')->nullable($value=true);
                // $table->integer('member_transgender_pwd')->nullable($value=true);
                
            
            /** Step 2 */

                $table->integer('contacted_up_within_ps_member')->nullable($value=true);
                $table->integer('contacted_up_beyond_ps_member')->nullable($value=true);
                $table->integer('contacted_local_within_ps_member')->nullable($value=true);
                $table->integer('contacted_local_beyond_ps_member')->nullable($value=true);
                $table->integer('family_consultation_within_ps_member')->nullable($value=true);
                $table->integer('family_consultation_beyond_ps_member')->nullable($value=true);
                $table->integer('contacted_upazila_within_ps_member')->nullable($value=true);
                $table->integer('contacted_upazila_beyond_ps_member')->nullable($value=true);
                $table->integer('hotline_number_within_ps_member')->nullable($value=true);
                $table->integer('hotline_number_beyond_ps_member')->nullable($value=true);
                $table->integer('girls_risk_of_child_marriage')->nullable($value=true);
                $table->integer('girls_risk_of_child_marriage_pwd')->nullable($value=true);
                $table->integer('card_provided_among_girls')->nullable($value=true);
                $table->integer('card_provided_among_pwd')->nullable($value=true);
                $table->integer('girls_connected_to_service')->nullable($value=true);
                $table->integer('girls_connected_to_service_pwd')->nullable($value=true);
                $table->integer('girls_got_married_finally')->nullable($value=true);
                $table->integer('girls_got_married_finally_pwd')->nullable($value=true);
                $table->integer('illegal_divorce')->nullable($value=true);
                $table->integer('illegal_polygamy')->nullable($value=true);
                $table->integer('family_conflict')->nullable($value=true);
                $table->integer('hilla_marriage')->nullable($value=true);
                $table->integer('illegal_arbitration')->nullable($value=true);
                $table->integer('illegal_fatwah')->nullable($value=true);
                $table->integer('physical_torture')->nullable($value=true);
                $table->integer('sexual_harassment')->nullable($value=true);


                // $table->integer('ps_members')->nullable($value=true);
                // $table->integer('beyond_ps_members')->nullable($value=true);
                // $table->integer('ps_members_initiative')->nullable($value=true);
                // $table->integer('beyond_ps_members_initiative')->nullable($value=true);
                // $table->integer('girls_risk_of_child_marriage')->nullable($value=true);
                // $table->integer('girls_risk_of_child_marriage_initiative')->nullable($value=true);
                // $table->integer('girls_risk_of_child_marriage_pwd')->nullable($value=true);
                // $table->integer('girls_risk_of_child_marriage_pwd_initiative')->nullable($value=true);
                // $table->integer('girls_connected_to_service')->nullable($value=true);
                // $table->integer('girls_connected_to_service_initiative')->nullable($value=true);
                // $table->integer('girls_connected_to_service_pwd')->nullable($value=true);
                // $table->integer('girls_connected_to_service_pwd_initiative')->nullable($value=true);
                // $table->integer('girls_got_married_finally')->nullable($value=true);
                // $table->integer('girls_got_married_finally_initiative')->nullable($value=true);
                // $table->integer('girls_got_married_finally_pwd')->nullable($value=true);
                // $table->integer('girls_got_married_finally_pwd_initiative')->nullable($value=true);
                // $table->integer('illegal_divorce')->nullable($value=true);
                // $table->string('illegal_divorce_name')->nullable($value=true);
                // $table->string('illegal_divorce_gurdian')->nullable($value=true);
                // $table->string('illegal_divorce_village')->nullable($value=true);
                // $table->string('illegal_divorce_contact')->nullable($value=true);
                
                // $table->integer('illegal_polygamy')->nullable($value=true);
                // $table->string('illegal_polygamy_name')->nullable($value=true);
                // $table->string('illegal_polygamy_gurdian')->nullable($value=true);
                // $table->string('illegal_polygamy_village')->nullable($value=true);
                // $table->string('illegal_polygamy_contact')->nullable($value=true);


                // $table->integer('family_conflict')->nullable($value=true);
                // $table->string('family_conflict_name')->nullable($value=true);
                // $table->string('family_conflict_gurdian')->nullable($value=true);
                // $table->string('family_conflict_village')->nullable($value=true);
                // $table->string('family_conflict_contact')->nullable($value=true);

                // $table->integer('hilla_marriage')->nullable($value=true);
                // $table->string('hilla_marriage_name')->nullable($value=true);
                // $table->string('hilla_marriage_gurdian')->nullable($value=true);
                // $table->string('hilla_marriage_village')->nullable($value=true);
                // $table->string('hilla_marriage_contact')->nullable($value=true);

                // $table->integer('illegal_arbitration')->nullable($value=true);
                // $table->string('illegal_arbitration_name')->nullable($value=true);
                // $table->string('illegal_arbitration_gurdian')->nullable($value=true);
                // $table->string('illegal_arbitration_village')->nullable($value=true);
                // $table->string('illegal_arbitration_contact')->nullable($value=true);

                // $table->integer('illegal_fatwah')->nullable($value=true);
                // $table->string('illegal_fatwah_name')->nullable($value=true);
                // $table->string('illegal_fatwah_gurdian')->nullable($value=true);
                // $table->string('illegal_fatwah_village')->nullable($value=true);
                // $table->string('illegal_fatwah_contact')->nullable($value=true);

                // $table->integer('physical_torture')->nullable($value=true);
                // $table->string('physical_torture_name')->nullable($value=true);
                // $table->string('physical_torture_gurdian')->nullable($value=true);
                // $table->string('physical_torture_village')->nullable($value=true);
                // $table->string('physical_torture_contact')->nullable($value=true);
            
            /**Step 3 */
                $table->integer('ps_mem_gov_elec_men')->nullable($value=true);
                $table->integer('ps_mem_gov_elec_women')->nullable($value=true);
                $table->integer('ps_mem_gov_elec_transgender')->nullable($value=true);
                $table->integer('ps_mem_gov_elec_pwd')->nullable($value=true);
                $table->integer('ps_mem_gov_elec_men_elected')->nullable($value=true);
                $table->integer('ps_mem_gov_elec_women_elected')->nullable($value=true);
                $table->integer('ps_mem_gov_elec_transgender_elected')->nullable($value=true);
                $table->integer('ps_mem_gov_elec_pwd_elected')->nullable($value=true);
                $table->integer('contested_as_joyeeta')->nullable($value=true);
                $table->integer('joyeeta_contested_women')->nullable($value=true);

                $table->integer('joyeeta_contested_pwd')->nullable($value=true);
                $table->integer('joyeeta_dis_selected')->nullable($value=true);
                $table->integer('joyeeta_div_selected')->nullable($value=true);
                $table->integer('joyeeta_national_selected')->nullable($value=true);
                $table->integer('school_committee_boys')->nullable($value=true);
                $table->integer('school_committee_girls')->nullable($value=true);
                $table->integer('school_committee_male')->nullable($value=true);
                $table->integer('school_committee_female')->nullable($value=true);
                $table->integer('school_committee_transgender')->nullable($value=true);
                $table->integer('school_committee_total')->nullable($value=true);

                $table->integer('school_committee_pwd_boys')->nullable($value=true);
                $table->integer('school_committee_pwd_girls')->nullable($value=true);
                $table->integer('school_committee_pwd_male')->nullable($value=true);
                $table->integer('school_committee_pwd_female')->nullable($value=true);
                $table->integer('school_committee_pwd_transgender')->nullable($value=true);
                $table->integer('school_committee_pwd_total')->nullable($value=true);
                $table->integer('hatbazar_committee_boys')->nullable($value=true);
                $table->integer('hatbazar_committee_girls')->nullable($value=true);
                $table->integer('hatbazar_committee_male')->nullable($value=true);
                $table->integer('hatbazar_committee_female')->nullable($value=true);

                $table->integer('hatbazar_committee_transgender')->nullable($value=true);
                $table->integer('hatbazar_committee_total')->nullable($value=true);
                $table->integer('hatbazar_committee_pwd_boys')->nullable($value=true);
                $table->integer('hatbazar_committee_pwd_girls')->nullable($value=true);
                $table->integer('hatbazar_committee_pwd_male')->nullable($value=true);
                $table->integer('hatbazar_committee_pwd_female')->nullable($value=true);
                $table->integer('hatbazar_committee_pwd_transgender')->nullable($value=true);
                $table->integer('hatbazar_committee_pwd_total')->nullable($value=true);
                $table->integer('stading_committee_boys')->nullable($value=true);
                $table->integer('stading_committee_girls')->nullable($value=true);

                $table->integer('stading_committee_male')->nullable($value=true);
                $table->integer('stading_committee_female')->nullable($value=true);
                $table->integer('stading_committee_transgender')->nullable($value=true);
                $table->integer('stading_committee_total')->nullable($value=true);
                $table->integer('stading_committee_pwd_boys')->nullable($value=true);
                $table->integer('stading_committee_pwd_girls')->nullable($value=true);
                $table->integer('stading_committee_pwd_male')->nullable($value=true);
                $table->integer('stading_committee_pwd_female')->nullable($value=true);
                $table->integer('stading_committee_pwd_transgender')->nullable($value=true);
                $table->integer('stading_committee_pwd_total')->nullable($value=true);

                $table->integer('clinic_committee_boys')->nullable($value=true);
                $table->integer('clinic_committee_girls')->nullable($value=true);
                $table->integer('clinic_committee_male')->nullable($value=true);
                $table->integer('clinic_committee_female')->nullable($value=true);
                $table->integer('clinic_committee_transgender')->nullable($value=true);
                $table->integer('clinic_committee_total')->nullable($value=true);
                $table->integer('clinic_committee_pwd_boys')->nullable($value=true);
                $table->integer('clinic_committee_pwd_girls')->nullable($value=true);
                $table->integer('clinic_committee_pwd_male')->nullable($value=true);
                $table->integer('clinic_committee_pwd_female')->nullable($value=true);

                $table->integer('clinic_committee_pwd_transgender')->nullable($value=true);
                $table->integer('clinic_committee_pwd_total')->nullable($value=true);
                $table->integer('institution_committee_boys')->nullable($value=true);
                $table->integer('institution_committee_girls')->nullable($value=true);
                $table->integer('institution_committee_male')->nullable($value=true);
                $table->integer('institution_committee_female')->nullable($value=true);
                $table->integer('institution_committee_transgender')->nullable($value=true);
                $table->integer('institution_committee_total')->nullable($value=true);
                $table->integer('institution_committee_pwd_boys')->nullable($value=true);
                $table->integer('institution_committee_pwd_girls')->nullable($value=true);

                $table->integer('institution_committee_pwd_male')->nullable($value=true);
                $table->integer('institution_committee_pwd_female')->nullable($value=true);
                $table->integer('institution_committee_pwd_transgender')->nullable($value=true);
                $table->integer('institution_committee_pwd_total')->nullable($value=true);
                $table->integer('solidarity_committee_boys')->nullable($value=true);
                $table->integer('solidarity_committee_girls')->nullable($value=true);
                $table->integer('solidarity_committee_male')->nullable($value=true);
                $table->integer('solidarity_committee_female')->nullable($value=true);
                $table->integer('solidarity_committee_transgender')->nullable($value=true);
                $table->integer('solidarity_committee_total')->nullable($value=true);

                $table->integer('solidarity_committee_pwd_boys')->nullable($value=true);
                $table->integer('solidarity_committee_pwd_girls')->nullable($value=true);
                $table->integer('solidarity_committee_pwd_male')->nullable($value=true);
                $table->integer('solidarity_committee_pwd_female')->nullable($value=true);
                $table->integer('solidarity_committee_pwd_transgender')->nullable($value=true);
                $table->integer('solidarity_committee_pwd_total')->nullable($value=true);
                $table->integer('welfare_committee_boys')->nullable($value=true);
                $table->integer('welfare_committee_girls')->nullable($value=true);
                $table->integer('welfare_committee_male')->nullable($value=true);
                $table->integer('welfare_committee_female')->nullable($value=true);

                $table->integer('welfare_committee_transgender')->nullable($value=true);
                $table->integer('welfare_committee_total')->nullable($value=true);
                $table->integer('welfare_committee_pwd_boys')->nullable($value=true);
                $table->integer('welfare_committee_pwd_girls')->nullable($value=true);
                $table->integer('welfare_committee_pwd_male')->nullable($value=true);
                $table->integer('welfare_committee_pwd_female')->nullable($value=true);
                $table->integer('welfare_committee_pwd_transgender')->nullable($value=true);
                $table->integer('welfare_committee_pwd_total')->nullable($value=true);

                // Extra
                // $table->integer('ps_mem_gov_elec')->nullable($value=true);
                // $table->integer('ps_mem_gov_elec_women')->nullable($value=true);
                // $table->integer('ps_mem_gov_elec_transgender')->nullable($value=true);
                // $table->integer('ps_mem_gov_elec_pwd')->nullable($value=true);
                // $table->integer('ps_mem_gov_elec_elected')->nullable($value=true);

                // $table->integer('ps_mem_gov_elec_women_elected')->nullable($value=true);
                // $table->integer('ps_mem_gov_elec_transgender_elected')->nullable($value=true);
                // $table->integer('ps_mem_gov_elec_pwd_elected')->nullable($value=true);
                // $table->integer('ps_mem_joyeets_con')->nullable($value=true);
                // $table->integer('contested_as_joyeeta')->nullable($value=true);

                // $table->integer('ps_mem_joyeeta_selected')->nullable($value=true);
                // $table->integer('joyeeta_dis_selected')->nullable($value=true);
                // $table->integer('joyeeta_national_selected')->nullable($value=true);
                // $table->integer('ps_in_different_committee')->nullable($value=true);
                // $table->integer('school_madrasha_committee')->nullable($value=true);

                // $table->integer('hat_bazar_committee')->nullable($value=true);
                // $table->integer('up_committee')->nullable($value=true);
                // $table->integer('com_clinic_committee')->nullable($value=true);
                // $table->integer('religion_institute_committee')->nullable($value=true);
                // $table->integer('vssc')->nullable($value=true);
                // $table->integer('ngo_social_committee')->nullable($value=true);



            /**Step 4 */
                $table->integer('iga_training_financial_ps_mem_boys')->nullable($value=true);
                $table->integer('iga_training_financial_ps_mem_girls')->nullable($value=true);
                $table->integer('iga_training_financial_ps_mem_men')->nullable($value=true);
                $table->integer('iga_training_financial_ps_mem_women')->nullable($value=true);
                $table->integer('iga_training_financial_ps_mem_transgender')->nullable($value=true);
                $table->integer('iga_training_financial_ps_mem_total')->nullable($value=true);
                $table->integer('iga_training_financial_ps_mem_pwd_boys')->nullable($value=true);
                $table->integer('iga_training_financial_ps_mem_pwd_girls')->nullable($value=true);
                $table->integer('iga_training_financial_ps_mem_pwd_male')->nullable($value=true);
                $table->integer('iga_training_financial_ps_mem_pwd_women')->nullable($value=true);

                $table->integer('iga_training_financial_ps_mem_pwd_transgender')->nullable($value=true);
                $table->integer('iga_training_financial_ps_mem_pwd_total')->nullable($value=true);
                $table->integer('iga_training_financial_without_ps_mem_boys')->nullable($value=true);
                $table->integer('iga_training_financial_without_ps_mem_girls')->nullable($value=true);
                $table->integer('iga_training_financial_without_ps_mem_men')->nullable($value=true);
                $table->integer('iga_training_financial_without_ps_mem_women')->nullable($value=true);
                $table->integer('iga_training_financial_without_ps_mem_transgender')->nullable($value=true);
                $table->integer('iga_training_financial_without_ps_mem_total')->nullable($value=true);
                $table->integer('iga_training_financial_without_ps_mem_pwd_boys')->nullable($value=true);
                $table->integer('iga_training_financial_without_ps_mem_pwd_girls')->nullable($value=true);

                $table->integer('iga_training_financial_without_ps_mem_pwd_male')->nullable($value=true);
                $table->integer('iga_training_financial_without_ps_mem_pwd_women')->nullable($value=true);
                $table->integer('iga_training_financial_without_ps_mem_pwd_transgender')->nullable($value=true);
                $table->integer('iga_training_financial_without_ps_mem_pwd_total')->nullable($value=true);
                $table->integer('iga_training_ps_mem_boys')->nullable($value=true);
                $table->integer('iga_training_ps_mem_girls')->nullable($value=true);
                $table->integer('iga_training_ps_mem_women')->nullable($value=true);
                $table->integer('iga_training_ps_mem_transgender')->nullable($value=true);
                $table->integer('iga_training_ps_mem_total')->nullable($value=true);
                $table->integer('iga_training_ps_mem_pwd_boys')->nullable($value=true);

                $table->integer('iga_training_ps_mem_pwd_girls')->nullable($value=true);
                $table->integer('iga_training_ps_mem_pwd_men')->nullable($value=true);
                $table->integer('iga_training_ps_mem_pwd_women')->nullable($value=true);
                $table->integer('iga_training_ps_mem_pwd_transgender')->nullable($value=true);
                $table->integer('iga_training_ps_mem_pwd_total')->nullable($value=true);
                $table->integer('iga_training_without_ps_mem_boys')->nullable($value=true);
                $table->integer('iga_training_without_ps_mem_girls')->nullable($value=true);
                $table->integer('iga_training_without_ps_mem_men')->nullable($value=true);
                $table->integer('iga_training_without_ps_mem_women')->nullable($value=true);
                $table->integer('iga_training_without_ps_mem_transgender')->nullable($value=true);

                $table->integer('iga_training_without_ps_mem_total')->nullable($value=true);
                $table->integer('iga_training_without_ps_mem_pwd_boys')->nullable($value=true);
                $table->integer('iga_training_without_ps_mem_pwd_girls')->nullable($value=true);
                $table->integer('iga_training_without_ps_mem_pwd_men')->nullable($value=true);
                $table->integer('iga_training_without_ps_mem_pwd_women')->nullable($value=true);
                $table->integer('iga_training_without_ps_mem_pwd_transgender')->nullable($value=true);
                $table->integer('iga_training_without_ps_mem_pwd_total')->nullable($value=true);

                // $table->integer('iga_training_ps_mem')->nullable($value=true);
                // $table->integer('iga_training_ps_mem_girls')->nullable($value=true);
                // $table->integer('iga_training_ps_mem_women')->nullable($value=true);
                // $table->integer('iga_training_ps_mem_transgender')->nullable($value=true);
                // $table->integer('iga_training_without_ps_mem_girls')->nullable($value=true);
                // $table->integer('iga_training_without_ps_mem_women')->nullable($value=true);
                // $table->integer('iga_training_without_ps_mem_transgender')->nullable($value=true);

                // $table->integer('iga_training_financial_ps_mem')->nullable($value=true);
                // $table->integer('iga_training_financial_ps_mem_girls')->nullable($value=true);
                // $table->integer('iga_training_financial_ps_mem_women')->nullable($value=true);
                // $table->integer('iga_training_financial_ps_mem_transgender')->nullable($value=true);
                // $table->integer('iga_training_financial_without_ps_mem_girls')->nullable($value=true);
                // $table->integer('iga_training_financial_without_ps_mem_women')->nullable($value=true);
                // $table->integer('iga_training_financial_without_ps_mem_transgender')->nullable($value=true);


            /** Step 5 */ 
                

                // $table->integer('food_for_work_girls')->nullable($value=true);
                // $table->integer('food_for_work_women')->nullable($value=true);
                // $table->integer('food_for_work_transgender')->nullable($value=true);
                // $table->integer('food_for_work_girls_pwd')->nullable($value=true);
                // $table->integer('food_for_work_women_pwd')->nullable($value=true);
                // $table->integer('food_for_work_transgender_pwd')->nullable($value=true);


                // $table->integer('vgf_vgd_girls')->nullable($value=true);
                // $table->integer('vgf_vgd_women')->nullable($value=true);
                // $table->integer('vgf_vgd_transgender')->nullable($value=true);
                // $table->integer('vgf_vgd_girls_pwd')->nullable($value=true);
                // $table->integer('vgf_vgd_women_pwd')->nullable($value=true);
                // $table->integer('vgf_vgd_transgender_pwd')->nullable($value=true);


                // $table->integer('programe_for_poorest_girls')->nullable($value=true);
                // $table->integer('programe_for_poorest_women')->nullable($value=true);
                // $table->integer('programe_for_poorest_transgender')->nullable($value=true);
                // $table->integer('programe_for_poorest_girls_pwd')->nullable($value=true);
                // $table->integer('programe_for_poorest_women_pwd')->nullable($value=true);
                // $table->integer('programe_for_poorest_transgender_pwd')->nullable($value=true);

                // $table->integer('maternity_allowance_girls')->nullable($value=true);
                // $table->integer('maternity_allowance_women')->nullable($value=true);
                // $table->integer('maternity_allowance_transgender')->nullable($value=true);
                // $table->integer('maternity_allowance_girls_pwd')->nullable($value=true);
                // $table->integer('maternity_allowance_women_pwd')->nullable($value=true);
                // $table->integer('maternity_allowance_transgender_pwd')->nullable($value=true);


                // $table->integer('freedom_fighters_girls')->nullable($value=true);
                // $table->integer('freedom_fighters_women')->nullable($value=true);
                // $table->integer('freedom_fighters_transgender')->nullable($value=true);
                // $table->integer('freedom_fighters_girls_pwd')->nullable($value=true);
                // $table->integer('freedom_fighters_women_pwd')->nullable($value=true);
                // $table->integer('freedom_fighters_transgender_pwd')->nullable($value=true);

                // $table->integer('disaster_allocation_girls')->nullable($value=true);
                // $table->integer('disaster_allocation_women')->nullable($value=true);
                // $table->integer('disaster_allocation_transgender')->nullable($value=true);
                // $table->integer('disaster_allocation_girls_pwd')->nullable($value=true);
                // $table->integer('disaster_allocation_women_pwd')->nullable($value=true);
                // $table->integer('disaster_allocation_transgender_pwd')->nullable($value=true);


                // $table->integer('relief_activities_girls')->nullable($value=true);
                // $table->integer('relief_activities_women')->nullable($value=true);
                // $table->integer('relief_activities_transgender')->nullable($value=true);
                // $table->integer('relief_activities_girls_pwd')->nullable($value=true);
                // $table->integer('relief_activities_women_pwd')->nullable($value=true);
                // $table->integer('relief_activities_transgender_pwd')->nullable($value=true);

                // $table->integer('relief_gratuitous_girls')->nullable($value=true);
                // $table->integer('relief_gratuitous_women')->nullable($value=true);
                // $table->integer('relief_gratuitous_transgender')->nullable($value=true);
                // $table->integer('relief_gratuitous_girls_pwd')->nullable($value=true);
                // $table->integer('relief_gratuitous_women_pwd')->nullable($value=true);
                // $table->integer('relief_gratuitous_transgender_pwd')->nullable($value=true);


                // $table->integer('one_house_one_firm_girls')->nullable($value=true);
                // $table->integer('one_house_one_firm_women')->nullable($value=true);
                // $table->integer('one_house_one_firm_transgender')->nullable($value=true);
                // $table->integer('one_house_one_firm_girls_pwd')->nullable($value=true);
                // $table->integer('one_house_one_firm_women_pwd')->nullable($value=true);
                // $table->integer('one_house_one_firm_transgender_pwd')->nullable($value=true);


                // $table->integer('stipned_for_disabilities_girls')->nullable($value=true);
                // $table->integer('stipned_for_disabilities_women')->nullable($value=true);
                // $table->integer('stipned_for_disabilities_transgender')->nullable($value=true);
                // $table->integer('stipned_for_disabilities_girls_pwd')->nullable($value=true);
                // $table->integer('stipned_for_disabilities_women_pwd')->nullable($value=true);
                // $table->integer('stipned_for_disabilities_transgender_pwd')->nullable($value=true);


                // $table->integer('others_girls')->nullable($value=true);
                // $table->integer('others_women')->nullable($value=true);
                // $table->integer('others_transgender')->nullable($value=true);
                // $table->integer('others_girls_pwd')->nullable($value=true);
                // $table->integer('others_women_pwd')->nullable($value=true);
                // $table->integer('others_transgender_pwd')->nullable($value=true);

            /** Step 6 */
            $table->integer('session_with_men_total')->nullable($value=true);
            $table->integer('session_with_men_pwd_total')->nullable($value=true);
            $table->integer('session_with_women_total')->nullable($value=true);
            $table->integer('session_with_women_pwd_total')->nullable($value=true);
            $table->integer('session_with_adolescent_boys')->nullable($value=true);
            $table->integer('session_with_adolescent_girls')->nullable($value=true);
            $table->integer('session_with_adolescent_total')->nullable($value=true);
            $table->integer('session_with_adolescent_pwd_total')->nullable($value=true);
            $table->integer('session_with_ps_boys')->nullable($value=true);
            $table->integer('session_with_ps_girls')->nullable($value=true);
            $table->integer('session_with_ps_men')->nullable($value=true);
            $table->integer('session_with_ps_women')->nullable($value=true);
            $table->integer('session_with_ps_transgender')->nullable($value=true);
            $table->integer('session_with_ps_total')->nullable($value=true);
            $table->integer('capacity_building_training_by_selp_boy')->nullable($value=true);
            $table->integer('capacity_building_training_by_selp_girls')->nullable($value=true);
            $table->integer('capacity_building_training_by_selp_men')->nullable($value=true);
            $table->integer('capacity_building_training_by_selp_women')->nullable($value=true);
            $table->integer('capacity_building_training_by_selp_transgender')->nullable($value=true);
            $table->integer('capacity_building_training_by_selp_total')->nullable($value=true);
            $table->integer('capacity_building_training_by_selp_boy_pwd')->nullable($value=true);
            $table->integer('capacity_building_training_by_selp_girls_pwd')->nullable($value=true);
            $table->integer('capacity_building_training_by_selp_men_pwd')->nullable($value=true);
            $table->integer('capacity_building_training_by_selp_women_pwd')->nullable($value=true);
            $table->integer('capacity_building_training_by_selp_girls_transgender')->nullable($value=true);
            $table->integer('capacity_building_training_by_selp_pwd_total')->nullable($value=true);

                // $table->integer('training_session_by_selp')->nullable($value=true);
                // $table->integer('training_session_by_selp_girls')->nullable($value=true);
                // $table->integer('training_session_by_selp_women')->nullable($value=true);
                // $table->integer('training_session_by_selp_transgender')->nullable($value=true);
                // $table->integer('training_session_by_selp_girls_pwd')->nullable($value=true);
                // $table->integer('training_session_by_selp_women_pwd')->nullable($value=true);
                // $table->integer('training_session_by_selp_transgender_pwd')->nullable($value=true);

                // $table->integer('capacity_building_training_by_selp')->nullable($value=true);
                // $table->integer('capacity_building_training_by_selp_girls')->nullable($value=true);
                // $table->integer('capacity_building_training_by_selp_women')->nullable($value=true);
                // $table->integer('capacity_building_training_by_selp_transgender')->nullable($value=true);
                // $table->integer('capacity_building_training_by_selp_girls_pwd')->nullable($value=true);
                // $table->integer('capacity_building_training_by_selp_women_pwd')->nullable($value=true);
                // $table->integer('capacity_building_training_by_selp_transgender_pwd')->nullable($value=true);
            
            /** Step 7 */
                $table->integer('womens_day_celebration_boys')->nullable($value=true);
                $table->integer('womens_day_celebration_girls')->nullable($value=true);
                $table->integer('womens_day_celebration_men')->nullable($value=true);
                $table->integer('womens_day_celebration_women')->nullable($value=true);
                $table->integer('womens_day_celebration_transgender')->nullable($value=true);
                $table->integer('womens_day_celebration_total')->nullable($value=true);
                $table->date('womens_day_celebration_date')->nullable($value=true);
                $table->integer('womens_day_celebration_pwd_boys')->nullable($value=true);
                $table->integer('womens_day_celebration_pwd_girls')->nullable($value=true);
                $table->integer('womens_day_celebration_pwd_men')->nullable($value=true);
                $table->integer('womens_day_celebration_pwd_women')->nullable($value=true);
                $table->integer('womens_day_celebration_pwd_transgender')->nullable($value=true);
                $table->integer('womens_day_celebration_pwd_total')->nullable($value=true);
                $table->integer('celebration_days_campaign_boys')->nullable($value=true);
                $table->integer('celebration_days_campaign_girls')->nullable($value=true);
                $table->integer('celebration_days_campaign_men')->nullable($value=true);
                $table->integer('celebration_days_campaign_women')->nullable($value=true);
                $table->integer('celebration_days_campaign_transgender')->nullable($value=true);
                $table->integer('celebration_days_campaign_total')->nullable($value=true);
                $table->date('celebration_days_campaign_date')->nullable($value=true);
                $table->integer('celebration_days_campaign_pwd_boys')->nullable($value=true);
                $table->integer('celebration_days_campaign_pwd_girls')->nullable($value=true);
                $table->integer('celebration_days_campaign_pwd_men')->nullable($value=true);
                $table->integer('celebration_days_campaign_pwd_women')->nullable($value=true);
                $table->integer('celebration_days_campaign_pwd_transgender')->nullable($value=true);
                $table->integer('celebration_days_campaign_pwd_total')->nullable($value=true);
                $table->integer('legal_aid_days_boys')->nullable($value=true);
                $table->integer('legal_aid_days_girls')->nullable($value=true);
                $table->integer('legal_aid_days_men')->nullable($value=true);
                $table->integer('legal_aid_days_women')->nullable($value=true);
                $table->integer('legal_aid_days_transgender')->nullable($value=true);
                $table->integer('legal_aid_days_total')->nullable($value=true);
                $table->date('legal_aid_days_date')->nullable($value=true);
                $table->integer('legal_aid_days_pwd_boys')->nullable($value=true);
                $table->integer('legal_aid_days_pwd_girls')->nullable($value=true);
                $table->integer('legal_aid_days_pwd_men')->nullable($value=true);
                $table->integer('legal_aid_days_pwd_women')->nullable($value=true);
                $table->integer('legal_aid_days_pwd_transgender')->nullable($value=true);
                $table->integer('legal_aid_days_pwd_total')->nullable($value=true);

                // $table->integer('boys_girls_meeting')->nullable($value=true);
                // $table->date('boys_girls_meeting_date')->nullable($value=true);
                // $table->integer('boys_girls_meeting_participent_girls')->nullable($value=true);
                // $table->integer('boys_girls_meeting_participent_women')->nullable($value=true);
                // $table->integer('boys_girls_meeting_participent_transgender')->nullable($value=true);
                // $table->integer('boys_girls_meeting_participent_girls_pwd')->nullable($value=true);
                // $table->integer('boys_girls_meeting_participent_women_pwd')->nullable($value=true);
                // $table->integer('boys_girls_meeting_participent_transgender_pwd')->nullable($value=true);

                // $table->integer('couple_meeting')->nullable($value=true);
                // $table->date('couple_meeting_date')->nullable($value=true);
                // $table->integer('couple_meeting_participent_girls')->nullable($value=true);
                // $table->integer('couple_meeting_participent_women')->nullable($value=true);
                // $table->integer('couple_meeting_participent_transgender')->nullable($value=true);
                // $table->integer('couple_meeting_participent_girls_pwd')->nullable($value=true);
                // $table->integer('couple_meeting_participent_women_pwd')->nullable($value=true);
                // $table->integer('couple_meeting_participent_transgender_pwd')->nullable($value=true);
                
                // $table->integer('community_mobilization_meeting')->nullable($value=true);
                // $table->date('community_mobilization_meeting_date')->nullable($value=true);
                // $table->integer('community_mobilization_meeting_participent_girls')->nullable($value=true);
            
            /** Step 8 */ 
                $table->integer('social_cohesion_event')->nullable($value=true);
                $table->date('social_cohesion_event_date')->nullable($value=true);
                $table->integer('social_cohesion_event_participent_girl')->nullable($value=true);
                $table->integer('social_cohesion_event_participent_boy')->nullable($value=true);
                $table->integer('social_cohesion_event_participent_women')->nullable($value=true);
                $table->integer('social_cohesion_event_participent_men')->nullable($value=true);
                $table->integer('social_cohesion_event_participent_transgender')->nullable($value=true);
                $table->integer('social_cohesion_event_participent_total')->nullable($value=true);
                $table->integer('upazila_stakeholder_meeting')->nullable($value=true);
                $table->date('upazila_stakeholder_meeting_date')->nullable($value=true);
                $table->integer('upazila_stakeholder_meeting_participent_men_gob')->nullable($value=true);
                $table->integer('upazila_stakeholder_meeting_participent_women_gob')->nullable($value=true);
                $table->integer('upazila_stakeholder_meeting_participent_boy')->nullable($value=true);
                $table->integer('upazila_stakeholder_meeting_participent_girl')->nullable($value=true);
                $table->integer('upazila_stakeholder_meeting_participent_men')->nullable($value=true);
                $table->integer('upazila_stakeholder_meeting_participent_women')->nullable($value=true);
                $table->integer('upazila_stakeholder_meeting_participent_transgender')->nullable($value=true);
                $table->integer('upazila_stakeholder_meeting_participent_total')->nullable($value=true);
                $table->integer('upazila_stakeholder_meeting_participent_pwd_boy')->nullable($value=true);
                $table->integer('upazila_stakeholder_meeting_participent_pwd_girl')->nullable($value=true);
                $table->integer('upazila_stakeholder_meeting_participent_pwd_men')->nullable($value=true);
                $table->integer('upazila_stakeholder_meeting_participent_pwd_women')->nullable($value=true);
                $table->integer('upazila_stakeholder_meeting_participent_pwd_transgender')->nullable($value=true);
                $table->integer('upazila_stakeholder_meeting_participent_pwd_total')->nullable($value=true);

                // $table->integer('social_cohesion_event')->nullable($value=true);
                // $table->date('social_cohesion_event_date')->nullable($value=true);
                // $table->integer('social_cohesion_event_participent_girl')->nullable($value=true);
                // $table->integer('social_cohesion_event_participent_boy')->nullable($value=true);
                // $table->integer('social_cohesion_event_participent_women')->nullable($value=true);
                // $table->integer('social_cohesion_event_participent_men')->nullable($value=true);
                // $table->integer('social_cohesion_event_participent_transgender')->nullable($value=true);


                // $table->integer('upazila_stakeholder_meeting')->nullable($value=true);
                // $table->date('upazila_stakeholder_meeting_date')->nullable($value=true);
                // $table->integer('upazila_stakeholder_meeting_participent_girl')->nullable($value=true);
                // $table->integer('upazila_stakeholder_meeting_participent_boy')->nullable($value=true);
                // $table->integer('upazila_stakeholder_meeting_participent_women')->nullable($value=true);
                // $table->integer('upazila_stakeholder_meeting_participent_men')->nullable($value=true);
                // $table->integer('upazila_stakeholder_meeting_participent_transgender')->nullable($value=true);
                // $table->integer('upazila_stakeholder_meeting_participent_women_gob')->nullable($value=true);
                // $table->integer('upazila_stakeholder_meeting_participent_men_gob')->nullable($value=true);

                // $table->integer('client_workshop')->nullable($value=true);
                // $table->date('client_workshop_date')->nullable($value=true);
                // $table->integer('client_workshop_girl')->nullable($value=true);
                // $table->integer('client_workshop_boy')->nullable($value=true);
                // $table->integer('client_workshop_women')->nullable($value=true);
                // $table->integer('client_workshop_men')->nullable($value=true);
                // $table->integer('client_workshop_transgender')->nullable($value=true);

                // $table->integer('client_workshop_girl_pwd')->nullable($value=true);
                // $table->integer('client_workshop_boy_pwd')->nullable($value=true);
                // $table->integer('client_workshop_women_pwd')->nullable($value=true);
                // $table->integer('client_workshop_men_pwd')->nullable($value=true);
                // $table->integer('client_workshop_transgender_pwd')->nullable($value=true);

            /**Step 9 */    
                $table->integer('panel_staff_workshop')->nullable($value=true);
                $table->date('panel_staff_date')->nullable($value=true);
                $table->integer('panel_lawyer')->nullable($value=true);
                $table->date('panel_lawyer_date')->nullable($value=true);
                $table->integer('external_network_dlac_meeting')->nullable($value=true);
                $table->integer('external_network_dlac_meeting_male')->nullable($value=true);
                $table->integer('external_network_dlac_meeting_female')->nullable($value=true);
                $table->integer('external_network_dlac_meeting_total')->nullable($value=true);
                $table->date('external_network_dlac_meeting_date')->nullable($value=true);
                $table->integer('pt_group')->nullable($value=true);
                $table->integer('pt_group_performer_boy')->nullable($value=true);
                $table->integer('pt_group_performer_girl')->nullable($value=true);
                $table->integer('pt_group_performer_men')->nullable($value=true);
                $table->integer('pt_group_performer_women')->nullable($value=true);
                $table->integer('pt_group_performer_transgender')->nullable($value=true);
                $table->integer('pt_group_performer_total')->nullable($value=true);
                $table->integer('pt_group_performer_boy_pwd')->nullable($value=true);
                $table->integer('pt_group_performer_girl_pwd')->nullable($value=true);
                $table->integer('pt_group_performer_men_pwd')->nullable($value=true);
                $table->integer('pt_group_performer_women_pwd')->nullable($value=true);
                $table->integer('pt_group_performer_transgender_pwd')->nullable($value=true);
                $table->integer('pt_group_performer_transgender_pwd_total')->nullable($value=true);

                // $table->integer('panel_staff_workshop')->nullable($value=true);
                // $table->date('panel_staff_date')->nullable($value=true);
                // $table->integer('panel_lawyer')->nullable($value=true);

                // $table->integer('external_network_dlac_meeting')->nullable($value=true);
                // $table->date('external_network_dlac_meeting_date')->nullable($value=true);

                // $table->integer('external_network_occ_meeting')->nullable($value=true);
                // $table->date('external_network_occ_meeting_date')->nullable($value=true);
                // $table->integer('external_network_police_meeting')->nullable($value=true);
                // $table->date('external_network_police_meeting_date')->nullable($value=true);
                // $table->integer('external_network_women_meeting')->nullable($value=true);
                // $table->date('external_network_women_meeting_date')->nullable($value=true);
                // $table->integer('external_network_issue_meeting')->nullable($value=true);
                // $table->date('external_network_issue_meeting_date')->nullable($value=true);

                // $table->integer('external_network_stakeholder_meeting')->nullable($value=true);
                // $table->date('external_network_stakeholder_meeting_date')->nullable($value=true);

                // $table->integer('external_network_ngo_meeting')->nullable($value=true);
                // $table->date('external_network_ngo_meeting_date')->nullable($value=true);

                // $table->integer('pt_group')->nullable($value=true);
                // $table->date('pt_group_formation_date')->nullable($value=true);
                // $table->integer('pt_group_performer_girl')->nullable($value=true);
                // $table->integer('pt_group_performer_boy')->nullable($value=true);
                // $table->integer('pt_group_performer_women')->nullable($value=true);
                // $table->integer('pt_group_performer_men')->nullable($value=true);
                // $table->integer('pt_group_performer_transgender')->nullable($value=true);

                // $table->integer('pt_group_performer_girl_pwd')->nullable($value=true);
                // $table->integer('pt_group_performer_boy_pwd')->nullable($value=true);
                // $table->integer('pt_group_performer_women_pwd')->nullable($value=true);
                // $table->integer('pt_group_performer_men_pwd')->nullable($value=true);
                // $table->integer('pt_group_performer_transgender_pwd')->nullable($value=true);
            
            /** Step 10 */
                $table->integer('production_workshop_spa')->nullable($value=true);
                $table->integer('production_workshop_cost_recovery')->nullable($value=true);
                $table->integer('production_workshop_project')->nullable($value=true);
                $table->integer('production_workshop_special')->nullable($value=true);
                $table->integer('production_workshop_other')->nullable($value=true);

                // $table->integer('production_workshop_spa')->nullable($value=true);
                // $table->date('production_workshop_spa_date')->nullable($value=true);

                // $table->integer('production_workshop_cost_recovery')->nullable($value=true);
                // $table->date('production_workshop_cost_recovery_date')->nullable($value=true);

                // $table->integer('production_workshop_project')->nullable($value=true);
                // $table->date('production_workshop_project_date')->nullable($value=true);

                // $table->integer('production_workshop_special')->nullable($value=true);
                // $table->date('production_workshop_special_date')->nullable($value=true);

                // $table->integer('production_workshop_other')->nullable($value=true);
                // $table->date('production_workshop_other_date')->nullable($value=true);

            $table->smallInteger('flag')->default(0)->nullable($value=true);
            $table->smallInteger('status')->default(0)->nullable($value=true);
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
        Schema::dropIfExists('pollisomaj_data');
    }
}
