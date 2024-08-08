<?php

namespace App\Model\Admin\Incident;

use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Setup\Division;
use App\Model\Admin\Setup\District;
use App\Model\Admin\Setup\Upazila;
use App\Model\Admin\Setup\Union;
use App\Model\Admin\Setup\Village;
use App\Model\Admin\Setup\Religion;
use App\Model\Admin\Setup\Gender;
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
use App\Model\Admin\Setup\ViolenceName;
use App\Model\Admin\Setup\OrganizationType;
use App\Model\Admin\Setup\OrganizationName;
use App\Model\Admin\Setup\InformationProviderSource;
use App\Model\Admin\Incident\SurvivorBracSupport;
use App\Model\Admin\Incident\SurvivorOtherOrganizationSupport;
use App\Model\Admin\Setup\OtherOrganizationSupport;
use App\Model\Admin\Setup\ViolenceReason;
use App\Model\Admin\Setup\SocialStatus;
use App\Model\Admin\Setup\EconomicCondition;
use App\Model\Admin\Incident\SurvivorIncidentInformation;
use App\Model\Admin\Incident\PerpetratorInformation;
use App\Model\Admin\Setup\SurvivorAutisticInformation;
use App\Model\Admin\Setup\FamilyMember;
use App\Model\Admin\Setup\SurvivorFinalSupport;
use App\Model\Admin\Setup\Program;

class PerpetratorInformation extends Model
{
    protected $table='perpetrator_informations';
    protected  $fillable = [
    	'survivor_id',
    	'survivor_incident_info_id',
    	'perpetrator_name',
    	'perpetrator_marital_status_id',
    	'perpetrator_gender_id',
    	'perpetrator_occupation_id',
    	'perpetrator_age',
    	'perpetrator_family_member_id',
    	'perpetrator_religion_id',
    	'perpetrator_social_status_id',
    	'perpetrator_economic_condition_id',
    	'perpetrator_previous_enmity_status',
    	'perpetrator_place_id',
    	'perpetrator_relationship_id',
    	'perpetrator_division_id',
    	'perpetrator_district_id',
    	'perpetrator_upazila_id',
    	'perpetrator_union_id',
    	'perpetrator_village',
    	'perpetrator_city_corporation_id',
    	'perpetrator_pourosova_id',
    	'perpetrator_post_code',
    	'perpetrator_house',
    	'perpetrator_road'
    ];

    public function perpetrator_marital_status() 
    {
        return $this->belongsTo(MaritalStatus::class, 'perpetrator_marital_status_id','id');
    }

    public function purpetrator_gender() 
    {
        return $this->belongsTo(Gender::class, 'perpetrator_gender_id','id');
    }

    public function purpetrator_place() 
    {
        return $this->belongsTo(SurvivorIncidentPlace::class, 'perpetrator_place_id','id');
    }

    public function purpetrator_occupation() 
    {
        return $this->belongsTo(Occupation::class, 'perpetrator_occupation_id','id');
    }

    public function purpetrator_relationship() 
    {
        return $this->belongsTo(SurvivorRelationship::class, 'perpetrator_relationship_id','id');
    }

    public function purpetrator_family_member() 
    {
        return $this->belongsTo(FamilyMember::class, 'perpetrator_family_member_id','id');
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
}
