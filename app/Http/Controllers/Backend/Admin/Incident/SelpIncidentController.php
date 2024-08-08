<?php

namespace App\Http\Controllers\Backend\Admin\Incident;

use App\Exports\MisReportExport;
use App\Http\Controllers\Controller;
use App\Model\Admin\Setup\AccuseRelationship;
use App\Model\Admin\Setup\CEP_Region\Region;
use App\Model\Admin\Setup\CEP_Region\SetupUserArea;
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
use App\Model\Admin\Setup\SurvivorSupportName;
use App\Model\Admin\Setup\SurvivorViolencePlace;
use App\Model\Admin\Setup\Upazila;
use App\Model\Admin\Setup\ViolenceCategory;
use App\Model\Admin\Setup\ViolenceName;
use App\Model\Admin\Setup\ViolenceReason;
use App\Model\Adrmoneyrecover;
use App\Model\AlternativeDisputeResolution;
use App\Model\Bracprogramname;
use App\Model\Bracsupporttypes;
use App\Model\Civilcase;
use App\Model\DirectServiceType;
use App\Model\Education;
use App\Model\Followup;
use App\Model\FollowUpInfo;
use App\Model\Householdtype;
use App\Model\IncidentReferral;
use App\Model\Judgementstatus;
use App\Model\Moneyrecover;
use App\Model\Pititioncase;
use App\Model\Policecase;
use App\Model\SelpComingOrFailour;
use App\Model\SelpFirstInitiative;
use App\Model\SelpIncidentModel;
use App\Model\Selpzone;
use App\Model\Setup\Refferal;
use App\Model\Setup\SecondaryRefferal;
use App\Model\SurvivorCourtCaseModel;
use App\Model\SurvivorDirectServiceModel;
use App\Model\Survivorinitiative;
use App\Model\ViolenceLocation;
use App\SelpIncidentMoneySupport;
use App\User;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class SelpIncidentController extends Controller
{
    private function formatIncidentId($id)
    {
        if ($id < 10) {
            return '00' . $id;
        }

        if ($id < 100) {
            return '0' . $id;
        }

        return $id;
    }
    public function edit(Request $request, $inc_ref_id)
    {

        $request->session()->put('current_incident_store_session_' . $inc_ref_id, $inc_ref_id);
        //dd($inc_ref_id);
        // if ($request->session()->has('current_incident_store_session')) {
        //     $request->session()->forget('current_incident_store_session', uniqid("INCIDENT_ID_", true));
        //     $request->session()->put('current_incident_store_session', $inc_ref_id);
        // } else {
        //     $request->session()->put('current_incident_store_session', $inc_ref_id);
        // }
        $request->session()->put('edit_mode', true);
        return redirect()->route('incident.selp.add', ['selp_incident_ref' => $inc_ref_id]);
    }

    public function add(Request $request)
    {
        // dd($request->all());
        if ((bool) $request->query('addNew')) {
            $request->session()->forget('current_incident_store_session_' . $request->inc_ref_id);
            $request->session()->forget('edit_mode');
        }

        if ($request->back == 1) {
            $request->session()->put('edit_mode', true);
        }

        $data['regions']                  = getRegionByUserType();
        $data['user_info']                = Auth::user();
        $data['divisions']                = Division::where('status', 1)->get();
        $data['selpZone']                 = Selpzone::where('status', 1)->get();
        $data['informationProvider']      = InformationProviderSource::orderBy('name', 'asc')->where('status', 1)->get();
        $data['bracProgram']              = Bracprogramname::orderBy('title', 'asc')->where('status', 1)->get();
        $data['genders']                  = Gender::orderBy('name', 'asc')->where('status', 1)->get();
        $data['selpInitiatives']          = SelpFirstInitiative::where('status', 1)->get();
        $data['educations']               = Education::where('status', 1)->get();
        $data['religions']                = Religion::where('status', 1)->get();
        $data['houseHoldType']            = Householdtype::where('status', 1)->get();
        $data['disputeTypes']             = ViolenceName::where('status', 1)->get();
        $data['maritalStatus']            = MaritalStatus::orderBy('name', 'asc')->where('status', 1)->get();
        $data['organizalAffiliation']     = SurvivorSupportName::where('status', 1)->get();
        $data['ViolenceCategory']         = ViolenceCategory::orderBy('name', 'asc')->where('status', 1)->get();
        $data['previousViolenceCategory'] = PreviousViolenceCategory::where('status', 1)->get();
        $data['violenceReason']           = ViolenceReason::orderBy('name', 'asc')->where('status', 1)->get();
        $data['violenceLocation']         = ViolenceLocation::where('status', 1)->get();
        $data['violencePlace']            = SurvivorViolencePlace::orderBy('name', 'asc')->where('status', 1)->get();
        $data['disabilityStatus']         = SurvivorAutisticInformation::orderBy('name', 'asc')->where('status', 1)->get();
        $data['perpetratorRelation']      = FamilyMember::orderBy('name', 'asc')->where('status', 1)->get();
        $data['occupations']              = Occupation::orderBy('name', 'asc')->where('status', 1)->get();
        $data['survivorInitiatives']      = Survivorinitiative::orderBy('title', 'asc')->where('status', 1)->get();
        $data['selpFailour']              = SelpComingOrFailour::orderBy('title', 'asc')->where('status', 1)->get();
        $data['adrs']                     = AlternativeDisputeResolution::where('status', 1)->get();
        //$data['adrMoneyRecover']          = Adrmoneyrecover::where('status', 1)->get();
        $data['accuseRelationship']       = AccuseRelationship::orderBy('name', 'asc')->where('status', 1)->get();
        $data['civilCase']                = Civilcase::where('status', 1)->get();
        $data['policeCase']               = Policecase::where('status', 1)->get();
        $data['petitionCase']             = Pititioncase::where('status', 1)->get();
        $data['moneyRecoverCourteCase']   = Moneyrecover::where('status', 1)->get();
        $data['judgementStatus']          = Judgementstatus::where('status', 1)->get();
        $data['findingsFromFollowUp']     = Followup::where('status', 1)->get();
        $data['violenceTypes']            = ViolenceName::where('status', 1)->get();
        $data['bracSupport']              = Bracsupporttypes::orderBy('title', 'asc')->where('status', 1)->get();
        $data['refferals']                = Refferal::orderBy('name', 'asc')->where('status', 1)->get();
        $data['secondaryRefferals']       = SecondaryRefferal::orderBy('name', 'asc')->where('status', 1)->get();
        $data['selpIncident']             = SelpIncidentModel::with(['survivordirectservice', 'selpcourtcasesupport'])->where('selp_incident_ref', request()->selp_incident_ref)->get();

        $reported_incident_type = @$data['selpIncident'][0]->types_of_disputes->name;
        if ($reported_incident_type) {
            $data['adrMoneyRecover'] = Adrmoneyrecover::where('status', 1)->where('title', 'like', '%' . $reported_incident_type . '%')->get();
        } else {
            $data['adrMoneyRecover'] = Adrmoneyrecover::where('status', 1)->get();
        }

        return view('backend.admin.selp_incident.incident_form_new', $data);
    }

    public function incidentFormStep1(Request $request)
    {

        // return $request;

        $validated = $request->validate([
            'employee_zone_id'              => 'required|integer',
            'employee_district_id'          => 'required|integer',
            'employee_division_id'          => 'required|integer',
            'employee_upazila_id'           => 'required|integer',
            'employee_information_provider' => 'required',
            'brac_program_name'             => 'required',
            'gender_id'                     => 'required',
            'violence_reason_id'            => 'required',
            'date_of_dispute'               => 'required',
        ]);

        $selpIncident                    = SelpIncidentModel::where('selp_incident_ref', $request->selp_incident_ref)->get();
        $extra_data['tab']               = $request->tab;
        $extra_data['step']              = $request->step;
        $extra_data['selp_incident_ref'] = $request->selp_incident_ref;

        if (count($selpIncident) > 0) {
            //dd($selpIncident);
            $selpIncidentUpdate                                 = SelpIncidentModel::find($selpIncident[0]->id);
            $selpIncidentUpdate->posting_date                   = $request->posting_date != null ? date("Y-m-d", strtotime($request->posting_date)) : null;
            $selpIncidentUpdate->employee_mobile_number         = $request->employee_mobile_number;
            $selpIncidentUpdate->employee_name                  = $request->employee_name;
            $selpIncidentUpdate->employee_designation           = $request->employee_designation;
            $selpIncidentUpdate->employee_pin                   = $request->employee_pin;
            $selpIncidentUpdate->employee_zone_id               = $request->employee_zone_id;
            $selpIncidentUpdate->employee_division_id           = $request->employee_division_id;
            $selpIncidentUpdate->employee_district_id           = $request->employee_district_id;
            $selpIncidentUpdate->employee_upazila_id            = $request->employee_upazila_id;
            $selpIncidentUpdate->information_provider_source_id = $request->employee_information_provider;
            $selpIncidentUpdate->brac_programe_name_id          = $request->brac_program_name;
            $selpIncidentUpdate->referral_name                  = $request->referral_name;
            $selpIncidentUpdate->informer_mobile_number         = $request->informer_mobile_number;
            $selpIncidentUpdate->gender_id                      = $request->gender_id;
            $selpIncidentUpdate->occupation_id                  = $request->occupation_id;
            $selpIncidentUpdate->violence_reason_id             = $request->violence_reason_id;
            $selpIncidentUpdate->date_of_dispute                = $request->date_of_dispute != null ? date("Y-m-d", strtotime($request->date_of_dispute)) : null;
            //dd($selpIncidentUpdate->date_of_dispute);
            $selpIncidentUpdate->update_by = auth()->user()->id;
            $selpIncidentUpdate->save();
        } else {
            //dd($selpIncident);
            //dd($request->employee_division_id);
            $selpNewItem                                 = new SelpIncidentModel;
            $selpNewItem->selp_incident_ref              = uniqid("INCIDENT_ID_", true);
            $selpNewItem->posting_date                   = $request->posting_date != null ? date("Y-m-d", strtotime($request->posting_date)) : null;
            $selpNewItem->employee_name                  = $request->employee_name;
            $selpNewItem->employee_mobile_number         = $request->employee_mobile_number;
            $selpNewItem->employee_designation           = $request->employee_designation;
            $selpNewItem->employee_pin                   = $request->employee_pin;
            $selpNewItem->employee_zone_id               = $request->employee_zone_id;
            $selpNewItem->employee_division_id           = $request->employee_division_id;
            $selpNewItem->employee_district_id           = $request->employee_district_id;
            $selpNewItem->employee_upazila_id            = $request->employee_upazila_id;
            $selpNewItem->information_provider_source_id = $request->employee_information_provider;
            $selpNewItem->brac_programe_name_id          = $request->brac_program_name;
            $selpNewItem->referral_name                  = $request->referral_name;
            $selpNewItem->informer_mobile_number         = $request->informer_mobile_number;
            $selpNewItem->gender_id                      = $request->gender_id;
            $selpNewItem->occupation_id                  = $request->occupation_id;
            $selpNewItem->violence_reason_id             = $request->violence_reason_id;
            $selpNewItem->date_of_dispute                = $request->date_of_dispute != null ? date("Y-m-d", strtotime($request->date_of_dispute)) : null;
            //dd($selpNewItem->date_of_dispute);
            $selpNewItem->update_by = auth()->user()->id;
            $selpNewItem->save();

            $extra_data['selp_incident_ref'] = $selpNewItem->selp_incident_ref;
        }
        if ($request->has('save_destroy')) {
            $request->session()->forget('current_incident_store_session_' . $request->selp_incident_ref);
            $request->session()->forget('edit_mode');
            return redirect()->route('incident.list');
        }
        return redirect()->route('incident.selp.add', $extra_data);
    }

    public function incidentFormStep2(Request $request)
    {

        // dd($request->all());
        if ($request->selp_initiative == 2) {
            if (!$request->has('save_destroy')) {
                $validated = $request->validate([
                    'survivor_name'              => 'required',
                    'survivor_age'               => 'required',
                    'survivor_sex'               => 'required',
                    'survivor_disability_status' => 'required',
                    'survivor_division'          => 'required',
                    'survivor_district'          => 'required',
                    'survivor_upazila'           => 'required',
                    'survivor_union'             => 'required',
                    'survivor_village_name'      => 'required',
                    // 'number_of_defendant'           => 'required',
                    // 'name_of_main_defendant'        => 'required',
                    // 'relation_with_main_defendant'  => 'required',
                    // 'defendant_gender'              => 'required',
                    'selp_initiative'            => 'required',
                ]);
            }
        } elseif ($request->selp_initiative == 1) {
            if ($request->has('save_destroy')) {
                $validated = $request->validate([
                    'survivor_name'                => 'required',
                    'survivor_age'                 => 'required',
                    'survivor_sex'                 => 'required',
                    'survivor_disability_status'   => 'required',
                    'survivor_division'            => 'required',
                    'survivor_district'            => 'required',
                    'survivor_upazila'             => 'required',
                    'survivor_union'               => 'required',
                    'survivor_village_name'        => 'required',
                    'number_of_defendant'          => 'required',
                    'name_of_main_defendant'       => 'required',
                    'relation_with_main_defendant' => 'required',
                    'defendant_gender'             => 'required',
                    'selp_initiative'              => 'required',
                    'referral_no'                  => 'required',
                    'referral_to'                  => 'required',
                    'referral_date'                => 'required',
                ]);
            }
        } elseif ($request->selp_initiative == 3 || $request->selp_initiative == 4) {
            if ($request->has('save_destroy')) {
                $validated = $request->validate([
                    'survivor_name'                => 'required',
                    'survivor_age'                 => 'required',
                    'survivor_sex'                 => 'required',
                    'survivor_disability_status'   => 'required',
                    'survivor_division'            => 'required',
                    'survivor_district'            => 'required',
                    'survivor_upazila'             => 'required',
                    'survivor_union'               => 'required',
                    'survivor_village_name'        => 'required',
                    'number_of_defendant'          => 'required',
                    'name_of_main_defendant'       => 'required',
                    'relation_with_main_defendant' => 'required',
                    'defendant_gender'             => 'required',
                    'selp_initiative'              => 'required',
                ]);
            }
        } else {
            if (!$request->has('save_destroy')) {
                $validated = $request->validate([
                    'survivor_name'                => 'required',
                    'survivor_age'                 => 'required',
                    'survivor_sex'                 => 'required',
                    'survivor_disability_status'   => 'required',
                    'survivor_division'            => 'required',
                    'survivor_district'            => 'required',
                    'survivor_upazila'             => 'required',
                    'survivor_union'               => 'required',
                    'survivor_village_name'        => 'required',
                    'number_of_defendant'          => 'required',
                    'name_of_main_defendant'       => 'required',
                    'relation_with_main_defendant' => 'required',
                    'defendant_gender'             => 'required',
                    'selp_initiative'              => 'required',
                ]);
            }
        }

        $selpIncident                    = SelpIncidentModel::where('selp_incident_ref', $request->selp_incident_ref)->get();
        $extra_data['tab']               = $request->tab;
        $extra_data['step']              = $request->step;
        $extra_data['selp_incident_ref'] = $request->selp_incident_ref;
        if (count($selpIncident) > 0) {
            $selpIncidentUpdate                                     = SelpIncidentModel::find($selpIncident[0]->id);
            $selpIncidentUpdate->applicant_survivor_same            = $request->same_person;
            $selpIncidentUpdate->applicant_name                     = $request->applicant_name;
            $selpIncidentUpdate->applicant_father_name              = $request->applicant_father_name;
            $selpIncidentUpdate->applicant_mother_name              = $request->applicant_mother_name;
            $selpIncidentUpdate->applicant_husband_name             = $request->applicant_husband_name;
            $selpIncidentUpdate->applicant_age                      = $request->applicant_age;
            $selpIncidentUpdate->applicant_mobile_number            = $request->applicant_contact_no;
            $selpIncidentUpdate->applicant_mobile_number_on_request = $request->applicant_2nd_contact_no;
            $selpIncidentUpdate->applicant_gender_id                = $request->applicant_sex;
            $selpIncidentUpdate->applicant_education_id             = $request->applicant_education;
            $selpIncidentUpdate->applicant_religion_id              = $request->applicant_religion;
            $selpIncidentUpdate->applicant_division_id              = $request->applicant_division;
            $selpIncidentUpdate->applicant_district_id              = $request->applicant_district;
            $selpIncidentUpdate->applicant_upazila_id               = $request->applicant_upazila;
            $selpIncidentUpdate->applicant_union_id                 = $request->applicant_union;
            $selpIncidentUpdate->applicant_village_name             = $request->applicant_village_name;
            $selpIncidentUpdate->applicant_ward                     = $request->applicant_ward_para;
            $selpIncidentUpdate->application_occupation_id          = $request->applicant_occupation;

            $selpIncidentUpdate->survivor_name                     = $request->survivor_name;
            $selpIncidentUpdate->survivor_father_name              = $request->survivor_father_name;
            $selpIncidentUpdate->survivor_mother_name              = $request->survivor_mother_name;
            $selpIncidentUpdate->survivor_husband_name             = $request->survivor_husband_name;
            $selpIncidentUpdate->survivor_age                      = $request->survivor_age;
            $selpIncidentUpdate->survivor_mobile_number            = $request->survivor_contact_no;
            $selpIncidentUpdate->survivor_mobile_number_on_request = $request->survivor_2nd_contact_no;
            $selpIncidentUpdate->survivor_gender_id                = $request->survivor_sex;
            $selpIncidentUpdate->survivor_education_id             = $request->survivor_education;
            $selpIncidentUpdate->survivor_religion_id              = $request->survivor_religion;
            $selpIncidentUpdate->survivor_division_id              = $request->survivor_division;
            $selpIncidentUpdate->survivor_district_id              = $request->survivor_district;
            $selpIncidentUpdate->survivor_upazila_id               = $request->survivor_upazila;
            $selpIncidentUpdate->survivor_union_id                 = $request->survivor_union;
            $selpIncidentUpdate->survivor_village_name             = $request->survivor_village_name;
            $selpIncidentUpdate->survivor_ward                     = $request->survivor_ward_para;
            $selpIncidentUpdate->survivor_occupation_id            = $request->survivor_occupation;
            $selpIncidentUpdate->survivor_disability_status        = $request->survivor_disability_status;

            $selpIncidentUpdate->defendant_division_id    = $request->defendant_division;
            $selpIncidentUpdate->defendant_district_id    = $request->defendant_district;
            $selpIncidentUpdate->defendant_upazila_id     = $request->defendant_upazila;
            $selpIncidentUpdate->defendant_village_name   = $request->defendant_village_name;
            $selpIncidentUpdate->defendant_union_id       = $request->defendant_union;
            $selpIncidentUpdate->defendant_ward           = $request->defendant_ward_para;
            $selpIncidentUpdate->main_defendant_gender_id = $request->defendant_gender;
            $selpIncidentUpdate->main_defendant_age       = $request->defendant_age;

            $selpIncidentUpdate->main_defendants_name       = $request->name_of_main_defendant;
            $selpIncidentUpdate->number_of_defendants       = $request->number_of_defendant;
            $selpIncidentUpdate->main_defendant_relation_id = $request->relation_with_main_defendant;

            $selpIncidentUpdate->selp_initiative = $request->selp_initiative;
            if ($request->selp_initiative == 1) {
                $selpIncidentUpdate->referral_no   = $request->referral_no;
                $selpIncidentUpdate->referral      = $request->referral_to;
                $selpIncidentUpdate->referral_date = $request->referral_date != null ? date("Y-m-d", strtotime($request->referral_date)) : null;
            } else {
                $selpIncidentUpdate->referral_no   = null;
                $selpIncidentUpdate->referral      = null;
                $selpIncidentUpdate->referral_date = null;
            }

            if ($request->selp_initiative != 2) {
                $selpIncidentUpdate->household_type_id                      = null;
                $selpIncidentUpdate->household_total_income                 = null;
                $selpIncidentUpdate->violence_location_id                   = null;
                $selpIncidentUpdate->survivor_marital_status_id             = null;
                $selpIncidentUpdate->survivor_age_of_marriage               = null;
                $selpIncidentUpdate->survivor_organization_affiliation_id   = null;
                $selpIncidentUpdate->survivor_nid                           = null;
                $selpIncidentUpdate->survivor_reason_id                     = null;
                $selpIncidentUpdate->violence_place_id                      = null;
                $selpIncidentUpdate->defendant_education_id                 = null;
                $selpIncidentUpdate->defendant_occupation_id                = null;
                $selpIncidentUpdate->defendant_family_member_id             = null;
                $selpIncidentUpdate->if_perpetrator_family_member_yes_or_no = null;
                $selpIncidentUpdate->earlier_survivor_initiative            = null;
                $selpIncidentUpdate->earlier_survivor_initiative_place      = null;
                $selpIncidentUpdate->case_of_failour_coming_to_selp         = null;
                $selpIncidentUpdate->have_survivor_face_violence_before     = null;
                $selpIncidentUpdate->survivor_first_face_violence_age       = null;
                $selpIncidentUpdate->type_of_violence_was_yes_or_no         = null;
                $selpIncidentUpdate->survivor_first_face_violence_type      = null;
                $selpIncidentUpdate->survivor_seek_support_from_brac        = null;
                $selpIncidentUpdate->brac_supporttype_id                    = null;

                $directServiceType     = DirectServiceType::where('selp_incident_id', $selpIncident[0]->id)->delete();
                $survivorDirectService = SurvivorDirectServiceModel::where('selp_incident_information_id', $selpIncident[0]->id)->delete();
                $survivorCourtCase     = SurvivorCourtCaseModel::where('selp_incident_information_id', $selpIncident[0]->id)->delete();
                $followUpInfo          = FollowUpInfo::where('selp_incident_id', $selpIncident[0]->id)->delete();
                $incidentReferral      = IncidentReferral::where('selp_incident_id', $selpIncident[0]->id)->delete();
            }
            //dd($selpIncidentUpdate);
            if ($request->selp_initiative != null && $request->selp_initiative != 2 && $request->dm_approve != 2) {
                $selpIncidentUpdate->status = 1;
            }

            if ($request->selp_initiative == null) {
                $selpIncidentUpdate->status = 0;
            }

            if ($request->dm_approve == 2) {
                $selpIncidentUpdate->status = 2;
            }
            $selpIncidentUpdate->update_by = auth()->user()->id;

            $selpIncidentUpdate->save();
        } else {
            return redirect()->route('incident.selp.add');
        }
        if ($request->has('save_destroy')) {
            $request->session()->forget('current_incident_store_session_' . $request->selp_incident_ref);
            $request->session()->forget('edit_mode');
            return redirect()->route('incident.list');
        }
        return redirect()->route('incident.selp.add', $extra_data);
    }
    public function incidentFormStep3(Request $request)
    {
        //dd($request->all());

        if (!$request->has('save_destroy')) {
            $validated = $request->validate([
                'survivor_violence_location'             => 'required',
                'survivor_reason_of_violence'            => 'required',
                'survivor_place_of_violence'             => 'required',
                'if_perpetrator_family_member_yes_or_no' => 'required',
            ]);
        }

        $selpIncident                    = SelpIncidentModel::where('selp_incident_ref', $request->selp_incident_ref)->get();
        $extra_data['tab']               = $request->tab;
        $extra_data['step']              = $request->step;
        $extra_data['selp_incident_ref'] = $request->selp_incident_ref;

        if (count($selpIncident) > 0) {
            $selpIncidentUpdate                                       = SelpIncidentModel::find($selpIncident[0]->id);
            $selpIncidentUpdate->household_type_id                    = $request->survivor_household_id;
            $selpIncidentUpdate->household_total_income               = $request->survivor_income;
            $selpIncidentUpdate->violence_location_id                 = $request->survivor_violence_location;
            $selpIncidentUpdate->survivor_marital_status_id           = $request->survivor_marital_status;
            $selpIncidentUpdate->survivor_age_of_marriage             = $request->survivor_marriage_age;
            $selpIncidentUpdate->survivor_organization_affiliation_id = $request->survivor_organization_affiliation_id;
            $selpIncidentUpdate->survivor_nid                         = $request->survivor_nid;
            $selpIncidentUpdate->survivor_reason_id                   = $request->survivor_reason_of_violence;
            $selpIncidentUpdate->violence_place_id                    = $request->survivor_place_of_violence;
            // $selpIncidentUpdate->survivor_disability_status=$request->survivor_disability_status;
            $selpIncidentUpdate->defendant_education_id                 = $request->perpetrator_education;
            $selpIncidentUpdate->defendant_occupation_id                = $request->perpetrator_occupation;
            $selpIncidentUpdate->defendant_family_member_id             = $request->if_perpetrator_family_member;
            $selpIncidentUpdate->if_perpetrator_family_member_yes_or_no = $request->if_perpetrator_family_member_yes_or_no;
            $selpIncidentUpdate->update_by                              = auth()->user()->id;
            $selpIncidentUpdate->save();
        } else {
            return redirect()->route('incident.selp.add');
        }
        if ($request->has('save_destroy')) {
            $request->session()->forget('current_incident_store_session_' . $request->selp_incident_ref);
            $request->session()->forget('edit_mode');
            return redirect()->route('incident.list');
        }
        return redirect()->route('incident.selp.add', $extra_data);
    }
    public function incidentFormStep4(Request $request)
    {
        // dd($request->all());

        if (!$request->has('save_destroy')) {
            // $validated = $request->validate([
            //     'cause_of_failour_coming_to_selp'       => 'required_if:earlier_survivor_initiative,1',
            //     'direct_service_date.*'                 => 'required_if:direct_service_type.*,1,2,5,6',
            //     'selp_alternative_dispute_resolution.*' => 'required_if:direct_service_type.*,3',
            // ]);

            $request->validate([
                'cause_of_failour_coming_to_selp'       => 'required_if:earlier_survivor_initiative,1',
                'direct_service_date.*' => 'required_if:direct_service_type.*,1,2,5,6',
                'selp_alternative_dispute_resolution.*' => 'required_if:direct_service_type.*,3',
                'case_type.*' => 'required',
            ], [
                'direct_service_date.*.required' => 'The :attribute field is required for the selected direct service types.',
                'selp_alternative_dispute_resolution.*.required' => 'The :attribute field is required.',
                'case_type.*.required' => 'The :attribute field is required.',
            ], [
                'direct_service_date.*' => 'Direct Service Date',
                'selp_alternative_dispute_resolution.*' => 'Alternative Dispute Resolution',
                'case_type.*' => 'Case Type',
            ]);
        }



        $selpIncident                    = SelpIncidentModel::where('selp_incident_ref', $request->selp_incident_ref)->get();
        $extra_data['tab']               = $request->tab;
        $extra_data['step']              = $request->step;
        $extra_data['selp_incident_ref'] = $request->selp_incident_ref;
        if (count($selpIncident) > 0) {
            DB::beginTransaction();
            $selpIncidentUpdate                                    = SelpIncidentModel::find($selpIncident[0]->id);
            $selpIncidentUpdate->earlier_survivor_initiative       = $request->earlier_survivor_initiative;
            $selpIncidentUpdate->earlier_survivor_initiative_place = $request->earlier_survivor_initiative_place;
            $selpIncidentUpdate->case_of_failour_coming_to_selp    = $request->cause_of_failour_coming_to_selp;
            // $selpIncidentUpdate->direct_service_type=$request->direct_service_type;
            // $selpIncidentUpdate->direct_service_date=$request->direct_service_date;

            DirectServiceType::where('selp_incident_ref', $selpIncident[0]->selp_incident_ref)->where('selp_incident_id', $selpIncident[0]->id)->delete();

            for ($i = 0; $i < count($request->direct_service_type); $i++) {
                if ($request->direct_service_type[$i] != null) {
                    $item                    = new DirectServiceType;
                    $item->selp_incident_id  = $selpIncident[0]->id;
                    $item->selp_incident_ref = $selpIncident[0]->selp_incident_ref;
                    $item->service_type_id   = $request->direct_service_type[$i];
                    $item->service_date      = $request->direct_service_date[$i] != null ? date("Y-m-d", strtotime($request->direct_service_date[$i])) : null;

                    if ($request->direct_service_type[$i] == 1 && $request->receive_money[0]) {
                        $item->receive_money = $request->receive_money[0];
                    }
                    $item->save();
                }
            }

            SurvivorDirectServiceModel::where('selp_incident_ref', $selpIncident[0]->selp_incident_ref)->where('selp_incident_information_id', $selpIncident[0]->id)->delete();
            if ($request->has('selp_alternative_dispute_resolution')) {
                for ($i = 0; $i < count($request->selp_alternative_dispute_resolution); $i++) {
                    if ($request->selp_alternative_dispute_resolution[$i] != null) {
                        $item                                    = new SurvivorDirectServiceModel;
                        $item->selp_incident_information_id      = $selpIncident[0]->id;
                        $item->selp_incident_ref                 = $selpIncident[0]->selp_incident_ref;
                        $item->alternative_dispute_resolution_id = $request->selp_alternative_dispute_resolution[$i];
                        $item->money_recovered_through_adr       = $request->money_recovered_through_adr[$i];
                        $item->amount_of_money_received          = $request->amount_of_money_received[$i];
                        $item->no_of_adr_participants_benefited  = $request->no_of_adr_participants_benefited[$i];
                        $item->starting_date                     = $request->selp_support_start_date[$i] != null ? date("Y-m-d", strtotime($request->selp_support_start_date[$i])) : null;
                        $item->closing_date                      = $request->selp_support_closing_date[$i] != null ? date("Y-m-d", strtotime($request->selp_support_closing_date[$i])) : null;
                        $item->save();
                    }
                }
            }
            SurvivorCourtCaseModel::where('selp_incident_ref', $selpIncident[0]->selp_incident_ref)->where('selp_incident_information_id', $selpIncident[0]->id)->delete();
            if ($request->has('case_type')) {
                //dd($request->all());

                for ($i = 0; $i < count($request->case_type); $i++) {
                    if ($request->case_type[$i] != null) {
                        $item                                    = new SurvivorCourtCaseModel;
                        $item->selp_incident_information_id      = $selpIncident[0]->id;
                        $item->selp_incident_ref                 = $selpIncident[0]->selp_incident_ref;
                        $item->case_type                         = $request->case_type[$i];
                        $item->court_case_id                     = $request->court_case_id[$i];
                        $item->moneyrecover_case_id              = $request->court_case_moneyrecover_id[$i];
                        $item->amount_of_money_received          = $request->case_amount_of_money_received[$i];
                        $item->no_of_case_participants_benefited = $request->no_of_case_participants_benefited[$i];
                        $item->judjementstatus_id                = $request->judgementstatus_id[$i];
                        $item->case_start_date                   = $request->case_start_date[$i] != null ? date("Y-m-d", strtotime($request->case_start_date[$i])) : null;
                        $item->case_judjement_date               = $request->judgement_date[$i] != null ? date("Y-m-d", strtotime($request->judgement_date[$i])) : null;
                        $item->save();
                    }
                }
            }

            $selpIncidentUpdate->money_recovered_adr                  = $request->selp_adrmoneyrecover;
            $selpIncidentUpdate->amount_money_adr                     = $request->selp_amount_of_money_from_adr;
            $selpIncidentUpdate->selp_adr_money_recover_benifitiaries = $request->selp_adr_money_recover_benifitiaries;
            $selpIncidentUpdate->update_by                            = auth()->user()->id;
            $selpIncidentUpdate->save();
            DB::commit();
        } else {
            return redirect()->route('incident.selp.add');
        }
        if ($request->has('save_destroy')) {
            $request->session()->forget('current_incident_store_session_' . $request->selp_incident_ref);
            $request->session()->forget('edit_mode');
            return redirect()->route('incident.list');
        }
        return redirect()->route('incident.selp.add', $extra_data);
    }
    public function incidentFormStep5(Request $request)
    {
        $selpIncident                    = SelpIncidentModel::where('selp_incident_ref', $request->selp_incident_ref)->get();
        $extra_data['tab']               = $request->tab;
        $extra_data['step']              = $request->step;
        $extra_data['selp_incident_ref'] = $request->selp_incident_ref;
        if (count($selpIncident) > 0) {
            //dd($request->all());
            DB::beginTransaction();
            $selpIncidentUpdate = SelpIncidentModel::find($selpIncident[0]->id);

            // SurvivorCourtCaseModel::where('selp_incident_ref',$selpIncident[0]->selp_incident_ref)->where('selp_incident_information_id',$selpIncident[0]->id)->delete();
            // for ($i=0;$i <count($request->case_type) ; $i++) {
            //    if($request->case_type[$i]!=null){
            //         $item=new SurvivorCourtCaseModel;
            //         $item->selp_incident_information_id=$selpIncident[0]->id;
            //         $item->selp_incident_ref=$selpIncident[0]->selp_incident_ref;
            //         $item->case_type=$request->case_type[$i];
            //         $item->court_case_id=$request->court_case_id[$i];
            //         $item->moneyrecover_case_id=$request->court_case_moneyrecover_id[$i];
            //         $item->judjementstatus_id=$request->judgementstatus_id[$i];
            //         $item->case_start_date=$request->case_start_date[$i];
            //         $item->case_judjement_date=$request->judgement_date[$i];
            //         $item->save();
            //     }
            // }

            if ($request->has('no_of_followup_madeby_selp_staff') && $request->no_of_followup_madeby_selp_staff != null) {

                // Check if the followup number already exists for the incident
                $existingFollowUp = FollowUpInfo::where('selp_incident_ref', $selpIncident[0]->selp_incident_ref)
                    ->where('followup_number', $request->no_of_followup_madeby_selp_staff)
                    ->exists();

                if (!$existingFollowUp) {
                    $followUp                    = new FollowUpInfo;
                    $followUp->selp_incident_id  = $selpIncident[0]->id;
                    $followUp->selp_incident_ref = $selpIncident[0]->selp_incident_ref;
                    $followUp->followup_type     = $request->program_participent_followup;
                    $followUp->followup_number   = $request->no_of_followup_madeby_selp_staff;
                    $followUp->followup_findings = $request->followup_id;
                    $followUp->followup_date     = $request->followup_date != null ? date("Y-m-d", strtotime($request->followup_date)) : null;

                    $followUp->save();
                }
            }

            // if($request->has('service_referral_no') && $request->service_referral_no!=null){
            //     for($i=0;$i<count($request->service_referral_no);$i++){
            //         if($request->service_referral_no[$i]!=null){
            //             $referral=new IncidentReferral;
            //             $referral->selp_incident_id   =   $selpIncident[0]->id;
            //             $referral->selp_incident_ref  =   $selpIncident[0]->selp_incident_ref;
            //             $referral->referral_id        =   $request->service_referral_no[$i];
            //             $referral->referral_date      =   $request->service_raferral_date[$i] !=null ? date("Y-m-d", strtotime($request->service_raferral_date[$i])) : null;

            //             $referral->save();
            //         }
            //     }
            // }
            IncidentReferral::where('selp_incident_ref', $selpIncident[0]->selp_incident_ref)->where('selp_incident_id', $selpIncident[0]->id)->delete();
            if ($request->has('service_referral_no') && $request->service_referral_no != null) {
                for ($i = 0; $i < count($request->service_referral_no); $i++) {
                    if ($request->service_referral_no[$i] != null) {
                        $referral                    = new IncidentReferral;
                        $referral->selp_incident_id  = $selpIncident[0]->id;
                        $referral->selp_incident_ref = $selpIncident[0]->selp_incident_ref;
                        $referral->referral_id       = $request->service_referral_no[$i];
                        $referral->referral_date     = $request->service_raferral_date[$i] != null ? date("Y-m-d", strtotime($request->service_raferral_date[$i])) : null;

                        $referral->save();
                        // if (isset($request->id[$i]) && $request->id[$i] != null) {
                        //     $referral                     =   IncidentReferral::find($request->id[$i]);
                        //     // dd($selpIncident[0]->id);
                        //     $referral->selp_incident_id   =   $selpIncident[0]->id;
                        //     $referral->selp_incident_ref  =   $selpIncident[0]->selp_incident_ref;
                        //     $referral->referral_id        =   $request->service_referral_no[$i];
                        //     $referral->referral_date      =   $request->service_raferral_date[$i] !=null ? date("Y-m-d", strtotime($request->service_raferral_date[$i])) : null;

                        //     $referral->save();
                        // } else {
                        // }
                    }
                }
            }

            $selpIncidentUpdate->service_referral_date = $request->service_raferral_date;
            $selpIncidentUpdate->referral_service_id   = $request->service_referral_no;
            $selpIncidentUpdate->update_by             = auth()->user()->id;

            $selpIncidentUpdate->save();
            DB::commit();
        } else {
            return redirect()->route('incident.selp.add');
        }
        if ($request->has('save_destroy')) {
            $request->session()->forget('current_incident_store_session_' . $request->selp_incident_ref);
            $request->session()->forget('edit_mode');
            return redirect()->route('incident.list');
        }
        return redirect()->route('incident.selp.add', $extra_data);
    }
    public function incidentFormStep6(Request $request)
    {
        $selpIncident                    = SelpIncidentModel::where('selp_incident_ref', $request->selp_incident_ref)->get();
        $extra_data['tab']               = $request->tab;
        $extra_data['step']              = $request->step;
        $extra_data['selp_incident_ref'] = $request->selp_incident_ref;
        $auth_user                       = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        if (count($selpIncident) > 0) {
            //dd($selpIncident);
            $selpIncidentUpdate                                     = SelpIncidentModel::find($selpIncident[0]->id);
            $selpIncidentUpdate->have_survivor_face_violence_before = $request->have_survivor_face_violence_before;
            $selpIncidentUpdate->survivor_first_face_violence_age   = $request->survivor_first_violence_age;
            $selpIncidentUpdate->type_of_violence_was_yes_or_no     = $request->type_of_violence_was_yes_or_no;
            $selpIncidentUpdate->survivor_first_face_violence_type  = $request->violence_type_multiple_list == null ? '' : implode(",", $request->violence_type_multiple_list);
            $selpIncidentUpdate->survivor_seek_support_from_brac    = $request->survivor_seek_support_from_brac;
            $selpIncidentUpdate->brac_supporttype_id                = $request->bracsupporttype_id;
            $selpIncidentUpdate->flag                               = 1;
            $selpIncidentUpdate->update_by                          = auth()->user()->id;
            if ($request->dm_approve == 2) {
                $selpIncidentUpdate->status = 2;
                if ($selpIncidentUpdate->approved_at == null) {
                    $selpIncidentUpdate->approved_at = date('Y-m-d H:i:s', strtotime('now'));
                    $selpIncidentUpdate->approved_by = auth()->user()->id;
                }
            } else if ($auth_user->user_role[0]['role_id'] == 1 && $selpIncident[0]->status == 2) {
                $selpIncidentUpdate->status = 2;
            } else {
                $selpIncidentUpdate->status = 1;
                if ($selpIncidentUpdate->submited_at == null) {
                    $selpIncidentUpdate->submited_at = date('Y-m-d H:i:s', strtotime('now'));
                }
            }

            $selpIncidentUpdate->save();
        } else {
            return redirect()->route('incident.selp.add');
        }
        if ($request->has('save_destroy')) {
            $request->session()->forget('current_incident_store_session_' . $request->selp_incident_ref);
            $request->session()->forget('edit_mode');
        }
        if ($request->dm_approve == 2 || $auth_user->user_role[0]['role_id'] == 1) {
            return redirect()->route('incident.approved.list')->with('success', 'Data Approved Successfully');
        } else {
            return redirect()->route('incident.pending.list')->with('success', 'Data Submitted Successfully');
        }

        return redirect()->route('incident.selp.add', $extra_data);
    }

    // Incident List For Other User
    public function incidentList()
    {
        $divisions           = Division::all();
        $regions             = getRegionByUserType();
        $violence_categories = ViolenceCategory::where('status', '1')->get();
        $auth_user           = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        // if ($auth_user->user_role[0]['role_id'] == 4 || $auth_user->user_role[0]['role_id'] == 5) {
        // } else {
        //     return redirect()->route('incident.pending.list');
        // }
        return redirect()->route('incident.draft.list');

        // return view('backend.admin.selp_incident.selp-incident-list',compact('auth_user','divisions','violence_categories', 'regions'));
    }

    // Draft List
    public function incidentDraftList()
    {
        // $divisions                 = Division::all();
        $violence_categories = ViolenceCategory::where('status', '1')->get();
        $auth_user           = User::with(['setup_user_area'])->where('id', Auth::id())->first();

        $region_ids   = SetupUserArea::where('user_id', $auth_user->id)->groupBy('region_id')->pluck('region_id')->toArray();
        $division_ids = SetupUserArea::where('user_id', $auth_user->id)->groupBy('division_id')->pluck('division_id')->toArray();
        $district_ids = SetupUserArea::where('user_id', $auth_user->id)->groupBy('district_id')->pluck('district_id')->toArray();
        $upazila_ids  = SetupUserArea::where('user_id', $auth_user->id)->groupBy('upazila_id')->pluck('upazila_id')->toArray();

        $regions = Region::when($region_ids, function ($query) use ($region_ids) {
            if (count($region_ids) > 0) {
                $query->whereIn('id', $region_ids);
            }
        })->where('status', '1')->get();

        $divisions = Division::when($division_ids, function ($query) use ($division_ids) {
            if (count($division_ids) > 0) {
                $query->whereIn('id', $division_ids);
            }
        })->where('status', '1')->get();

        $districts = District::when($district_ids, function ($query) use ($district_ids) {
            if (count($district_ids) > 0) {
                $query->whereIn('id', $district_ids);
            }
        })->where('status', '1')->get();

        $upazilas = Upazila::when($upazila_ids, function ($query) use ($upazila_ids) {
            if (count($upazila_ids) > 0) {
                $query->whereIn('id', $upazila_ids);
            }
        })->where('status', '1')->get();
        return view('backend.admin.selp_incident.selp-incident-draft-list', compact('auth_user', 'divisions', 'violence_categories', 'regions', 'districts', 'upazilas'));
    }

    public function getSelpIncidentDraftDatatable(Request $request)
    {
        $auth_user = User::with(['setup_user_area', 'user_role'])->where('id', Auth::id())->first();
        // if ($auth_user->user_role[0]['role_id'] == 5) {
        //     $incidents = SelpIncidentModel::select('id','posting_date','selp_incident_ref', 'survivor_name', 'survivor_gender_id', 'survivor_age','status','created_at')->where('employee_pin', $auth_user->pin);
        // } else {
        // }
        $incidents = SelpIncidentModel::select('id', 'posting_date', 'selp_incident_ref', 'survivor_name', 'survivor_gender_id', 'survivor_age', 'status', 'created_at');
        $incidents = searchCriteria($query = $incidents, $data = ['region_id' => $request->region_id, 'division_id' => $request->division_id, 'district_id' => $request->district_id, 'upazila_id' => $request->upazila_id, 'from_posting_date' => $request->from_date, 'to_posting_date' => $request->to_date]);
        $incidents->where('status', 0);
        $incidents->orderBy('id', 'DESC');

        //$draftIncidentsCount = $incidents->count();
        //session(['draftData' => $draftIncidentsCount > 0]);

        return DataTables::of($incidents)
            ->addIndexColumn()
            ->editColumn('created_at', function ($incidents) {
                return date('d-m-Y', strtotime($incidents->created_at));
            })
            ->editColumn('posting_date', function ($incidents) {
                return $incidents->posting_date != null ? date("d-m-Y", strtotime($incidents->posting_date)) : null;
            })
            ->editColumn('selp_incident_ref', function ($incidents) {
                $incident_ref      = explode('.', $incidents->selp_incident_ref);
                $selp_incident_ref = $this->formatIncidentId($incidents->id); //$incident_ref[1];
                return $selp_incident_ref;
            })
            ->addColumn('action_column', function (SelpIncidentModel $incident) use ($auth_user) {
                if ($auth_user->user_role[0]['role_id'] == 5) {
                    $links = '<a href="' . route('incident.selp.edit', $incident->selp_incident_ref) . '" class="btn btn-sm btn-info" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
                <a href="' . route('view-single-incident', $incident->id) . '" target="__blank" class="btn btn-sm btn-danger" title="PDF"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                <a href="' . route('incident.excel', $incident->id) . '" target="__blank" class="btn btn-sm btn-success" title="Excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>';
                } else {
                    $links = '<a href="' . route('view-single-incident', $incident->id) . '" target="__blank" class="btn btn-sm btn-danger" title="PDF"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                <a href="' . route('incident.excel', $incident->id) . '" target="__blank" class="btn btn-sm btn-success" title="Excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>';
                }
                return $links;
                // <a href="#" class="btn btn-sm btn-danger delete_incident"  action_type="inc_del" id="'.$incident->id.'" title="Delete"><i action_type="inc_del" class="fa fa-trash delete_incident" id="'.$incident->id.'" aria-hidden="true"></i></a>
            })
            ->editColumn('status', function ($list) {
                $actionBtn = '';
                if ($list->status == 0 || $list->status == null) {
                    $actionBtn = '<span class="badge badge-warning">Draft</span>';
                } elseif ($list->status == 2) {
                    $actionBtn = '<span class="badge badge-success">Approved</span>';
                } else {
                    $actionBtn = '<span class="badge badge-primary">Submitted for Approval</span>';
                }
                return $actionBtn;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    // Pending List
    public function incidentPendingList()
    {
        $divisions = Division::all();
        //$regions             = Region::where('status', '1')->get();

        $regions = getRegionByUserType();

        $violence_categories = ViolenceCategory::where('status', '1')->get();
        $auth_user           = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        return view('backend.admin.selp_incident.selp-incident-pending-list', compact('auth_user', 'divisions', 'violence_categories', 'regions'));
    }

    public function getSelpIncidentPendingDatatable(Request $request)
    {
        // dd($request->all());
        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date   = date("Y-m-d", strtotime($request->to_date));

        $auth_user = User::with(['setup_user_area'])->where('id', Auth::id())->first();

        // if ($auth_user->user_role[0]['role_id'] == 5) {
        //     $incidents = SelpIncidentModel::select('id','posting_date','selp_incident_ref', 'survivor_name', 'survivor_gender_id', 'survivor_age','status','created_at')->where('employee_pin', $auth_user->pin);
        // } else {
        // }
        $incidents = SelpIncidentModel::select('id', 'posting_date', 'selp_incident_ref', 'survivor_name', 'survivor_gender_id', 'survivor_age', 'status', 'created_at');
        $incidents = searchCriteria($query = $incidents, $data = ['region_id' => $request->region_id, 'division_id' => $request->division_id, 'district_id' => $request->district_id, 'upazila_id' => $request->upazila_id, 'from_date' => $request->from_date, 'to_date' => $request->to_date]);
        $incidents->where('status', 1);
        $incidents->orderBy('id', 'DESC');

        return DataTables::of($incidents)
            ->addIndexColumn()
            ->editColumn('created_at', function ($incidents) {
                return date('d-m-Y', strtotime($incidents->created_at));
            })
            ->editColumn('posting_date', function ($incidents) {
                return $incidents->posting_date != null ? date("d-m-Y", strtotime($incidents->posting_date)) : null;
            })
            ->editColumn('selp_incident_ref', function ($incidents) {
                $incident_ref      = explode('.', $incidents->selp_incident_ref);
                $selp_incident_ref = $this->formatIncidentId($incidents->id); //$incident_ref[1];
                return $selp_incident_ref;
            })
            ->addColumn('action_column', function (SelpIncidentModel $incident) use ($auth_user) {
                // dd($auth_user);
                if ($auth_user->user_role[0]['role_id'] == 4) {
                    $links = '<a href="' . route('incident.selp.edit', $incident->selp_incident_ref) . '" class="btn btn-sm btn-info" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                    $links .= '&nbsp;<a href="' . route('view-single-incident', $incident->id) . '" target="__blank" class="btn btn-sm btn-danger" title="PDF"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                    <a href="' . route('incident.excel', $incident->id) . '" target="__blank" class="btn btn-sm btn-success" title="Excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>';
                } elseif ($auth_user->user_role[0]['role_id'] == 5) {
                    // $links = '<a href="' . route('incident.selp.edit', $incident->selp_incident_ref) . '" class="btn btn-sm btn-info" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                    // $links .=   '&nbsp;<a href="#" class="btn btn-sm btn-danger delete_incident"  action_type="inc_del" id="'.$incident->id.'" title="Delete"><i action_type="inc_del" class="fa fa-trash delete_incident" id="'.$incident->id.'" aria-hidden="true"></i></a>';
                    $links = '&nbsp;<a href="' . route('view-single-incident', $incident->id) . '" target="__blank" class="btn btn-sm btn-danger" title="PDF"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                <a href="' . route('incident.excel', $incident->id) . '" target="__blank" class="btn btn-sm btn-success" title="Excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>';
                } elseif ($auth_user->user_role[0]['role_id'] == 1) {
                    // $links =   '&nbsp;<a href="#" class="btn btn-sm btn-danger delete_incident"  action_type="inc_del" id="'.$incident->id.'" title="Delete"><i action_type="inc_del" class="fa fa-trash delete_incident" id="'.$incident->id.'" aria-hidden="true"></i></a>';
                    $links = '&nbsp;<a href="' . route('view-single-incident', $incident->id) . '" target="__blank" class="btn btn-sm btn-danger" title="PDF"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                <a href="' . route('incident.excel', $incident->id) . '" target="__blank" class="btn btn-sm btn-success" title="Excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>';
                } else {
                    $links = '&nbsp;<a href="' . route('view-single-incident', $incident->id) . '" target="__blank" class="btn btn-sm btn-danger" title="PDF"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                <a href="' . route('incident.excel', $incident->id) . '" target="__blank" class="btn btn-sm btn-success" title="Excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>';
                }
                return $links;
            })
            ->editColumn('status', function ($list) {
                $actionBtn = '';
                if ($list->status == 0 || $list->status == null) {
                    $actionBtn = '<span class="badge badge-warning">Draft</span>';
                } elseif ($list->status == 2) {
                    $actionBtn = '<span class="badge badge-success">Approved</span>';
                } else {
                    $actionBtn = '<span class="badge badge-primary">Submitted for Approval</span>';
                }
                return $actionBtn;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    // Approved List
    public function incidentApprovedList()
    {
        $divisions = Division::all();
        //$regions             = Region::where('status', '1')->get();

        $regions = getRegionByUserType();

        $violence_categories = ViolenceCategory::where('status', '1')->get();
        $auth_user           = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        return view('backend.admin.selp_incident.selp-incident-approved-list', compact('auth_user', 'divisions', 'violence_categories', 'regions'));
    }

    public function getSelpIncidentApprovedDatatable(Request $request)
    {
        // dd($request->all());
        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date   = date("Y-m-d", strtotime($request->to_date));

        $auth_user = User::with(['setup_user_area'])->where('id', Auth::id())->first();

        // if ($auth_user->user_role[0]['role_id'] == 5) {
        //     $incidents = SelpIncidentModel::select('id','posting_date','selp_incident_ref', 'survivor_name', 'survivor_gender_id', 'survivor_age','status','created_at')->where('employee_pin', $auth_user->pin);
        // } else {
        // }
        $incidents = SelpIncidentModel::select('id', 'posting_date', 'selp_incident_ref', 'survivor_name', 'survivor_gender_id', 'survivor_age', 'status', 'created_at', 'selp_initiative');
        $incidents = searchCriteria($query = $incidents, $data = ['region_id' => $request->region_id, 'division_id' => $request->division_id, 'district_id' => $request->district_id, 'upazila_id' => $request->upazila_id, 'from_posting_date' => $request->from_date, 'to_posting_date' => $request->to_date]);
        $incidents->where('status', 2);
        $incidents->orderBy('id', 'DESC');

        return DataTables::of($incidents)
            ->addIndexColumn()
            ->editColumn('created_at', function ($incidents) {
                return date('d-m-Y', strtotime($incidents->created_at));
            })
            ->editColumn('posting_date', function ($incidents) {
                return $incidents->posting_date != null ? date("d-m-Y", strtotime($incidents->posting_date)) : null;
            })
            ->editColumn('selp_incident_ref', function ($incidents) {
                $incident_ref      = explode('.', $incidents->selp_incident_ref);
                $selp_incident_ref = $this->formatIncidentId($incidents->id); //$incident_ref[1];
                return $selp_incident_ref;
            })
            ->addColumn('action_column', function (SelpIncidentModel $incident) use ($auth_user) {

                if ($auth_user->user_role[0]['role_id'] == 4 && $incident->status == 1) {
                    $links = '<a href="' . route('incident.selp.edit', $incident->selp_incident_ref) . '" class="btn btn-sm btn-info" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a> ';

                    $links .= '<a href="' . route('view-single-incident', $incident->id) . '" target="__blank" class="btn btn-sm btn-danger" title="PDF"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                    <a href="' . route('incident.excel', $incident->id) . '" target="__blank" class="btn btn-sm btn-success" title="Excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>';
                } elseif ($auth_user->user_role[0]['role_id'] == 1 || $auth_user->user_role[0]['role_id'] == 11 || $auth_user->user_role[0]['role_id'] == 12) {
                    $links = '<a href="' . route('incident.selp.edit', $incident->selp_incident_ref) . '" class="btn btn-sm btn-info" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a> ';
                    // $links = '<a href="#" class="btn btn-sm btn-danger delete_incident"  action_type="inc_del" id="' . $incident->id . '" title="Delete"><i action_type="inc_del" class="fa fa-trash delete_incident" id="' . $incident->id . '" aria-hidden="true"></i></a>';
                    $links .= '&nbsp;<a href="' . route('view-single-incident', $incident->id) . '" target="__blank" class="btn btn-sm btn-danger" title="PDF"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                    <a href="' . route('incident.excel', $incident->id) . '" target="__blank" class="btn btn-sm btn-success" title="Excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>';
                } else {
                    $links = '<a href="' . route('view-single-incident', $incident->id) . '" target="__blank" class="btn btn-sm btn-danger" title="PDF"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                    <a href="' . route('incident.excel', $incident->id) . '" target="__blank" class="btn btn-sm btn-success" title="Excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>';
                }

                // if ($incident->selp_initiative != 2) {
                //     $links .= '<a href="' . route('incident.selp.money.support', $incident->id) . '" target="__blank" class="btn btn-sm btn-primary ml-1" title="Excel"><i class="fa fa-usd mr-1" aria-hidden="true"></i>Add Money Support</a>';
                // }

                return $links;
            })
            ->editColumn('status', function ($list) {
                $actionBtn = '';
                if ($list->status == 0 || $list->status == null) {
                    $actionBtn = '<span class="badge badge-warning">Draft</span>';
                } elseif ($list->status == 2) {
                    $actionBtn = '<span class="badge badge-success">Approved</span>';
                } else {
                    $actionBtn = '<span class="badge badge-primary">Pending for Approval</span>';
                }
                return $actionBtn;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    // Direct support portion
    public function directSupportList()
    {
        $divisions = Division::all();
        //$regions             = Region::where('status', '1')->get();

        $regions             = getRegionByUserType();
        $violence_categories = ViolenceCategory::where('status', '1')->get();
        $auth_user           = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        return view('backend.admin.selp_incident.multiple_direct_support', compact('auth_user', 'divisions', 'violence_categories', 'regions'));
    }

    public function getSelpIncidentDirectServiceDatatable(Request $request)
    {
        // dd($request->all());
        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date   = date("Y-m-d", strtotime($request->to_date));
        // dd(Auth::id());
        // $auth_user      = User::with(['setup_user' => function ($query){
        //     $query->with(['setup_user_area']);
        // }])->where('id', Auth::id())->first();

        $auth_user = User::with(['setup_user_area'])->where('id', Auth::id())->first();

        // if ($auth_user->user_role[0]['role_id'] == 5) {
        //     $incidents = SelpIncidentModel::select('id','posting_date','selp_incident_ref', 'survivor_name', 'survivor_gender_id', 'survivor_age','status','created_at')->where('employee_pin', $auth_user->pin);
        // } else {
        // }
        $incidents = SelpIncidentModel::select('id', 'posting_date', 'selp_incident_ref', 'survivor_name', 'survivor_gender_id', 'survivor_age', 'status', 'created_at');
        $incidents = searchCriteria($query = $incidents, $data = ['region_id' => $request->region_id, 'division_id' => $request->division_id, 'district_id' => $request->district_id, 'upazila_id' => $request->upazila_id, 'from_date' => $request->from_date, 'to_date' => $request->to_date]);

        $incidents->where('selp_initiative', 2);
        $incidents->where('status', 2);
        $incidents->orderBy('id', 'DESC');

        return DataTables::of($incidents)
            ->addIndexColumn()
            ->editColumn('posting_date', function ($incidents) {
                return $incidents->posting_date != null ? date("d-m-Y", strtotime($incidents->posting_date)) : null;
            })
            ->editColumn('selp_incident_ref', function ($incidents) {
                $incident_ref      = explode('.', $incidents->selp_incident_ref);
                $selp_incident_ref = $this->formatIncidentId($incidents->id); //$incident_ref[1];
                return $selp_incident_ref;
            })
            ->addColumn('action_column', function (SelpIncidentModel $incident) use ($auth_user) {
                // dd($auth_user->user_role[0]['role_id']);
                if ($auth_user->user_role[0]['role_id'] == 5 && $incident->status == 2) {
                    $links = '<a href="' . route('incident.selp.addsupport', $incident->selp_incident_ref) . '" class="btn btn-sm btn-info" title="Edit">Add Direct Support</a> ';
                } else {
                    $links = '<a href="' . route('incident.selp.addsupport', $incident->selp_incident_ref) . '" class="btn btn-sm btn-info" title="Edit">Add Direct Support</a> ';
                }
                return $links;
            })
            ->editColumn('status', function ($list) {
                $actionBtn = '';
                if ($list->status == 0 || $list->status == null) {
                    $actionBtn = '<span class="badge badge-warning">Draft</span>';
                } elseif ($list->status == 2) {
                    $actionBtn = '<span class="badge badge-success">Approved</span>';
                } else {
                    $actionBtn = '<span class="badge badge-primary">Pending for Approval</span>';
                }
                return $actionBtn;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    public function getSelpIncidentDirectSupportAdd(Request $request, $incidentRef)
    {
        //  return $request->all();
        $selpIncident = SelpIncidentModel::where('selp_incident_ref', $incidentRef)->get();
        if ($request->isMethod('post')) {
            if ($request->has('direct_service_type')) {
                $request->validate([
                    'direct_service_date.*'                     => 'required_if:direct_service_type.*,1,2,5,6',
                    'selp_alternative_dispute_resolution.*'     => 'required',
                    'money_recovered_through_adr.*'             => 'required_with:selp_alternative_dispute_resolution.*',
                    'case_type.*'                               => 'required',
                    'court_case_moneyrecover_id.*'              => 'required_with:case_type.*',
                ], [
                    'direct_service_date.*.required'                    => 'The :attribute field is required for the selected direct service types.',
                    'selp_alternative_dispute_resolution.*.required'    => 'The :attribute field is required.',
                    'money_recovered_through_adr.*.required'            => 'The :attribute field is required.',
                    'case_type.*.required'                              => 'The :attribute field is required.',
                    'court_case_moneyrecover_id.*.required'             => 'The :attribute field is required.',
                ], [
                    'direct_service_date.*'                 => 'Direct Service Date',
                    'selp_alternative_dispute_resolution.*' => 'Alternative Dispute Resolution',
                    'money_recovered_through_adr.*'         => 'Purpose of disputes',
                    'case_type.*'                           => 'Case Type',
                    'court_case_moneyrecover_id.*'          => 'Court Case Purpose of disputes',
                ]);

                //return $request;
                for ($i = 0; $i < count($request->direct_service_type); $i++) {
                    if ($request->direct_service_type[$i] != null) {
                        if (isset($request->id[$i]) && $request->id[$i] != null) {
                            $item                    = DirectServiceType::find($request->id[$i]);
                            $item->selp_incident_id  = $selpIncident[0]->id;
                            $item->selp_incident_ref = $selpIncident[0]->selp_incident_ref;
                            $item->service_type_id   = $request->direct_service_type[$i];
                            $item->service_date      = $request->direct_service_date[$i] != null ? date("Y-m-d", strtotime($request->direct_service_date[$i])) : null;

                            if ($request->direct_service_type[$i] == 1 && $request->receive_money[0]) {
                                $item->receive_money = $request->receive_money[0];
                            }
                            $item->save();
                        } else {
                            $item                    = new DirectServiceType;
                            $item->selp_incident_id  = $selpIncident[0]->id;
                            $item->selp_incident_ref = $selpIncident[0]->selp_incident_ref;
                            $item->service_type_id   = $request->direct_service_type[$i];
                            $item->service_date      = $request->direct_service_date[$i] != null ? date("Y-m-d", strtotime($request->direct_service_date[$i])) : null;
                            if ($request->direct_service_type[$i] == 1 && $request->receive_money[0]) {
                                $item->receive_money = $request->receive_money[0];
                            }
                            $item->save();
                        }
                    }
                }
            }

            if ($request->has('selp_alternative_dispute_resolution')) {

                for ($i = 0; $i < count($request->selp_alternative_dispute_resolution); $i++) {
                    if ($request->selp_alternative_dispute_resolution[$i] != null) {
                        if (isset($request->adr_id[$i]) && $request->adr_id[$i] != null) {
                            $item                                    = SurvivorDirectServiceModel::find($request->adr_id[$i]);
                            $item->selp_incident_information_id      = $selpIncident[0]->id;
                            $item->selp_incident_ref                 = $selpIncident[0]->selp_incident_ref;
                            $item->alternative_dispute_resolution_id = $request->selp_alternative_dispute_resolution[$i];
                            $item->money_recovered_through_adr       = $request->money_recovered_through_adr[$i];
                            $item->amount_of_money_received          = $request->amount_of_money_received[$i];
                            $item->no_of_adr_participants_benefited  = $request->no_of_adr_participants_benefited[$i];
                            $item->starting_date                     = $request->selp_support_start_date[$i] != null ? date("Y-m-d", strtotime($request->selp_support_start_date[$i])) : null;
                            $item->closing_date                      = $request->selp_support_closing_date[$i] != null ? date("Y-m-d", strtotime($request->selp_support_closing_date[$i])) : null;
                            $item->save();
                        } else {
                            $item                                    = new SurvivorDirectServiceModel;
                            $item->selp_incident_information_id      = $selpIncident[0]->id;
                            $item->selp_incident_ref                 = $selpIncident[0]->selp_incident_ref;
                            $item->alternative_dispute_resolution_id = $request->selp_alternative_dispute_resolution[$i];
                            $item->money_recovered_through_adr       = $request->money_recovered_through_adr[$i];
                            $item->amount_of_money_received          = $request->amount_of_money_received[$i];
                            $item->no_of_adr_participants_benefited  = $request->no_of_adr_participants_benefited[$i];
                            $item->starting_date                     = $request->selp_support_start_date[$i] != null ? date("Y-m-d", strtotime($request->selp_support_start_date[$i])) : null;
                            $item->closing_date                      = $request->selp_support_closing_date[$i] != null ? date("Y-m-d", strtotime($request->selp_support_closing_date[$i])) : null;
                            $item->save();
                        }
                    }
                }
            }

            if ($request->has('case_type')) {

                for ($i = 0; $i < count($request->case_type); $i++) {
                    if ($request->case_type[$i] != null) {
                        if (isset($request->case_id[$i]) && $request->case_id[$i] != null) {
                            $item                                    = SurvivorCourtCaseModel::find($request->case_id[$i]);
                            $item->selp_incident_information_id      = $selpIncident[0]->id;
                            $item->selp_incident_ref                 = $selpIncident[0]->selp_incident_ref;
                            $item->case_type                         = $request->case_type[$i];
                            $item->court_case_id                     = $request->court_case_id[$i];
                            $item->moneyrecover_case_id              = $request->court_case_moneyrecover_id[$i];
                            $item->amount_of_money_received          = $request->case_amount_of_money_received[$i];
                            $item->no_of_case_participants_benefited = $request->no_of_case_participants_benefited[$i];
                            $item->judjementstatus_id                = $request->judgementstatus_id[$i];
                            $item->case_start_date                   = $request->case_start_date[$i] != null ? date("Y-m-d", strtotime($request->case_start_date[$i])) : null;
                            $item->case_judjement_date               = $request->judgement_date[$i] != null ? date("Y-m-d", strtotime($request->judgement_date[$i])) : null;
                            $item->save();
                        } else {
                            $item                                    = new SurvivorCourtCaseModel;
                            $item->selp_incident_information_id      = $selpIncident[0]->id;
                            $item->selp_incident_ref                 = $selpIncident[0]->selp_incident_ref;
                            $item->case_type                         = $request->case_type[$i];
                            $item->court_case_id                     = $request->court_case_id[$i];
                            $item->moneyrecover_case_id              = $request->court_case_moneyrecover_id[$i];
                            $item->amount_of_money_received          = $request->case_amount_of_money_received[$i];
                            $item->no_of_case_participants_benefited = $request->no_of_case_participants_benefited[$i];
                            $item->judjementstatus_id                = $request->judgementstatus_id[$i];
                            $item->case_start_date                   = $request->case_start_date[$i] != null ? date("Y-m-d", strtotime($request->case_start_date[$i])) : null;
                            $item->case_judjement_date               = $request->judgement_date[$i] != null ? date("Y-m-d", strtotime($request->judgement_date[$i])) : null;
                            $item->save();
                        }
                    }
                }
            }

            $request->session()->flash('success', 'Direct service added');
            return redirect()->route('incident.directsupport.list');
        }

        $data['incidentRef']     = $incidentRef;
        $data['selpIncident']    = $selpIncident;
        $data['adrs']            = AlternativeDisputeResolution::where('status', 1)->get();

        $reported_incident_type = @$data['selpIncident'][0]->types_of_disputes->name;
        if ($reported_incident_type) {
            $data['adrMoneyRecover'] = Adrmoneyrecover::where('status', 1)->where('title', 'like', '%' . $reported_incident_type . '%')->get();
        } else {
            $data['adrMoneyRecover'] = Adrmoneyrecover::where('status', 1)->get();
        }

        return view('backend.admin.selp_incident.direct_support_container', $data);
    }

    //Followup support
    public function getSelpIncidentFollowUpSupportList()
    {
        $divisions = Division::all();
        //$regions             = Region::where('status', '1')->get();

        $regions             = getRegionByUserType();
        $violence_categories = ViolenceCategory::where('status', '1')->get();
        $auth_user           = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        return view('backend.admin.selp_incident.multi_followup', compact('auth_user', 'divisions', 'violence_categories', 'regions'));
    }
    public function getSelpIncidentFollowUpDatatable(Request $request)
    {
        // dd($request->all());
        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date   = date("Y-m-d", strtotime($request->to_date));
        // dd(Auth::id());
        // $auth_user      = User::with(['setup_user' => function ($query){
        //     $query->with(['setup_user_area']);
        // }])->where('id', Auth::id())->first();

        $auth_user = User::with(['setup_user_area'])->where('id', Auth::id())->first();

        // if ($auth_user->user_role[0]['role_id'] == 5) {
        //     $incidents = SelpIncidentModel::select('id','posting_date','selp_incident_ref', 'survivor_name', 'survivor_gender_id', 'survivor_age','status','created_at')->where('employee_pin', $auth_user->pin);
        // } else {
        // }
        $incidents = SelpIncidentModel::select('id', 'posting_date', 'selp_incident_ref', 'survivor_name', 'survivor_gender_id', 'survivor_age', 'status', 'created_at');
        $incidents = searchCriteria($query = $incidents, $data = ['region_id' => $request->region_id, 'division_id' => $request->division_id, 'district_id' => $request->district_id, 'upazila_id' => $request->upazila_id, 'from_date' => $request->from_date, 'to_date' => $request->to_date]);

        $incidents->where('selp_initiative', 2);
        $incidents->where('status', 2);
        $incidents->orderBy('id', 'DESC');

        return DataTables::of($incidents)
            ->addIndexColumn()
            ->editColumn('created_at', function ($incidents) {
                return date('d-m-Y', strtotime($incidents->created_at));
            })
            ->editColumn('selp_incident_ref', function ($incidents) {
                $incident_ref      = explode('.', $incidents->selp_incident_ref);
                $selp_incident_ref = $this->formatIncidentId($incidents->id); //$incident_ref[1];
                return $selp_incident_ref;
            })
            ->addColumn('action_column', function (SelpIncidentModel $incident) use ($auth_user) {
                // dd($auth_user->user_role[0]['role_id']);
                if ($auth_user->user_role[0]['role_id'] == 5 && $incident->status == 2) {
                    $links = '<a href="' . route('incident.selp.addfollowup', $incident->selp_incident_ref) . '" class="btn btn-sm btn-info" title="Edit">Add Followup</a> ';
                } else {
                    $links = '<a href="' . route('incident.selp.addfollowup', $incident->selp_incident_ref) . '" class="btn btn-sm btn-info" title="Edit">Add Followup</a> ';
                }
                return $links;
            })
            ->editColumn('status', function ($list) {
                $actionBtn = '';
                if ($list->status == 0 || $list->status == null) {
                    $actionBtn = '<span class="badge badge-warning">Draft</span>';
                } elseif ($list->status == 2) {
                    $actionBtn = '<span class="badge badge-success">Approved</span>';
                } else {
                    $actionBtn = '<span class="badge badge-primary">Pending for Approval</span>';
                }
                return $actionBtn;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    public function getSelpIncidentFollowUpSupportAdd(Request $request, $incidentRef)
    {
        // dd($request->all());
        $selpIncident = SelpIncidentModel::where('selp_incident_ref', $incidentRef)->get();
        if ($request->isMethod('post')) {
            if ($request->has('no_of_followup_madeby_selp_staff') && $request->no_of_followup_madeby_selp_staff != null) {
                for ($i = 0; $i < count($request->no_of_followup_madeby_selp_staff); $i++) {
                    if ($request->no_of_followup_madeby_selp_staff[$i] != null) {
                        if (isset($request->id[$i]) && $request->id[$i] != null) {
                            $followUp                    = FollowUpInfo::find($request->id[$i]);
                            $followUp->selp_incident_id  = $selpIncident[0]->id;
                            $followUp->selp_incident_ref = $selpIncident[0]->selp_incident_ref;
                            $followUp->followup_type     = $request->program_participent_followup[$i];
                            $followUp->followup_number   = $request->no_of_followup_madeby_selp_staff[$i];
                            $followUp->followup_findings = $request->followup_id[$i];
                            $followUp->followup_date     = $request->followup_date[$i] != null ? date("Y-m-d", strtotime($request->followup_date[$i])) : null;

                            $followUp->save();
                        } else {
                            $followUp                    = new FollowUpInfo;
                            $followUp->selp_incident_id  = $selpIncident[0]->id;
                            $followUp->selp_incident_ref = $selpIncident[0]->selp_incident_ref;
                            $followUp->followup_type     = $request->program_participent_followup[$i];
                            $followUp->followup_number   = $request->no_of_followup_madeby_selp_staff[$i];
                            $followUp->followup_findings = $request->followup_id[$i];
                            $followUp->followup_date     = $request->followup_date[$i] != null ? date("Y-m-d", strtotime($request->followup_date[$i])) : null;

                            $followUp->save();
                        }
                    }
                }
            }

            $request->session()->flash('success', 'Followup added');
            return redirect()->route('incident.followup.list');
        }

        $data['incidentRef']          = $incidentRef;
        $data['selpIncident']         = $selpIncident;
        $data['findingsFromFollowUp'] = Followup::where('status', 1)->get();
        return view('backend.admin.selp_incident.multi_followup_container', $data);
    }

    //Referral support

    //Followup support
    public function getSelpIncidentReferralSupportList()
    {
        $divisions = Division::all();
        //$regions             = Region::where('status', '1')->get();

        $regions = getRegionByUserType();

        $violence_categories = ViolenceCategory::where('status', '1')->get();
        $auth_user           = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        return view('backend.admin.selp_incident.multi_referral', compact('auth_user', 'divisions', 'violence_categories', 'regions'));
    }
    public function getSelpIncidentReferralDatatable(Request $request)
    {
        // dd($request->all());
        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date   = date("Y-m-d", strtotime($request->to_date));
        // dd(Auth::id());
        // $auth_user      = User::with(['setup_user' => function ($query){
        //     $query->with(['setup_user_area']);
        // }])->where('id', Auth::id())->first();

        $auth_user = User::with(['setup_user_area'])->where('id', Auth::id())->first();

        // if ($auth_user->user_role[0]['role_id'] == 5) {
        //     $incidents = SelpIncidentModel::select('id','posting_date','selp_incident_ref', 'survivor_name', 'survivor_gender_id', 'survivor_age','status','created_at')->where('employee_pin', $auth_user->pin);
        // } else {
        // }
        $incidents = SelpIncidentModel::select('id', 'posting_date', 'selp_incident_ref', 'survivor_name', 'survivor_gender_id', 'survivor_age', 'status', 'created_at');
        $incidents = searchCriteria($query = $incidents, $data = ['region_id' => $request->region_id, 'division_id' => $request->division_id, 'district_id' => $request->district_id, 'upazila_id' => $request->upazila_id, 'from_date' => $request->from_date, 'to_date' => $request->to_date]);

        $incidents->where('selp_initiative', 2);
        $incidents->where('status', 2);
        $incidents->orderBy('id', 'DESC');

        return DataTables::of($incidents)
            ->addIndexColumn()
            ->editColumn('created_at', function ($incidents) {
                return date('d-m-Y', strtotime($incidents->created_at));
            })
            ->editColumn('selp_incident_ref', function ($incidents) {
                $incident_ref      = explode('.', $incidents->selp_incident_ref);
                $selp_incident_ref = $this->formatIncidentId($incidents->id); //$incident_ref[1];
                return $selp_incident_ref;
            })
            ->addColumn('action_column', function (SelpIncidentModel $incident) use ($auth_user) {
                // dd($auth_user->user_role[0]['role_id']);
                if ($auth_user->user_role[0]['role_id'] == 5 && $incident->status == 2) {
                    $links = '<a href="' . route('incident.selp.addreferral', $incident->selp_incident_ref) . '" class="btn btn-sm btn-info" title="Edit">Add Referral</a> ';
                } else {
                    $links = '<a href="' . route('incident.selp.addreferral', $incident->selp_incident_ref) . '" class="btn btn-sm btn-info" title="Edit">Add Referral</a> ';
                }
                return $links;
            })
            ->editColumn('status', function ($list) {
                $actionBtn = '';
                if ($list->status == 0 || $list->status == null) {
                    $actionBtn = '<span class="badge badge-warning">Draft</span>';
                } elseif ($list->status == 2) {
                    $actionBtn = '<span class="badge badge-success">Approved</span>';
                } else {
                    $actionBtn = '<span class="badge badge-primary">Pending for Approval</span>';
                }
                return $actionBtn;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    public function getSelpIncidentReferralSupportAdd(Request $request, $incidentRef)
    {
        // dd($request->all());
        $selpIncident = SelpIncidentModel::where('selp_incident_ref', $incidentRef)->get();
        if ($request->isMethod('post')) {
            IncidentReferral::where('selp_incident_ref', $selpIncident[0]->selp_incident_ref)->where('selp_incident_id', $selpIncident[0]->id)->delete();
            if ($request->has('service_referral_no') && $request->service_referral_no != null) {
                for ($i = 0; $i < count($request->service_referral_no); $i++) {
                    if ($request->service_referral_no[$i] != null) {
                        $referral                    = new IncidentReferral;
                        $referral->selp_incident_id  = $selpIncident[0]->id;
                        $referral->selp_incident_ref = $selpIncident[0]->selp_incident_ref;
                        $referral->referral_id       = $request->service_referral_no[$i];
                        $referral->referral_date     = $request->service_raferral_date[$i] != null ? date("Y-m-d", strtotime($request->service_raferral_date[$i])) : null;

                        $referral->save();
                        // if (isset($request->id[$i]) && $request->id[$i] != null) {
                        //     $referral                     =   IncidentReferral::find($request->id[$i]);
                        //     $referral->selp_incident_id   =   $selpIncident[0]->id;
                        //     $referral->selp_incident_ref  =   $selpIncident[0]->selp_incident_ref;
                        //     $referral->referral_id        =   $request->service_referral_no[$i];
                        //     $referral->referral_date      =   $request->service_raferral_date[$i] !=null ? date("Y-m-d", strtotime($request->service_raferral_date[$i])) : null;

                        //     $referral->save();
                        // } else {
                        // }
                    }
                }
            }

            $request->session()->flash('success', 'Referral added');
            return redirect()->route('incident.referral.list');
        }

        $data['incidentRef']        = $incidentRef;
        $data['selpIncident']       = $selpIncident;
        $data['secondaryRefferals'] = SecondaryRefferal::orderBy('name', 'asc')->where('status', 1)->get();
        return view('backend.admin.selp_incident.multi_referral_container', $data);
    }

    public function deleteIncident(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $incident_tbl = SelpIncidentModel::find($id)->delete();
            $serviec_tbl  = SurvivorDirectServiceModel::where('selp_incident_information_id', $id)->delete();
            $followup_tbl = FollowUpInfo::where('selp_incident_id', $id)->delete();
            $referral_tbl = IncidentReferral::where('selp_incident_id', $id)->delete();
            $case_tbl     = SurvivorCourtCaseModel::where('selp_incident_information_id', $id)->delete();
            DB::commit();
            return "Deleted Successfully";
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function incidentExcelExpot($id)
    {
        $data['incident_data'] = SelpIncidentModel::with(['direct_services', 'direct_support_adr', 'direct_service_followup', 'direct_service_courtcase', 'survivor_referral'])
            ->where('id', $id)
            ->first();
        // dd($data['indicent_data']);
        $view_link = 'backend.admin.selp_incident.single_incident_excel';
        // return view($view_link, $data);
        return Excel::download(new MisReportExport($data, $view_link), 'single_incident_excel.xlsx');
    }

    // Money support
    public function selpIncidentExceptComplainReceivedList()
    {
        $divisions              = Division::all();
        $regions                = getRegionByUserType();
        $violence_categories    = ViolenceCategory::where('status', '1')->get();
        $auth_user              = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        return view('backend.admin.selp_incident.money_support_list', compact('auth_user', 'divisions', 'violence_categories', 'regions'));
    }

    public function selpIncidentExceptComplainReceivedDatatable(Request $request)
    {
        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date   = date("Y-m-d", strtotime($request->to_date));
        $auth_user = User::with(['setup_user_area'])->where('id', Auth::id())->first();

        $incidents = SelpIncidentModel::select('id', 'posting_date', 'selp_incident_ref', 'survivor_name', 'survivor_gender_id', 'survivor_age', 'selp_initiative', 'status', 'created_at');
        $incidents = searchCriteria($query = $incidents, $data = ['region_id' => $request->region_id, 'division_id' => $request->division_id, 'district_id' => $request->district_id, 'upazila_id' => $request->upazila_id, 'from_date' => $request->from_date, 'to_date' => $request->to_date]);
        
        // Apply filter for selp_initiative if requested
        $incidents->where(function ($query) use ($request) {

            // If specific selp_initiative requested, apply additional filter
            if ($request->filled('selp_initiative')) {
                $selp_initiative = $request->selp_initiative;
                $query->where('selp_initiative', $selp_initiative);
            } else{
                $query->where('selp_initiative', '!=', 2);
            }
        })
        ->where('status', 2)
        ->orderBy('id', 'DESC');

        return DataTables::of($incidents)
            ->addIndexColumn()
            ->editColumn('posting_date', function ($incident) {
                return $incident->posting_date != null ? date("d-m-Y", strtotime($incident->posting_date)) : null;
            })
            ->editColumn('complain_id', function ($incident) {
                // $incident_ref      = explode('.', $incident->selp_incident_ref);
                $complain_id = $this->formatIncidentId($incident->id);
                return $complain_id;
            })
            ->addColumn('action_column', function (SelpIncidentModel $incident) use ($auth_user) {
                // if ($auth_user->user_role[0]['role_id'] == 5 && $incident->status == 2) {
                //     $links = '<a href="' . route('incident.selp.addsupport', $incident->selp_incident_ref) . '" class="btn btn-sm btn-info" title="Edit">Add Direct Support</a> ';
                // } else {
                //     $links = '<a href="' . route('incident.selp.addsupport', $incident->selp_incident_ref) . '" class="btn btn-sm btn-info" title="Edit">Add Direct Support</a> ';
                // }
                $links = '<a href="' . route('incident.selp.money.support', $incident->id) . '" class="btn btn-sm btn-primary ml-1" title="Excel"><i class="fa fa-usd mr-1" aria-hidden="true"></i>Add Money Support</a>';
                return $links;
            })
            ->editColumn('status', function ($list) {
                $actionBtn = '';
                if ($list->status == 0 || $list->status == null) {
                    $actionBtn = '<span class="badge badge-warning">Draft</span>';
                } elseif ($list->status == 2) {
                    $actionBtn = '<span class="badge badge-success">Approved</span>';
                } else {
                    $actionBtn = '<span class="badge badge-primary">Pending for Approval</span>';
                }
                return $actionBtn;
            })
            ->editColumn('selp_initiative', function ($incident) {
                $selpInitiative = '';
                if ($incident->selp_initiative == 1) {
                    $selpInitiative = '<span class="badge badge-info">Referral</span>';
                } elseif ($incident->selp_initiative == 3) {
                    $selpInitiative = '<span class="badge badge-primary">Violence Incident Documented</span>';
                } elseif ($incident->selp_initiative == 4) {
                    $selpInitiative = '<span class="badge badge-secondary">Legal Advice</span>';
                }
                return $selpInitiative;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }
    public function addSelpIncidentMoneySupport(Request $request, $id)
    {

        $data['selp_incident'] = SelpIncidentModel::select('id', 'posting_date', 'selp_incident_ref', 'survivor_name', 'survivor_gender_id', 'survivor_age', 'status', 'created_at', 'selp_initiative')->where('id', $id)->first();

        if ($request->isMethod('post')) {

            $request->validate([
                'amount_of_money_received.*'    => 'required|numeric|min:0',
                'money_receive_date.*'          => 'required|date',
            ], [],[
                'amount_of_money_received.*'    => 'Amount Of Money Received',
                'money_receive_date.*'          => 'Money Receive Date'
            ]);

            $moneySupportIds    = $request->selp_incident_money_support_id;
            $amounts            = $request->amount_of_money_received;
            $dates              = $request->money_receive_date;

            foreach ($amounts as $index => $amount) {
                if ($moneySupportIds[$index]) {
                    // Update existing entry
                    $moneySupport                           = SelpIncidentMoneySupport::find($moneySupportIds[$index]);
                    $moneySupport->amount_of_money_received = $amount;
                    $moneySupport->money_receive_date       = $dates[$index];
                    $moneySupport->updated_by               = Auth::id();
                    $moneySupport->save();
                } else {
                    // Create new entry
                    $moneySupport                               = new SelpIncidentMoneySupport();
                    $moneySupport->selp_incident_information_id = $id;
                    $moneySupport->amount_of_money_received     = $amount;
                    $moneySupport->money_receive_date           = $dates[$index];
                    $moneySupport->created_by                   = Auth::id();
                    $moneySupport->save();
                }
            }
            return redirect()->route('incident.except_complain_received.list')->with('success', 'Money support updated successfully.');
        }

        return view('backend.admin.selp_incident.money_support', $data);
    }
}
