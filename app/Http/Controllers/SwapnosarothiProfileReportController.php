<?php

namespace App\Http\Controllers;

use App\ChildMarriageInformation;
use App\Exports\MisReportExport;
use App\Http\Controllers\Controller;
use App\Model\Admin\Setup\CEP_Region\Region;
use App\Model\Admin\Setup\District;
use App\Model\Admin\Setup\Division;
use App\Model\Admin\Setup\Upazila;
use App\SwapnosarothiProfile;
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

class SwapnosarothiProfileReportController extends Controller
{

    // Swapnosarothi Group Wise SELP Report

    public function swapnoSarothiProfileQuery($request)
    {
        $s_divisions    = session()->get('userareaaccess.sdivisions');
        $s_districts    = session()->get('userareaaccess.sdistricts');
        $s_upazilas     = session()->get('userareaaccess.supazilas');
        $s_unions       = session()->get('userareaaccess.sunions');

        $query  = SwapnosarothiProfile::query();

        if ($request->region_id) {
            // if ($request->division_id) {
            //     $previousZoneInfo = getPreviousZoneIdsFromDivision($request->division_id);
            //     if (!empty($previousZoneInfo)) {
            //         $regionIds      = array_keys($previousZoneInfo);
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

        if ($request->group_id) {
            $query->where('group_id', $request->group_id);
        }

        return $query;
    }

    public function childmarriagequery($request)
    {
        $query = ChildMarriageInformation::query();

        if ($request->region_id) {
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

    public function swapnosarothiReportGenerate(Request $request)
    {
        Session::put('title', 'Swapnosarothi Reports');

        $data['regions']    = getRegionByUserType();
        $data['auth_user']  = User::with(['setup_user_area'])->where('id', Auth::id())->first();

        if ($request->isMethod('post')) {

            ini_set('memory_limit', -1);
            $from_date = date('Y-m-d', strtotime($request->from_date)) . ' 00:00:00';
            $to_date   = date('Y-m-d', strtotime($request->to_date)) . ' 23:59:59';

            $data['date_from']     = $request->from_date;
            $data['date_to']       = $request->to_date;
            $data['report_type']   = $request->report_type;
            $upazila_id            = $request->upazila_id;

            $data['region']        = Region::where('id', $request->region_id)->first()->region_name ?? 'All';

            $data['division']      = Division::where('id', $request->division_id)->first();
            $data['district']      = District::where('id', $request->district_id)->first();
            $data['upazila']       = Upazila::where('id', $upazila_id)->first();

            $data['groups']        = SwapnosarothiSetupGroup::when($upazila_id, function ($query) use ($upazila_id) {
                $query->where('upazila_id', $upazila_id);
            })->where('status', 1)->get();

            if ($request->report_type == 1) {
                $data['title'] = "Number of Girls";

                if ($request->data_source == 'current_zone') {
                    $swapnosarothi_infos = $this->swapnoSarothiProfileQuery($request)
                        ->whereBetween('created_at', [$from_date, $to_date])
                        ->approved()
                        ->whereNotNull('group_id')
                        ->get();
                } else {
                    $previousZoneInfo = getPreviousZoneIdsFromDivision($request->division_id, $request->region_id);

                    if (!empty($previousZoneInfo)) {
                        $swapnosarothi_infos = SwapnosarothiProfile::query();
                        $swapnosarothi_infos = searchCriteriaPreviousSwapnosarothiProfile($query = $swapnosarothi_infos, $sw_data = ['previous_zone_info' => $previousZoneInfo, 'division_id' => $request->division_id, 'district_id' => $request->district_id, 'upazila_id' => $request->upazila_id,  'group_id' => $request->group_id, 'group_status' => $request->group_status, 'profile_union' => $request->union, 'profile_village' => $request->village, 'status' => 2]);
                        $swapnosarothi_infos = $swapnosarothi_infos->whereNotNull('group_id')->get();
                    } else {
                        $swapnosarothi_infos = collect();
                    }
                }
                $data['array_data'] = $this->groupWiseSwapnosarothiStatisticsReport($swapnosarothi_infos);
            } elseif ($request->report_type == 2) {
                $data['title'] = "Number of PWD Girls";

                if ($request->data_source == 'current_zone') {
                    $swapnosarothi_infos = $this->swapnoSarothiProfileQuery($request)
                        ->whereBetween('created_at', [$from_date, $to_date])
                        ->approved()
                        ->whereNotNull('group_id')
                        ->withDisability()
                        ->get();
                } else {
                    $previousZoneInfo = getPreviousZoneIdsFromDivision($request->division_id, $request->region_id);

                    if (!empty($previousZoneInfo)) {
                        $swapnosarothi_infos = SwapnosarothiProfile::query();
                        $swapnosarothi_infos = searchCriteriaPreviousSwapnosarothiProfile($query = $swapnosarothi_infos, $sw_data = ['previous_zone_info' => $previousZoneInfo, 'division_id' => $request->division_id, 'district_id' => $request->district_id, 'upazila_id' => $request->upazila_id,  'group_id' => $request->group_id, 'group_status' => $request->group_status, 'profile_union' => $request->union, 'profile_village' => $request->village, 'status' => 2]);
                        $swapnosarothi_infos = $swapnosarothi_infos->whereNotNull('group_id')->withDisability()->get();
                    } else {
                        $swapnosarothi_infos = collect();
                    }
                }

                $data['array_data'] = $this->groupWiseSwapnosarothiStatisticsReport($swapnosarothi_infos);
            } elseif ($request->report_type == 3) {
                $data['title'] = "Number of Girls Under Cash Support";

                if ($request->data_source == 'current_zone') {
                    $swapnosarothi_infos = $this->swapnoSarothiProfileQuery($request)
                        ->whereBetween('created_at', [$from_date, $to_date])
                        ->approved()
                        ->whereNotNull('group_id')
                        ->get();
                } else {
                    $previousZoneInfo = getPreviousZoneIdsFromDivision($request->division_id, $request->region_id);
                    if (!empty($previousZoneInfo)) {
                        $swapnosarothi_infos = SwapnosarothiProfile::query();
                        $swapnosarothi_infos = searchCriteriaPreviousSwapnosarothiProfile($query = $swapnosarothi_infos, $sw_data = ['previous_zone_info' => $previousZoneInfo, 'division_id' => $request->division_id, 'district_id' => $request->district_id, 'upazila_id' => $request->upazila_id,  'group_id' => $request->group_id, 'group_status' => $request->group_status, 'profile_union' => $request->union, 'profile_village' => $request->village, 'status' => 2]);
                        $swapnosarothi_infos = $swapnosarothi_infos->whereNotNull('group_id')->get();
                    } else {
                        $swapnosarothi_infos = collect();
                    }
                }

                $data['array_data'] = $this->groupWiseSwapnosarothiCashSupportReport($swapnosarothi_infos);
            } elseif ($request->report_type == 4) {
                $data['title'] = "Number of PWD Girls Under Cash Support";

                if ($request->data_source == 'current_zone') {
                    $swapnosarothi_infos = $this->swapnoSarothiProfileQuery($request)
                        ->whereBetween('created_at', [$from_date, $to_date])
                        ->approved()
                        ->whereNotNull('group_id')
                        ->withDisability()
                        ->get();
                } else {
                    $previousZoneInfo = getPreviousZoneIdsFromDivision($request->division_id, $request->region_id);

                    if (!empty($previousZoneInfo)) {
                        $swapnosarothi_infos = SwapnosarothiProfile::query();
                        $swapnosarothi_infos = searchCriteriaPreviousSwapnosarothiProfile($query = $swapnosarothi_infos, $sw_data = ['previous_zone_info' => $previousZoneInfo, 'division_id' => $request->division_id, 'district_id' => $request->district_id, 'upazila_id' => $request->upazila_id,  'group_id' => $request->group_id, 'group_status' => $request->group_status, 'profile_union' => $request->union, 'profile_village' => $request->village, 'status' => 2]);
                        $swapnosarothi_infos = $swapnosarothi_infos->whereNotNull('group_id')->withDisability()->get();
                    } else {
                        $swapnosarothi_infos = collect();
                    }
                }

                $data['array_data'] = $this->groupWiseSwapnosarothiCashSupportReport($swapnosarothi_infos);
            } elseif ($request->report_type == 5) {
                $data['title'] = "Number of First Time Initiative of Child Marriage Prevention";

                if ($request->data_source == 'current_zone') {

                    $swapnosarothi_infos = $this->swapnoSarothiProfileQuery($request)
                        ->approved()
                        ->whereNotNull('group_id')
                        // ->whereHas('cmInitiatives')
                        ->whereHas('cmInitiatives', function ($query) use ($from_date, $to_date) {
                            $query->whereBetween('date', [$from_date, $to_date]);
                        })
                        ->get();
                } else {
                    $previousZoneInfo = getPreviousZoneIdsFromDivision($request->division_id, $request->region_id);

                    if (!empty($previousZoneInfo)) {
                        $swapnosarothi_infos = SwapnosarothiProfile::query();
                        $swapnosarothi_infos = searchCriteriaPreviousSwapnosarothiProfile($query = $swapnosarothi_infos, $sw_data = ['previous_zone_info' => $previousZoneInfo, 'division_id' => $request->division_id, 'district_id' => $request->district_id, 'upazila_id' => $request->upazila_id,  'group_id' => $request->group_id, 'group_status' => $request->group_status, 'profile_union' => $request->union, 'profile_village' => $request->village, 'status' => 2]);
                        $swapnosarothi_infos = $swapnosarothi_infos->whereNotNull('group_id')
                            // ->whereHas('cmInitiatives')
                            ->whereHas('cmInitiatives', function ($query) use ($from_date, $to_date) {
                                $query->whereBetween('date', [$from_date, $to_date]);
                            })
                            ->get();
                    } else {
                        $swapnosarothi_infos = collect();
                    }
                }

                $data['array_data'] = $this->groupWiseSwapnosarothiInitiativeReport($swapnosarothi_infos, 5, '1st');
            } elseif ($request->report_type == 6) {
                $data['title'] = "Number of Second Time Initiative of Child Marriage Prevention";

                if ($request->data_source == 'current_zone') {
                    $swapnosarothi_infos = $this->swapnoSarothiProfileQuery($request)
                        ->approved()
                        ->whereNotNull('group_id')
                        ->whereHas('cmInitiatives', function ($query) use ($from_date, $to_date) {
                            $query->whereBetween('date', [$from_date, $to_date]);
                        })
                        ->with('cmInitiatives')
                        ->get();
                } else {
                    $previousZoneInfo = getPreviousZoneIdsFromDivision($request->division_id, $request->region_id);

                    if (!empty($previousZoneInfo)) {
                        $swapnosarothi_infos = SwapnosarothiProfile::query();
                        $swapnosarothi_infos = searchCriteriaPreviousSwapnosarothiProfile($query = $swapnosarothi_infos, $sw_data = ['previous_zone_info' => $previousZoneInfo, 'division_id' => $request->division_id, 'district_id' => $request->district_id, 'upazila_id' => $request->upazila_id,  'group_id' => $request->group_id, 'group_status' => $request->group_status, 'profile_union' => $request->union, 'profile_village' => $request->village, 'status' => 2]);
                        $swapnosarothi_infos = $swapnosarothi_infos->whereNotNull('group_id')
                            ->whereHas('cmInitiatives', function ($query) use ($from_date, $to_date) {
                                $query->whereBetween('date', [$from_date, $to_date]);
                            })
                            ->with('cmInitiatives')
                            ->get();
                    } else {
                        $swapnosarothi_infos = collect();
                    }
                }

                $data['array_data'] = $this->groupWiseSwapnosarothiInitiativeReport($swapnosarothi_infos, 6, '2nd');
            } elseif ($request->report_type == 7) {
                $data['title'] = "Number of Third Time Initiative of Child Marriage Prevention";

                $swapnosarothi_infos = $this->swapnoSarothiProfileQuery($request)
                    ->approved()
                    ->whereNotNull('group_id')
                    ->whereHas('cmInitiatives', function ($query) use ($from_date, $to_date) {
                        $query->whereBetween('date', [$from_date, $to_date]);
                    })
                    ->get();

                $data['array_data'] = $this->groupWiseSwapnosarothiInitiativeReport($swapnosarothi_infos, 7, '3rd');
            } elseif ($request->report_type == 8) {
                $data['title'] = "No.of Married Girl";

                if ($request->data_source == 'current_zone') {
                    $data['array_data'] = $this->groupWiseSwapnosarothiMarriedReport($request, $from_date, $to_date, 8);
                } else {
                    $previousZoneInfo = getPreviousZoneIdsFromDivision($request->division_id, $request->region_id);

                    if (!empty($previousZoneInfo)) {
                        $data['array_data'] = $this->previousSwapnosarothiMarriedReport($request, $previousZoneInfo, $from_date, $to_date, 8);
                    } else {
                        $data['array_data'] = collect();
                    }
                }
            } elseif ($request->report_type == 9) {
                $data['title'] = "No.of Married Girl under studenship";

                $data['array_data'] = $this->groupWiseSwapnosarothiMarriedReport($request, $from_date, $to_date, 8);
            } elseif ($request->report_type == 10) {
                $data['title'] = "No.of Girls Attended in Life Skill Session";

                if ($request->data_source == 'current_zone') {

                    $swapnosarothi_infos = $this->swapnoSarothiProfileQuery($request)
                        ->join('swapnosarothi_profile_skills', 'swapnosarothi_profile_skills.profile_table_id', '=', 'swapnosarothi_profiles.id')
                        ->where('swapnosarothi_profiles.status', 2)
                        ->whereNotNull('swapnosarothi_profiles.group_id')
                        ->whereNull('swapnosarothi_profile_skills.deleted_at')
                        ->whereBetween('swapnosarothi_profile_skills.skill_date', [$from_date, $to_date])
                        ->select(
                            DB::raw('COUNT(swapnosarothi_profiles.id) as total_girls'),
                            // 'swapnosarothi_profiles.id',
                            'swapnosarothi_profiles.group_id',
                            'swapnosarothi_profile_skills.skill_table_id',
                            // 'swapnosarothi_profile_skills.skill_date',
                            'swapnosarothi_profiles.employee_zone_id',
                            'swapnosarothi_profiles.employee_division_id',
                            'swapnosarothi_profiles.employee_district_id',
                            'swapnosarothi_profiles.employee_upazila_id'
                        )
                        ->groupBy('swapnosarothi_profiles.group_id', 'swapnosarothi_profile_skills.skill_table_id', 'swapnosarothi_profiles.employee_zone_id', 'swapnosarothi_profiles.employee_division_id', 'swapnosarothi_profiles.employee_district_id', 'swapnosarothi_profiles.employee_upazila_id')
                        ->get();

                } else {
                    $previousZoneInfo = getPreviousZoneIdsFromDivision($request->division_id, $request->region_id);

                    if (!empty($previousZoneInfo)) {
                        // $swapnosarothi_infos = SwapnosarothiProfile::query();
                        // $swapnosarothi_infos = searchCriteriaPreviousSwapnosarothiProfile($query = $swapnosarothi_infos, $sw_data = ['previous_zone_info' => $previousZoneInfo, 'division_id' => $request->division_id, 'district_id' => $request->district_id, 'upazila_id' => $request->upazila_id,  'group_id' => $request->group_id, 'group_status' => $request->group_status, 'profile_union' => $request->union, 'profile_village' => $request->village, 'status' => 2]);
                        // $swapnosarothi_infos = $swapnosarothi_infos->whereNotNull('group_id')->whereHas('profile_skills')->get();
                        $swapnosarothi_infos = collect();
                    } else {
                        $swapnosarothi_infos = collect();
                    }
                }

                $data['swapnosarothi_skills']   = SwapnosarothiSkill::where('status', 1)->get();
                $data['array_data']             = $swapnosarothi_infos;
                // $data['array_data']             = $this->groupWiseSwapnosarothiSkillSessionReport($swapnosarothi_infos, $data['swapnosarothi_skills'], 10);
            }

            if ($request->type == 'pdf') {
                return $this->swapnoSarothiReportPdf($data);
            } elseif ($request->type == 'xls') {
                return $this->swapnoSarothiReportExcel($data);
            }
        }

        return view('backend.report.swapnosarothi.group_wise_report_view', $data);
    }

    public function groupWiseSwapnosarothiStatisticsReport($swapnosarothi_infos, $report_type = null)
    {

        $array_data     = [];
        $count          = count($swapnosarothi_infos);

        for ($i = 0; $i < $count; $i++) {
            $swapnosarothi_info = $swapnosarothi_infos[$i];
            $divisionId         = $swapnosarothi_info->employee_division_id;
            $districtId         = $swapnosarothi_info->employee_district_id;
            $upazilaId          = $swapnosarothi_info->employee_upazila_id;
            $groupId            = $swapnosarothi_info->group_id;

            @$array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['ongoing']     += 0;
            @$array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['married']     += 0;
            @$array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['migrated']    += 0;
            @$array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['droupout']    += 0;
            @$array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['graduated']   += 0;
            @$array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['total']       += 0;

            // Initialize the division data if not already set
            $array_data['division'][$divisionId]['name'] = @$swapnosarothi_info->employee_division->name;
            $array_data['division'][$divisionId]['id']   = @$swapnosarothi_info->employee_division->id;

            // Initialize the district data if not already set
            $array_data['division'][$divisionId]['district'][$districtId]['name'] = @$swapnosarothi_info->employee_district->name;
            $array_data['division'][$divisionId]['district'][$districtId]['id']   = @$swapnosarothi_info->employee_district->id;

            // Initialize the upazila data if not already set
            $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['name'] = @$swapnosarothi_info->employee_upazila->name;
            $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['id']   = @$swapnosarothi_info->employee_upazila->id;

            // Initialize the group data if not already set
            $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['name']     = @$swapnosarothi_info->groupName->group_name;
            $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['id']       = @$swapnosarothi_info->groupName->id;
            $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['zone']     = @$swapnosarothi_info->employee_zone->region_name;

            if (@$swapnosarothi_info->group_status == 'ongoing') {
                @$array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['ongoing'] += 1;
            } elseif (@$swapnosarothi_info->group_status == 'married') {
                @$array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['married'] += 1;
            } elseif (@$swapnosarothi_info->group_status == 'migrated') {
                @$array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['migrated'] += 1;
            } elseif (@$swapnosarothi_info->group_status == 'droupout') {
                @$array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['droupout'] += 1;
            } elseif (@$swapnosarothi_info->group_status == 'graduated') {
                @$array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['graduated'] += 1;
            }

            @$array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['total'] += 1;
        }

        return $array_data;
    }

    public function groupWiseSwapnosarothiCashSupportReport($swapnosarothi_infos, $report_type = null)
    {
        $array_data     = [];
        $count          = count($swapnosarothi_infos);

        for ($i = 0; $i < $count; $i++) {
            $swapnosarothi_info = $swapnosarothi_infos[$i];
            $divisionId         = $swapnosarothi_info->employee_division_id;
            $districtId         = $swapnosarothi_info->employee_district_id;
            $upazilaId          = $swapnosarothi_info->employee_upazila_id;
            $groupId            = $swapnosarothi_info->group_id;

            @$array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['low'] += 0;
            @$array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['medium'] += 0;
            @$array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['none'] += 0;
            @$array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['total'] += 0;

            $array_data['division'][$divisionId]['name'] = @$swapnosarothi_info->employee_division->name;
            $array_data['division'][$divisionId]['id']   = @$swapnosarothi_info->employee_division->id;

            $array_data['division'][$divisionId]['district'][$districtId]['name'] = @$swapnosarothi_info->employee_district->name;
            $array_data['division'][$divisionId]['district'][$districtId]['id']   = @$swapnosarothi_info->employee_district->id;

            $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['name'] = @$swapnosarothi_info->employee_upazila->name;
            $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['id']   = @$swapnosarothi_info->employee_upazila->id;

            $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['name']     = @$swapnosarothi_info->groupName->group_name;
            $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['id']       = @$swapnosarothi_info->groupName->id;
            $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['zone']     = @$swapnosarothi_info->employee_zone->region_name;


            if (@$swapnosarothi_info->amount_money != null) {
                if (@$swapnosarothi_info->cash_support_type == 1) {
                    @$array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['low'] += 1;
                } elseif (@$swapnosarothi_info->cash_support_type == 2) {
                    @$array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['medium'] += 1;
                } else {
                    @$array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['none'] += 1;
                }
            } else {
                @$array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['none'] += 1;
            }

            @$array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['total'] += 1;
        }

        return $array_data;
    }

    public function groupWiseSwapnosarothiInitiativeReport($swapnosarothi_infos, $report_type = null, $initiate_type = null)
    {
        $array_data     = [];
        $count          = count($swapnosarothi_infos);

        for ($i = 0; $i < $count; $i++) {
            $swapnosarothi_info = $swapnosarothi_infos[$i];
            $divisionId         = $swapnosarothi_info->employee_division_id;
            $districtId         = $swapnosarothi_info->employee_district_id;
            $upazilaId          = $swapnosarothi_info->employee_upazila_id;
            $groupId            = $swapnosarothi_info->group_id;

            if (!$swapnosarothi_info->cmInitiatives->isEmpty()) {

                $initiative = $swapnosarothi_info->cmInitiatives->where('initiative', $initiate_type)->first();

                if ($initiative) {
                    @$array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['prevented'] += 0;
                    @$array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['failed'] += 0;
                    @$array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['not_prevented'] += 0;

                    @$array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['total'] += 0;

                    $array_data['division'][$divisionId]['name'] = @$swapnosarothi_info->employee_division->name;
                    $array_data['division'][$divisionId]['id']   = @$swapnosarothi_info->employee_division->id;

                    $array_data['division'][$divisionId]['district'][$districtId]['name'] = @$swapnosarothi_info->employee_district->name;
                    $array_data['division'][$divisionId]['district'][$districtId]['id']   = @$swapnosarothi_info->employee_district->id;

                    $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['name'] = @$swapnosarothi_info->employee_upazila->name;
                    $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['id']   = @$swapnosarothi_info->employee_upazila->id;

                    $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['name']     = @$swapnosarothi_info->groupName->group_name;
                    $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['id']       = @$swapnosarothi_info->groupName->id;
                    $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['zone']     = @$swapnosarothi_info->employee_zone->region_name;

                    if ($initiative->prevention_type == 1) {
                        $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['prevented'] += 1;
                    } elseif ($initiative->prevention_type == 2) {
                        $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['failed'] += 1;
                    } elseif ($initiative->prevention_type == 3) {
                        $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['not_prevented'] += 1;
                    }
                    $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['total'] += 1;
                }
            }
        }

        return $array_data;
    }

    public function groupWiseSwapnosarothiMarriedReport($request, $from_date, $to_date, $report_type = null)
    {

        $bindings = [
            'from_date' => $from_date,
            'to_date'   => $to_date,
            'status'    => 2
        ];

        $sql = "
            SELECT 
                sp.employee_division_id as division_id,
                sp.employee_district_id as district_id,
                sp.employee_upazila_id as upazila_id,
                sp.group_id as group_id,
                sp.date_of_birth,
                sp.age_completion_date,
                r.region_name,
                dv.name as division,
                dr.name as district,
                u.name as upazila,
                g.group_name as group_name,
                smi.marriage_date
            FROM swapnosarothi_profiles AS sp
            JOIN swapnosarothi_marriage_infos AS smi ON sp.id = smi.swapnosarothi_profile_id AND smi.deleted_at IS NULL
            LEFT JOIN regions AS r ON sp.employee_zone_id = r.id
            LEFT JOIN divisions AS dv ON sp.employee_division_id = dv.id
            LEFT JOIN districts AS dr ON sp.employee_district_id = dr.id
            LEFT JOIN upazilas AS u ON sp.employee_upazila_id = u.id
            LEFT JOIN swapnosarothi_setup_groups AS g ON sp.group_id = g.id
            WHERE sp.status = :status
            AND sp.group_status = 'married'
            AND sp.created_at BETWEEN :from_date AND :to_date
            AND sp.deleted_at IS NULL
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

        if ($request->group_id) {
            $sql .= " AND sp.group_id = :group_id";
            $params['group_id'] = $request->group_id;
        }

        // Fetch the marriage info using raw SQL
        $result = DB::select(DB::raw($sql), array_merge($bindings, $params));


        $array_data     = [];
        $currentDate    = Carbon::now();
        foreach ($result as $row) {
            $divisionId = $row->division_id;
            $districtId = $row->district_id;
            $upazilaId  = $row->upazila_id;
            $groupId    = $row->group_id;
            $regionName = $row->region_name;

            $dateOfBirth    = Carbon::parse($row->date_of_birth);
            $marriageDate   = Carbon::parse($row->marriage_date);
            $ageAtMarriage  = $dateOfBirth->diffInYears($marriageDate);


            if (!isset($array_data['division'][$divisionId])) {
                $array_data['division'][$divisionId]['name']    = $row->division;
                $array_data['division'][$divisionId]['id']      = $divisionId;
            }

            if (!isset($array_data['division'][$divisionId]['district'][$districtId])) {
                $array_data['division'][$divisionId]['district'][$districtId]['name']   = $row->district;
                $array_data['division'][$divisionId]['district'][$districtId]['id']     = $districtId;
            }

            if (!isset($array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId])) {
                $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['name']    = $row->upazila;
                $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['id']      = $upazilaId;
            }

            if (!isset($array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId])) {
                $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['name']     = $row->group_name;
                $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['id']       = $groupId;
                $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['zone']     = $regionName;
                $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['below_18'] = 0;
                $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['after_18'] = 0;
                $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['total']    = 0;
            }

            // Check if the girl is 18 or older
            if ($ageAtMarriage < 18) {
                $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['below_18']++;
            } else {
                $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['after_18']++;
            }

            $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['total']++;
        }

        return $array_data;
    }

    public function previousSwapnosarothiMarriedReport($request, $previous_zone_info, $from_date, $to_date, $report_type = null)
    {
        $bindings = [
            'status' => 2
        ];

        $sql = "
            SELECT 
                sp.employee_division_id as division_id,
                sp.employee_district_id as district_id,
                sp.employee_upazila_id as upazila_id,
                sp.group_id as group_id,
                sp.date_of_birth,
                sp.age_completion_date,
                r.region_name,
                dv.name as division,
                dr.name as district,
                u.name as upazila,
                g.group_name as group_name,
                smi.marriage_date
            FROM swapnosarothi_profiles AS sp
            JOIN swapnosarothi_marriage_infos AS smi ON sp.id = smi.swapnosarothi_profile_id AND smi.deleted_at IS NULL
            LEFT JOIN regions AS r ON sp.employee_zone_id = r.id
            LEFT JOIN divisions AS dv ON sp.employee_division_id = dv.id
            LEFT JOIN districts AS dr ON sp.employee_district_id = dr.id
            LEFT JOIN upazilas AS u ON sp.employee_upazila_id = u.id
            LEFT JOIN swapnosarothi_setup_groups AS g ON sp.group_id = g.id
            WHERE sp.status = :status
            AND sp.group_status = 'married'
            AND sp.deleted_at IS NULL
        ";

        // Add conditions for previous_zone_info
        if (!empty($previous_zone_info)) {
            $zoneConditions = [];
            foreach ($previous_zone_info as $regionId => $dateTo) {
                $zoneConditions[] = "(sp.employee_zone_id = :regionId_$regionId AND sp.created_at <= :dateTo_$regionId)";
                $bindings["regionId_$regionId"] = $regionId;
                $bindings["dateTo_$regionId"] = $dateTo;
            }
            $sql .= " AND (" . implode(' OR ', $zoneConditions) . ")";
        }

        // Dynamic Filters
        $params = [];

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

        if ($request->group_id) {
            $sql .= " AND sp.group_id = :group_id";
            $params['group_id'] = $request->group_id;
        }

        if ($request->group_status) {
            $sql .= " AND sp.group_status = :group_status";
            $params['group_status'] = $request->group_status;
        }

        // Fetch the marriage info using raw SQL
        $result = DB::select(DB::raw($sql), array_merge($bindings, $params));

        $array_data     = [];
        $currentDate    = Carbon::now();

        foreach ($result as $row) {
            $divisionId = $row->division_id;
            $districtId = $row->district_id;
            $upazilaId  = $row->upazila_id;
            $groupId    = $row->group_id;
            $regionName = $row->region_name;

            $dateOfBirth    = Carbon::parse($row->date_of_birth);
            $marriageDate   = Carbon::parse($row->marriage_date);
            $ageAtMarriage  = $dateOfBirth->diffInYears($marriageDate);


            if (!isset($array_data['division'][$divisionId])) {
                $array_data['division'][$divisionId]['name']    = $row->division;
                $array_data['division'][$divisionId]['id']      = $divisionId;
            }

            if (!isset($array_data['division'][$divisionId]['district'][$districtId])) {
                $array_data['division'][$divisionId]['district'][$districtId]['name']   = $row->district;
                $array_data['division'][$divisionId]['district'][$districtId]['id']     = $districtId;
            }

            if (!isset($array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId])) {
                $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['name']    = $row->upazila;
                $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['id']      = $upazilaId;
            }

            if (!isset($array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId])) {
                $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['name']     = $row->group_name;
                $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['id']       = $groupId;
                $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['zone']     = $regionName;
                $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['below_18'] = 0;
                $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['after_18'] = 0;
                $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['total']    = 0;
            }

            // Check if the girl is 18 or older
            if ($ageAtMarriage < 18) {
                $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['below_18']++;
            } else {
                $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['after_18']++;
            }

            $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['total']++;
        }

        return $array_data;
    }

    public function groupWiseSwapnosarothiSkillSessionReport($swapnosarothi_infos, $swapnosarothi_skills, $report_type = null)
    {
        $array_data     = [];
        $count          = count($swapnosarothi_infos);

        for ($i = 0; $i < $count; $i++) {

            $swapnosarothi_info = $swapnosarothi_infos[$i];
            $divisionId         = $swapnosarothi_info->employee_division_id;
            $districtId         = $swapnosarothi_info->employee_district_id;
            $upazilaId          = $swapnosarothi_info->employee_upazila_id;
            $groupId            = $swapnosarothi_info->group_id;
            $skillTableId       = $swapnosarothi_info->skill_table_id;

            // Initialize the division data if not already set
            $array_data['division'][$divisionId]['name']    = @$swapnosarothi_info->employee_division->name;
            $array_data['division'][$divisionId]['id']      = @$swapnosarothi_info->employee_division->id;


            // Initialize the district data if not already set
            $array_data['division'][$divisionId]['district'][$districtId]['name']   = @$swapnosarothi_info->employee_district->name;
            $array_data['division'][$divisionId]['district'][$districtId]['id']     = @$swapnosarothi_info->employee_district->id;

            // Initialize the upazila data if not already set
            $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['name']    = @$swapnosarothi_info->employee_upazila->name;
            $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['id']      = @$swapnosarothi_info->employee_upazila->id;

            // Initialize the group data if not already set
            $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['name']     = @$swapnosarothi_info->groupName->group_name;
            $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['id']       = @$swapnosarothi_info->groupName->id;
            $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['zone']     = @$swapnosarothi_info->employee_zone->region_name;


            if (!isset($array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['skill'][$skillTableId])) {
                $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['skill'][$skillTableId] = 1;
            } else {
                $array_data['division'][$divisionId]['district'][$districtId]['upazila'][$upazilaId]['group'][$groupId]['skill'][$skillTableId] += 1;
            }

        }
        return $array_data;
    }

    private function swapnoSarothiReportPdf($data)
    {
        switch ($data['report_type']) {
            case '1':
            case '2':
                $view = 'backend.report.swapnosarothi.pdf.no_of_girls';
                $file_name = 'swapnosarothi_no_of_girls.pdf';
                break;
            case '3':
            case '4':
                $view = 'backend.report.swapnosarothi.pdf.girls_under_cash_support';
                $file_name = 'swapnosarothi_girls_under_cash_support.pdf';
                break;
            case '5':
            case '6':
            case '7':
                $view = 'backend.report.swapnosarothi.pdf.girls_under_initiative';
                $file_name = 'swapnosarothi_girls_under_initiative.pdf';
                break;
            case '8':
            case '9':
                $view = 'backend.report.swapnosarothi.pdf.married_girls';
                $file_name = 'swapnosarothi_married_girls.pdf';
                break;
            case '10':
                $view = 'backend.report.swapnosarothi.pdf.girls_skills_session';
                $file_name = 'swapnosarothi_girls_skills_session.pdf';
                break;
            default:
                $view = '';
                $file_name = 'swapnosarothi.pdf';
                break;
        }
        //return view($view, $data);
        $pdf = PDF::loadView($view, $data, [], ['title' => 'Certificate', 'format' => 'A4-L', 'orientation' => 'L']);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream($file_name);
    }

    private function swapnoSarothiReportExcel($data)
    {
        switch ($data['report_type']) {
            case '1':
            case '2':
                $view = 'backend.report.swapnosarothi.excel.no_of_girls';
                $file_name = 'swapnosarothi_no_of_girls.xlsx';
                break;
            case '3':
            case '4':
                $view = 'backend.report.swapnosarothi.excel.girls_under_cash_support';
                $file_name = 'swapnosarothi_girls_under_cash_support.xlsx';
                break;
            case '5':
            case '6':
            case '7':
                $view = 'backend.report.swapnosarothi.excel.girls_under_initiative';
                $file_name = 'swapnosarothi_girls_under_initiative.xlsx';
                break;
            case '8':
            case '9':
                $view = 'backend.report.swapnosarothi.excel.married_girls';
                $file_name = 'swapnosarothi_married_girls.xlsx';
                break;
            case '10':
                $view = 'backend.report.swapnosarothi.excel.girls_skills_session';
                $file_name = 'swapnosarothi_girls_skills_session.xlsx';
                break;
            default:
                $view = '';
                $file_name = 'swapnosarothi_report.xlsx';
                break;
        }
        //return view($view, $data);
        return Excel::download(new MisReportExport($data, $view), $file_name);
    }
}
