<?php

namespace App\Model\Admin\Incident;

use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Setup\Gender;
use App\Model\Admin\Setup\OrganizationName;
use App\Model\Admin\Setup\InformationProviderSource;
use App\Model\Admin\Setup\ViolenceName;
use App\Model\Admin\Followup\FollowupQuestionAnswer;
use App\Model\Admin\Setup\Division;
use App\Model\Admin\Setup\District;
use App\Model\Admin\Setup\Upazila;
use App\Model\Admin\Setup\Union;
use App\Model\Admin\Setup\Village;
use App\Model\Admin\Setup\Religion;
use App\Model\Admin\Setup\Occupation;
use App\Model\Admin\Setup\SurvivorRelationship;
use App\Model\Admin\Setup\MaritalStatus;
use App\Model\Admin\Setup\SurvivorSupportOrganization;
use App\Model\Admin\Setup\SurvivorSupportName;
use App\Model\Admin\Setup\SuprvivorInitialSupport;
use App\Model\Admin\Setup\SurvivorSituation;
use App\Model\Admin\Setup\SurvivorIncidentPlace;
use App\Model\Admin\Setup\ViolenceCategory;
use App\Model\Admin\Setup\ViolenceSubCategory;
use App\Model\Admin\Setup\OrganizationType;
use App\Model\Admin\Incident\SurvivorBracSupport;
use App\Model\Admin\Incident\SurvivorOtherOrganizationSupport;
use App\Model\Admin\Setup\OtherOrganizationSupport;
use App\Model\Admin\Setup\ViolenceReason;
use App\Model\Admin\Setup\LegelInitiativeReason;
use App\Model\Admin\Setup\SocialStatus;
use App\Model\Admin\Setup\EconomicCondition;
use App\Model\Admin\Incident\SurvivorIncidentInformation;
use App\Model\Admin\Incident\PerpetratorInformation;
use App\Model\Admin\Setup\SurvivorAutisticInformation;
use App\Model\Admin\Setup\FamilyMember;
use App\Model\Admin\Setup\SurvivorFinalSupport;
use App\Model\Admin\Setup\Program;
use App\Model\Admin\Setup\PerpetratorPlace;

class SurvivorIncidentInformation extends Model
{

    protected $table= 'survivor_incident_informations';
    
    protected  $fillable = [
    	'employee_id',
        'employee_name',
        'employee_mobile_number',
        'employee_designation',
        'employee_pin',
        'employee_signature',
        'employee_division_id',
        'employee_district_id',
        'employee_upazila_id',
        'employee_union_id',
        'employee_village',
        'employee_house',
        'employee_road',
        'survivor_id',
        'provider_applicable_status',
        'provider',
        'provider_source_id',
    	'provider_name',
        'provider_other_source',
    	'provider_mobile_no',
    	'provider_organization_type_id',
    	'provider_organization_name_id',
    	'provider_gender_id',
        'provider_others_gender',
    	'provider_relationship_id',
        'provider_other_relationship',
    	'provider_division_id',
    	'provider_district_id',
    	'provider_upazila_id',
    	'provider_union_id',
    	'provider_village',
    	'provider_city_corporation_id',
    	'provider_pourosova_id',
    	'provider_post_code',
    	'provider_house',
        'provider_road',
    	'source_name',
        'source_division_id',
        'source_district_id',
        'source_upazila_id',
        'source_union_id',
        'source_village',
        'source_city_corporation_id',
        'source_pourosova_id',
        'source_post_code',
        'source_house',
        'source_road',
    	'violence_applicable_status',
        'violence_place_id',
        'violence_category_id',
    	'violence_sub_category_id',
    	'violence_name_id',
    	'violence_date',
    	'violence_time',
    	'violence_incident_place_id',
        'violence_reason_id',
    	'violence_reason_details',
    	'violence_division_id',
    	'violence_district_id',
    	'violence_upazila_id',
    	'violence_union_id',
    	'violence_village',
    	'violence_city_corporation_id',
    	'violence_pourosova_id',
    	'violence_post_code',
    	'violence_house',
    	'violence_road',
    	'survivor_applicable_status',
        'survivor_name',
    	'survivor_mobile_no',
    	'survivor_religion_id',
        'survivor_others_religion',
    	'survivor_father_name',
    	'survivor_mother_name',
    	'survivor_husband_name',
    	'survivor_marital_status_id',
    	'survivor_age',
        'survivor_gender_id',
        'survivor_nid',
    	'survivor_birth_registration_no',
        'survivor_others_gender',
    	'survivor_occupation_id',
    	'survivor_monthly_income',
    	'survivor_organization_type_id',
    	'survivor_organization_name_id',
    	'survivor_incident_place_id',
        'survivor_others_incident_place',
        'survivor_autistic_id',
        'survivor_others_autistic',
        'survivor_image',
    	'survivor_division_id',
    	'survivor_district_id',
    	'survivor_upazila_id',
    	'survivor_union_id',
    	'survivor_village',
    	'survivor_city_corporation_id',
    	'survivor_post_code',
    	'survivor_house',
    	'survivor_road',
    	'case_applicable_status',
        'case_status',
    	'thana_name',
    	'court_name',
    	'case_no',
    	'case_filed_date',
    	'not_filing_reason',
    	'current_situation_applicable_status',
        'survivor_initial_support_id',
        'survivor_initial_other_support',
    	'survivor_situation_id',
        'survivor_other_situation',
    	'survivor_place_id',
        'survivor_other_place',
        'provider_applicable_status',
        'perpetrator_name',
        'perpetrator_marital_status_id',
        'perpetrator_gender_id',
        'perpetrator_others_gender',
        'perpetrator_occupation_id',
        'perpetrator_age',
    	'no_of_perpetrator',
        'perpetrator_family_member_id',
        'perpetrator_others_family_member',
        'perpetrator_religion_id',
        'perpetrator_social_status_id',
        'perpetrator_economic_condition_id',
        'perpetrator_previous_enmity_status',
        'perpetrator_place_id',
        'perpetrator_others_place',
        'perpetrator_relationship_id',
        'perpetrator_others_relationship',
        'perpetrator_division_id',
        'perpetrator_district_id',
        'perpetrator_upazila_id',
        'perpetrator_union_id',
        'perpetrator_village',
        'perpetrator_house',
        'perpetrator_road',
        'created_at',
        'created_by',
        'updated_by'
    ];

    public function information_provider_source()
    {
        return $this->belongsTo(InformationProviderSource::class, 'provider_source_id', 'id');
    }

    public function legel_initiative_reason()
    {
        return $this->belongsTo(LegelInitiativeReason::class, 'not_filing_reason', 'id');
    }

    public function organization_name()
    {
        return $this->belongsTo(OrganizationName::class, 'provider_organization_name_id', 'id');
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class, 'provider_gender_id', 'id');
    }

    public function perpetrator_info()
    {
        return $this->hasMany(PerpetratorInformation::class, 'survivor_incident_info_id', 'id');
    }

    public function followup_info()
    {
        return $this->hasMany(FollowupQuestionAnswer::class, 'survivor_incident_info_id', 'id');
    }

    public function survivor_brac_support()
    {
        return $this->hasMany(SurvivorBracSupport::class, 'survivor_incident_info_id', 'id');
    }

    public function survivorBracSupportReport()
    {
        return $this->hasMany(SurvivorBracSupport::class, 'survivor_incident_info_id', 'id')->where('survivor_final_support_id','!=','null');
    }

    public function survivor_other_organization_support()
    {
        return $this->hasMany(SurvivorOtherOrganizationSupport::class, 'survivor_incident_info_id', 'id');
    }

    public function violencecategoryname()
    {
        return $this->belongsTo(ViolenceCategory::class,'violence_category_id','id');
    }

    public function violencesubcategoryname()
    {
        return $this->belongsTo(ViolenceSubCategory::class,'violence_sub_category_id','id');
    }

    public function violencename()
    {
        return $this->belongsTo(ViolenceName::class,'violence_name_id','id');
    }

    public function violencereason()
    {
        return $this->belongsTo(ViolenceReason::class,'violence_reason_id','id');
    }

    public function survivor_gender()
    {
        return $this->belongsTo(Gender::class, 'survivor_gender_id');
    }

    public function perpetrator_gender()
    {
        return $this->belongsTo(Gender::class, 'perpetrator_gender_id','id');
    }

    public function provider_reationship()
    {
        return $this->belongsTo(SurvivorRelationship::class, 'provider_relationship_id','id');
    }

    public function perpetrator_relationship()
    {
        return $this->belongsTo(SurvivorRelationship::class, 'perpetrator_relationship_id','id');
    }

    public function provider_union()
    {
        return $this->belongsTo(Union::class, 'provider_union_id','id');
    }

    public function provider_upazila()
    {
        return $this->belongsTo(Upazila::class, 'provider_upazila_id','id');
    }

    public function provider_district()
    {
        return $this->belongsTo(District::class, 'provider_district_id','id');
    }

    public function provider_division()
    {
        return $this->belongsTo(Division::class, 'provider_division_id','id');
    }

    public function source_union()
    {
        return $this->belongsTo(Union::class, 'source_union_id','id');
    }

    public function source_upazila()
    {
        return $this->belongsTo(Upazila::class, 'source_upazila_id','id');
    }

    public function source_district()
    {
        return $this->belongsTo(District::class, 'source_district_id','id');
    }

    public function source_division()
    {
        return $this->belongsTo(Division::class, 'source_division_id','id');
    }

    public function employee_union()
    {
        return $this->belongsTo(Union::class, 'employee_union_id','id');
    }

    public function employee_upazila()
    {
        return $this->belongsTo(Upazila::class, 'employee_upazila_id','id');
    }

    public function employee_district()
    {
        return $this->belongsTo(District::class, 'employee_district_id','id');
    }

    public function employee_division()
    {
        return $this->belongsTo(Division::class, 'employee_division_id','id');
    }

    public function provider_violence_name()
    {
        return $this->belongsTo(ViolenceName::class, 'violence_name_id','id');
    }

    public function provider_place()
    {
        return $this->belongsTo(SurvivorIncidentPlace::class, 'violence_place_id','id');
    }

    public function survivor_religion()
    {
        return $this->belongsTo(Religion::class, 'survivor_religion_id','id');
    }

    public function survivor_marital_status()
    {
        return $this->belongsTo(MaritalStatus::class, 'survivor_marital_status_id','id');
    }

    public function perpetrator_marital_status()
    {
        return $this->belongsTo(MaritalStatus::class, 'perpetrator_marital_status_id','id');
    }

    public function survivor_occupation()
    {
        return $this->belongsTo(Occupation::class, 'survivor_occupation_id','id');
    }

    public function perpetrator_occupation()
    {
        return $this->belongsTo(Occupation::class, 'perpetrator_occupation_id','id');
    }

    public function survivor_organization()
    {
        return $this->belongsTo(OrganizationType::class, 'survivor_organization_type_id','id');
    }

    public function perpetrator_organization()
    {
        return $this->belongsTo(OrganizationType::class, 'perpetrator_organization_type_id','id');
    }

    public function survivor_place()
    {
        return $this->belongsTo(SurvivorIncidentPlace::class, 'survivor_incident_place_id','id');
    }

    public function perpetrator_place()
    {
        return $this->belongsTo(PerpetratorPlace::class, 'perpetrator_place_id','id');
    }

    public function survivor_disability()
    {
        return $this->belongsTo(SurvivorAutisticInformation::class, 'survivor_autistic_id','id');
    }

    public function survivor_union()
    {
        return $this->belongsTo(Union::class, 'survivor_union_id','id');
    }

    public function survivor_upazila()
    {
        return $this->belongsTo(Upazila::class, 'survivor_upazila_id','id');
    }

    public function survivor_district()
    {
        return $this->belongsTo(District::class, 'survivor_district_id','id');
    }

    public function survivor_division()
    {
        return $this->belongsTo(Division::class, 'survivor_division_id','id');
    }

    public function perpetrator_union()
    {
        return $this->belongsTo(Union::class, 'perpetrator_union_id','id');
    }

    public function perpetrator_upazila()
    {
        return $this->belongsTo(Upazila::class, 'perpetrator_upazila_id','id');
    }

    public function perpetrator_district()
    {
        return $this->belongsTo(District::class, 'perpetrator_district_id','id');
    }

    public function perpetrator_division()
    {
        return $this->belongsTo(Division::class, 'perpetrator_division_id','id');
    }

    public function survivor_initial_support()
    {
        return $this->belongsTo(SuprvivorInitialSupport::class, 'survivor_initial_support_id','id');
    }

    public function survivor_situation()
    {
        return $this->belongsTo(SurvivorSituation::class, 'survivor_situation_id','id');
    }

    public function survivor_during_place()
    {
        return $this->belongsTo(SurvivorIncidentPlace::class, 'survivor_place_id','id');
    }

    public function perpetrator_initial_support()
    {
        return $this->belongsTo(SuprvivorInitialSupport::class, 'perpetrator_initial_support_id','id');
    }

    public function perpetrator_situation()
    {
        return $this->belongsTo(SurvivorSituation::class, 'perpetrator_situation_id','id');
    }

    public function perpetrator_during_place()
    {
        return $this->belongsTo(SurvivorIncidentPlace::class, 'perpetrator_place_id','id');
    }

}
