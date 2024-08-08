<?php

namespace App\Http\Controllers\Report;

use PDF;
use Carbon\Carbon;
use App\Model\Civilcase;
use App\Model\Policecase;
use App\Model\Moneyrecover;
use App\Model\Pititioncase;
use Illuminate\Http\Request;
use App\Model\Judgementstatus;
use App\Exports\MisReportExport;
use App\Model\SelpIncidentModel;
use App\Model\Admin\Setup\Upazila;
use App\Model\Admin\Setup\District;
use App\Model\Admin\Setup\Division;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Model\SurvivorCourtCaseModel;
use App\Model\Admin\Setup\CEP_Region\Region;
use App\Model\Admin\Setup\CEP_Region\SetupUserArea;
use App\User;
use Illuminate\Support\Facades\Auth;

class SelpCourtCaseReportController extends Controller
{

    public function SelpIncidentQuery($request) {

        $query = SelpIncidentModel::query();

        if ($request->region_id && $request->region_id != "all_zone" ) {
            if ($request->division_id) {
                $previousZoneInfo = getPreviousZoneIdsFromDivision($request->division_id);
                if (!empty($previousZoneInfo)) {
                    // Extract region_ids and date_to values
                    $regionIds      = array_keys($previousZoneInfo);
                    //$dateToValues   = array_values($previousZoneInfo);
                    $updateReigonIds = array_unique(array_merge($regionIds, [(int)$request->region_id]));
                } else {
                    $updateReigonIds = [(int)$request->region_id];
                }
                $query->whereIn('employee_zone_id', $updateReigonIds);
            } else {
                $query->where('employee_zone_id', $request->region_id);
            }
            //$query->where('employee_zone_id', $request->region_id);
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

        if ($request->district_id && $request->district_id != "all_district") {
            $query->where('employee_district_id', $request->district_id);
        } else if (array_intersect([5, 4], auth()->user()->user_role->pluck('role_id')->toarray())) {
            $area = array_unique(User::with('setup_user_area')->find(Auth::id())->setup_user_area->pluck('district_id')->toArray());
            $query->whereIn('employee_district_id', $area);
        }

        if ($request->upazila_id && $request->upazila_id != "all_upazila") {
            $query->where('employee_upazila_id', $request->upazila_id);
        } else if (array_intersect([5], auth()->user()->user_role->pluck('role_id')->toarray())) {
            $area = array_unique(User::with('setup_user_area')->find(Auth::id())->setup_user_area->pluck('upazila_id')->toArray());
            $query->whereIn('employee_upazila_id', $area);
        }
        return $query;
    }


    public function courtCaseReportGenerate(Request $request)
    {
        ini_set('memory_limit', -1);
        // dd($request->toArray());
        $from_date        = date('Y-m-d', strtotime($request->from_date));
        $to_date          = date('Y-m-d', strtotime($request->to_date));
        $where[]          = ['status', 2];
        $wherein          = [];
        $setup_area       = [];
        $reportTypeTarget = null;
        $groupBy          = null;

        if ($request->upazila_id == "all_upazila" || $request->upazila_id > 0) {
            $reportTypeTarget = "employee_upazila_id";
            $groupBy          = 'upazila_id';
            if ($request->upazila_id > 0) {
                $setup_area = SetupUserArea::where('upazila_id', $request->upazila_id)->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
            }
        }
        if ($request->district_id == "all_district" || $request->district_id > 0) {

            if ($reportTypeTarget == null) {
                $reportTypeTarget = "employee_district_id";
            }

            if ($groupBy == null) {
                $groupBy = "district_id";
            }
            if ($request->district_id > 0 && count($setup_area) == 0) {
                $setup_area = SetupUserArea::where('district_id', $request->district_id)->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
            }
        }

        if ($request->division_id > 0 && count($setup_area) == 0) {
            if ($reportTypeTarget == null) {
                $reportTypeTarget = "employee_district_id";
            }
            if ($groupBy == null) {
                $groupBy = "district_id";
            }

            $setup_area = SetupUserArea::where('division_id', $request->division_id)->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
        }

        if ($request->region_id == "all_zone" || $request->region_id > 0) {
            if ($reportTypeTarget == null) {
                $reportTypeTarget = "employee_district_id";
            }

            if ($groupBy == null) {
                $groupBy = "district_id";
            }
            if ($request->region_id > 0 && count($setup_area) == 0) {
                $setup_area = SetupUserArea::where('region_id', $request->region_id)->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
            }
        }

        if (count($setup_area) == 0) {
            $setup_area = SetupUserArea::groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
        }

        if ($groupBy == "district_id") {
            $areas   = District::select('id', 'name')->whereIn('id', $setup_area)->orderBy('id', "ASC")->get();
            $area_id = District::select('id', 'name')->whereIn('id', $setup_area)->orderBy('id', "ASC")->pluck('id')->toArray();
        }

        if ($groupBy == "upazila_id") {
            $areas   = Upazila::select('id', 'name')->whereIn('id', $setup_area)->orderBy('id', "ASC")->get();
            $area_id = Upazila::select('id', 'name')->whereIn('id', $setup_area)->orderBy('id', "ASC")->pluck('id')->toArray();
        }
        // dd($reportTypeTarget,$area_id);

        $direct_services = SurvivorCourtCaseModel::with(['selpincident' => function ($query) use ($areas, $area_id, $reportTypeTarget) {
            $query->whereIn($reportTypeTarget, $area_id);
            $query->where('status', 2);
        }])
            ->select('id', 'selp_incident_information_id', 'selp_incident_ref', 'court_case_id', 'case_type', 'no_of_case_participants_benefited', 'moneyrecover_case_id')
            ->whereNotNull('court_case_id')
            ->whereNotNull('case_type')
            ->whereNotNull('moneyrecover_case_id')
            ->whereBetween('case_start_date', [$from_date, $to_date])
            ->get();

        //dd($direct_services->toArray());
        // return count($direct_services);

        // $adrs           =   AlternativeDisputeResolution::select('id','title')->whereNotIn('id', [7,9,10])->orderBy('id', "ASC")->get();
        $civilCase    = Civilcase::select('id', 'title')->orderBy('id', "ASC")->get();
        $policeCase   = Policecase::select('id', 'title')->orderBy('id', "ASC")->get();
        $pititionCase = Pititioncase::select('id', 'title')->orderBy('id', "ASC")->get();
        $moneyRecover = Moneyrecover::select('id', 'title')->whereNotIn('id', [11])->orderBy('id', "ASC")->get();

        // dd($adrs->toArray());

        $pdata = array('informations_civil_case' => [], 'informations_police_case' => [], 'informations_petition_case' => []);

        // For Civil Case
        foreach ($moneyRecover as $key => $money) {
            if (!isset($pdata['informations_civil_case'][$money->title])) {
                $pdata['informations_civil_case'][$money->title] = array();
            }
            foreach ($civilCase as $key => $adr) {
                if (!isset($pdata['informations_civil_case'][$money->title][$adr->title])) {
                    $pdata['informations_civil_case'][$money->title][$adr->title] = 0;
                }
                foreach ($direct_services as $key => $services) {
                    if ($services->selpincident != null && $services->case_type == 1) {
                        if ($services->court_case_id == $adr->id && $services->moneyrecover_case_id == $money->id) {
                            $pdata['informations_civil_case'][$money->title][$adr->title] += 1;
                        } else {
                            $pdata['informations_civil_case'][$money->title][$adr->title] += 0;
                        }
                    }
                }
            }
        }

        // For Police Case
        foreach ($moneyRecover as $key => $money) {
            if (!isset($pdata['informations_police_case'][$money->title])) {
                $pdata['informations_police_case'][$money->title] = array();
            }
            foreach ($policeCase as $key => $adr) {
                if (!isset($pdata['informations_police_case'][$money->title][$adr->title])) {
                    $pdata['informations_police_case'][$money->title][$adr->title] = 0;
                }
                foreach ($direct_services as $key => $services) {
                    if ($services->selpincident != null && $services->case_type == 2) {
                        if ($services->court_case_id == $adr->id && $services->moneyrecover_case_id == $money->id) {
                            $pdata['informations_police_case'][$money->title][$adr->title] += 1;
                        } else {
                            $pdata['informations_police_case'][$money->title][$adr->title] += 0;
                        }
                    }
                }
            }
        }

        // For Pitition Case
        foreach ($moneyRecover as $key => $money) {
            if (!isset($pdata['informations_petition_case'][$money->title])) {
                $pdata['informations_petition_case'][$money->title] = array();
            }
            foreach ($pititionCase as $key => $adr) {
                if (!isset($pdata['informations_petition_case'][$money->title][$adr->title])) {
                    $pdata['informations_petition_case'][$money->title][$adr->title] = 0;
                }
                foreach ($direct_services as $key => $services) {
                    if ($services->selpincident != null && $services->case_type == 3) {
                        if ($services->court_case_id == $adr->id && $services->moneyrecover_case_id == $money->id) {
                            $pdata['informations_petition_case'][$money->title][$adr->title] += 1;
                        } else {
                            $pdata['informations_petition_case'][$money->title][$adr->title] += 0;
                        }
                    }
                }
            }
        }
        // dd($pdata['informations_civil_case']);
        // dd($pdata['informations_police_case']);
        // dd($pdata['informations_petition_case']);

        $pdata['region']       = ($request->region_id != "all_zone") ? Region::where('id', $request->region_id)->pluck('region_name')->first() : "All";
        $pdata['division']     = ($request->division_id != null) ? Division::where('id', $request->division_id)->pluck('name')->first() : "";
        $pdata['district']     = ($request->district_id != "all_district") ? District::where('id', $request->district_id)->pluck('name')->first() : "All";
        $pdata['upazila']      = ($request->upazila_id != "all_upazila") ? Upazila::where('id', $request->upazila_id)->pluck('name')->first() : "All";
        $pdata['date']         = date('d-M-Y');
        $pdata['from_date']    = date('d-M-Y', strtotime($request->from_date));
        $pdata['to_date']      = date('d-M-Y', strtotime($request->to_date));
        $pdata['civilCase']    = $civilCase;
        $pdata['policeCase']   = $policeCase;
        $pdata['pititionCase'] = $pititionCase;

        // if (!@$pdata['informations']) {
        //     return redirect()->back()->with('error', "There is no data entry found in this search criteria");
        // }

        if ($request->format_download == 1) {
            // $pdf = PDF::loadView('backend.report.pdf.disability_report', $pdata);
            $pdf = PDF::loadView('selp.pdf.selp_court_case_report_pdf', $pdata, [], ['title' => 'Certificate', 'format' => 'A4-L', 'orientation' => 'L']);
            $pdf->SetProtection(['copy', 'print'], '', 'pass');
            return $pdf->stream('selp_case_status_wise_report.pdf');
        } else {
            $view_link = 'selp.excel.selp_court_case_report_excel';
            return Excel::download(new MisReportExport($pdata, $view_link), 'selp_case_status_wise_report.xlsx');
        }
    }

    public function courtCaseCompletedReportGenerate(Request $request)
    {
        ini_set('memory_limit', -1);
        // dd($request->toArray());
        $from_date        = date('Y-m-d', strtotime($request->from_date));
        $to_date          = date('Y-m-d', strtotime($request->to_date));
        $where[]          = ['status', 2];
        $wherein          = [];
        $setup_area       = [];
        $reportTypeTarget = null;
        $groupBy          = null;

        if ($request->upazila_id == "all_upazila" || $request->upazila_id > 0) {
            $reportTypeTarget = "employee_upazila_id";
            $groupBy          = 'upazila_id';
            if ($request->upazila_id > 0) {
                $setup_area = SetupUserArea::withTrashed()->where('upazila_id', $request->upazila_id)->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
            }
        }
        if ($request->district_id == "all_district" || $request->district_id > 0) {

            if ($reportTypeTarget == null) {
                $reportTypeTarget = "employee_district_id";
            }

            if ($groupBy == null) {
                $groupBy = "district_id";
            }
            if ($request->district_id > 0 && count($setup_area) == 0) {
                $setup_area = SetupUserArea::withTrashed()->where('district_id', $request->district_id)->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
            }
        }

        if ($request->division_id > 0 && count($setup_area) == 0) {
            if ($reportTypeTarget == null) {
                $reportTypeTarget = "employee_district_id";
            }
            if ($groupBy == null) {
                $groupBy = "district_id";
            }

            $setup_area = SetupUserArea::withTrashed()->where('division_id', $request->division_id)->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
        }

        if ($request->region_id == "all_zone" || $request->region_id > 0) {
            if ($reportTypeTarget == null) {
                $reportTypeTarget = "employee_district_id";
            }

            if ($groupBy == null) {
                $groupBy = "district_id";
            }
            if ($request->region_id > 0 && count($setup_area) == 0) {
                $setup_area = SetupUserArea::withTrashed()->where('region_id', $request->region_id)->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
            }
        }

        if (count($setup_area) == 0) {
            $setup_area = SetupUserArea::withTrashed()->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
        }

        if ($groupBy == "district_id") {
            $areas   = District::select('id', 'name')->whereIn('id', $setup_area)->orderBy('id', "ASC")->get();
            $area_id = District::select('id', 'name')->whereIn('id', $setup_area)->orderBy('id', "ASC")->pluck('id')->toArray();
        }

        if ($groupBy == "upazila_id") {
            $areas   = Upazila::select('id', 'name')->whereIn('id', $setup_area)->orderBy('id', "ASC")->get();
            $area_id = Upazila::select('id', 'name')->whereIn('id', $setup_area)->orderBy('id', "ASC")->pluck('id')->toArray();
        }
        // dd($reportTypeTarget,$area_id);

        /*
            ## Query Info Based on Database ##

            Case Type : 1(Civil cases)
            Court Case ID : 23(Judgment), 34(Installment)

            Case Type : 2(GR/Police Case)
            Court Case ID : 22(Judgment), 36(Installment)

            Case Type : 3(CR/Petition Case)
            Court Case ID : 26(Judgment), 29(Installment)

        */

        $courtcase_info = SurvivorCourtCaseModel::with(['selpincident' => function ($query) use ($areas, $area_id, $reportTypeTarget) {
            $query->whereIn($reportTypeTarget, $area_id);
            $query->where('status', 2);
        }])
            ->select('id', 'selp_incident_information_id', 'selp_incident_ref', 'case_type', 'amount_of_money_received', 'no_of_case_participants_benefited', 'moneyrecover_case_id', 'judjementstatus_id', 'court_case_id', 'case_judjement_date')
            ->where(function ($query) use ($from_date, $to_date) {
                $query->whereNotNull('case_type')
                    ->whereNotNull('moneyrecover_case_id')
                    ->whereNotNull('judjementstatus_id')
                    ->whereNotNull('case_judjement_date')
                    ->whereBetween('case_judjement_date', [$from_date, $to_date])
                    ->where(function ($query) use ($from_date, $to_date) {
                        $query->whereIn('court_case_id', [23, 34])
                            ->where('case_type', 1)
                            ->orWhere(function ($query) use ($from_date, $to_date) {
                                $query->whereIn('court_case_id', [22, 36])
                                    ->where('case_type', 2);
                            })
                            ->orWhere(function ($query) use ($from_date, $to_date) {
                                $query->whereIn('court_case_id', [26, 29])
                                    ->where('case_type', 3);
                            });
                    });
            })
            //->groupBy('selp_incident_information_id')
            //->orderBy('selp_incident_information_id', 'asc')
            ->get();

        //dd($courtcase_info->toArray());

        // return  count($courtcase_info);

        // $adrs           =   AlternativeDisputeResolution::select('id','title')->whereNotIn('id', [7,9,10])->orderBy('id', "ASC")->get();
        $judgementStatus = Judgementstatus::select('id', 'title')->orderBy('id', "ASC")->get();
        $civilCase       = Civilcase::select('id', 'title')->orderBy('id', "ASC")->get();
        $policeCase      = Policecase::select('id', 'title')->orderBy('id', "ASC")->get();
        $pititionCase    = Pititioncase::select('id', 'title')->orderBy('id', "ASC")->get();
        $moneyRecover    = Moneyrecover::select('id', 'title')->whereNotIn('id', [11])->orderBy('id', "ASC")->get();

        // dd($moneyRecover->toArray());

        $pdata = array('informations' => [], 'informations_police_case' => [], 'informations_petition_case' => []);

        foreach ($moneyRecover as $key => $money) {
            foreach ($judgementStatus as $key => $status) {
                if (!isset($pdata['informations'][$money->title][$status->title])) {
                    $pdata['informations'][$money->title][$status->title] = 0;
                }
                if (!isset($pdata['informations_police_case'][$money->title][$status->title])) {
                    $pdata['informations_police_case'][$money->title][$status->title] = 0;
                }
                if (!isset($pdata['informations_petition_case'][$money->title][$status->title])) {
                    $pdata['informations_petition_case'][$money->title][$status->title] = 0;
                }

                if (!isset($pdata['informations'][$money->title][$status->id]['Amount of Money Received'])) {
                    $pdata['informations'][$money->title][$status->id]['Amount of Money Received'] = 0;
                }
                if (!isset($pdata['informations_police_case'][$money->title][$status->id]['Amount of Money Received'])) {
                    $pdata['informations_police_case'][$money->title][$status->id]['Amount of Money Received'] = 0;
                }
                if (!isset($pdata['informations_petition_case'][$money->title][$status->id]['Amount of Money Received'])) {
                    $pdata['informations_petition_case'][$money->title][$status->id]['Amount of Money Received'] = 0;
                }

                if (!isset($pdata['informations'][$money->title][$status->id]['No. of participants benefited'])) {
                    $pdata['informations'][$money->title][$status->id]['No. of participants benefited'] = 0;
                }
                if (!isset($pdata['informations_police_case'][$money->title][$status->id]['No. of participants benefited'])) {
                    $pdata['informations_police_case'][$money->title][$status->id]['No. of participants benefited'] = 0;
                }
                if (!isset($pdata['informations_petition_case'][$money->title][$status->id]['No. of participants benefited'])) {
                    $pdata['informations_petition_case'][$money->title][$status->id]['No. of participants benefited'] = 0;
                }
                foreach ($courtcase_info as $key => $info) {
                    if ($info->selpincident != null) {
                        if ($info->case_type == 1) {
                            if ($info->moneyrecover_case_id == $money->id && $info->judjementstatus_id == $status->id) {
                                $pdata['informations'][$money->title][$status->title] += 1;
                                $pdata['informations'][$money->title][$status->id]['Amount of Money Received'] += $info->amount_of_money_received;
                                $pdata['informations'][$money->title][$status->id]['No. of participants benefited'] += $info->no_of_case_participants_benefited;
                            } else {
                                $pdata['informations'][$money->title][$status->title] += 0;
                            }
                        }
                        if ($info->case_type == 2) {
                            if ($info->moneyrecover_case_id == $money->id && $info->judjementstatus_id == $status->id) {
                                $pdata['informations_police_case'][$money->title][$status->title] += 1;
                                $pdata['informations_police_case'][$money->title][$status->id]['Amount of Money Received'] += $info->amount_of_money_received;
                                $pdata['informations_police_case'][$money->title][$status->id]['No. of participants benefited'] += $info->no_of_case_participants_benefited;
                            } else {
                                $pdata['informations_police_case'][$money->title][$status->title] += 0;
                            }
                        }
                        if ($info->case_type == 3) {
                            if ($info->moneyrecover_case_id == $money->id && $info->judjementstatus_id == $status->id) {
                                $pdata['informations_petition_case'][$money->title][$status->title] += 1;
                                $pdata['informations_petition_case'][$money->title][$status->id]['Amount of Money Received'] += $info->amount_of_money_received;
                                $pdata['informations_petition_case'][$money->title][$status->id]['No. of participants benefited'] += $info->no_of_case_participants_benefited;
                            } else {
                                $pdata['informations_petition_case'][$money->title][$status->title] += 0;
                            }
                        }
                    }
                }
            }
        }
        // dd($pdata['informations']);
        // dd($pdata['informations_police_case']);
        // dd($pdata['informations_petition_case']);

        $pdata['region']          = ($request->region_id != "all_zone") ? Region::where('id', $request->region_id)->pluck('region_name')->first() : "All";
        $pdata['division']        = ($request->division_id != null) ? Division::where('id', $request->division_id)->pluck('name')->first() : "";
        $pdata['district']        = ($request->district_id != "all_district") ? District::where('id', $request->district_id)->pluck('name')->first() : "All";
        $pdata['upazila']         = ($request->upazila_id != "all_upazila") ? Upazila::where('id', $request->upazila_id)->pluck('name')->first() : "All";
        $pdata['date']            = date('d-M-Y');
        $pdata['from_date']       = date('d-M-Y', strtotime($request->from_date));
        $pdata['to_date']         = date('d-M-Y', strtotime($request->to_date));
        $pdata['civilCase']       = $civilCase;
        $pdata['policeCase']      = $policeCase;
        $pdata['pititionCase']    = $pititionCase;
        $pdata['judgementStatus'] = $judgementStatus;

        // if (!@$pdata['informations']) {
        //     return redirect()->back()->with('error', "There is no data entry found in this search criteria");
        // }

        if ($request->format_download == 1) {
            // $pdf = PDF::loadView('backend.report.pdf.disability_report', $pdata);
            $pdf = PDF::loadView('selp.pdf.selp_court_case_completed_report_pdf', $pdata, [], ['title' => 'Certificate', 'format' => 'A4-L', 'orientation' => 'L']);
            $pdf->SetProtection(['copy', 'print'], '', 'pass');
            return $pdf->stream('selp_case_status_wise_report.pdf');
        } else {
            $view_link = 'selp.excel.selp_court_case_completed_report_excel';
            return Excel::download(new MisReportExport($pdata, $view_link), 'selp_court_case_completed_report.xlsx');
        }
    }

    // courtCaseFileToJudgementTotalDay

    public function courtCaseFileToJudgementTotalDay(Request $request)
    {

        ini_set('memory_limit', -1);
        $pdata['title']     = "Case field to Judgement Total Day";
        $from_date          = date('Y-m-d', strtotime($request->from_date));
        $to_date            = date('Y-m-d', strtotime($request->to_date));
        $where[]            = ['status', 2];
        $wherein            = [];
        $setup_area         = [];
        $reportTypeTarget   = null;
        $groupBy            = null;


        /* This query does not meet user area-wise data. */

        // if ($request->upazila_id == "all_upazila" || $request->upazila_id > 0) {
        //     $reportTypeTarget = "employee_upazila_id";
        //     $groupBy          = 'upazila_id';
        //     if ($request->upazila_id > 0) {
        //         $setup_area = SetupUserArea::withTrashed()->where('upazila_id', $request->upazila_id)->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
        //     }
        // }
        // if ($request->district_id == "all_district" || $request->district_id > 0) {

        //     if ($reportTypeTarget == null) {
        //         $reportTypeTarget = "employee_district_id";
        //     }

        //     if ($groupBy == null) {
        //         $groupBy = "district_id";
        //     }
        //     if ($request->district_id > 0 && count($setup_area) == 0) {
        //         $setup_area = SetupUserArea::withTrashed()->where('district_id', $request->district_id)->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
        //     }
        // }

        // if ($request->division_id > 0 && count($setup_area) == 0) {
        //     if ($reportTypeTarget == null) {
        //         $reportTypeTarget = "employee_district_id";
        //     }
        //     if ($groupBy == null) {
        //         $groupBy = "district_id";
        //     }

        //     $setup_area = SetupUserArea::withTrashed()->where('division_id', $request->division_id)->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
        // }

        // if ($request->region_id == "all_zone" || $request->region_id > 0) {
        //     if ($reportTypeTarget == null) {
        //         $reportTypeTarget = "employee_district_id";
        //     }

        //     if ($groupBy == null) {
        //         $groupBy = "district_id";
        //     }
        //     if ($request->region_id > 0 && count($setup_area) == 0) {
        //         $setup_area = SetupUserArea::withTrashed()->where('region_id', $request->region_id)->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
        //     }
        // }

        // if (count($setup_area) == 0) {
        //     $setup_area = SetupUserArea::withTrashed()->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
        // }

        // if ($groupBy == "district_id") {
        //     $areas   = District::select('id', 'name')->whereIn('id', $setup_area)->orderBy('id', "ASC")->get();
        //     $area_id = District::select('id', 'name')->whereIn('id', $setup_area)->orderBy('id', "ASC")->pluck('id')->toArray();
        // }

        // if ($groupBy == "upazila_id") {
        //     $areas   = Upazila::select('id', 'name')->whereIn('id', $setup_area)->orderBy('id', "ASC")->get();
        //     $area_id = Upazila::select('id', 'name')->whereIn('id', $setup_area)->orderBy('id', "ASC")->pluck('id')->toArray();
        // }

        $indicent_data = $this->SelpIncidentQuery($request)
            ->join('survivor_court_cases', 'survivor_court_cases.selp_incident_information_id', '=', 'selp_incident_informations.id')
            ->select('selp_incident_informations.id', 'survivor_court_cases.case_start_date', 'survivor_court_cases.court_case_id', 'survivor_court_cases.case_judjement_date', 'survivor_court_cases.case_type')
            ->whereIn('court_case_id', [16, 35, 28, 23, 22, 26])
            ->whereBetween('posting_date', [$from_date, $to_date])
            ->orderBy('id', 'desc')
            ->where('status', 2)
            ->get();

        $datas = $indicent_data->groupBy('id');
        // $newArr = [];
        // foreach($datas as $key=>$data){
        //     if(count($data)> 1){
        //         $newArr[$key] = $data->groupBy('case_type');
        //     }
        // }
        $pdata['indicent_data'] = [];
        foreach ($datas as $key => $data) {
            if (count($data) > 0) {
                $groupTypes = $data->groupBy('case_type');
                $clo = "";
                $str = "";
                $type = 0;
                foreach ($groupTypes as $keyGroup => $groupType) {
                    foreach ($groupType as $d) {
                        if (($d->court_case_id == 23 || $d->court_case_id == 22 || $d->court_case_id == 26) && $d->case_judjement_date != null) {
                            $clo = $d->case_judjement_date;
                            $type = $d->case_type;
                        } elseif (($d->court_case_id == 16 || $d->court_case_id == 35 || $d->court_case_id == 28) && $d->case_start_date != null) {
                            $str = $d->case_start_date;
                            $type = $d->case_type;
                        }
                    }
    
                    $start = $str ? Carbon::createFromFormat('Y-m-d', $str) : null;
                    $close = $clo ? Carbon::createFromFormat('Y-m-d', $clo) : null;

                    if ($start != null && $close != null) {
                        $pdata['indicent_data'][$key][$keyGroup]['start_date'] = $start;
                        $pdata['indicent_data'][$key][$keyGroup]['close_date'] = $close;
                        $pdata['indicent_data'][$key][$keyGroup]['day'] = $start->diffInDays($close);
                        $pdata['indicent_data'][$key][$keyGroup]['type'] = $type == 1 ? "Civil cases" : ($type == 2 ? "GR/Police Case" : "CR/Petition Case");
                    }
                }
            }
        }
        // return $pdata['indicent_data'];

        // $pdata['indicent_data'] = [];
        // foreach($datas as $key => $data){
        //     if(count($data)> 1){
        //         $clo = "";
        //         $str = "";
        //         $type = 0;
        //         foreach($data as $d){

        //             if(($d->court_case_id == 23 || $d->court_case_id == 22 || $d->court_case_id == 26) && $d->case_judjement_date != null){
        //                 $clo = $d->case_judjement_date;
        //                 $type = $d->case_type;
        //             }elseif(($d->court_case_id == 16 || $d->court_case_id == 35 || $d->court_case_id == 28) && $d->case_start_date !=null){
        //                 $str = $d->case_start_date;
        //                 $type = $d->case_type;
        //             }
        //         }

        //         $start = $str ? Carbon::createFromFormat('Y-m-d', $str): null;
        //         $close = $clo ? Carbon::createFromFormat('Y-m-d', $clo) : null; 

        //         // $pdata['indicent_data'][$key]['start_date'] = $start;
        //         // $pdata['indicent_data'][$key]['close_date'] = $close;
        //         if($start != null && $close !=null){
        //             $pdata['indicent_data'][$key]['start_date'] = $start;
        //             $pdata['indicent_data'][$key]['close_date'] = $close;
        //             $pdata['indicent_data'][$key]['day'] = $start->diffInDays($close);
        //             $pdata['indicent_data'][$key]['type'] = $type == 1 ? "Civil cases" : ($type == 2 ? "GR/Police Case" : "CR/Petition Case");

        //         }
        //     }
        // }

        $pdata['region']    = ($request->region_id != "all_zone") ? Region::where('id', $request->region_id)->pluck('region_name')->first() : "All";
        $pdata['division']  = ($request->division_id != null) ? Division::where('id', $request->division_id)->pluck('name')->first() : "";
        $pdata['district']  = ($request->district_id != "all_district") ? District::where('id', $request->district_id)->pluck('name')->first() : "All";
        $pdata['upazila']   = ($request->upazila_id != "all_upazila") ? Upazila::where('id', $request->upazila_id)->pluck('name')->first() : "All";
        $pdata['date']      = date('d-M-Y');
        $pdata['from_date'] = date('d-M-Y', strtotime($request->from_date));
        $pdata['to_date']   = date('d-M-Y', strtotime($request->to_date));


        if ($request->format_download == 1) {
            $pdf = PDF::loadView('selp.pdf.selp_court_case_day_count_report_pdf', $pdata, [], ['title' => 'Certificate', 'format' => 'A4-L', 'orientation' => 'L']);
            $pdf->SetProtection(['copy', 'print'], '', 'pass');
            return $pdf->stream('selp_adr_day_count_report.pdf');
        } else {
            $view_link = 'selp.excel.selp_court_case_day_count_report_ex';
            return Excel::download(new MisReportExport($pdata, $view_link), 'court_case_field_to_judgement_day_count_report.xlsx');
        }
    }
}
