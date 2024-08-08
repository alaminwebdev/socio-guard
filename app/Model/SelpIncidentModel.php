<?php

namespace App\Model;

use App\Model\Admin\Setup\AccuseRelationship;
use App\Model\Admin\Setup\CEP_Region\Region;
use App\Model\Admin\Setup\District;
use App\Model\Admin\Setup\Division;
use App\Model\Admin\Setup\FamilyMember;
use App\Model\Admin\Setup\Gender;
use App\Model\Admin\Setup\InformationProviderSource;
use App\Model\Admin\Setup\MaritalStatus;
use App\Model\Admin\Setup\Occupation;
use App\Model\Admin\Setup\PreviousViolenceCategory;
use App\Model\Admin\Setup\Religion;
use App\Model\Admin\Setup\SurvivorAutisticInformation;
use App\Model\Admin\Setup\SurvivorRelationship;
use App\Model\Admin\Setup\SurvivorViolencePlace;
use App\Model\Admin\Setup\Union;
use App\Model\Admin\Setup\Upazila;
use App\Model\Admin\Setup\ViolenceCategory;
use App\Model\Admin\Setup\ViolenceReason;
use App\Model\Bracsupporttypes;
use App\Model\DirectServiceType;
use App\Model\Education;
use App\Model\Followup;
use App\Model\Householdtype;
use App\Model\SelpComingOrFailour;
use App\Model\Setup\Refferal;
use App\Model\Survivorinitiative;
use App\Model\ViolenceLocation;
use App\SelpIncidentMoneySupport;
use Illuminate\Database\Eloquent\Model;

class SelpIncidentModel extends Model {
    protected $table = 'selp_incident_informations';


    protected $casts = [
        'date_of_dispute' => 'date',
        'posting_date' => 'date',
    ];
    public function survivordirectservice() {
        return $this->hasMany(SurvivorDirectServiceModel::class, 'selp_incident_information_id');
    }

    public function selpcourtcasesupport() {
        return $this->hasMany(SurvivorCourtCaseModel::class, 'selp_incident_information_id');
    }

    public function employee_union() {
        return $this->belongsTo(Union::class, 'employee_union_id', 'id');
    }

    public function employee_upazila() {
        return $this->belongsTo(Upazila::class, 'employee_upazila_id', 'id');
    }

    public function employee_district() {
        return $this->belongsTo(District::class, 'employee_district_id', 'id');
    }

    public function employee_division() {
        return $this->belongsTo(Division::class, 'employee_division_id', 'id');
    }

    public function employee_zone() {
        return $this->belongsTo(Region::class, 'employee_zone_id', 'id');
    }

    public function applicant_union() {
        return $this->belongsTo(Union::class, 'applicant_union_id', 'id');
    }

    public function applicant_upazila() {
        return $this->belongsTo(Upazila::class, 'applicant_upazila_id', 'id');
    }

    public function applicant_district() {
        return $this->belongsTo(District::class, 'applicant_district_id', 'id');
    }

    public function applicant_division() {
        return $this->belongsTo(Division::class, 'applicant_division_id', 'id');
    }

    public function survivor_union() {
        return $this->belongsTo(Union::class, 'survivor_union_id', 'id');
    }

    public function survivor_upazila() {
        return $this->belongsTo(Upazila::class, 'survivor_upazila_id', 'id');
    }

    public function survivor_district() {
        return $this->belongsTo(District::class, 'survivor_district_id', 'id');
    }

    public function survivor_division() {
        return $this->belongsTo(Division::class, 'survivor_division_id', 'id');
    }

    public function defendant_union() {
        return $this->belongsTo(Union::class, 'defendant_union_id', 'id');
    }

    public function defendant_upazila() {
        return $this->belongsTo(Upazila::class, 'defendant_upazila_id', 'id');
    }

    public function defendant_district() {
        return $this->belongsTo(District::class, 'defendant_district_id', 'id');
    }

    public function defendant_division() {
        return $this->belongsTo(Division::class, 'defendant_division_id', 'id');
    }

    public function referral_reletionship() {
        return $this->belongsTo(SurvivorRelationship::class, 'referral_reletionship_id', 'id');
    }

    public function main_defendant_reletionship() {
        return $this->belongsTo(SurvivorRelationship::class, 'main_defendant_relation_id', 'id');
    }

    public function relation_main_accused() {
        return $this->belongsTo(AccuseRelationship::class, 'main_defendant_relation_id', 'id');
    }

    public function refferal() {
        return $this->belongsTo(Refferal::class, 'referral', 'id');
    }

    public function defendant_family_member() {
        return $this->belongsTo(SurvivorRelationship::class, 'defendant_family_member_id', 'id');
    }

    public function accuse_family_member() {
        return $this->belongsTo(FamilyMember::class, 'defendant_family_member_id', 'id');
    }

    public function brac_program_name() {
        return $this->belongsTo(Bracprogramname::class, 'brac_programe_name_id', 'id');
    }

    public function information_provider() {
        return $this->belongsTo(InformationProviderSource::class, 'information_provider_source_id', 'id');
    }

    public function referral_occupation() {
        return $this->belongsTo(Occupation::class, 'occupation_id', 'id');
    }

    public function referral_gender() {
        return $this->belongsTo(Gender::class, 'gender_id', 'id');
    }

    public function applicant_gender() {
        return $this->belongsTo(Gender::class, 'applicant_gender_id', 'id');
    }

    public function survivor_gender() {
        return $this->belongsTo(Gender::class, 'survivor_gender_id', 'id');
    }

    public function defendant_gender() {
        return $this->belongsTo(Gender::class, 'main_defendant_gender_id', 'id');
    }

    public function types_of_disputes() {
        return $this->belongsTo(ViolenceCategory::class, 'violence_reason_id', 'id');
    }

    public function previous_violence() {
        return $this->belongsTo(PreviousViolenceCategory::class, 'survivor_first_face_violence_type', 'id');
    }

    public function survivor_violence_reason() {
        return $this->belongsTo(ViolenceReason::class, 'survivor_reason_id', 'id');
    }

    public function applicant_education() {
        return $this->belongsTo(Education::class, 'applicant_education_id', 'id');
    }

    public function survivor_education() {
        return $this->belongsTo(Education::class, 'survivor_education_id', 'id');
    }

    public function defendant_education() {
        return $this->belongsTo(Education::class, 'defendant_education_id', 'id');
    }

    public function defendant_occupation() {
        return $this->belongsTo(Occupation::class, 'defendant_occupation_id', 'id');
    }

    public function applicant_occupation() {
        return $this->belongsTo(Occupation::class, 'application_occupation_id', 'id');
    }

    public function survivor_occupation() {
        return $this->belongsTo(Occupation::class, 'survivor_occupation_id', 'id');
    }

    public function applicant_religion() {
        return $this->belongsTo(Religion::class, 'applicant_religion_id', 'id');
    }

    public function survivor_religion() {
        return $this->belongsTo(Religion::class, 'survivor_religion_id', 'id');
    }

    public function house_hold_type() {
        return $this->belongsTo(Householdtype::class, 'household_type_id', 'id');
    }

    public function violence_location() {
        return $this->belongsTo(ViolenceLocation::class, 'violence_location_id', 'id');
    }

    public function marital_status() {
        return $this->belongsTo(MaritalStatus::class, 'survivor_marital_status_id', 'id');
    }

    public function violence_reason() {
        return $this->belongsTo(ViolenceReason::class, 'violence_reason_id', 'id');
    }

    public function violence_place() {
        return $this->belongsTo(SurvivorViolencePlace::class, 'violence_place_id', 'id');
    }

    public function survivor_disability() {
        return $this->belongsTo(SurvivorAutisticInformation::class, 'survivor_disability_status', 'id');
    }

    public function selp_initiative_place() {
        return $this->belongsTo(Survivorinitiative::class, 'earlier_survivor_initiative_place', 'id');
    }

    public function selp_coming_failour() {
        return $this->belongsTo(SelpComingOrFailour::class, 'case_of_failour_coming_to_selp', 'id');
    }

    public function brac_support_type() {
        return $this->belongsTo(Bracsupporttypes::class, 'brac_supporttype_id', 'id');
    }

    public function followup() {
        return $this->belongsTo(Followup::class, 'followup_id', 'id');
    }

    public function direct_support() {
        return $this->hasMany(SurvivorDirectServiceModel::class, 'id', 'selp_incident_information_id');
    }

    public function survivor_direct_support() {
        return $this->hasMany(SurvivorDirectServiceModel::class, 'selp_incident_information_id', 'id');
    }

    public function direct_services() {
        return $this->hasMany(DirectServiceType::class, 'selp_incident_id', 'id');
    }

    public function direct_support_adr() {
        return $this->hasMany(SurvivorDirectServiceModel::class, 'selp_incident_information_id', 'id');
    }

    public function direct_service_followup() {
        return $this->hasMany(FollowUpInfo::class, 'selp_incident_id', 'id');
    }

    public function direct_service_courtcase() {
        return $this->hasMany(SurvivorCourtCaseModel::class, 'selp_incident_information_id', 'id');
    }

    public function money_recovered_through_adr() {
        return $this->belongsTo(Moneyrecover::class, 'money_recovered_through_adr', 'id');
    }

    public function survivor_referral() {
        return $this->hasMany(IncidentReferral::class, 'selp_incident_id', 'id');
    }

    public function money_supports()
    {
        return $this->hasMany(SelpIncidentMoneySupport::class, 'selp_incident_information_id');
    }
}
