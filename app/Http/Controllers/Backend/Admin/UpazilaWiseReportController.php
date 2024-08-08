<?php

namespace App\Http\Controllers\Backend\Admin;

use App\ChildMarriageAssistanceTaken;
use App\ChildMarriageInformation;
use App\ChildMarriageInitiative;
use App\Exports\MisReportExport;
use App\Http\Controllers\Controller;
use App\Model\Admin\Setup\CEP_Region\Region;
use App\Model\Admin\Setup\District;
use App\Model\Admin\Setup\Division;
use App\Model\Admin\Setup\InformationProviderSource;
use App\Model\Admin\Setup\Upazila;
use App\Model\SelpIncidentModel;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class UpazilaWiseReportController extends Controller
{
    // Upazila Wise SELP Report
    public function upazilaWiseReportView()
    {

        $data['regions']   = getRegionByUserType();
        $data['auth_user'] = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        return view('backend.report.upazila_wise_report_view', $data);
    }

    public function SelpIncidentQuery($request)
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

    public function upazilaWiseReportGenerate(Request $request)
    {
        ini_set('memory_limit', -1);
        $from_date = date('Y-m-d', strtotime($request->from_date));
        $to_date   = date('Y-m-d', strtotime($request->to_date));
        //$where[]          = ['status', 2];
        $datas['date_to']   = $to_date;
        $datas['date_from'] = $from_date;
        $datas['region']    = Region::where('id', $request->region_id)->first()->region_name ?? 'All';
        $datas['division']  = Division::where('id', $request->division_id)->first()->name ?? "All";
        $datas['district']  = District::where('id', $request->district_id)->first()->name ?? "All";
        $datas['upazila']   = Upazila::where('id', $request->upazila_id)->first()->name ?? "All";

        if ($request->report_type == 1) {

            $datas['title'] = "Dispute reported by BRAC participants";

            $datas['information_providers'] = InformationProviderSource::orderBy('id', 'asc')->whereNotIn('id', [3, 6, 8, 9, 13, 14, 15])->where('status', 1)->get();

            $information_providers_array = [];
            foreach ($datas['information_providers'] as $key => $list) {
                $information_providers_array[] = 'sum(case when selp_incident_informations.information_provider_source_id = ' . $list->id . ' then 1 else 0 end) as information_provider_source_id_' . $list->id;
            }
            $information_providers_db = implode(',', $information_providers_array);
            $datas['selfDatas']       = $this->SelpIncidentQuery($request)
                ->select(
                    'divisions.name as division_name',
                    'districts.name as district_name',
                    'upazilas.name as upazila_name',
                    DB::raw($information_providers_db)
                )
                ->join('information_provider_sources', 'information_provider_sources.id', '=', 'selp_incident_informations.information_provider_source_id')
                ->join('divisions', 'divisions.id', '=', 'selp_incident_informations.employee_division_id')
                ->join('districts', 'districts.id', '=', 'selp_incident_informations.employee_district_id')
                ->join('upazilas', 'upazilas.id', '=', 'selp_incident_informations.employee_upazila_id')
                ->whereBetween('selp_incident_informations.posting_date', [$from_date, $to_date])
                ->where('selp_incident_informations.status', 2)
                ->whereNotIn('selp_incident_informations.information_provider_source_id', [3, 6, 8, 9, 13, 14, 15])
                ->groupBy(
                    'employee_division_id',
                    'employee_district_id',
                    'employee_upazila_id',
                )
                ->orderBy('division_name', 'asc')
                ->orderBy('district_name', 'asc')
                ->orderBy('upazila_name', 'asc')
                ->get();

            if ($request->format_download == 1) {
                $pdf = PDF::loadView('selp.pdf.upazila_wise_report_1', $datas, [], ['title' => 'Certificate', 'format' => 'A4-L', 'orientation' => 'L']);
                $pdf->SetProtection(['copy', 'print'], '', 'pass');
                return $pdf->stream('document.pdf');
            } else {
                $view_link = 'selp.excel.upazila_wise_report_1';
                return Excel::download(new MisReportExport($datas, $view_link), 'selp_gender_wise_violence_report.xlsx');
            }
        } elseif ($request->report_type == 2) {
            $datas['title'] = "No of Disputes reported";
            $selp_infos     = $this->SelpIncidentQuery($request)
                ->whereBetween('posting_date', [$from_date, $to_date])
                ->whereNotNull('violence_reason_id')
                ->where('status', 2)
                ->get();
            $datas['array_data'] = $this->upazilaWisePwdGeneralGenderReport($selp_infos);
        } elseif ($request->report_type == 3) {
            $datas['title'] = "No. of Provided Legal Advices";

            $selp_infos = $this->SelpIncidentQuery($request)
                ->whereIn('selp_initiative', [1, 4])
                ->whereBetween('posting_date', [$from_date, $to_date])
                ->where('status', 2)
                ->get();

            $datas['array_data'] = $this->upazilaWisePwdGeneralGenderReport($selp_infos);
        } elseif ($request->report_type == 4) {

            $datas['title'] = "No. of Complaints Received";
            $selp_infos     = $this->SelpIncidentQuery($request)
                ->where('selp_initiative', 2)
                ->whereBetween('posting_date', [$from_date, $to_date])
                ->where('status', 2)
                ->get();

            $datas['array_data'] = $this->upazilaWisePwdGeneralGenderReport($selp_infos);
        } elseif ($request->report_type == 5) {

            $datas['title'] = "No of ADR completed";

            $selp_infos = $this->SelpIncidentQuery($request)->join('survivor_direct_services', 'survivor_direct_services.selp_incident_information_id', '=', 'selp_incident_informations.id')
                ->select('selp_incident_informations.id', 'employee_zone_id', 'employee_division_id', 'employee_district_id', 'employee_upazila_id', 'status', 'survivor_disability_status', 'survivor_age', 'survivor_gender_id', 'survivor_direct_services.alternative_dispute_resolution_id', 'survivor_direct_services.closing_date')
                ->whereIn('alternative_dispute_resolution_id', [7, 9])
                ->whereNotNull('money_recovered_through_adr')
                ->whereNotNull('closing_date')
                ->whereBetween('closing_date', [$from_date, $to_date])
                ->where('status', 2)
                ->groupBy(
                    'selp_incident_informations.id'
                )
                ->get();
            // return count($selp_infos);
            if (@$selp_infos->isEmpty()) {
                return redirect()->back()->with('error', "There is no data entry found in this search criteria");
            }

            $datas['array_data'] = $this->upazilaWisePwdGeneralGenderReport($selp_infos);
        } elseif ($request->report_type == 6) {

            $datas['title'] = "No of Court Cases Filed";

            $selp_infos = $this->SelpIncidentQuery($request)->join('survivor_court_cases', 'survivor_court_cases.selp_incident_information_id', '=', 'selp_incident_informations.id')
                ->select('selp_incident_informations.id', 'employee_zone_id', 'employee_division_id', 'employee_district_id', 'employee_upazila_id', 'status', 'survivor_disability_status', 'survivor_age', 'survivor_gender_id', 'survivor_court_cases.case_start_date', 'survivor_court_cases.court_case_id', 'survivor_court_cases.case_type')
                // ->whereIn('court_case_id', [16, 35, 28])
                // ->whereNotNull('case_start_date')
                // ->whereBetween('case_start_date', [$from_date, $to_date])
                // ->where('status', 2)
                ->where(function ($query) use ($from_date, $to_date) {
                    $query->whereNotNull('moneyrecover_case_id')
                        ->whereNotNull('case_start_date')
                        ->whereBetween('case_start_date', [$from_date, $to_date])
                        ->where('status', 2)
                        ->where(function ($query) use ($from_date, $to_date) {
                            $query->where('court_case_id', 16)
                                ->where('case_type', 1)
                                ->orWhere(function ($query) use ($from_date, $to_date) {
                                    $query->where('court_case_id', 35)
                                        ->where('case_type', 2);
                                })
                                ->orWhere(function ($query) use ($from_date, $to_date) {
                                    $query->where('court_case_id', 28)
                                        ->where('case_type', 3);
                                });
                        });
                })
                ->groupBy('selp_incident_informations.id')
                ->get();

            if (@$selp_infos->isEmpty()) {
                return redirect()->back()->with('error', "There is no data entry found in this search criteria");
            }

            $datas['array_data'] = $this->upazilaWisePwdGeneralGenderReport($selp_infos);
        } elseif ($request->report_type == 7) {

            $datas['title'] = "No of Judgement Received";
            $selp_infos     = $this->SelpIncidentQuery($request)->join('survivor_court_cases', 'survivor_court_cases.selp_incident_information_id', '=', 'selp_incident_informations.id')
                ->select('selp_incident_informations.id', 'employee_zone_id', 'employee_division_id', 'employee_district_id', 'employee_upazila_id', 'status', 'survivor_disability_status', 'survivor_age', 'survivor_gender_id', 'survivor_court_cases.case_judjement_date', 'survivor_court_cases.court_case_id', 'survivor_court_cases.case_type', 'case_judjement_date')
                // ->whereIn('court_case_id', [23, 22, 26])
                // ->whereNotNull('case_type')
                // ->whereNotNull('moneyrecover_case_id')
                // ->whereNotNull('judjementstatus_id')
                ->where(function ($query) use ($from_date, $to_date) {
                    $query->whereNotNull('case_type')
                        ->whereNotNull('moneyrecover_case_id')
                        ->whereNotNull('judjementstatus_id')
                        ->whereNotNull('case_judjement_date')
                        ->whereBetween('case_judjement_date', [$from_date, $to_date])
                        ->where('status', 2)
                        ->where(function ($query) use ($from_date, $to_date) {
                            $query->whereIn('court_case_id', [23])
                                ->where('case_type', 1)
                                ->orWhere(function ($query) use ($from_date, $to_date) {
                                    $query->whereIn('court_case_id', [22])
                                        ->where('case_type', 2);
                                })
                                ->orWhere(function ($query) use ($from_date, $to_date) {
                                    $query->whereIn('court_case_id', [26])
                                        ->where('case_type', 3);
                                });
                        });
                })
                ->groupBy('selp_incident_informations.id')
                ->get();

            $datas['array_data'] = $this->upazilaWisePwdGeneralGenderReport($selp_infos);
        } elseif ($request->report_type == 8) {

            $datas['title'] = "No of survivors provided referral services(Primary and secondary)";

            $selp_infos = $this->SelpIncidentQuery($request)->leftJoin('incident_referrals', 'incident_referrals.selp_incident_id', '=', 'selp_incident_informations.id')
                ->select('selp_incident_informations.id', 'employee_zone_id', 'employee_division_id', 'employee_district_id', 'employee_upazila_id', 'status', 'referral', 'survivor_disability_status', 'survivor_age', 'survivor_gender_id', 'incident_referrals.referral_id')
                ->where('status', 2)
                ->where(function ($q) {
                    $q->orWhere(function ($q1) {
                        $q1->whereNotNull('referral')->whereNotIn('referral', [1]);
                    })->orWhere(function ($q3) {
                        $q3->whereNotIn('referral_id', [9]);
                    });
                })
                ->whereBetween('posting_date', [$from_date, $to_date])
                ->get();
            $datas['array_data'] = $this->upazilaWisePwdGeneralGenderReport($selp_infos);
        } elseif ($request->report_type == 9) {

            $datas['title'] = "No. of ADR recovered money(office+self initiative/outside)";

            $selp_infos = $this->SelpIncidentQuery($request)
                ->join('survivor_direct_services', 'survivor_direct_services.selp_incident_information_id', '=', 'selp_incident_informations.id')
                ->select('selp_incident_informations.id', 'employee_zone_id', 'employee_division_id', 'employee_district_id', 'employee_upazila_id', 'status', 'survivor_disability_status', 'survivor_age', 'survivor_gender_id', 'survivor_direct_services.alternative_dispute_resolution_id', 'survivor_direct_services.closing_date', 'survivor_direct_services.amount_of_money_received')
                ->whereIn('alternative_dispute_resolution_id', [7, 9, 11])
                ->whereNotNull('amount_of_money_received')
                ->whereBetween('closing_date', [$from_date, $to_date])
                ->groupBy('selp_incident_informations.id')
                ->where('status', 2)
                ->get();

            if (@$selp_infos->isEmpty()) {
                return redirect()->back()->with('error', "There is no data entry found in this search criteria");
            }
            $datas['array_data'] = $this->upazilaWisePwdGeneralGenderReport($selp_infos);
        } elseif ($request->report_type == 10) {

            $datas['title'] = "Amount of money recovered through ADRs(office+self,initiative/outside)";

            $selp_infos = $this->SelpIncidentQuery($request)
                ->join('survivor_direct_services', 'survivor_direct_services.selp_incident_information_id', '=', 'selp_incident_informations.id')
                ->select(
                    'selp_incident_informations.id', 
                    'employee_zone_id', 
                    'employee_division_id', 
                    'status', 
                    'employee_district_id', 
                    'employee_upazila_id', 
                    'survivor_disability_status', 
                    'survivor_age', 
                    'survivor_gender_id', 
                    'survivor_direct_services.alternative_dispute_resolution_id', 
                    'survivor_direct_services.closing_date', 
                    DB::raw('SUM(survivor_direct_services.amount_of_money_received) as amount_of_money_received')
                )
                ->whereIn('alternative_dispute_resolution_id', [7, 9, 11])
                ->whereNotNull('amount_of_money_received')
                ->whereNotNull('money_recovered_through_adr')
                ->whereBetween('closing_date', [$from_date, $to_date])
                ->where('selp_incident_informations.status', 2)
                ->groupBy('selp_incident_informations.id')
                ->get();

            if (@$selp_infos->isEmpty()) {
                return redirect()->back()->with('error', "There is no data entry found in this search criteria");
            }

            $array_data = [];
            foreach ($selp_infos as $selp_info) {
                $array_data = $this->employeeWiseLocation($array_data, $selp_info);

                @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_women_count'] += 0;
                @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_men_count'] += 0;
                @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_boy_count'] += 0;
                @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_girl_count'] += 0;
                @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_women_count'] += 0;
                @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_men_count'] += 0;
                @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_boy_count'] += 0;
                @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_girl_count'] += 0;

                @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['other_count'] += 0;

                @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['total_count'] += 0;

                if (@$selp_info->survivor_gender_id == '1') {
                    if (@$selp_info->survivor_age < 18) {
                        @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_boy'] += $selp_info->amount_of_money_received;

                        @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_boy_count'] += 1;
                    } else {
                        @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_men'] += $selp_info->amount_of_money_received;

                        @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_men_count'] += 1;
                    }
                } elseif (@$selp_info->survivor_gender_id == '2') {
                    if (@$selp_info->survivor_age < 18) {
                        @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_girl'] += $selp_info->amount_of_money_received;
                        @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_girl_count'] += 1;
                    } else {
                        @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_women'] += $selp_info->amount_of_money_received;

                        @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_women_count'] += 1;
                    }
                }
                if (@$selp_info->survivor_disability_status != '10') {
                    if (@$selp_info->survivor_gender_id == '1') {
                        if (@$selp_info->survivor_age < 18) {
                            @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_boy'] += $selp_info->amount_of_money_received;

                            @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_boy_count'] += 1;
                        } else {
                            @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_men'] += $selp_info->amount_of_money_received;

                            @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_men_count'] += 1;
                        }
                    } elseif (@$selp_info->survivor_gender_id == '2') {
                        if (@$selp_info->survivor_age < 18) {
                            @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_girl'] += $selp_info->amount_of_money_received;

                            @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_girl_count'] += 1;
                        } else {
                            @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_women'] += $selp_info->amount_of_money_received;

                            @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_women_count'] += 1;
                        }
                    }
                }

                if (!in_array(@$selp_info->survivor_gender_id, [1, 2])) {
                    @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['other'] += $selp_info->amount_of_money_received;

                    @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['other_count'] += 1;
                }

                @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['total'] += $selp_info->amount_of_money_received;

                @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['total_count'] += 1;
            }

            $array_data['report_type'] = 10;
            $datas['array_data']       = $array_data;
        } elseif ($request->report_type == 11) {

            $datas['title'] = "No. of court cases recovered money";

            $selp_infos = $this->SelpIncidentQuery($request)->join('survivor_court_cases', 'survivor_court_cases.selp_incident_information_id', '=', 'selp_incident_informations.id')
                ->select('selp_incident_informations.id', 'employee_zone_id', 'employee_division_id', 'employee_district_id', 'employee_upazila_id', 'status', 'survivor_disability_status', 'survivor_age', 'survivor_gender_id', 'violence_reason_id', 'survivor_court_cases.amount_of_money_received', 'survivor_court_cases.court_case_id', 'survivor_court_cases.case_judjement_date')
                ->whereIn('court_case_id', [23, 22, 26, 24, 34, 36, 29]) //Decree 24 / installment 34, 36, 29
                ->whereNotNull('amount_of_money_received')
                ->where('amount_of_money_received', '>', 0)
                ->whereBetween('case_judjement_date', [$from_date, $to_date])
                // ->where( 'violence_reason_id', 12 )
                ->groupBy('selp_incident_informations.id')
                ->where('status', 2)
                ->get();

            if (@$selp_infos->isEmpty()) {
                return redirect()->back()->with('error', "There is no data entry found in this search criteria");
            }
            $datas['array_data'] = $this->upazilaWisePwdGeneralGenderReport($selp_infos);
        } elseif ($request->report_type == 12) {

            $datas['title'] = "Amount of money recovered through court cases";

            $selp_infos = $this->SelpIncidentQuery($request)->join('survivor_court_cases', 'survivor_court_cases.selp_incident_information_id', '=', 'selp_incident_informations.id')
                ->select('selp_incident_informations.id', 'employee_zone_id', 'employee_division_id', 'employee_district_id', 'employee_upazila_id', 'status', 'survivor_disability_status', 'survivor_age', 'survivor_gender_id', 'survivor_court_cases.court_case_id', 'survivor_court_cases.case_judjement_date', DB::raw('SUM(survivor_court_cases.amount_of_money_received) as amount_of_money_received'))
                ->whereIn('court_case_id', [23, 22, 26, 24, 34, 36, 29]) //Decree 24  / installment 34, 36, 29
                ->whereNotNull('amount_of_money_received')
                ->where('amount_of_money_received', '>', 0)
                ->whereBetween('case_judjement_date', [$from_date, $to_date])
                // ->where( 'selp_incident_informations.id', 37881 )
                ->where('status', 2)
                ->groupBy('id')
                ->get();

            // return  $selp_infos;
            if (@$selp_infos->isEmpty()) {
                return redirect()->back()->with('error', "There is no data entry found in this search criteria");
            }

            $array_data = [];
            foreach ($selp_infos as $selp_info) {
                $array_data = $this->employeeWiseLocation($array_data, $selp_info);

                @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_women_count'] += 0;
                @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_men_count'] += 0;
                @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_boy_count'] += 0;
                @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_girl_count'] += 0;
                @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_women_count'] += 0;
                @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_men_count'] += 0;
                @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_boy_count'] += 0;
                @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_girl_count'] += 0;
                @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['other_count'] += 0;

                @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['total_count'] += 0;

                if (@$selp_info->survivor_gender_id == '1') {
                    if (@$selp_info->survivor_age < 18) {
                        @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_boy'] += $selp_info->amount_of_money_received;

                        @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_boy_count'] += 1;
                    } else {
                        @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_men'] += $selp_info->amount_of_money_received;

                        @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_men_count'] += 1;
                    }
                } elseif (@$selp_info->survivor_gender_id == '2') {
                    if (@$selp_info->survivor_age < 18) {
                        @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_girl'] += $selp_info->amount_of_money_received;
                        @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_girl_count'] += 1;
                    } else {
                        @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_women'] += $selp_info->amount_of_money_received;

                        @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_women_count'] += 1;
                    }
                }
                if (@$selp_info->survivor_disability_status != '10') {
                    if (@$selp_info->survivor_gender_id == '1') {
                        if (@$selp_info->survivor_age < 18) {
                            @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_boy'] += $selp_info->amount_of_money_received;

                            @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_boy_count'] += 1;
                        } else {
                            @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_men'] += $selp_info->amount_of_money_received;

                            @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_men_count'] += 1;
                        }
                    } elseif (@$selp_info->survivor_gender_id == '2') {
                        if (@$selp_info->survivor_age < 18) {
                            @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_girl'] += $selp_info->amount_of_money_received;

                            @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_girl_count'] += 1;
                        } else {
                            @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_women'] += $selp_info->amount_of_money_received;

                            @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_women_count'] += 1;
                        }
                    }
                }

                if (!in_array(@$selp_info->survivor_gender_id, [1, 2])) {
                    @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['other'] += $selp_info->amount_of_money_received;

                    @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['other_count'] += 1;
                }

                @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['total'] += $selp_info->amount_of_money_received;

                @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['total_count'] += 1;
            }

            $array_data['report_type'] = 12;
            $datas['array_data']       = $array_data;
        } elseif ($request->report_type == 13) {
            $datas['title'] = "No of Complains completed on Dower, maintanance, inheritance rights and dower and maintanance through ADR and Court case";

            $selp_infos = $this->SelpIncidentQuery($request)->leftJoin('survivor_direct_services', 'survivor_direct_services.selp_incident_information_id', '=', 'selp_incident_informations.id')
                ->leftJoin('survivor_court_cases', 'survivor_court_cases.selp_incident_information_id', '=', 'selp_incident_informations.id')
                ->select('selp_incident_informations.id', 'employee_zone_id', 'employee_division_id', 'employee_district_id', 'employee_upazila_id', 'status', 'survivor_disability_status', 'survivor_age', 'survivor_gender_id')
                ->whereIn('violence_reason_id', [1, 2, 3, 5])
                ->where(function ($q) {
                    $q->where('alternative_dispute_resolution_id', 7)
                        ->orWhere('alternative_dispute_resolution_id', 9)
                        ->orWhereNotNull('case_judjement_date');
                })
                ->whereBetween('posting_date', [$from_date, $to_date])
                ->where('status', 2)
                ->groupBy('selp_incident_informations.id')
                ->get();

            if (@$selp_infos->isEmpty()) {
                return redirect()->back()->with('error', "There is no data entry found in this search criteria");
            }

            $datas['array_data'] = $this->upazilaWisePwdGeneralGenderReport($selp_infos);
        } elseif ($request->report_type == 14) {

            $datas['title'] = "No.of People benefited for dower,Maintenance,Inheritance,Dower and Maintenance through ADR and Court case";

            $selp_infos = $this->SelpIncidentQuery($request)->leftJoin('survivor_direct_services as sds', 'sds.selp_incident_information_id', '=', 'selp_incident_informations.id')
                ->leftJoin('survivor_court_cases as scc', 'scc.selp_incident_information_id', '=', 'selp_incident_informations.id')
                ->select('selp_incident_informations.id', 'employee_zone_id', 'employee_division_id', 'employee_district_id', 'employee_upazila_id', 'survivor_disability_status', 'survivor_age', 'survivor_gender_id', 'no_of_adr_participants_benefited', 'no_of_case_participants_benefited')
                ->whereIn('violence_reason_id', [1, 2, 3, 5])
                ->where(function ($q) {
                    $q->where('alternative_dispute_resolution_id', 7)
                        ->orWhere('alternative_dispute_resolution_id', 9)
                        ->orWhereNotNull('case_judjement_date');
                })
                ->whereBetween('posting_date', [$from_date, $to_date])
                ->where('status', 2)
                ->groupBy('selp_incident_informations.id')
                ->get();

            if (@$selp_infos->isEmpty()) {
                return redirect()->back()->with('error', "There is no data entry found in this search criteria");
            }

            $array_data = [];
            foreach ($selp_infos as $selp_info) {
                $array_data = $this->employeeWiseLocation($array_data, $selp_info);
                if (@$selp_info->survivor_gender_id == '1') {
                    if (@$selp_info->survivor_age < 18) {
                        @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_boy'] += 1;
                    } else {
                        @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_men'] += 1;
                    }
                } elseif (@$selp_info->survivor_gender_id == '2') {
                    if (@$selp_info->survivor_age < 18) {
                        @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_girl'] += 1;
                    } else {
                        @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_women'] += 1;
                    }
                }

                if (@$selp_info->survivor_disability_status != '10') {
                    if (@$selp_info->survivor_gender_id == '1') {
                        if (@$selp_info->survivor_age < 18) {
                            @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_boy'] += 1;
                        } else {
                            @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_men'] += 1;
                        }
                    } elseif (@$selp_info->survivor_gender_id == '2') {
                        if (@$selp_info->survivor_age < 18) {
                            @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_girl'] += 1;
                        } else {
                            @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_women'] += 1;
                        }
                    }
                }
                if (!in_array(@$selp_info->survivor_gender_id, [1, 2])) {
                    @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['other'] += 1;
                }

                @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['total'] += 1;

                @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['benefited'] += $selp_info->no_of_adr_participants_benefited + $selp_info->no_of_case_participants_benefited;
            }
            $datas['report_type14'] = 14;
            $datas['array_data']    = $array_data;
        } elseif ($request->report_type == 15) {

            $datas['title']         = "No.of Survivors received Assistance to treatment/Medical support";
            $datas['report_type15'] = 15;
            $selp_infos             = $this->SelpIncidentQuery($request)->join('direct_service_types as dst', 'dst.selp_incident_id', '=', 'selp_incident_informations.id')
                ->select('selp_incident_informations.id', 'employee_zone_id', 'employee_division_id', 'employee_district_id', 'employee_upazila_id', 'status', 'survivor_disability_status', 'survivor_age', 'survivor_gender_id', 'dst.service_type_id', 'dst.service_date', 'dst.receive_money')
                ->where('service_type_id', 1)
                ->whereNotNull('service_date')
                ->whereBetween('service_date', [$from_date, $to_date])
                ->where('status', 2)
                ->groupBy('selp_incident_informations.id')
                ->get();

            if (@$selp_infos->isEmpty()) {
                return redirect()->back()->with('error', "There is no data entry found in this search criteria");
            }

            $datas['array_data'] = $this->upazilaWisePwdGeneralGenderReport($selp_infos, 15);
        } elseif ($request->report_type == 16) {
            $datas['title'] = "No.of Survivors received Assistance to One stop Crisis Centre (OCC)";

            $selp_infos = $this->SelpIncidentQuery($request)->join('direct_service_types as dst', 'dst.selp_incident_id', '=', 'selp_incident_informations.id')
                ->select('selp_incident_informations.id', 'employee_zone_id', 'employee_division_id', 'employee_district_id', 'employee_upazila_id', 'status', 'survivor_disability_status', 'survivor_age', 'survivor_gender_id', 'dst.service_type_id', 'dst.service_date')
                ->where('service_type_id', 2)
                ->whereNotNull('service_date')
                ->whereBetween('service_date', [$from_date, $to_date])
                ->where('status', 2)
                ->groupBy('selp_incident_informations.id')
                ->get();

            if (@$selp_infos->isEmpty()) {
                return redirect()->back()->with('error', "There is no data entry found in this search criteria");
            }

            $datas['array_data'] = $this->upazilaWisePwdGeneralGenderReport($selp_infos);
        } elseif ($request->report_type == 17) {
            $datas['title'] = "No.of Survivors received Assistance to Police station";

            $selp_infos = $this->SelpIncidentQuery($request)->join('direct_service_types as dst', 'dst.selp_incident_id', '=', 'selp_incident_informations.id')
                ->select('selp_incident_informations.id', 'employee_zone_id', 'employee_division_id', 'employee_district_id', 'employee_upazila_id', 'status', 'survivor_disability_status', 'survivor_age', 'survivor_gender_id', 'dst.service_type_id', 'dst.service_date')
                ->where('service_type_id', 5)
                ->whereNotNull('service_date')
                ->whereBetween('service_date', [$from_date, $to_date])
                ->groupBy('selp_incident_informations.id')
                ->where('status', 2)
                ->get();

            if (@$selp_infos->isEmpty()) {
                return redirect()->back()->with('error', "There is no data entry found in this search criteria");
            }

            $datas['array_data'] = $this->upazilaWisePwdGeneralGenderReport($selp_infos);
        } elseif ($request->report_type == 18) {
            $datas['title'] = "No.of Survivors received Provided to Phycosocial counselling";

            $selp_infos = $this->SelpIncidentQuery($request)->join('direct_service_types as dst', 'dst.selp_incident_id', '=', 'selp_incident_informations.id')
                ->select('selp_incident_informations.id', 'employee_zone_id', 'employee_division_id', 'employee_district_id', 'employee_upazila_id', 'status', 'survivor_disability_status', 'survivor_age', 'survivor_gender_id', 'dst.service_type_id', 'dst.service_date')
                ->where('service_type_id', 6)
                ->whereNotNull('service_date')
                ->whereBetween('service_date', [$from_date, $to_date])
                ->where('status', 2)
                ->groupBy('selp_incident_informations.id')
                ->get();

            if (@$selp_infos->isEmpty()) {
                return redirect()->back()->with('error', "There is no data entry found in this search criteria");
            }

            $datas['array_data'] = $this->upazilaWisePwdGeneralGenderReport($selp_infos);
        } elseif ($request->report_type == 19) {
            $datas['title'] = "No.of child marriage incident report";

            $selp_infos = $this->SelpIncidentQuery($request)
                ->select('id', 'employee_zone_id', 'employee_division_id', 'employee_district_id', 'employee_upazila_id', 'status', 'survivor_disability_status', 'survivor_age', 'survivor_gender_id', 'violence_reason_id')
                ->where('violence_reason_id', 37)
                ->whereBetween('posting_date', [$from_date, $to_date])
                ->where('status', 2)
                ->get();
            if (@$selp_infos->isEmpty()) {
                return redirect()->back()->with('error', "There is no data entry found in this search criteria");
            }

            $datas['array_data'] = $this->upazilaWisePwdGeneralGenderReport($selp_infos);
            //print pdf or excel
            if ($request->format_download == 1) {
                $pdf = PDF::loadView('selp.pdf.upazila_wise_report_3', $datas, [], ['title' => 'Certificate', 'format' => 'A4-L', 'orientation' => 'L']);
                $pdf->SetProtection(['copy', 'print'], '', 'pass');
                return $pdf->stream('document.pdf');
            } else {
                $view_link = 'selp.excel.upazila_wise_report_2';
                return Excel::download(new MisReportExport($datas, $view_link), 'upazila_wise_report.xlsx');
            }
        } elseif ($request->report_type == 20) {

            $datas['title'] = "No.of child marriage prevented";

            $childMarriagePrevent = $this->childmarriagequery($request)->select('id', 'employee_zone_id', 'employee_division_id', 'employee_district_id', 'employee_upazila_id', 'status', 'survivor_autistic_information_id', 'child_gender_id')
                ->whereBetween('reporting_date', [$from_date, $to_date])
                ->where('status', 2)
                ->get();
            if (@$childMarriagePrevent->isEmpty()) {
                return redirect()->back()->with('error', "There is no data entry found in this search criteria");
            }

            $datas['array_data'] = $this->upazilaWisePwdGeneralGenderReportChildMarrige($childMarriagePrevent);

            if ($request->format_download == 1) {
                $pdf = PDF::loadView('selp.pdf.upazila_wise_report_3', $datas, [], ['title' => 'Certificate', 'format' => 'A4-L', 'orientation' => 'L']);
                $pdf->SetProtection(['copy', 'print'], '', 'pass');
                return $pdf->stream('document.pdf');
            } else {
                $view_link = 'selp.excel.upazila_wise_report_2';
                return Excel::download(new MisReportExport($datas, $view_link), 'upazila_wise_report.xlsx');
            }
        } elseif ($request->report_type == 21) {

            $datas['title'] = "Types of first initiative taken to prevent child marriage";

            $datas['ChildMarriageInitiative'] = ChildMarriageInitiative::orderBy('id', 'asc')->get();

            $ChildMarriageInitiative_array = [];
            foreach ($datas['ChildMarriageInitiative'] as $key => $list) {
                $ChildMarriageInitiative_array[] = 'sum(case when child_marriage_informations.child_marriage_initiative_id = ' . $list->id . ' then 1 else 0 end) as child_marriage_initiative_id_' . $list->id;
            }
            $ChildMarriageInitiative_db = implode(',', $ChildMarriageInitiative_array);
            $datas['selfDatas']         = $this->childmarriagequery($request)->select(
                'divisions.name as division_name',
                'districts.name as district_name',
                'upazilas.name as upazila_name',
                DB::raw($ChildMarriageInitiative_db)
            )
                ->join('child_marriage_initiatives', 'child_marriage_initiatives.id', '=', 'child_marriage_informations.child_marriage_initiative_id')
                ->join('divisions', 'divisions.id', '=', 'child_marriage_informations.employee_division_id')
                ->join('districts', 'districts.id', '=', 'child_marriage_informations.employee_district_id')
                ->join('upazilas', 'upazilas.id', '=', 'child_marriage_informations.employee_upazila_id')
                ->whereBetween('child_marriage_informations.reporting_date', [$from_date, $to_date])
                ->where('child_marriage_informations.status', 2)
                ->groupBy(
                    'employee_division_id',
                    'employee_district_id',
                    'employee_upazila_id',
                )
                ->orderBy('division_name', 'asc')
                ->orderBy('district_name', 'asc')
                ->orderBy('upazila_name', 'asc')
                ->get();

            if ($request->format_download == 1) {
                $pdf = PDF::loadView('backend.childmarriageinformation.upazila_wise_initiatives_report_pdf', $datas, [], ['title' => 'Certificate', 'format' => 'A4-L', 'orientation' => 'L']);
                $pdf->SetProtection(['copy', 'print'], '', 'pass');
                return $pdf->stream('document.pdf');
            } else {
                $view_link = 'backend.childmarriageinformation.upazila_wise_initiatives_report_excel';
                return Excel::download(new MisReportExport($datas, $view_link), 'upazila_wise_child_marriage_initiatives_report.xlsx');
            }
        } elseif ($request->report_type == 22) {

            $datas['title'] = "Assistance taken to Prevent child marriage initiatives";

            $datas['ChildMarriageAssistanceTaken'] = ChildMarriageAssistanceTaken::orderBy('id', 'asc')->get();

            $ChildMarriageAssistanceTaken_array = [];
            foreach ($datas['ChildMarriageAssistanceTaken'] as $key => $list) {
                $ChildMarriageAssistanceTaken_array[] = 'sum(case when child_marriage_assistance_information.child_marriage_assistance_taken_id = ' . $list->id . ' then 1 else 0 end) as child_marriage_assistance_takens_id_' . $list->id;
            }

            $ChildMarriageAssistanceTaken_db = implode(',', $ChildMarriageAssistanceTaken_array);

            $datas['selfDatas'] = $this->childmarriagequery($request)->select(
                'divisions.name as division_name',
                'districts.name as district_name',
                'upazilas.name as upazila_name',
                DB::raw($ChildMarriageAssistanceTaken_db)
            )
                ->join('child_marriage_assistance_information', 'child_marriage_assistance_information.child_marriage_information_id', '=', 'child_marriage_informations.id')
                ->join('divisions', 'divisions.id', '=', 'child_marriage_informations.employee_division_id')
                ->join('districts', 'districts.id', '=', 'child_marriage_informations.employee_district_id')
                ->join('upazilas', 'upazilas.id', '=', 'child_marriage_informations.employee_upazila_id')
                ->whereBetween('child_marriage_informations.reporting_date', [$from_date, $to_date])
                ->where('child_marriage_informations.status', 2)
                ->groupBy(
                    'employee_division_id',
                    'employee_district_id',
                    'employee_upazila_id',
                )
                ->orderBy('division_name', 'asc')
                ->orderBy('district_name', 'asc')
                ->orderBy('upazila_name', 'asc')
                ->get();

            if ($request->format_download == 1) {
                $pdf = PDF::loadView('backend.childmarriageinformation.upazila_wise_child_assistance_report_pdf', $datas, [], ['title' => 'Certificate', 'format' => 'A4-L', 'orientation' => 'L']);
                $pdf->SetProtection(['copy', 'print'], '', 'pass');
                return $pdf->stream('document.pdf');
            } else {
                $view_link = 'backend.childmarriageinformation.upazila_wise_child_assistance_report_excel';
                return Excel::download(new MisReportExport($datas, $view_link), 'upazila_wise_child_assistance_report_excel.xlsx');
            }
        }

        //print pdf or excel
        if ($request->format_download == 1) {
            $pdf = PDF::loadView('selp.pdf.upazila_wise_report_2', $datas, [], ['title' => 'Certificate', 'format' => 'A4-L', 'orientation' => 'L']);
            $pdf->SetProtection(['copy', 'print'], '', 'pass');
            return $pdf->stream('document.pdf');
        } else {
            $view_link = 'selp.excel.upazila_wise_report';
            return Excel::download(new MisReportExport($datas, $view_link), 'upazila_wise_report.xlsx');
        }
    }

    public function employeeWiseLocation($array_data, $selp_info)
    {
        @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_women'] += 0;
        @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_men'] += 0;
        @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_boy'] += 0;
        @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_girl'] += 0;
        @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_women'] += 0;
        @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_men'] += 0;
        @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_boy'] += 0;
        @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_girl'] += 0;
        @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['other'] += 0;
        @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['total'] += 0;

        $array_data['division'][$selp_info->employee_division_id]['name'] = @$selp_info->employee_division->name;
        $array_data['division'][$selp_info->employee_division_id]['id']   = @$selp_info->employee_division->id;

        $array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['name'] = @$selp_info->employee_district->name;
        $array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['id']   = @$selp_info->employee_district->id;

        $array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['name'] = @$selp_info->employee_upazila->name;
        $array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['id']   = @$selp_info->employee_upazila->id;

        return $array_data;
    }

    public function upazilaWisePwdGeneralGenderReport($selp_infos, $report_type = null)
    {
        $array_data = [];
        foreach ($selp_infos as $selp_info) {
            @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_women'] += 0;
            @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_men'] += 0;
            @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_boy'] += 0;
            @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_girl'] += 0;
            @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_women'] += 0;
            @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_men'] += 0;
            @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_boy'] += 0;
            @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_girl'] += 0;
            @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['other'] += 0;
            @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['total'] += 0;

            if ($report_type == 15) {
                @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['receive_money'] += 0;
            }

            $array_data['division'][$selp_info->employee_division_id]['name'] = @$selp_info->employee_division->name;
            $array_data['division'][$selp_info->employee_division_id]['id']   = @$selp_info->employee_division->id;

            $array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['name'] = @$selp_info->employee_district->name;
            $array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['id']   = @$selp_info->employee_district->id;

            $array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['name'] = @$selp_info->employee_upazila->name;
            $array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['id']   = @$selp_info->employee_upazila->id;

            if (@$selp_info->survivor_gender_id == '1') {
                if (@$selp_info->survivor_age < 18) {
                    @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_boy'] += 1;
                } else {
                    @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_men'] += 1;
                }
            } elseif (@$selp_info->survivor_gender_id == '2') {
                if (@$selp_info->survivor_age < 18) {
                    @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_girl'] += 1;
                } else {
                    @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_women'] += 1;
                }
            }

            if (@$selp_info->survivor_disability_status != '10') {
                if (@$selp_info->survivor_gender_id == '1') {
                    if (@$selp_info->survivor_age < 18) {
                        @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_boy'] += 1;
                    } else {
                        @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_men'] += 1;
                    }
                } elseif (@$selp_info->survivor_gender_id == '2') {
                    if (@$selp_info->survivor_age < 18) {
                        @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_girl'] += 1;
                    } else {
                        @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_women'] += 1;
                    }
                }
            }
            if (!in_array(@$selp_info->survivor_gender_id, [1, 2])) {
                @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['other'] += 1;
            }

            if ($report_type == 15) {
                @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['receive_money'] += $selp_info->receive_money;
            }

            @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['total'] += 1;
        }

        return $array_data;
    }

    public function upazilaWisePwdGeneralGenderReportChildMarrige($selp_infos)
    {
        $array_data = [];
        foreach ($selp_infos as $selp_info) {
            @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_boy'] += 0;
            @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_girl'] += 0;
            @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_boy'] += 0;
            @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_girl'] += 0;
            @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['total'] += 0;

            $array_data['division'][$selp_info->employee_division_id]['name'] = @$selp_info->employee_division->name;
            $array_data['division'][$selp_info->employee_division_id]['id']   = @$selp_info->employee_division->id;

            $array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['name'] = @$selp_info->employee_district->name;
            $array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['id']   = @$selp_info->employee_district->id;

            $array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['name'] = @$selp_info->employee_upazila->name;
            $array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['id']   = @$selp_info->employee_upazila->id;

            if (@$selp_info->child_gender_id == '1') {
                @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_boy'] += 1;
            } elseif (@$selp_info->child_gender_id == '2') {
                @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['g_girl'] += 1;
            }

            if (@$selp_info->survivor_autistic_information_id != '10') {
                if (@$selp_info->child_gender_id == '1') {
                    @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_boy'] += 1;
                } elseif (@$selp_info->child_gender_id == '2') {
                    @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['p_girl'] += 1;
                }
            }

            @$array_data['division'][$selp_info->employee_division_id]['district'][$selp_info->employee_district_id]['upazila'][$selp_info->employee_upazila_id]['total'] += 1;
        }

        return $array_data;
    }
}
