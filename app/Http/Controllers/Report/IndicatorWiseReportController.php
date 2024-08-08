<?php

namespace App\Http\Controllers\Report;

use App\ChildMarriageInformation;
use App\Exports\MisReportExport;
use App\HeadOfficeActivity;
use App\Http\Controllers\Controller;
use App\Model\ActivityModel;
use App\Model\Admin\Setup\CEP_Region\Region;
use App\Model\Admin\Setup\District;
use App\Model\Admin\Setup\Division;
use App\Model\Admin\Setup\Upazila;
use App\Model\DirectServiceType;
use App\Model\SelpIncidentModel;
use App\SwapnosarothiProfile;
use App\SwapnosarothiProfileSkill;
use App\SwapnosarothiSetupGroup;
use App\SwapnosarothiSkill;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class IndicatorWiseReportController extends Controller
{

    // Indicator Wise Report

    public function swapnoSarothiProfileQuery($request, $profile_ids = null)
    {

        $role_ids = auth()->user()->user_role->pluck('role_id')->toArray();

        $query = SwapnosarothiProfile::query();

        if ($profile_ids) {
            $query->whereIn('id', $profile_ids);
        }

        if ($request->region_id) {
            // if ($request->division_id) {
            //     $previousZoneInfo = getPreviousZoneIdsFromDivision($request->division_id);
            //     if (!empty($previousZoneInfo)) {
            //         // Extract region_ids and date_to values
            //         $regionIds      = array_keys($previousZoneInfo);
            //         //$dateToValues   = array_values($previousZoneInfo);
            //         $updateReigonIds = array_unique(array_merge($regionIds, [(int)$request->region_id]));
            //     } else {
            //         $updateReigonIds = [(int)$request->region_id];
            //     }
            //     $query->whereIn('employee_zone_id', $updateReigonIds);
            // } else {
            //     $query->where('employee_zone_id', $request->region_id);
            // }
            $query->where('employee_zone_id', $request->region_id);
        } else if (array_intersect([5, 4, 3], $role_ids)) {
            $area = array_unique(User::with('setup_user_area')->find(Auth::id())->setup_user_area->pluck('region_id')->toArray());
            $query->whereIn('employee_zone_id', $area);
        }

        if ($request->division_id) {
            $query->where('employee_division_id', $request->division_id);
        } else if (array_intersect([5, 4], $role_ids)) {
            $area = array_unique(User::with('setup_user_area')->find(Auth::id())->setup_user_area->pluck('division_id')->toArray());
            $query->whereIn('employee_division_id', $area);
        }

        if ($request->district_id) {
            $query->where('employee_district_id', $request->district_id);
        } else if (array_intersect([5, 4], $role_ids)) {
            $area = array_unique(User::with('setup_user_area')->find(Auth::id())->setup_user_area->pluck('district_id')->toArray());
            $query->whereIn('employee_district_id', $area);
        }

        if ($request->upazila_id) {
            $query->where('employee_upazila_id', $request->upazila_id);
        } else if (array_intersect([5], $role_ids)) {
            $area = array_unique(User::with('setup_user_area')->find(Auth::id())->setup_user_area->pluck('upazila_id')->toArray());
            $query->whereIn('employee_upazila_id', $area);
        }

        if ($request->group_id) {
            $query->where('group_id', $request->group_id);
        }

        return $query;
    }

    public function selpIncidentQuery($request)
    {

        $query = SelpIncidentModel::query();

        if ($request->region_id) {
            // if ($request->division_id) {
            //     $previousZoneInfo = getPreviousZoneIdsFromDivision($request->division_id);
            //     if (!empty($previousZoneInfo)) {
            //         // Extract region_ids and date_to values
            //         $regionIds      = array_keys($previousZoneInfo);
            //         //$dateToValues   = array_values($previousZoneInfo);
            //         $updateReigonIds = array_unique(array_merge($regionIds, [(int)$request->region_id]));
            //     } else {
            //         $updateReigonIds = [(int)$request->region_id];
            //     }
            //     $query->whereIn('employee_zone_id', $updateReigonIds);
            // } else {
            //     $query->where('employee_zone_id', $request->region_id);
            // }
            $query->where('employee_zone_id', $request->region_id);
        } else if (array_intersect([5, 4, 3], auth()->user()->user_role->pluck('role_id')->toarray())) {
            $area = array_unique(User::with('setup_user_area')->find(Auth::id())->setup_user_area->pluck('region_id')->toArray());
            $query->whereIn('employee_zone_id', $area);
        }

        if ($request->division_id) {
            $query->where('employee_division_id', $request->division_id);
        } else if (array_intersect([5, 4], auth()->user()->user_role->pluck('role_id')->toarray())) {
            $area = array_unique(User::with('setup_user_area')->find(Auth::id())->setup_user_area->pluck('division_id')->toArray());
            $query->whereIn('employee_division_id', $area);
        }

        if ($request->district_id) {
            $query->where('employee_district_id', $request->district_id);
        } else if (array_intersect([5, 4], auth()->user()->user_role->pluck('role_id')->toarray())) {
            $area = array_unique(User::with('setup_user_area')->find(Auth::id())->setup_user_area->pluck('district_id')->toArray());
            $query->whereIn('employee_district_id', $area);
        }

        if ($request->upazila_id) {
            $query->where('employee_upazila_id', $request->upazila_id);
        } else if (array_intersect([5], auth()->user()->user_role->pluck('role_id')->toarray())) {
            $area = array_unique(User::with('setup_user_area')->find(Auth::id())->setup_user_area->pluck('upazila_id')->toArray());
            $query->whereIn('employee_upazila_id', $area);
        }
        return $query;
    }

    public function indicatorReportGenerate(Request $request)
    {
        Session::put('title', 'Indicator Reports');

        $data['regions']            = getRegionByUserType();
        $data['auth_user']          = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        $data['indicator_reports']  = $this->getIndicatorReportDetails();
        $data['report_types']       = [];

        return view('backend.report.indicator_reports.view', $data);
    }

    public function indicatorReportProcess(Request $request)
    {

        $from_date      = date('Y-m-d', strtotime($request->from_date));
        $to_date        = date('Y-m-d', strtotime($request->to_date));
        $report_type    = $request->input('report_type');
        $processed_data = [];

        $indicator_report_details   = $this->getIndicatorReportDetails($report_type);
        $outcome_data               = $indicator_report_details['outcome'];

        switch ($report_type) {
            case '1':

                // $complain_received_for_adr          = $this->getComplainReceivedForAdrInfo($request, $from_date, $to_date, $report_type);
                // $complain_received_for_court_case   = $this->getComplainReceivedForCourtCaseInfo($request, $from_date, $to_date, $report_type);
                // $combined_complain                  = $complain_received_for_adr->merge($complain_received_for_court_case)->unique('id')->values();

                $combined_complain                      = $this->getComplainReceivedInfo($request, $from_date, $to_date, $report_type);
                $adr_received_money                     = $this->getAdrReceivedMoneyInfo($request, $from_date, $to_date, $report_type);
                $court_case_received_money              = $this->getCourtCaseReceivedMoneyInfo($request, $from_date, $to_date, $report_type);
                $combined_complain_with_money_received  = $adr_received_money->merge($court_case_received_money)->unique('id')->values()->count();

                $report_output_info                     = $this->getIndicatorOneOutputInfo($combined_complain, $report_type);

                if (@$report_output_info['total'] != 0) {
                    $outcome_1_1_4_1 = number_format(($combined_complain_with_money_received / $report_output_info['total']) * 100, 2) . '%';
                } else {
                    $outcome_1_1_4_1 = 'N/A';
                }

                $processed_data = [
                    'title'         => @$indicator_report_details['title'],
                    'data'          => [
                        'indicator_ref'         => @$indicator_report_details['reference'],
                        'indicator_title'       => @$indicator_report_details['title'],
                        'year'                  => '-',
                        'from_date'             => $from_date,
                        'to_date'               => $to_date,
                        'total'                 => @$report_output_info['total'],
                        'outcome_ref'           => @$indicator_report_details['outcome']['reference'],
                        'outcome_title'         => @$indicator_report_details['outcome']['title'],
                        'percentage_in_outcome' => $outcome_1_1_4_1,
                        'men'                   => @$report_output_info['g_men'],
                        'women'                 => @$report_output_info['g_women'],
                        'other_gender'          => @$report_output_info['g_other'],
                        'pwd_men'               => @$report_output_info['p_men'],
                        'pwd_women'             => @$report_output_info['p_women'],
                        'pwd_other_gender'      => @$report_output_info['p_other'],

                    ],
                    'indicator_span' => count($outcome_data) > 0 ? 2 : 1,
                ];
                break;

            case '2':

                $session_12         = SwapnosarothiSkill::where('code', 12)->value('id');
                $rhrn_project_girls = HeadOfficeActivity::where('ho_event_id', 7)->sum('participant_total');

                // Calculate the count of girls who have profile skills within the specified date range
                $swapnosarothi_girls = $this->countSwapnoSarothiGirlsWithSkills($request, $from_date, $to_date, $report_type, $session_12);

                $output_2_1_2_3_1 = $swapnosarothi_girls + $rhrn_project_girls;

                $processed_data = [
                    'title'         => @$indicator_report_details['title'],
                    'data'          => [
                        'indicator_ref'         => @$indicator_report_details['reference'],
                        'indicator_title'       => @$indicator_report_details['title'],
                        'year'                  => '-',
                        'from_date'             => $from_date,
                        'to_date'               => $to_date,
                        'total'                 => $output_2_1_2_3_1,
                        'outcome_ref'           => @$indicator_report_details['outcome']['reference'],
                        'outcome_title'         => @$indicator_report_details['outcome']['title'],
                        'percentage_in_outcome' => '-',
                        'men'                   => '-',
                        'women'                 => '-',
                        'other_gender'          => '-',
                        'pwd_men'               => '-',
                        'pwd_women'             => '-',
                        'pwd_other_gender'      => '-',

                    ],
                    'indicator_span' => count($outcome_data) > 0 ? 2 : 1,
                ];
                break;

            case '3':
                $pt_show_activities     = $this->getPTShowActivitiesOutputInfo($request, $from_date, $to_date, $report_type);
                $campaign_activities    = $this->getCampaignActivitiesOutputInfo($request, $from_date, $to_date, $report_type);

                $total_participant      = @$pt_show_activities->total_participant + @$campaign_activities->total_participant;
                $total_men              = @$pt_show_activities->total_participant_boys + @$pt_show_activities->total_participant_men + @$campaign_activities->total_participant_boys + @$campaign_activities->total_participant_men;
                $total_women            = @$pt_show_activities->total_participant_girls + @$pt_show_activities->total_participant_women + @$campaign_activities->total_participant_girls + @$campaign_activities->total_participant_women;
                $total_other_gender     = @$pt_show_activities->total_participant_other_gender + @$campaign_activities->total_participant_other_gender;
                $total_pwd_men          = @$pt_show_activities->total_participant_pwd_boys + @$pt_show_activities->total_participant_pwd_men + @$campaign_activities->total_participant_pwd_boys + @$campaign_activities->total_participant_pwd_men;
                $total_pwd_women        = @$pt_show_activities->total_participant_pwd_girls + @$pt_show_activities->total_participant_pwd_women + @$campaign_activities->total_participant_pwd_girls + @$campaign_activities->total_participant_pwd_women;
                $total_pwd_other_gender = @$pt_show_activities->total_participant_pwd_other_gender + @$campaign_activities->total_participant_pwd_other_gender;

                $total_information_providers = $this->selpIncidentQuery($request)
                    ->whereBetween('posting_date', [$from_date . ' 00:00:00', $to_date . ' 23:59:59'])
                    ->where('selp_incident_informations.status', 2)
                    ->whereIn('information_provider_source_id', [1, 2, 5, 4, 7, 10, 11, 12, 17, 18])
                    ->count();

                if ($total_participant != 0) {
                    $outcome_2_3_1_1 = number_format(($total_information_providers / $total_participant) * 100, 2) . '%';
                } else {
                    $outcome_2_3_1_1 = 'N/A';
                }

                $processed_data = [
                    'title'         => @$indicator_report_details['title'],
                    'data'          => [
                        'indicator_ref'         => @$indicator_report_details['reference'],
                        'indicator_title'       => @$indicator_report_details['title'],
                        'year'                  => '-',
                        'from_date'             => $from_date,
                        'to_date'               => $to_date,
                        'total'                 => $total_participant,
                        'outcome_ref'           => @$indicator_report_details['outcome']['reference'],
                        'outcome_title'         => @$indicator_report_details['outcome']['title'],
                        'percentage_in_outcome' => $outcome_2_3_1_1,
                        'men'                   => $total_men,
                        'women'                 => $total_women,
                        'other_gender'          => $total_other_gender,
                        'pwd_men'               => $total_pwd_men,
                        'pwd_women'             => $total_pwd_women,
                        'pwd_other_gender'      => $total_pwd_other_gender,

                    ],
                    'indicator_span' => count($outcome_data) > 0 ? 2 : 1,
                ];
                break;

            case '4':

                $session_and_other_service_by_ho = $this->getTotalSessionServiceByHO($from_date, $to_date, $report_type);

                $processed_data = [
                    'title'         => @$indicator_report_details['title'],
                    'data'          => [
                        'indicator_ref'         => @$indicator_report_details['reference'],
                        'indicator_title'       => @$indicator_report_details['title'],
                        'year'                  => '-',
                        'from_date'             => $from_date,
                        'to_date'               => $to_date,
                        'total'                 => @$session_and_other_service_by_ho->total_no_of_event,
                        'outcome_ref'           => @$indicator_report_details['outcome']['reference'],
                        'outcome_title'         => @$indicator_report_details['outcome']['title'],
                        'percentage_in_outcome' => '-',
                        'men'                   => '-',
                        'women'                 => '-',
                        'other_gender'          => '-',
                        'pwd_men'               => '-',
                        'pwd_women'             => '-',
                        'pwd_other_gender'      => '-',

                    ],
                    'indicator_span' => count($outcome_data) > 0 ? 2 : 1,
                ];
                break;

            case '5':

                $meeting_activities = $this->getMeetingActivitiesOutputInfo($request, $from_date, $to_date, $report_type);

                $processed_data = [
                    'title'         => @$indicator_report_details['title'],
                    'data'          => [
                        'indicator_ref'         => @$indicator_report_details['reference'],
                        'indicator_title'       => @$indicator_report_details['title'],
                        'year'                  => '-',
                        'from_date'             => $from_date,
                        'to_date'               => $to_date,
                        'total'                 => $meeting_activities,
                        'outcome_ref'           => @$indicator_report_details['outcome']['reference'],
                        'outcome_title'         => @$indicator_report_details['outcome']['title'],
                        'percentage_in_outcome' => '-',
                        'men'                   => '-',
                        'women'                 => '-',
                        'other_gender'          => '-',
                        'pwd_men'               => '-',
                        'pwd_women'             => '-',
                        'pwd_other_gender'      => '-',

                    ],
                    'indicator_span' => count($outcome_data) > 0 ? 2 : 1,
                ];
                break;

            case '6':

                $referrral_service_by_selp = $this->getTotalReferralServiceBySelp($request, $from_date, $to_date, $report_type);
                $referrral_service_by_hgsp = $this->getTotalReferralServiceByHGSP($from_date, $to_date, $report_type);

                $processed_data = [
                    'title'         => @$indicator_report_details['title'],
                    'data'          => [
                        'indicator_ref'         => @$indicator_report_details['reference'],
                        'indicator_title'       => @$indicator_report_details['title'],
                        'year'                  => '-',
                        'from_date'             => $from_date,
                        'to_date'               => $to_date,
                        'total'                 => $referrral_service_by_selp + $referrral_service_by_hgsp,
                        'outcome_ref'           => @$indicator_report_details['outcome']['reference'],
                        'outcome_title'         => @$indicator_report_details['outcome']['title'],
                        'percentage_in_outcome' => '-',
                        'men'                   => '-',
                        'women'                 => '-',
                        'other_gender'          => '-',
                        'pwd_men'               => '-',
                        'pwd_women'             => '-',
                        'pwd_other_gender'      => '-',

                    ],
                    'indicator_span' => count($outcome_data) > 0 ? 2 : 1,
                ];
                break;

            case '7':

                $total_complain_documented_and_received = $this->getComplainDocumentedAndReceivedInfo($request, $from_date, $to_date, $report_type);
                $total_service_provided                 = $this->getTotalServiceProvidedInfo($request, $from_date, $to_date, $report_type);

                if ($total_complain_documented_and_received != 0) {
                    $outcome_2_4_4_1 = number_format(($total_service_provided / $total_complain_documented_and_received) * 100, 2) . '%';
                } else {
                    $outcome_2_4_4_1 = 'N/A';
                }

                $processed_data = [
                    'title'         => @$indicator_report_details['title'],
                    'data'          => [
                        'indicator_ref'         => @$indicator_report_details['reference'],
                        'indicator_title'       => @$indicator_report_details['title'],
                        'year'                  => '-',
                        'from_date'             => $from_date,
                        'to_date'               => $to_date,
                        'total'                 => $total_complain_documented_and_received,
                        'outcome_ref'           => @$indicator_report_details['outcome']['reference'],
                        'outcome_title'         => @$indicator_report_details['outcome']['title'],
                        'percentage_in_outcome' => $outcome_2_4_4_1,
                        'men'                   => '-',
                        'women'                 => '-',
                        'other_gender'          => '-',
                        'pwd_men'               => '-',
                        'pwd_women'             => '-',
                        'pwd_other_gender'      => '-',

                    ],
                    'indicator_span' => count($outcome_data) > 0 ? 2 : 1,
                ];
                break;

            case '8':

                $swapnosarothi_girls_with_skills    = $this->countSwapnoSarothiGirlsWithSkills($request, $from_date, $to_date, $report_type);
                $total_life_skill_session_held      = $this->numberOfSkillSessionHeld($request, $from_date, $to_date);
                $total_swapnosarothi_group          = $this->getSwapnosarothiGroup($request);
                $swapnosarothi_married_info         = $this->swapnosarothiMarriedInfo($request, $from_date, $to_date, $report_type);

                // Calculate the output value based on the ratio of girls who have skills to the total unique skills held
                if ($total_life_skill_session_held != 0) {
                    $output_2_3_3_1_1 = (int) ceil($swapnosarothi_girls_with_skills / $total_life_skill_session_held) * $total_swapnosarothi_group;
                } else {
                    $output_2_3_3_1_1 = 'N/A';
                }

                if (@$swapnosarothi_married_info['not_married_after_18'] != 0) {
                    $outcome_2_3_3_1 = number_format(($swapnosarothi_married_info['not_married_after_18'] / $swapnosarothi_married_info['total']) * 100, 2) . '%';
                } else {
                    $outcome_2_3_3_1 = 'N/A';
                }

                $processed_data = [
                    'title'         => @$indicator_report_details['title'],
                    'data'          => [
                        'indicator_ref'         => @$indicator_report_details['reference'],
                        'indicator_title'       => @$indicator_report_details['title'],
                        'year'                  => '-',
                        'from_date'             => $from_date,
                        'to_date'               => $to_date,
                        'total'                 => $output_2_3_3_1_1,
                        'outcome_ref'           => @$indicator_report_details['outcome']['reference'],
                        'outcome_title'         => @$indicator_report_details['outcome']['title'],
                        'percentage_in_outcome' => $outcome_2_3_3_1,
                        'men'                   => '-',
                        'women'                 => '-',
                        'other_gender'          => '-',
                        'pwd_men'               => '-',
                        'pwd_women'             => '-',
                        'pwd_other_gender'      => '-',

                    ],
                    'indicator_span' => count($outcome_data) > 0 ? 2 : 1,
                ];
                break;

            case '9':

                $number_of_parents_attend_meeting   = $this->numberOfParentsAttendMeeting($request, $from_date, $to_date, $report_type);

                $number_of_swapnosarothi_groups = $this->getSwapnosarothiGroup($request);

                $total_parents  = @$number_of_parents_attend_meeting->total_participant;
                $total_events   = @$number_of_parents_attend_meeting->total_no_of_event;

                // Calculate the output value based on the ratio of girls who have skills to the total unique skills held, then add 722
                if ($total_events != 0 && $number_of_swapnosarothi_groups != 0) {
                    $output_2_3_3_1_2 = (int) ceil($total_parents / $total_events) * $number_of_swapnosarothi_groups;
                } else {
                    $output_2_3_3_1_2 = 'N/A';
                }

                $processed_data = [

                    'title'         => @$indicator_report_details['title'],
                    'data'          => [
                        'indicator_ref'         => @$indicator_report_details['reference'],
                        'indicator_title'       => @$indicator_report_details['title'],
                        'year'                  => '-',
                        'from_date'             => $from_date,
                        'to_date'               => $to_date,
                        'total'                 => $output_2_3_3_1_2,
                        'outcome_ref'           => @$indicator_report_details['outcome']['reference'],
                        'outcome_title'         => @$indicator_report_details['outcome']['title'],
                        'percentage_in_outcome' => '-',
                        'men'                   => '-',
                        'women'                 => '-',
                        'other_gender'          => '-',
                        'pwd_men'               => '-',
                        'pwd_women'             => '-',
                        'pwd_other_gender'      => '-',

                    ],
                    'indicator_span' => count($outcome_data) > 0 ? 2 : 1,
                ];

                break;

            case '10':

                $number_of_girls_under_cash_support   = $this->swapnosarothiCashSupportInfo($request, $from_date, $to_date, $report_type);

                $processed_data = [
                    'title'         => @$indicator_report_details['title'],
                    'data'          => [
                        'indicator_ref'         => @$indicator_report_details['reference'],
                        'indicator_title'       => @$indicator_report_details['title'],
                        'year'                  => '-',
                        'from_date'             => $from_date,
                        'to_date'               => $to_date,
                        'total'                 => $number_of_girls_under_cash_support,
                        'outcome_ref'           => @$indicator_report_details['outcome']['reference'],
                        'outcome_title'         => @$indicator_report_details['outcome']['title'],
                        'percentage_in_outcome' => '-',
                        'men'                   => '-',
                        'women'                 => '-',
                        'other_gender'          => '-',
                        'pwd_men'               => '-',
                        'pwd_women'             => '-',
                        'pwd_other_gender'      => '-',

                    ],
                    'indicator_span' => count($outcome_data) > 0 ? 2 : 1,
                ];
                break;

            case '11':

                $number_of_cm_incident_reported     = $this->getCMIncidentInfos($request, $from_date, $to_date, $report_type);
                $number_of_cm_prevented             = $this->getCMPreventedInfos($request, $from_date, $to_date, $report_type);

                if ($number_of_cm_incident_reported != 0) {
                    $outcome_2_3_4_1 = number_format(($number_of_cm_prevented / $number_of_cm_incident_reported) * 100, 2) . '%';
                } else {
                    $outcome_2_3_4_1 = 'N/A';
                }

                $processed_data = [
                    'title'         => @$indicator_report_details['title'],
                    'data'          => [
                        'indicator_ref'         => @$indicator_report_details['reference'],
                        'indicator_title'       => @$indicator_report_details['title'],
                        'year'                  => '-',
                        'from_date'             => $from_date,
                        'to_date'               => $to_date,
                        'total'                 => $number_of_cm_incident_reported,
                        'outcome_ref'           => @$indicator_report_details['outcome']['reference'],
                        'outcome_title'         => @$indicator_report_details['outcome']['title'],
                        'percentage_in_outcome' => $outcome_2_3_4_1,
                        'men'                   => '-',
                        'women'                 => '-',
                        'other_gender'          => '-',
                        'pwd_men'               => '-',
                        'pwd_women'             => '-',
                        'pwd_other_gender'      => '-',

                    ],
                    'indicator_span' => count($outcome_data) > 0 ? 2 : 1,
                ];
                break;

            default:
                # code...
                break;
        }

        return response()->json($processed_data);
    }


    function getIndicatorReportDetails($report_type = null)
    {
        $indicator_reports = [
            1  => [

                'reference' => 'Output: 1.1.4.1.1',
                'title'     => "No. of BRAC participants claimed their rights related to dower, maintenance and inheritance/ property rights issues",
                'outcome'   => [

                    'reference' => 'Outcome: 1.1.4.1',
                    'title'     => "BRAC participants, were able to get their money for dower, maintenance, inheritance etc. through legal aid services",

                ]
            ],
            2  => [

                'reference' => 'Output: 2.1.2.3.1',
                'title'     => "No. of Adolescent women and girls gained knowledge on SRHR education and participation in HH level decision making through SELP initiatives",
                'outcome'   => []
            ],
            3  => [

                'reference' => 'Output: 2.3.1.1.1',
                'title'     => "No. of people informed on reporting and prevention of VAWC through SELP initiatives",
                'outcome'   => [

                    'reference' => 'Outcome: 2.3.1.1',
                    'title'     => "No. of programme participants (both men and women) reported VAWG and harmful practice",

                ]
            ],
            4  => [

                'reference' => 'Output: 2.3.2.2.1',
                'title'     => "No. of evidence based findings sharing sessions/ dialogues/ workshops and memberships with networks and organizations for strengthening public prosecution systems",
                'outcome'   => []
            ],
            5  => [

                'reference' => 'Output: 2.4.2.1.1',
                'title'     => "No. of meeting/webinar/seminar/ workshops arranged/attended with different BRAC programme, state and non-state network and agencies to enhance integrated support to VAWC survivors",
                'outcome'   => []
            ],
            6  => [

                'reference' => 'Output: 2.4.2.1.2',
                'title'     => "No. of VAWC survivors referred to different service providers (BRAC and others state and non-state actors)",
                'outcome'   => []
            ],
            7  => [

                'reference' => 'Output: 2.4.4.1.1',
                'title'     => "No. of VAWG related cases are  documented/received  to SELP programme of BRAC ",
                'outcome'   => [

                    'reference' => 'Outcome: 2.4.4.1',
                    'title'     => "No.of VAWG reported cases (survivors) received legal aid services (legal advice and counselling, ADR, court cases, assistance to police station, emergency medical support etc)",

                ]
            ],
            8  => [

                'reference' => 'Output: 2.3.3.1.1',
                'title'     => "No. of girls who received aspiration and confidence-building support through various life-skill sessions, aimed for enhancing their potential.",
                'outcome'   => [

                    'reference' => 'Outcome: 2.3.3.1',
                    'title'     => "No. of BRAC identified adolescent girls have not married before the age of 18",

                ]
            ],
            9  => [

                'reference' => 'Output: 2.3.3.1.2',
                'title'     => "No. of parents who gained knowledge on the negative consequences of child marriage and the benefits of girls' education",
                'outcome'   => []
            ],
            10  => [

                'reference' => 'Output: 2.3.3.1.3',
                'title'     => "No. of girls and their families who received cash incentives or livelihood assistance to support the girls' education and prevent them from getting married before the age of 18",
                'outcome'   => []
            ],
            11  => [

                'reference' => 'Output: 2.3.4.1.1',
                'title'     => "No. of child marriage initiatives that were reported through the BRAC reporting mechanism.",
                'outcome'   => [

                    'reference' => 'Outcome: 2.3.4.1',
                    'title'     => "No. of reported child marriage initiatives prevented by BRAC participants",

                ]
            ],
        ];

        return $indicator_reports[$report_type] ?? $indicator_reports;
    }

    // Indicator Output: 1.1.4.1.1
    // public function getComplainReceivedForAdrInfo($request, $from_date, $to_date, $report_type = null)
    // {

    //     $complain_received_for_adr = $this->selpIncidentQuery($request)->join('survivor_direct_services', 'survivor_direct_services.selp_incident_information_id', '=', 'selp_incident_informations.id')
    //         ->select(
    //             'selp_incident_informations.id',
    //             'employee_zone_id',
    //             'employee_division_id',
    //             'employee_district_id',
    //             'employee_upazila_id',
    //             'status',
    //             'survivor_disability_status',
    //             'survivor_age',
    //             'survivor_gender_id',
    //             'money_recovered_through_adr as purpose'
    //         )
    //         ->whereIn('money_recovered_through_adr', [2, 3, 4, 5])
    //         ->whereNotNull('posting_date')
    //         ->whereBetween('posting_date', [$from_date . ' 00:00:00', $to_date . ' 23:59:59'])
    //         ->where('selp_incident_informations.selp_initiative', 2)
    //         ->where('selp_incident_informations.status', 2)
    //         ->get();

    //     return $complain_received_for_adr;
    // }

    // public function getComplainReceivedForCourtCaseInfo($request, $from_date, $to_date, $report_type = null)
    // {
    //     $complain_received_for_court_case = $this->selpIncidentQuery($request)->join('survivor_court_cases', 'survivor_court_cases.selp_incident_information_id', '=', 'selp_incident_informations.id')
    //         ->select(
    //             'selp_incident_informations.id',
    //             'employee_zone_id',
    //             'employee_division_id',
    //             'employee_district_id',
    //             'employee_upazila_id',
    //             'status',
    //             'survivor_disability_status',
    //             'survivor_age',
    //             'survivor_gender_id',
    //             'moneyrecover_case_id as purpose'
    //         )
    //         ->whereIn('moneyrecover_case_id', [12, 13, 14, 15])
    //         ->whereNotNull('posting_date')
    //         ->whereBetween('posting_date', [$from_date . ' 00:00:00', $to_date . ' 23:59:59'])
    //         ->where('selp_incident_informations.selp_initiative', 2)
    //         ->where('selp_incident_informations.status', 2)
    //         ->get();

    //     return $complain_received_for_court_case;
    // }

    public function getComplainReceivedInfo($request, $from_date, $to_date, $report_type = null)
    {

        $complain_received = $this->selpIncidentQuery($request)
            ->select(
                'id',
                'employee_zone_id',
                'employee_division_id',
                'employee_district_id',
                'employee_upazila_id',
                'status',
                'survivor_disability_status',
                'survivor_age',
                'survivor_gender_id',
            )
            ->whereIn('violence_reason_id', [1, 2, 3, 5])
            ->whereNotNull('posting_date')
            ->whereBetween('posting_date', [$from_date . ' 00:00:00', $to_date . ' 23:59:59'])
            ->where('selp_initiative', 2)
            ->where('status', 2)
            ->get();

        return $complain_received;
    }

    public function getAdrReceivedMoneyInfo($request, $from_date, $to_date, $report_type = null)
    {
        $adr_received_money = $this->selpIncidentQuery($request)->join('survivor_direct_services', 'survivor_direct_services.selp_incident_information_id', '=', 'selp_incident_informations.id')
            ->select(
                'selp_incident_informations.id',
                'money_recovered_through_adr as purpose',
                'amount_of_money_received'
            )
            ->whereIn('money_recovered_through_adr', [2, 3, 4, 5])
            ->whereNotNull('amount_of_money_received')
            ->whereNotNull('posting_date')
            ->whereBetween('posting_date', [$from_date . ' 00:00:00', $to_date . ' 23:59:59'])
            ->where('selp_incident_informations.selp_initiative', 2)
            ->where('selp_incident_informations.status', 2)
            ->get();

        return $adr_received_money;
    }

    public function getCourtCaseReceivedMoneyInfo($request, $from_date, $to_date, $report_type = null)
    {
        $court_case_received_money = $this->selpIncidentQuery($request)->join('survivor_court_cases', 'survivor_court_cases.selp_incident_information_id', '=', 'selp_incident_informations.id')
            ->select(
                'selp_incident_informations.id',
                'moneyrecover_case_id as purpose',
                'amount_of_money_received'
            )
            ->whereIn('moneyrecover_case_id', [12, 13, 14, 15])
            ->whereNotNull('amount_of_money_received')
            ->whereNotNull('posting_date')
            ->whereBetween('posting_date', [$from_date . ' 00:00:00', $to_date . ' 23:59:59'])
            ->where('selp_incident_informations.selp_initiative', 2)
            ->where('selp_incident_informations.status', 2)
            ->get();

        return $court_case_received_money;
    }

    public function getIndicatorOneOutputInfo($combined_complain, $report_type = null)
    {

        $array_data         = [];
        $count              = count($combined_complain);

        for ($i = 0; $i < $count; $i++) {
            $survivor_info              = $combined_complain[$i];
            @$array_data['g_men']       += 0;
            @$array_data['g_women']     += 0;
            @$array_data['g_other']     += 0;
            @$array_data['p_men']       += 0;
            @$array_data['p_women']     += 0;
            @$array_data['p_other']     += 0;
            @$array_data['total']       += 0;

            if (@$survivor_info->survivor_gender_id == '1') {
                @$array_data['g_men']       += 1;
            } elseif (@$survivor_info->survivor_gender_id == '2') {
                @$array_data['g_women']     += 1;
            } elseif (@$survivor_info->survivor_gender_id == '4') {
                @$array_data['g_other']     += 1;
            }

            if (@$survivor_info->survivor_disability_status != '10') {
                if (@$survivor_info->survivor_gender_id == '1') {
                    @$array_data['p_men']       += 1;
                } elseif (@$survivor_info->survivor_gender_id == '2') {
                    @$array_data['p_women']     += 1;
                } elseif (@$survivor_info->survivor_gender_id == '4') {
                    @$array_data['p_other']     += 1;
                }
            }

            @$array_data['total']       += 1;
        }
        return $array_data;
    }

    // Indicator Output: 2.3.1.1.1
    public function getPTShowActivitiesOutputInfo($request, $from_date, $to_date, $report_type = null)
    {

        $pt_show_activities = ActivityModel::query();
        $pt_show_activities = searchCriteria($query = $pt_show_activities, $data = ['region_id' => $request->region_id, 'division_id' => $request->division_id, 'district_id' => $request->district_id, 'upazila_id' => $request->upazila_id]);
        $pt_show_activities->where('status', 2)->whereBetween('reporting_date', [$from_date . ' 00:00:00', $to_date . ' 23:59:59']);

        // Filter by date range
        $pt_show_activities->join('selp_pt_show_activities', 'selp_pt_show_activities.selp_activities_id', '=', 'selp_activities.id')
            // ->where(function ($query) use ($from_date, $to_date) {
            //     $query->where('starting_date', '<=', $to_date)
            //         ->where('ending_date', '>=', $from_date);
            // })
            ->where('selp_pt_show_activities.event_id', 2)
            // ->select('selp_activities.id', 'selp_activities.employee_zone_id', 'selp_activities.employee_division_id', 'selp_activities.employee_district_id', 'selp_activities.employee_upazila_id', 'selp_activities.reporting_date','selp_pt_show_activities.event_id');
            ->selectRaw('SUM(participant_boys) AS total_participant_boys')
            ->selectRaw('SUM(participant_girls) AS total_participant_girls')
            ->selectRaw('SUM(participant_men) AS total_participant_men')
            ->selectRaw('SUM(participant_women) AS total_participant_women')
            ->selectRaw('SUM(participant_other_gender) AS total_participant_other_gender')
            ->selectRaw('SUM(participant_total) AS total_participant')
            ->selectRaw('SUM(participant_pwd_boys) AS total_participant_pwd_boys')
            ->selectRaw('SUM(participant_pwd_girls) AS total_participant_pwd_girls')
            ->selectRaw('SUM(participant_pwd_men) AS total_participant_pwd_men')
            ->selectRaw('SUM(participant_pwd_women) AS total_participant_pwd_women')
            ->selectRaw('SUM(participant_pwd_other_gender) AS total_participant_pwd_other_gender')
            ->selectRaw('SUM(participant_pwd_total) AS total_participant_pwd');

        $pt_show_activities = $pt_show_activities->first();
        return $pt_show_activities;
    }

    public function getCampaignActivitiesOutputInfo($request, $from_date, $to_date, $report_type = null)
    {
        $campaign_activities = ActivityModel::query();
        $campaign_activities = searchCriteria($query = $campaign_activities, $data = ['region_id' => $request->region_id, 'division_id' => $request->division_id, 'district_id' => $request->district_id, 'upazila_id' => $request->upazila_id]);
        $campaign_activities->where('status', 2)->whereBetween('reporting_date', [$from_date . ' 00:00:00', $to_date . ' 23:59:59']);

        // Filter by date range
        $campaign_activities->join('selp_campaign_activities', 'selp_campaign_activities.selp_activities_id', '=', 'selp_activities.id')
            ->whereIn('selp_campaign_activities.event_id', [2, 3, 4])
            ->selectRaw('SUM(participant_boys) AS total_participant_boys')
            ->selectRaw('SUM(participant_girls) AS total_participant_girls')
            ->selectRaw('SUM(participant_men) AS total_participant_men')
            ->selectRaw('SUM(participant_women) AS total_participant_women')
            ->selectRaw('SUM(participant_other_gender) AS total_participant_other_gender')
            ->selectRaw('SUM(participant_total) AS total_participant')
            ->selectRaw('SUM(participant_pwd_boys) AS total_participant_pwd_boys')
            ->selectRaw('SUM(participant_pwd_girls) AS total_participant_pwd_girls')
            ->selectRaw('SUM(participant_pwd_men) AS total_participant_pwd_men')
            ->selectRaw('SUM(participant_pwd_women) AS total_participant_pwd_women')
            ->selectRaw('SUM(participant_pwd_other_gender) AS total_participant_pwd_other_gender')
            ->selectRaw('SUM(participant_pwd_total) AS total_participant_pwd');

        $campaign_activities = $campaign_activities->first();
        return $campaign_activities;
    }

    // Indicator Output: 2.3.2.2.1
    public function getTotalSessionServiceByHO($from_date, $to_date, $report_type = null)
    {
        $service = HeadOfficeActivity::where('ho_event_id', 5)
            ->where(function ($query) use ($from_date, $to_date) {
                $query->where('starting_date', '>=', $from_date)
                    ->where('ending_date', '<=', $to_date);
            })
            ->selectRaw('SUM(no_of_event) AS total_no_of_event')
            ->first();
        return $service;
    }

    // Indicator Output: 2.4.2.1.1
    public function getMeetingActivitiesOutputInfo($request, $from_date, $to_date, $report_type = null)
    {
        /* 
        Event List
        1: Meeting with Upazila administration on Child marriage
        4: Meeting with district legal aid committee(DLAC)
        5: Meeting with Police station
        7: Meeting with Women Affairs
        9: Meeting with NGO
        10:Meeting with Others
        15:Advocacy meeting with Union Parishad
        */

        $meeting_activities = ActivityModel::query();
        $meeting_activities = searchCriteria($query = $meeting_activities, $data = ['region_id' => $request->region_id, 'division_id' => $request->division_id, 'district_id' => $request->district_id, 'upazila_id' => $request->upazila_id]);
        $meeting_activities->where('status', 2);

        // Filter by date range
        $meeting_activities->join('selp_meeting_activities', 'selp_meeting_activities.selp_activities_id', '=', 'selp_activities.id')
            // ->where(function ($query) use ($from_date, $to_date) {
            //     $query->where('starting_date', '<=', $to_date)
            //         ->where('ending_date', '>=', $from_date);
            // })
            ->whereBetween('selp_activities.reporting_date', [$from_date . ' 00:00:00', $to_date . ' 23:59:59'])
            ->whereIn('selp_meeting_activities.event_id', [1, 4, 5, 7, 9, 10, 15]);

        $meeting_activities = $meeting_activities->count();
        return $meeting_activities;
    }

    // Indicator Output: 2.4.2.1.2
    public function getTotalReferralServiceBySelp($request, $from_date, $to_date, $report_type = null)
    {

        $referral_service = $this->selpIncidentQuery($request)->where('selp_incident_informations.status', 2)
            ->leftjoin('incident_referrals', 'incident_referrals.selp_incident_id', '=', 'selp_incident_informations.id')
            ->select('selp_incident_informations.id', 'employee_zone_id', 'employee_division_id', 'employee_district_id', 'employee_upazila_id', 'status', 'referral', 'survivor_disability_status', 'survivor_age', 'survivor_gender_id', 'incident_referrals.referral_id')
            ->where(function ($q) {
                $q->orWhere(function ($q1) {
                    $q1->whereNotNull('selp_incident_informations.referral')->whereNotIn('selp_incident_informations.referral', [1]);
                })->orWhere(function ($q3) {
                    $q3->whereNotIn('incident_referrals.referral_id', [9]);
                });
            })
            // ->where(function ($query) use ($from_date, $to_date) {
            //     $query->where('incident_referrals.referral_date', '<=', $to_date)
            //         ->where('incident_referrals.referral_date', '>=', $from_date);
            // })
            ->whereBetween('posting_date', [$from_date . ' 00:00:00', $to_date . ' 23:59:59'])
            ->count();
        return $referral_service;
    }

    public function getTotalReferralServiceByHGSP($from_date, $to_date, $report_type = null)
    {
        $referral_service = HeadOfficeActivity::where('ho_event_id', 9)
            ->where(function ($query) use ($from_date, $to_date) {
                $query->where('starting_date', '>=', $from_date)
                    ->where('ending_date', '<=', $to_date);
            })->count();
        return $referral_service;
    }

    // Indicator Output: 2.4.4.1.1
    public function getComplainDocumentedAndReceivedInfo($request, $from_date, $to_date, $report_type = null)
    {
        $complain_documented_and_received_info = $this->selpIncidentQuery($request)
            ->whereNotNull('posting_date')
            ->whereBetween('posting_date', [$from_date . ' 00:00:00', $to_date . ' 23:59:59'])
            ->where('status', 2)
            ->whereNotNull('selp_initiative')
            // ->whereIn('selp_initiative', [2, 3])
            ->where('survivor_gender_id', 2)
            ->count();

        return $complain_documented_and_received_info;
    }
    // Indicator Outcome: 2.4.4.1
    public function getTotalServiceProvidedInfo($request, $from_date, $to_date, $report_type = null)
    {
        $complain_advice_and_referral_info = $this->selpIncidentQuery($request)
            ->select(
                'selp_incident_informations.id as id',
                'posting_date',
                'survivor_name',
                'survivor_gender_id',
                'selp_initiative'
            )
            ->whereNotNull('posting_date')
            ->whereBetween('posting_date', [$from_date . ' 00:00:00', $to_date . ' 23:59:59'])
            ->where('status', 2)
            ->whereIn('selp_initiative', [1, 4])
            ->where('survivor_gender_id', 2)
            ->get();

        $direct_service_info = $this->selpIncidentQuery($request)
            ->whereHas('direct_services')
            ->select(
                'selp_incident_informations.id as id',
                'posting_date',
                'survivor_name',
                'survivor_gender_id',
                'selp_initiative'
            )
            ->whereNotNull('posting_date')
            ->whereBetween('posting_date', [$from_date . ' 00:00:00', $to_date . ' 23:59:59'])
            ->where('status', 2)
            ->where('survivor_gender_id', 2)
            ->get();

        $combined_service = $complain_advice_and_referral_info->merge($direct_service_info)->unique('id')->values()->count();
        return $combined_service;
    }

    /**
     * Count unique SwapnoSarothi girls with skills based on the given criteria.
     * Indicator Outcome: 2.3.3.1.1 and 2.1.2.3.1
     * @param \Illuminate\Http\Request $request
     * @param string $from_date
     * @param string $to_date
     * @param string|null $report_type
     * @return int
     */
    public function countSwapnoSarothiGirlsWithSkills($request, $from_date, $to_date, $report_type = null, $session = null)
    {
        $bindings = [
            'from_date' => $from_date . ' 00:00:00',
            'to_date'   => $to_date . ' 23:59:59',
            'status'    => 2
        ];

        $sql = "
            SELECT COUNT(sp.id) as count
            FROM swapnosarothi_profile_skills AS sps
            JOIN swapnosarothi_profiles AS sp ON sp.id = sps.profile_table_id
            WHERE sps.skill_date BETWEEN :from_date AND :to_date
            AND sp.status = :status
            AND sps.deleted_at IS NULL
        ";

        $params = [];

        if ($session) {
            $sql .= " AND sps.skill_table_id = :skill_table_id";
            $params['skill_table_id'] = $session;
        }

        if ($request->region_id) {
            $sql .= " AND sp.employee_zone_id = :region_id";
            $params['region_id'] = $request->region_id;
        }

        if ($request->division_id) {
            $sql .= " AND sp.employee_division_id = :division_id";
            $params['division_id'] = $request->division_id;
        }

        if ($request->district_id) {
            $sql .= " AND sp.employee_district_id = :district_id";
            $params['district_id'] = $request->district_id;
        }

        if ($request->upazila_id) {
            $sql .= " AND sp.employee_upazila_id = :upazila_id";
            $params['upazila_id'] = $request->upazila_id;
        }

        $result = DB::select(DB::raw($sql), array_merge($bindings, $params));

        return $result[0]->count;
    }

    /**
     * Calculate the count of how many times each skill is provided in all distinct groups within the specified date range
     * Indicator Outcome: 2.3.3.1.1 and 2.1.2.3.1
     * @param \Illuminate\Http\Request $request
     * @param string $from_date
     * @param string $to_date
     * @param string|null $report_type
     * @return int
     */
    public function numberOfSkillSessionHeld($request, $from_date, $to_date)
    {
        $bindings = [
            'from_date' => $from_date . ' 00:00:00',
            'to_date'   => $to_date . ' 23:59:59',
            'status'    => 2
        ];

        $sql = "
            SELECT sps.skill_table_id, sps.group_table_id, COUNT(DISTINCT sps.skill_date) as session_count
            FROM swapnosarothi_profile_skills AS sps
            JOIN swapnosarothi_profiles AS sp ON sp.id = sps.profile_table_id
            WHERE sps.skill_date BETWEEN :from_date AND :to_date
            AND sp.status = :status
            AND sps.deleted_at IS NULL
        ";

        $params = [];

        if ($request->region_id) {
            $sql .= " AND sp.employee_zone_id = :region_id";
            $params['region_id'] = $request->region_id;
        }

        if ($request->division_id) {
            $sql .= " AND sp.employee_division_id = :division_id";
            $params['division_id'] = $request->division_id;
        }

        if ($request->district_id) {
            $sql .= " AND sp.employee_district_id = :district_id";
            $params['district_id'] = $request->district_id;
        }

        if ($request->upazila_id) {
            $sql .= " AND sp.employee_upazila_id = :upazila_id";
            $params['upazila_id'] = $request->upazila_id;
        }

        $sql .= " GROUP BY sps.skill_table_id, sps.group_table_id";

        // Fetch the session counts using raw SQL
        $session_counts = DB::select(DB::raw($sql), array_merge($bindings, $params));

        $total_session = array_sum(array_column($session_counts, 'session_count'));
        return $total_session;
    }

    /**
     * Calculate the count of unique group_id values within the specified date range
     * @param \Illuminate\Http\Request $request
     * @param string $from_date
     * @param string $to_date
     * @param string|null $report_type
     * @return int
     */
    public function numberOfSwapnosarothiGroup($request, $from_date, $to_date, $report_type = null)
    {

        $bindings = [
            'from_date' => $from_date . ' 00:00:00',
            'to_date'   => $to_date . ' 23:59:59',
            'status'    => 2
        ];

        $sql = "
            SELECT COUNT(DISTINCT sp.group_id) as group_count
            FROM swapnosarothi_profiles AS sp
            JOIN swapnosarothi_profile_skills AS sps ON sp.id = sps.profile_table_id
            WHERE sp.status = :status
            AND sp.group_id IS NOT NULL
            AND sps.created_at BETWEEN :from_date AND :to_date
        ";

        $params = [];

        if ($request->region_id) {
            $sql .= " AND sp.employee_zone_id = :region_id";
            $params['region_id'] = $request->region_id;
        }

        if ($request->division_id) {
            $sql .= " AND sp.employee_division_id = :division_id";
            $params['division_id'] = $request->division_id;
        }

        if ($request->district_id) {
            $sql .= " AND sp.employee_district_id = :district_id";
            $params['district_id'] = $request->district_id;
        }

        if ($request->upazila_id) {
            $sql .= " AND sp.employee_upazila_id = :upazila_id";
            $params['upazila_id'] = $request->upazila_id;
        }

        // Fetch the group count using raw SQL
        $result = DB::select(DB::raw($sql), array_merge($bindings, $params));

        // Extract the group count from the result
        $swapnosarothi_groups = $result[0]->group_count ?? 0;

        return $swapnosarothi_groups;
    }

    public function swapnosarothiMarriedInfo($request, $from_date, $to_date, $report_type = null)
    {
        $bindings = [
            'from_date' => $from_date . ' 00:00:00',
            'to_date'   => $to_date . ' 23:59:59',
            'status'    => 2
        ];

        $sql = "
            SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN sp.group_status = 'ongoing' THEN 1 ELSE 0 END) as not_married_after_18 
            FROM swapnosarothi_profiles AS sp
            WHERE sp.status = :status
            AND sp.created_at BETWEEN :from_date AND :to_date
            AND TIMESTAMPDIFF(YEAR, sp.date_of_birth, CURDATE()) >= 18
        ";

        $params = [];

        if ($request->region_id) {
            $sql .= " AND sp.employee_zone_id = :region_id";
            $params['region_id'] = $request->region_id;
        }

        if ($request->division_id) {
            $sql .= " AND sp.employee_division_id = :division_id";
            $params['division_id'] = $request->division_id;
        }

        if ($request->district_id) {
            $sql .= " AND sp.employee_district_id = :district_id";
            $params['district_id'] = $request->district_id;
        }

        if ($request->upazila_id) {
            $sql .= " AND sp.employee_upazila_id = :upazila_id";
            $params['upazila_id'] = $request->upazila_id;
        }

        // Fetch the married info counts using raw SQL
        $result = DB::select(DB::raw($sql), array_merge($bindings, $params));

        // Extract the counts from the result
        $array_data = [
            'total'                 => $result[0]->total ?? 0,
            'not_married_after_18'  => $result[0]->not_married_after_18 ?? 0,
        ];

        return $array_data;
    }

    // Indicator Output: 2.3.3.1.2
    public function numberOfParentsAttendMeeting($request, $from_date, $to_date, $report_type = null)
    {
        $parent_meeting_activities = ActivityModel::query();
        $parent_meeting_activities = searchCriteria($query = $parent_meeting_activities, $data = ['region_id' => $request->region_id, 'division_id' => $request->division_id, 'district_id' => $request->district_id, 'upazila_id' => $request->upazila_id]);
        $parent_meeting_activities->where('status', 2)->whereBetween('reporting_date', [$from_date . ' 00:00:00', $to_date . ' 23:59:59']);

        // Filter by date range
        $parent_meeting_activities->join('selp_meeting_activities', 'selp_meeting_activities.selp_activities_id', '=', 'selp_activities.id')
            ->where('selp_meeting_activities.event_id', 13)
            ->selectRaw('SUM(no_of_event) AS total_no_of_event')
            ->selectRaw('SUM(participant_total) AS total_participant')
            ->selectRaw('SUM(participant_pwd_total) AS total_participant_pwd');

        $parent_meeting_activities = $parent_meeting_activities->first();

        return $parent_meeting_activities;
    }

    public function getSwapnosarothiGroup($request)
    {
        $swapnosarothi_groups = SwapnosarothiSetupGroup::query();
        $swapnosarothi_groups = searchCriteriaSwapnosarothi($query = $swapnosarothi_groups, $data = ['region_id' => $request->region_id, 'division_id' => $request->division_id, 'district_id' => $request->district_id, 'upazila_id' => $request->upazila_id]);
        $swapnosarothi_groups = $swapnosarothi_groups->count();
        return $swapnosarothi_groups;
    }

    // Indicator Output: 2.3.3.1.3
    public function swapnosarothiCashSupportInfo($request, $from_date, $to_date, $report_type = null)
    {

        $swapnosarothi_infos = $this->swapnoSarothiProfileQuery($request)
            ->whereBetween('created_at', [$from_date . ' 00:00:00', $to_date . ' 23:59:59'])
            ->approved()
            ->withCashSupport()
            ->count();

        return $swapnosarothi_infos;
    }

    // Indicator Output: 2.3.4.1.1
    public function getCMIncidentInfos($request, $from_date, $to_date, $report_type = null)
    {
        $cm_incident_info = $this->selpIncidentQuery($request)
            ->whereNotNull('posting_date')
            ->whereBetween('posting_date', [$from_date . ' 00:00:00', $to_date . ' 23:59:59'])
            ->where('status', 2)
            ->where('violence_reason_id', 37)
            ->count();

        $bindings = [
            'from_date' => $from_date . ' 00:00:00',
            'to_date'   => $to_date . ' 23:59:59',
            'status'    => 2
        ];

        $sql = "
                SELECT 
                    COUNT(*) as married_before_18
                FROM swapnosarothi_profiles AS sp
                WHERE sp.status = :status
                AND sp.group_status = 'married'
                AND sp.created_at BETWEEN :from_date AND :to_date
                AND TIMESTAMPDIFF(YEAR, sp.date_of_birth, CURDATE()) <= 18
            ";

        $params = [];

        if ($request->region_id) {
            $sql .= " AND sp.employee_zone_id = :region_id";
            $params['region_id'] = $request->region_id;
        }

        if ($request->division_id) {
            $sql .= " AND sp.employee_division_id = :division_id";
            $params['division_id'] = $request->division_id;
        }

        if ($request->district_id) {
            $sql .= " AND sp.employee_district_id = :district_id";
            $params['district_id'] = $request->district_id;
        }

        if ($request->upazila_id) {
            $sql .= " AND sp.employee_upazila_id = :upazila_id";
            $params['upazila_id'] = $request->upazila_id;
        }

        // Fetch the married info counts using raw SQL
        $sw_married_result = DB::select(DB::raw($sql), array_merge($bindings, $params));

        return $cm_incident_info + $sw_married_result[0]->married_before_18 ?? 0;
    }

    public function getCMPreventedInfos($request, $from_date, $to_date, $report_type = null)
    {
        $cm_prevention_info = ChildMarriageInformation::select('id', 'reporting_date', 'child_name', 'child_age', 'child_gender_id', 'created_at')->where('status', 2);

        $cm_prevention_info = searchCriteria($query = $cm_prevention_info, $data = ['region_id' => $request->region_id, 'division_id' => $request->division_id, 'district_id' => $request->district_id, 'upazila_id' => $request->upazila_id, 'from_reporting_date' => $request->from_date, 'to_reporting_date' => $request->to_date]);
        $cm_prevention_info = $cm_prevention_info->count();
        return $cm_prevention_info;
    }

    public function indicatorReportExcel(Request $request)
    {

        $data['processed_data'] = $request->input('processedData');

        $decodedFormData    = [];
        parse_str($request->input('formData'), $decodedFormData);

        $data['date_from']     = $decodedFormData['from_date'];
        $data['date_to']       = $decodedFormData['to_date'];
        $data['region']        = Region::where('id', $decodedFormData['region_id'])->first()->region_name ?? 'All';
        $data['division']      = Division::where('id', $decodedFormData['division_id'])->first();
        $data['district']      = District::where('id', $decodedFormData['district_id'])->first();
        $data['upazila']       = Upazila::where('id', $decodedFormData['upazila_id'])->first();

        // Define the view and file name
        $view       = 'backend.report.indicator_reports.excel.view';
        $file_name  = 'indicator_reports.xlsx';

        // Generate and download the Excel file
        return Excel::download(new MisReportExport($data, $view), $file_name);
    }
}
