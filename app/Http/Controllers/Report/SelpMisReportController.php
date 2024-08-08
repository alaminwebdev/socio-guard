<?php

namespace App\Http\Controllers\Report;

use PDF;
use App\User;
use Carbon\Carbon;
use App\Model\Education;
use Illuminate\Http\Request;
use App\Model\Setup\Refferal;
use App\Exports\MisReportExport;
use App\Model\SelpIncidentModel;
use App\Model\Admin\Setup\Gender;
use App\Model\Admin\Setup\Upazila;
use App\Model\Admin\Setup\District;
use App\Model\Admin\Setup\Division;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Model\Admin\Setup\Occupation;
use App\Model\SurvivorDirectServiceModel;
use App\Model\Admin\Setup\OrganizationName;
use App\Model\Admin\Setup\ViolenceCategory;
use App\Model\Admin\Setup\CEP_Region\Region;
use App\Model\Admin\Setup\CEP_Region\SetupUserArea;
use App\Model\Admin\Setup\SurvivorAutisticInformation;
use Illuminate\Support\Facades\Auth;

class SelpMisReportController extends Controller {

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

    public function misReportView() {
        $data['platform']  = OrganizationName::where('status', 1)->get();
        $data['regions']   = getRegionByUserType();
        $data['autistics'] = SurvivorAutisticInformation::where('status', '1')->get();
        $data['genders']   = Gender::all();
        $data['auth_user'] = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        // dd($platform->toArray());
        return view('selp.view.selp_mis_report_view', $data);
    }

    public function misReportGenerate(Request $request) {
        // dd($request->toArray());
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
        // dd($area_id);
        $survivor_infos = SelpIncidentModel::select('id', 'violence_reason_id', 'employee_district_id', 'employee_upazila_id')
            ->whereIn($reportTypeTarget, $area_id)
            ->where($where)
            ->whereNotNull('violence_reason_id')
            ->whereBetween('posting_date', [$from_date, $to_date])
            ->get();

            
        $violences = ViolenceCategory::select('id', 'name')->orderBy('id', "ASC")->get();


        foreach ($survivor_infos as $survivor_key => $survivor_info) {
            foreach ($areas as $source_key => $source) {
                foreach ($violences as $violence_key => $violence) {
                    
                    $pdata['informations']['source'][$source->id]['name']                            = $source->name;
                    $pdata['informations']['source'][$source->id]['violence'][$violence->id]['name'] = $violence->name;

                    if ($request->upazila_id == "all_upazila" || !empty($request->upazila_id)) {
                        
                        if ($survivor_info->employee_upazila_id == $source->id && $survivor_info->violence_reason_id == $violence->id) {
                            @$pdata['informations']['source'][$source->id]['violence'][$violence->id]['count'] += 1;
                        } else {
                            @$pdata['informations']['source'][$source->id]['violence'][$violence->id]['count'] += 0;
                        }
                    } else {
                        
                        if ($survivor_info->employee_district_id == $source->id && $survivor_info->violence_reason_id == $violence->id) {
                            @$pdata['informations']['source'][$source->id]['violence'][$violence->id]['count'] += 1;
                        } else {
                            @$pdata['informations']['source'][$source->id]['violence'][$violence->id]['count'] += 0;
                        }
                        
                    }
                    
                }
            }

        
        }
        
        
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
            $pdf = PDF::loadView('selp.pdf.selp_mis_report_pdf', $pdata, [], ['title' => 'Certificate', 'format' => 'A4-L', 'orientation' => 'L']);
            $pdf->SetProtection(['copy', 'print'], '', 'pass');
            return $pdf->stream('document.pdf');
        } else {
            $view_link = 'selp.excel.selp_mis_report_excel';
            return Excel::download(new MisReportExport($pdata, $view_link), 'selp_mis_report.xlsx');
        }
    }

    //Education Wise
    public function educationWiseViolenceReportGenerate(Request $request) {
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

        $educations = Education::select('id', 'title')->orderBy('id', "ASC")->get();
        $violences  = ViolenceCategory::select('id', 'name')->orderBy('id', "ASC")->get();

        foreach ($educations as $district_key => $education) {
            foreach ($violences as $violence_key => $violence) {
                $pdata['informations']['education'][$education->id]['title']                                      = $education->title;
                $pdata['informations']['education'][$education->id]['violence'][$violence->id]['name']            = $violence->name;
                $pdata['informations']['education'][$education->id]['violence'][$violence->id]['age']['0-17']     = SelpIncidentModel::select('id', 'violence_reason_id', 'defendant_education_id', 'main_defendant_age')->whereIn($reportTypeTarget, $area_id)->where('defendant_education_id', $education->id)->where('violence_reason_id', $violence->id)->whereIn('main_defendant_age', range(0, 17))->where($where)->whereNotNull('violence_reason_id')->whereBetween('posting_date', [$from_date, $to_date])->count();
                $pdata['informations']['education'][$education->id]['violence'][$violence->id]['age']['18-25']    = SelpIncidentModel::select('id', 'violence_reason_id', 'defendant_education_id', 'main_defendant_age')->whereIn($reportTypeTarget, $area_id)->where('defendant_education_id', $education->id)->where('violence_reason_id', $violence->id)->whereIn('main_defendant_age', range(18, 25))->where($where)->whereNotNull('violence_reason_id')->whereBetween('posting_date', [$from_date, $to_date])->count();
                $pdata['informations']['education'][$education->id]['violence'][$violence->id]['age']['26-35']    = SelpIncidentModel::select('id', 'violence_reason_id', 'defendant_education_id', 'main_defendant_age')->whereIn($reportTypeTarget, $area_id)->where('defendant_education_id', $education->id)->where('violence_reason_id', $violence->id)->whereIn('main_defendant_age', range(26, 35))->where($where)->whereNotNull('violence_reason_id')->whereBetween('posting_date', [$from_date, $to_date])->count();
                $pdata['informations']['education'][$education->id]['violence'][$violence->id]['age']['36-45']    = SelpIncidentModel::select('id', 'violence_reason_id', 'defendant_education_id', 'main_defendant_age')->whereIn($reportTypeTarget, $area_id)->where('defendant_education_id', $education->id)->where('violence_reason_id', $violence->id)->whereIn('main_defendant_age', range(36, 45))->where($where)->whereNotNull('violence_reason_id')->whereBetween('posting_date', [$from_date, $to_date])->count();
                $pdata['informations']['education'][$education->id]['violence'][$violence->id]['age']['46-above'] = SelpIncidentModel::select('id', 'violence_reason_id', 'defendant_education_id', 'main_defendant_age')->whereIn($reportTypeTarget, $area_id)->where('defendant_education_id', $education->id)->where('violence_reason_id', $violence->id)->whereIn('main_defendant_age', range(46, 200))->where($where)->whereNotNull('violence_reason_id')->whereBetween('posting_date', [$from_date, $to_date])->count();
            }
        }
        // dd($pdata['informations']);

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
        // dd(gettype($pdata['violence']));

        if (!@$pdata['informations']) {
            return redirect()->back()->with('error', "There is no data entry found in this search criteria");
        }

        if ($request->format_download == 1) {
            // return view('selp.pdf.selp_age_wise_report_pdf', $pdata);
            $pdf = PDF::loadView('selp.pdf.selp_education_wise_violence_report_pdf', $pdata, [], ['title' => 'Certificate', 'format' => 'A4-L', 'orientation' => 'L']);
            $pdf->SetProtection(['copy', 'print'], '', 'pass');
            return $pdf->stream('document.pdf');
        } else {
            $view_link = 'selp.excel.selp_education_wise_violence_report_excel';
            return Excel::download(new MisReportExport($pdata, $view_link), 'selp_education_wise_violence_report.xlsx');
        }
    }

    //Occupation Wise
    public function occupationWiseViolenceReportGenerate(Request $request) {
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

        $occupations = Occupation::select('id', 'name')->orderBy('id', "ASC")->get();
        $violences   = ViolenceCategory::select('id', 'name')->orderBy('id', "ASC")->get();

        foreach ($occupations as $district_key => $occupation) {
            foreach ($violences as $violence_key => $violence) {
                $pdata['informations']['occupation'][$occupation->id]['name']                                       = $occupation->name;
                $pdata['informations']['occupation'][$occupation->id]['violence'][$violence->id]['name']            = $violence->name;
                $pdata['informations']['occupation'][$occupation->id]['violence'][$violence->id]['age']['0-17']     = SelpIncidentModel::select('id', 'violence_reason_id', 'defendant_occupation_id', 'main_defendant_age')->whereIn($reportTypeTarget, $area_id)->where('defendant_occupation_id', $occupation->id)->where('violence_reason_id', $violence->id)->whereIn('main_defendant_age', range(0, 17))->where($where)->whereNotNull('violence_reason_id')->whereBetween('posting_date', [$from_date, $to_date])->count();
                $pdata['informations']['occupation'][$occupation->id]['violence'][$violence->id]['age']['18-25']    = SelpIncidentModel::select('id', 'violence_reason_id', 'defendant_occupation_id', 'main_defendant_age')->whereIn($reportTypeTarget, $area_id)->where('defendant_occupation_id', $occupation->id)->where('violence_reason_id', $violence->id)->whereIn('main_defendant_age', range(18, 25))->where($where)->whereNotNull('violence_reason_id')->whereBetween('posting_date', [$from_date, $to_date])->count();
                $pdata['informations']['occupation'][$occupation->id]['violence'][$violence->id]['age']['26-35']    = SelpIncidentModel::select('id', 'violence_reason_id', 'defendant_occupation_id', 'main_defendant_age')->whereIn($reportTypeTarget, $area_id)->where('defendant_occupation_id', $occupation->id)->where('violence_reason_id', $violence->id)->whereIn('main_defendant_age', range(26, 35))->where($where)->whereNotNull('violence_reason_id')->whereBetween('posting_date', [$from_date, $to_date])->count();
                $pdata['informations']['occupation'][$occupation->id]['violence'][$violence->id]['age']['36-45']    = SelpIncidentModel::select('id', 'violence_reason_id', 'defendant_occupation_id', 'main_defendant_age')->whereIn($reportTypeTarget, $area_id)->where('defendant_occupation_id', $occupation->id)->where('violence_reason_id', $violence->id)->whereIn('main_defendant_age', range(36, 45))->where($where)->whereNotNull('violence_reason_id')->whereBetween('posting_date', [$from_date, $to_date])->count();
                $pdata['informations']['occupation'][$occupation->id]['violence'][$violence->id]['age']['46-above'] = SelpIncidentModel::select('id', 'violence_reason_id', 'defendant_occupation_id', 'main_defendant_age')->whereIn($reportTypeTarget, $area_id)->where('defendant_occupation_id', $occupation->id)->where('violence_reason_id', $violence->id)->whereIn('main_defendant_age', range(46, 200))->where($where)->whereNotNull('violence_reason_id')->whereBetween('posting_date', [$from_date, $to_date])->count();
            }
        }
        // dd($pdata['informations']);

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
        // dd(gettype($pdata['violence']));

        if (!@$pdata['informations']) {
            return redirect()->back()->with('error', "There is no data entry found in this search criteria");
        }

        if ($request->format_download == 1) {
            // return view('selp.pdf.selp_age_wise_report_pdf', $pdata);
            $pdf = PDF::loadView('selp.pdf.selp_occupation_wise_violence_report_pdf', $pdata, [], ['title' => 'Certificate', 'format' => 'A4-L', 'orientation' => 'L']);
            $pdf->SetProtection(['copy', 'print'], '', 'pass');
            return $pdf->stream('document.pdf');
        } else {
            $view_link = 'selp.excel.selp_occupation_wise_violence_report_excel';
            return Excel::download(new MisReportExport($pdata, $view_link), 'selp_occupation_wise_violence_report.xlsx');
        }
    }

    //Referrel Wise

    public function referrelReportGenerate(Request $request) {
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

        // $survivor_infos     = SelpIncidentModel::select('id', 'violence_reason_id' , 'employee_district_id', 'employee_upazila_id')
        //                     ->whereIn($reportTypeTarget,$area_id)
        //                     ->where($where)
        //                     ->whereNotNull('violence_reason_id')
        //                     ->whereBetween('posting_date', [$from_date,$to_date])
        //                     ->get();
        // dd($survivor_infos->toArray());

        $refferel_to = Refferal::select('id', 'name')->orderBy('id', "ASC")->get();

        foreach ($areas as $area_key => $area) {
            foreach ($refferel_to as $referral_key => $referral) {
                $pdata['informations']['area'][$area->id]['name']                    = $area->name;
                $pdata['informations']['area'][$area->id]['refferel'][$referral_key] = SelpIncidentModel::select('id', 'employee_district_id', 'employee_upazila_id', 'referral')->where($reportTypeTarget, $area->id)->where('referral', $referral->id)->where($where)->whereNotNull('violence_reason_id')->whereBetween('posting_date', [$from_date, $to_date])->count();
            }
        }
        // dd($pdata['informations']);
        $pdata['region']      = ($request->region_id != "all_zone") ? Region::where('id', $request->region_id)->pluck('region_name')->first() : "All";
        $pdata['division']    = ($request->division_id != null) ? Division::where('id', $request->division_id)->pluck('name')->first() : "";
        $pdata['district']    = ($request->district_id != "all_district") ? District::where('id', $request->district_id)->pluck('name')->first() : "All";
        $pdata['upazila']     = ($request->upazila_id != "all_upazila") ? Upazila::where('id', $request->upazila_id)->pluck('name')->first() : "All";
        $pdata['date']        = date('d-M-Y');
        $pdata['from_date']   = date('d-M-Y', strtotime($request->from_date));
        $pdata['to_date']     = date('d-M-Y', strtotime($request->to_date));
        $pdata['refferel_to'] = $refferel_to;

        if (!@$pdata['informations']) {
            return redirect()->back()->with('error', "There is no data entry found in this search criteria");
        }

        if ($request->format_download == 1) {
            // $pdf = PDF::loadView('backend.report.pdf.disability_report', $pdata);
            $pdf = PDF::loadView('selp.pdf.selp_refferel_report_pdf', $pdata, [], ['title' => 'Certificate', 'format' => 'A4-L', 'orientation' => 'L']);
            $pdf->SetProtection(['copy', 'print'], '', 'pass');
            return $pdf->stream('document.pdf');
        } else {
            $view_link = 'selp.excel.selp_refferel_report_excel';
            return Excel::download(new MisReportExport($pdata, $view_link), 'selp_refferel_report.xlsx');
        }
    }

    public function genderWiseViolenceReportGenerate(Request $request) {
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

        $districts = District::select('id', 'name')->orderBy('id', "ASC")->get();
        $violences = ViolenceCategory::select('id', 'name')->orderBy('id', "ASC")->get();
        $genders   = Gender::select('id', 'name')->orderBy('id', "ASC")->get();

        foreach ($areas as $district_key => $district) {
            foreach ($violences as $violence_key => $violence) {
                foreach ($genders as $gender_key => $gender) {
                    $pdata['informations']['district'][$district->id]['name']                                           = $district->name;
                    $pdata['informations']['district'][$district->id]['violence'][$violence->id]['name']                = $violence->name;
                    $pdata['informations']['district'][$district->id]['violence'][$violence->id]['gender'][$gender_key] = SelpIncidentModel::select('id', 'violence_place_id', 'employee_district_id', 'employee_upazila_id', 'survivor_gender_id')->where($reportTypeTarget, $district->id)->where('violence_reason_id', $violence->id)->where('survivor_gender_id', $gender->id)->where($where)->whereNotNull('violence_reason_id')->whereBetween('posting_date', [$from_date, $to_date])->count();
                    // dd($pdata['informations']);
                }
            }
        }

        //return $pdata['informations'];

        // $rtm =   SelpIncidentModel::select('id', 'violence_place_id' , 'employee_district_id')->where('employee_district_id',1)->where('violence_reason_id',$violence->id)->where('violence_place_id', $place->id)->where($where)->whereNotNull('violence_reason_id')->whereBetween('created_at', [$from_date.' 00:00:00',$to_date.' 23:59:59'])->count();
        // dd($pdata['informations']);

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
        $pdata['violence_place'] = $genders;
        // dd(gettype($pdata['violence']));

        if (!@$pdata['informations']) {
            return redirect()->back()->with('error', "There is no data entry found in this search criteria");
        }

        if ($request->format_download == 1) {
            // return view('selp.pdf.selp_place_wise_violence_report_pdf', $pdata);
            $pdf = PDF::loadView('selp.pdf.selp_gender_wise_violence_report_pdf', $pdata, [], ['title' => 'Certificate', 'format' => 'A4-L', 'orientation' => 'L']);
            $pdf->SetProtection(['copy', 'print'], '', 'pass');
            return $pdf->stream('document.pdf');
        } else {
            $view_link = 'selp.excel.selp_gender_wise_violence_report_excel';
            return Excel::download(new MisReportExport($pdata, $view_link), 'selp_gender_wise_violence_report.xlsx');
        }
    }

    public function allIncidentReportGenerate(Request $request) {
       
        ini_set('memory_limit', -1);
        // dd($request->all());
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

        // $pdata  =   SelpIncidentModel::all();
        $pdata['indicent_data'] = SelpIncidentModel::with(['direct_services', 'direct_support_adr', 'direct_service_followup', 'direct_service_courtcase', 'survivor_referral'])
            ->whereIn($reportTypeTarget, $area_id)
            ->where($where)
            ->whereBetween('posting_date', [$from_date, $to_date])
            ->orderBy('id', 'desc')
            ->get();

        //    return count($pdata['indicent_data']);
        // $pdata['indicent_data']     =   SelpIncidentModel::whereBetween('posting_date', [$from_date,$to_date])->where('status', 2)->count();
        // dd($pdata['indicent_data']);

        // $rtm =   SelpIncidentModel::select('id', 'violence_place_id' , 'employee_district_id')->where('employee_district_id',1)->where('violence_reason_id',$violence->id)->where('violence_place_id', $place->id)->where($where)->whereNotNull('violence_reason_id')->whereBetween('created_at', [$from_date.' 00:00:00',$to_date.' 23:59:59'])->count();
        // dd($pdata['indicent_data']->toArray());

        // echo "<pre>";
        // print_r($pdata['informations']); die();
        $pdata['region']    = ($request->region_id != "all_zone") ? Region::where('id', $request->region_id)->pluck('region_name')->first() : "All";
        $pdata['division']  = ($request->division_id != null) ? Division::where('id', $request->division_id)->pluck('name')->first() : "";
        $pdata['district']  = ($request->district_id != "all_district") ? District::where('id', $request->district_id)->pluck('name')->first() : "All";
        $pdata['upazila']   = ($request->upazila_id != "all_upazila") ? Upazila::where('id', $request->upazila_id)->pluck('name')->first() : "All";
        $pdata['date']      = date('d-M-Y');
        $pdata['from_date'] = date('d-M-Y', strtotime($request->from_date));
        $pdata['to_date']   = date('d-M-Y', strtotime($request->to_date));
        // dd(gettype($pdata['violence']));

        // if (!@$pdata['informations']) {
        //     return redirect()->back()->with('error', "There is no data entry found in this search criteria");
        // }
        // return view('selp.excel.selp_all_incident_report_excel',$pdata);
        // $view_link = 'selp.excel.selp_all_incident_report_excel';
        // return Excel::download(new MisReportExport($pdata,$view_link), 'selp_all_incident_report_excel.xlsx');
        // if ($request->format_download == 1) {
        //     // return view('selp.pdf.selp_place_wise_violence_report_pdf', $pdata);
        //     $pdf = PDF::loadView('selp.pdf.selp_gender_wise_violence_report_pdf', $pdata,[],['title' => 'Certificate','format' => 'A4-L','orientation' => 'L']);
        //     $pdf->SetProtection(['copy', 'print'], '', 'pass');
        //     return $pdf->stream('document.pdf');
        // } else {
        // }

        if ($request->format_download == 1) {
            return redirect()->back()->with('error', "This Report Can not be generate in PDF format");
        } else {

            $view_link = 'selp.excel.selp_all_incident_report_excel';

            return Excel::download(new MisReportExport($pdata, $view_link), 'selp_all_incident_report_excel.xlsx');
        }
    }
    public function adrCompletedDayCont(Request $request) {
        ini_set('memory_limit', -1);
        $pdata['title'] = "ADR Completed with decesion Total Day Count";
        $from_date        = date('Y-m-d', strtotime($request->from_date));
        $to_date          = date('Y-m-d', strtotime($request->to_date));
        $where[]          = ['status', 2];
        $wherein          = [];
        $setup_area       = [];
        $reportTypeTarget = null;
        $groupBy          = null;

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
        

        $indicent_data = $this->SelpIncidentQuery($request)->join('survivor_direct_services', 'survivor_direct_services.selp_incident_information_id', '=', 'selp_incident_informations.id')
            ->select('selp_incident_informations.id', 'status',  'survivor_direct_services.alternative_dispute_resolution_id', 'survivor_direct_services.closing_date', 'survivor_direct_services.starting_date')
            ->whereIn('alternative_dispute_resolution_id', [1,7, 9])
            ->whereBetween('posting_date', [$from_date, $to_date])
            ->orderBy('id','desc')
            ->where('status', 2)
            ->get();

            $datas = $indicent_data->groupBy('id');
        
            $pdata['indicent_data_count'] = [];
            foreach($datas as $key => $data){
                if(count($data)> 1){
                    $clo = "";
                    $str = "";
                    foreach($data as $d){
                        
                        if(($d->alternative_dispute_resolution_id == 7 || $d->alternative_dispute_resolution_id == 9) && $d->closing_date){
                            $clo = $d->closing_date;
                        }elseif($d->alternative_dispute_resolution_id == 1 && $d->starting_date){
                            $str = $d->starting_date;
                        }
                    }

                    $start = $str ? Carbon::createFromFormat('Y-m-d', $str): null;
                    $close = $clo ? Carbon::createFromFormat('Y-m-d', $clo) : null; 
                
                    if($start != null && $close !=null){
                        $pdata['indicent_data_count'][$key]['close_date'] = $close;
                        $pdata['indicent_data_count'][$key]['start_date'] = $start;
                        $pdata['indicent_data_count'][$key]['day'] = $start->diffInDays($close);
                    }
                }
            }

        $pdata['region']    = ($request->region_id != "all_zone") ? Region::where('id', $request->region_id)->pluck('region_name')->first() : "All";
        $pdata['division']  = ($request->division_id != null) ? Division::where('id', $request->division_id)->pluck('name')->first() : "";
        $pdata['district']  = ($request->district_id != "all_district") ? District::where('id', $request->district_id)->pluck('name')->first() : "All";
        $pdata['upazila']   = ($request->upazila_id != "all_upazila") ? Upazila::where('id', $request->upazila_id)->pluck('name')->first() : "All";
        $pdata['date']      = date('d-M-Y');
        $pdata['from_date'] = date('d-M-Y', strtotime($request->from_date));
        $pdata['to_date']   = date('d-M-Y', strtotime($request->to_date));
       
        if ($request->format_download == 1) {
            $pdf = PDF::loadView('selp.pdf.selp_adr_day_count_report_pdf', $pdata, [], ['title' => 'Certificate', 'format' => 'A4-L', 'orientation' => 'L']);
            $pdf->SetProtection(['copy', 'print'], '', 'pass');
            return $pdf->stream('selp_adr_day_count_report.pdf');
        } else {
            $view_link = 'selp.excel.selp_adr_day_count_report_ex';
            return Excel::download(new MisReportExport($pdata, $view_link), 'selp_adr_day_Count_report.xlsx');
        }
    }
}
