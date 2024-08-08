<?php

namespace App\Http\Controllers\Report;

use PDF;
use App\Model\Civilcase;
use Illuminate\Http\Request;
use App\Model\Adrmoneyrecover;
use App\Model\Judgementstatus;
use App\Exports\MisReportExport;
use App\Model\SelpIncidentModel;
use App\Model\Admin\Setup\Upazila;
use Illuminate\Support\Facades\DB;
use App\Model\Admin\Setup\District;
use App\Model\Admin\Setup\Division;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Model\SurvivorCourtCaseModel;
use App\Model\SurvivorDirectServiceModel;
use App\Model\AlternativeDisputeResolution;
use App\Model\Admin\Setup\CEP_Region\Region;
use App\Model\Admin\Setup\CEP_Region\SetupUserArea;
use App\Model\Admin\Setup\CEP_Region\RegionAreaDetail;
use App\User;
use Illuminate\Support\Facades\Auth;

class SelpADRReportController extends Controller
{

    public function SelpIncidentQuery($request)
    {
        $query = SelpIncidentModel::query();
        if ($request->region_id && $request->region_id != "all_zone") {
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
    public function adrReportGenerate(Request $request)
    {
        ini_set('memory_limit', -1);
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

        $direct_services = SurvivorDirectServiceModel::with(['incident_district' => function ($query) use ($areas, $area_id, $reportTypeTarget) {
            $query->whereIn($reportTypeTarget, $area_id);
            $query->where('status', 2);
        }])->select('id', 'selp_incident_ref', 'alternative_dispute_resolution_id')
            ->whereNotNull('alternative_dispute_resolution_id')
            ->whereBetween('starting_date', [$from_date, $to_date])
            ->get();
        // dd($direct_services->toArray());

        $adrs = AlternativeDisputeResolution::select('id', 'title')->orderBy('id', "ASC")->get();

        foreach ($direct_services as $survivor_key => $direct_services) {
            foreach ($areas as $source_key => $source) {
                foreach ($adrs as $violence_key => $adr) {
                    $pdata['informations']['source'][$source->id]['name']                   = $source->name;
                    $pdata['informations']['source'][$source->id]['adr'][$adr->id]['title'] = $adr->title;
                    if ($request->upazila_id == "all_upazila" || $request->upazila_id > 0) {
                        if (@$direct_services->incident_district->employee_upazila_id == $source->id && $direct_services->alternative_dispute_resolution_id == $adr->id) {
                            @$pdata['informations']['source'][$source->id]['adr'][$adr->id]['count'] += 1;
                        } else {
                            @$pdata['informations']['source'][$source->id]['adr'][$adr->id]['count'] += 0;
                        }
                    } else {
                        if (@$direct_services->incident_district->employee_district_id == $source->id && $direct_services->alternative_dispute_resolution_id == $adr->id) {
                            @$pdata['informations']['source'][$source->id]['adr'][$adr->id]['count'] += 1;
                        } else {
                            @$pdata['informations']['source'][$source->id]['adr'][$adr->id]['count'] += 0;
                        }
                    }
                }
            }
        }
        // dd($pdata['informations']);

        $pdata['region']    = ($request->region_id != "all_zone") ? Region::where('id', $request->region_id)->pluck('region_name')->first() : "All";
        $pdata['division']  = ($request->division_id != null) ? Division::where('id', $request->division_id)->pluck('name')->first() : "";
        $pdata['district']  = ($request->district_id != "all_district") ? District::where('id', $request->district_id)->pluck('name')->first() : "All";
        $pdata['upazila']   = ($request->upazila_id != "all_upazila") ? Upazila::where('id', $request->upazila_id)->pluck('name')->first() : "All";
        $pdata['date']      = date('d-M-Y');
        $pdata['from_date'] = date('d-M-Y', strtotime($request->from_date));
        $pdata['to_date']   = date('d-M-Y', strtotime($request->to_date));

        if (!@$pdata['informations']) {
            return redirect()->back()->with('error', "There is no data entry found in this search criteria");
        }

        if ($request->format_download == 1) {
            // $pdf = PDF::loadView('backend.report.pdf.disability_report', $pdata);
            $pdf = PDF::loadView('selp.pdf.selp_adr_wise_report_pdf', $pdata, [], ['title' => 'Certificate', 'format' => 'A4-L', 'orientation' => 'L']);
            $pdf->SetProtection(['copy', 'print'], '', 'pass');
            return $pdf->stream('document.pdf');
        } else {
            $view_link = 'selp.excel.selp_adr_report_excel';
            return Excel::download(new MisReportExport($pdata, $view_link), 'selp_adr_report_excel.xlsx');
        }
    }

    public function courtcaseReportGenerate(Request $request)
    {
        ini_set('memory_limit', -1);
        // dd($request->toArray());
        $from_date = date('Y-m-d', strtotime($request->from_date));
        $to_date   = date('Y-m-d', strtotime($request->to_date));
        $where[]   = '';
        $wherein   = [];

        if (!empty($request->region_id) && empty($request->division_id)) {
            //Only Region
            $allDistrict = RegionAreaDetail::where('region_id', $request->region_id)->where('status', '1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein     = $allDistrict;
        } elseif (!empty($request->region_id) && !empty($request->division_id) && empty($request->district_id)) {
            //Region and Division
            $allDivision = RegionAreaDetail::where('region_id', $request->region_id)->where('status', '1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein     = $allDivision;
        } else {
            //District and Upazila
            if ($request->district_id) {
                $where[] = ['employee_district_id', '=', $request->district_id];
            }
            if ($request->upazila_id) {
                $where[] = ['employee_upazila_id', '=', $request->upazila_id];
            }
        }

        // if ($wherein != null) {
        //     $survivor_infos = SelpIncidentModel::select('id', 'violence_reason_id' , 'employee_district_id', 'survivor_age')->where($where)->whereNotNull('violence_reason_id')->whereIn('employee_district_id',$wherein)->whereBetween('created_at', [$from_date.' 00:00:00',$to_date.' 23:59:59'])->get();
        // } else {
        //     $survivor_infos = SelpIncidentModel::select('id', 'violence_reason_id' , 'employee_district_id', 'survivor_age')->where($where)->whereNotNull('violence_reason_id')->whereBetween('created_at', [$from_date.' 00:00:00',$to_date.' 23:59:59'])->get();
        // }

        // dd($survivor_infos->toArray());

        $districts = District::select('id', 'name')->orderBy('id', "ASC")->get();
        // $court_cases         = SurvivorCourtCaseModel::select('id','name')->orderBy('id', "ASC")->get();
        $court_cases       = Civilcase::select('id', 'title')->orderBy('id', "ASC")->get();
        $judgementstatuses = Judgementstatus::select('id', 'title')->orderBy('id', "ASC")->get();

        foreach ($districts as $district_key => $district) {
            foreach ($court_cases as $violence_key => $court_case) {
                foreach ($judgementstatuses as $place_key => $place) {
                    $pdata['informations']['district'][$district->id]['name']                                                 = $district->name;
                    $pdata['informations']['district'][$district->id]['court_case'][$court_case->id]['title']                 = $court_case->title;
                    $pdata['informations']['district'][$district->id]['court_case'][$court_case->id]['judgement'][$place_key] =
                        SurvivorCourtCaseModel::with(['incident_district:selp_incident_ref,employee_district_id'])
                        ->select('id', 'court_case_id', 'civil_case_id', 'policecase_case_id', 'judjementstatus_id')
                        // ->where('employee_district_id',$district->id)
                        ->where('court_case_id', $court_case->id)
                        ->where('judjementstatus_id', $place->id)
                        // ->where($where)
                        ->whereNotNull('case_type')
                        ->whereBetween('created_at', [$from_date . ' 00:00:00', $to_date . ' 23:59:59'])
                        ->count();
                    // dd($pdata['informations']);
                }
            }
        }

        // $rtm =   SelpIncidentModel::select('id', 'violence_place_id' , 'employee_district_id')->where('employee_district_id',1)->where('violence_reason_id',$violence->id)->where('violence_place_id', $place->id)->where($where)->whereNotNull('violence_reason_id')->whereBetween('created_at', [$from_date.' 00:00:00',$to_date.' 23:59:59'])->count();
        //dd($pdata['informations']);

        // echo "<pre>";
        // print_r($pdata['informations']); die();
        $pdata['region']         = ($request->region_id != "all_zone") ? Region::where('id', $request->region_id)->pluck('region_name')->first() : "All";
        $pdata['division']       = ($request->division_id != null) ? Division::where('id', $request->division_id)->pluck('name')->first() : "";
        $pdata['district']       = ($request->district_id != "all_district") ? District::where('id', $request->district_id)->pluck('name')->first() : "All";
        $pdata['upazila']        = ($request->upazila_id != "all_upazila") ? Upazila::where('id', $request->upazila_id)->pluck('name')->first() : "All";
        $pdata['date']           = date('d-M-Y');
        $pdata['from_date']      = date('d-M-Y', strtotime($request->from_date));
        $pdata['to_date']        = date('d-M-Y', strtotime($request->to_date));
        $pdata['violence_count'] = count($violences);
        $pdata['violence_place'] = $violence_place;
        // dd(gettype($pdata['violence']));

        if (!@$pdata['informations']) {
            return redirect()->back()->with('error', "There is no data entry found in this search criteria");
        }

        if ($request->format_download == 1) {
            // return view('selp.pdf.selp_place_wise_violence_report_pdf', $pdata);
            $pdf = PDF::loadView('selp.pdf.selp_place_wise_violence_report_pdf', $pdata, [], ['title' => 'Certificate', 'format' => 'A4-L', 'orientation' => 'L']);
            $pdf->SetProtection(['copy', 'print'], '', 'pass');
            return $pdf->stream('document.pdf');
        } else {
            $view_link = 'selp.excel.selp_place_wise_violence_report_excel';
            return Excel::download(new MisReportExport($pdata, $view_link), 'selp_place_wise_violence_report.xlsx');
        }
    }

    public function adrInitiativesReportGenerate(Request $request)
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

        $direct_services = SurvivorDirectServiceModel::with(['incident_district' => function ($query) use ($areas, $area_id, $reportTypeTarget) {
            $query->whereIn($reportTypeTarget, $area_id);
            $query->where('status', 2);
        }])
            ->select('id', 'selp_incident_information_id', 'selp_incident_ref', 'alternative_dispute_resolution_id', 'money_recovered_through_adr')
            ->whereNotNull('alternative_dispute_resolution_id')
            ->whereNotNull('money_recovered_through_adr')
            ->whereBetween('starting_date', [$from_date, $to_date])
            ->get();
        // dd($direct_services->toArray());

        $adrs         = AlternativeDisputeResolution::select('id', 'title')->whereNotIn('id', [7, 9, 10, 11])->orderBy('id', "ASC")->get();
        $moneyRecover = Adrmoneyrecover::select('id', 'title')->whereNotIn('id', [1])->orderBy('id', "ASC")->get();
        $pdata        = array('informations' => []);

        foreach ($moneyRecover as $key => $money) {
            if (!isset($pdata['informations'][$money->title])) {
                $pdata['informations'][$money->title] = array();
            }
            foreach ($adrs as $key => $adr) {
                if (!isset($pdata['informations'][$money->title][$adr->title])) {
                    $pdata['informations'][$money->title][$adr->title] = 0;
                }
                foreach ($direct_services as $key => $services) {
                    if ($services->incident_district != null) {
                        if ($services->alternative_dispute_resolution_id == $adr->id && $services->money_recovered_through_adr == $money->id) {
                            $pdata['informations'][$money->title][$adr->title] += 1;
                        } else {
                            $pdata['informations'][$money->title][$adr->title] += 0;
                        }
                    }
                }
            }
        }
        // dd($pdata['informations']);

        $pdata['region']    = ($request->region_id != "all_zone") ? Region::where('id', $request->region_id)->pluck('region_name')->first() : "All";
        $pdata['division']  = ($request->division_id != null) ? Division::where('id', $request->division_id)->pluck('name')->first() : "";
        $pdata['district']  = ($request->district_id != "all_district") ? District::where('id', $request->district_id)->pluck('name')->first() : "All";
        $pdata['upazila']   = ($request->upazila_id != "all_upazila") ? Upazila::where('id', $request->upazila_id)->pluck('name')->first() : "All";
        $pdata['date']      = date('d-M-Y');
        $pdata['from_date'] = date('d-M-Y', strtotime($request->from_date));
        $pdata['to_date']   = date('d-M-Y', strtotime($request->to_date));
        $pdata['adrs']      = $adrs;

        // if (!@$pdata['informations']) {
        //     return redirect()->back()->with('error', "There is no data entry found in this search criteria");
        // }

        if ($request->format_download == 1) {
            // $pdf = PDF::loadView('backend.report.pdf.disability_report', $pdata);
            $pdf = PDF::loadView('selp.pdf.selp_adr_initiatives_report_pdf', $pdata, [], ['title' => 'Certificate', 'format' => 'A4-L', 'orientation' => 'L']);
            $pdf->SetProtection(['copy', 'print'], '', 'pass');
            return $pdf->stream('selp_adr_initiatives_report.pdf');
        } else {
            $view_link = 'selp.excel.selp_adr_initiatives_report_excel';
            return Excel::download(new MisReportExport($pdata, $view_link), 'selp_adr_initiatives_report.xlsx');
        }
    }

    public function adrCompletedReportGenerate(Request $request)
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

        // data with SelpIncidentModel and  survivordirectservice  check by sajal
        // $test_data = SelpIncidentModel::whereHas('survivordirectservice', function ($q) use ($from_date, $to_date) {
        //     $q->where('alternative_dispute_resolution_id', 10)
        //         ->where('money_recovered_through_adr', 5)
        //         ->whereBetween('closing_date', [$from_date, $to_date]);
        // })->with('survivordirectservice')->where('employee_pin', "121808")->get();

        // return count($test_data);

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

        // $direct_services = SurvivorDirectServiceModel::with([
        //     'incident_district' => function ($query) use ($areas, $area_id, $reportTypeTarget) {
        //         $query->whereIn($reportTypeTarget, $area_id);
        //         $query->where('status', 2);
        //     }
        // ])
        //     ->select('id', 'selp_incident_information_id', 'selp_incident_ref', 'alternative_dispute_resolution_id', 'money_recovered_through_adr', 'no_of_adr_participants_benefited', 'amount_of_money_received as amount', DB::raw('SUM(amount_of_money_received) as amount_of_money_received'))
        //     ->whereIn('alternative_dispute_resolution_id', [7, 9, 11, 10])
        //     ->whereNotNull('money_recovered_through_adr')
        //     ->whereNotNull('closing_date')
        //     ->whereBetween('closing_date', [$from_date, $to_date])
        //     ->groupBy('selp_incident_information_id')
        //     ->get();

        $direct_services = $this->SelpIncidentQuery($request)->join('survivor_direct_services', 'survivor_direct_services.selp_incident_information_id', '=', 'selp_incident_informations.id')
            ->leftjoin('adrmoneyrecovers', 'survivor_direct_services.money_recovered_through_adr', '=', 'adrmoneyrecovers.id')
            ->select(
                'survivor_direct_services.id',
                'selp_incident_informations.id as selp_incident_information_id',
                'selp_incident_informations.selp_incident_ref',
                'survivor_direct_services.alternative_dispute_resolution_id',
                'survivor_direct_services.money_recovered_through_adr',
                'adrmoneyrecovers.title as purpose',
                'survivor_direct_services.no_of_adr_participants_benefited',
                'survivor_direct_services.amount_of_money_received as amount_of_money_received',
                // DB::raw('SUM(survivor_direct_services.amount_of_money_received) as amount_of_money_received')
            )
            ->whereIn('alternative_dispute_resolution_id', [7, 9, 10, 11])
            // ->whereIn('alternative_dispute_resolution_id', [7, 9, 11])
            ->whereNotNull('money_recovered_through_adr')
            ->whereNotNull('closing_date')
            ->whereBetween('closing_date', [$from_date, $to_date])
            ->where('selp_incident_informations.status', 2)
            ->groupBy(
                // 'selp_incident_informations.id',
                // 'survivor_direct_services.alternative_dispute_resolution_id',
                // 'survivor_direct_services.money_recovered_through_adr',
            )
            ->get();

        $adrs = AlternativeDisputeResolution::select('id', 'title')->whereIn('id', [7, 9, 11, 10])->orderBy('id', "ASC")->get();
        $moneyRecover = Adrmoneyrecover::select('id', 'title')->whereNotIn('id', [1])->orderBy('id', "ASC")->get();
        $pdata        = array('informations' => []);
        $adata        = array('infos' => []);

        // foreach ($moneyRecover as $key => $money) {
        //     if (!isset($pdata['informations'][$money->title])) {
        //         $pdata['informations'][$money->title] = array();
        //     }
        //     foreach ($adrs as $key => $adr) {
        //         if (!isset($pdata['informations'][$money->title][$adr->title])) {
        //             $pdata['informations'][$money->title][$adr->title] = 0;
        //         }
        //         if (!isset($pdata['informations'][$money->title][$adr->id]['Amount of Money Received'])) {
        //             $pdata['informations'][$money->title][$adr->id]['Amount of Money Received'] = 0;
        //         }
        //         if (!isset($pdata['informations'][$money->title][$adr->id]['No. of participants benefited'])) {
        //             $pdata['informations'][$money->title][$adr->id]['No. of participants benefited'] = 0;
        //         }
        //         foreach ($direct_services as $key => $services) {
        //             // if ($services->incident_district != null) {

        //             if ($services->alternative_dispute_resolution_id == $adr->id && $services->money_recovered_through_adr == $money->id) {
        //                 $pdata['informations'][$money->title][$adr->title] += 1;
        //                 $pdata['informations'][$money->title][$adr->id]['Amount of Money Received'] += $services->amount_of_money_received;
        //                 $pdata['informations'][$money->title][$adr->id]['No. of participants benefited'] += $services->no_of_adr_participants_benefited;
        //             } else {
        //                 $pdata['informations'][$money->title][$adr->title] += 0;

        //                 // $pdata['informations'][$money->title][$adr->id]['Amount of Money Received'] = 0;
        //                 // $pdata['informations'][$money->title][$adr->id]['Amount of Money Received'] += $services->amount_of_money_received;

        //             }
        //             // }
        //         }
        //     }
        // }


        foreach ($direct_services as $services) {
            $moneyTitle = $services->purpose;
            $adrTitle   = $services->alternative_dispute_resolution_id;

            if (!isset($pdata['informations'][$moneyTitle])) {
                $pdata['informations'][$moneyTitle] = array();
            }

            if (!isset($pdata['informations'][$moneyTitle][$adrTitle])) {
                $pdata['informations'][$moneyTitle][$adrTitle] = [
                    'count'                         => 0,
                    'Amount of Money Received'      => 0,
                    'No. of participants benefited' => 0,
                    'selp_incident_ids'             => [],
                ];
            }

            // Check if the selp_incident_id is not already counted
            if (!in_array($services->selp_incident_information_id, $pdata['informations'][$moneyTitle][$adrTitle]['selp_incident_ids'])) {
                $pdata['informations'][$moneyTitle][$adrTitle]['count']                 += 1;
                $pdata['informations'][$moneyTitle][$adrTitle]['selp_incident_ids'][]   = $services->selp_incident_information_id;
            }

            // Sum amounts for each unique adr_title
            $pdata['informations'][$moneyTitle][$adrTitle]['Amount of Money Received']      += $services->amount_of_money_received;
            $pdata['informations'][$moneyTitle][$adrTitle]['No. of participants benefited'] += $services->no_of_adr_participants_benefited;
        }

        $pdata['region']    = ($request->region_id != "all_zone") ? Region::where('id', $request->region_id)->pluck('region_name')->first() : "All";
        $pdata['division']  = ($request->division_id != null) ? Division::where('id', $request->division_id)->pluck('name')->first() : "";
        $pdata['district']  = ($request->district_id != "all_district") ? District::where('id', $request->district_id)->pluck('name')->first() : "All";
        $pdata['upazila']   = ($request->upazila_id != "all_upazila") ? Upazila::where('id', $request->upazila_id)->pluck('name')->first() : "All";
        $pdata['date']      = date('d-M-Y');
        $pdata['from_date'] = date('d-M-Y', strtotime($request->from_date));
        $pdata['to_date']   = date('d-M-Y', strtotime($request->to_date));
        $pdata['adrs']      = $adrs;

        // if (!@$pdata['informations']) {
        //     return redirect()->back()->with('error', "There is no data entry found in this search criteria");
        // }

        if ($request->format_download == 1) {
            $pdf = PDF::loadView('selp.pdf.selp_adr_completed_report_pdf', $pdata, [], ['title' => 'Certificate', 'format' => 'A4-L', 'orientation' => 'L']);
            $pdf->SetProtection(['copy', 'print'], '', 'pass');
            return $pdf->stream('selp_adr_completed_report.pdf');
        } else {
            $view_link = 'selp.excel.selp_adr_completed_report_excel';
            return Excel::download(new MisReportExport($pdata, $view_link), 'selp_adr_completed_report.xlsx');
        }
    }

    public function adrCompletedWithAreaReportGenerate(Request $request)
    {
        ini_set('memory_limit', -1);
        //dd($request->toArray());
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

        $direct_services = SurvivorDirectServiceModel::with(['incident_district' => function ($query) use ($areas, $area_id, $reportTypeTarget) {
            $query->whereIn($reportTypeTarget, $area_id);
            $query->where('status', 2);
        }])
            ->select('id', 'selp_incident_information_id', 'selp_incident_ref', 'alternative_dispute_resolution_id', 'money_recovered_through_adr', 'no_of_adr_participants_benefited', 'amount_of_money_received')
            ->whereNotNull('alternative_dispute_resolution_id')
            ->whereNotNull('money_recovered_through_adr')
            ->whereBetween('closing_date', [$from_date, $to_date])
            ->get();
        // dd($direct_services->toArray());

        $adrs         = AlternativeDisputeResolution::select('id', 'title')->whereIn('id', [7, 9, 10, 11])->orderBy('id', "ASC")->get();
        $moneyRecover = Adrmoneyrecover::select('id', 'title')->whereNotIn('id', [1])->orderBy('id', "ASC")->get();
        $pdata        = array('informations' => []);
        $adata        = array('infos' => []);

        foreach ($moneyRecover as $key => $money) {
            if (!isset($pdata['informations'][$money->title])) {
                $pdata['informations'][$money->title] = array();
            }
            foreach ($adrs as $key => $adr) {
                if (!isset($pdata['informations'][$money->title][$adr->title])) {
                    $pdata['informations'][$money->title][$adr->title] = 0;
                }
                if (!isset($pdata['informations'][$money->title][$adr->id]['Amount of Money Received'])) {
                    $pdata['informations'][$money->title][$adr->id]['Amount of Money Received'] = 0;
                }
                if (!isset($pdata['informations'][$money->title][$adr->id]['No. of participants benefited'])) {
                    $pdata['informations'][$money->title][$adr->id]['No. of participants benefited'] = 0;
                }
                foreach ($direct_services as $key => $services) {
                    if ($services->incident_district != null) {
                        // dd($services);
                        if ($services->alternative_dispute_resolution_id == $adr->id && $services->money_recovered_through_adr == $money->id) {
                            $pdata['informations'][$money->title][$adr->title] += 1;
                            $pdata['informations'][$money->title][$adr->id]['Amount of Money Received'] += $services->amount_of_money_received;
                            $pdata['informations'][$money->title][$adr->id]['No. of participants benefited'] += $services->no_of_adr_participants_benefited;
                            // dd("sdsd");
                        } else {
                            // dd($services->amount_of_money_received);
                            $pdata['informations'][$money->title][$adr->title] += 0;

                            // dd("dsf");
                            // $pdata['informations'][$money->title][$adr->id]['Amount of Money Received'] = 0;
                            // $pdata['informations'][$money->title][$adr->id]['Amount of Money Received'] += $services->amount_of_money_received;

                        }
                    }
                }
            }
        }
        // dd($pdata['informations']);

        $pdata['region']    = ($request->region_id != "all_zone") ? Region::where('id', $request->region_id)->pluck('region_name')->first() : "All";
        $pdata['division']  = ($request->division_id != null) ? Division::where('id', $request->division_id)->pluck('name')->first() : "";
        $pdata['district']  = ($request->district_id != "all_district") ? District::where('id', $request->district_id)->pluck('name')->first() : "All";
        $pdata['upazila']   = ($request->upazila_id != "all_upazila") ? Upazila::where('id', $request->upazila_id)->pluck('name')->first() : "All";
        $pdata['date']      = date('d-M-Y');
        $pdata['from_date'] = date('d-M-Y', strtotime($request->from_date));
        $pdata['to_date']   = date('d-M-Y', strtotime($request->to_date));
        $pdata['adrs']      = $adrs;

        // if (!@$pdata['informations']) {
        //     return redirect()->back()->with('error', "There is no data entry found in this search criteria");
        // }

        if ($request->format_download == 1) {
            // $pdf = PDF::loadView('backend.report.pdf.disability_report', $pdata);
            $pdf = PDF::loadView('selp.pdf.selp_adr_completed_report_pdf', $pdata, [], ['title' => 'Certificate', 'format' => 'A4-L', 'orientation' => 'L']);
            $pdf->SetProtection(['copy', 'print'], '', 'pass');
            return $pdf->stream('selp_adr_completed_report.pdf');
        } else {
            $view_link = 'selp.excel.selp_adr_completed_report_excel';
            return Excel::download(new MisReportExport($pdata, $view_link), 'selp_adr_completed_report.xlsx');
        }
    }
}
