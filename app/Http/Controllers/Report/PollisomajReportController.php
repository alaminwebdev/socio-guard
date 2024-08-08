<?php

namespace App\Http\Controllers\Report;

use App\Exports\MisReportExport;
use App\Http\Controllers\Controller;
use App\Model\Admin\Setup\CEP_Region\Region;
use App\Model\Admin\Setup\District;
use App\Model\Admin\Setup\Division;
use App\Model\Admin\Setup\Gender;
use App\Model\Admin\Setup\OrganizationName;
use App\Model\Admin\Setup\SurvivorAutisticInformation;
use App\Model\Admin\Setup\Upazila;
use App\Model\PollisomajDataModel;
use App\Model\PollisomajSetup;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PollisomajReportController extends Controller {
    public function pollisomajReportView() {
        $data['platform']  = OrganizationName::where('status', 1)->get();
        $data['regions']   = getRegionByUserType();
        $data['autistics'] = SurvivorAutisticInformation::where('status', '1')->get();
        $data['genders']   = Gender::all();
        $data['auth_user'] = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        // dd($platform->toArray());
        return view('selp.view.pollisomajreport.pollisomaj_report', $data);
    }

    public function pollisomajReportExcel(Request $request) {

        ini_set('memory_limit', -1);

        $from_date        = date('Y-m-d', strtotime($request->from_date));
        $to_date          = date('Y-m-d', strtotime($request->to_date));
        $where[]          = ['flag', 2];
        $wherein          = [];
        $setup_area       = [];
        $reportTypeTarget = null;
        $groupBy          = null;
        $label_name       = null;

        if ($request->upazila_id == "all_upazila" || $request->upazila_id > 0) {
            $reportTypeTarget = "upazilla_id";
            $groupBy          = 'upazila_id';
            $label_name       = 'Upazila Name';
            if ($request->upazila_id > 0) {
                // $setup_area = SetupUserArea::where('upazila_id', $request->upazila_id)->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
                $setup_area = PollisomajSetup::withTrashed()->where('upazila_id', $request->upazila_id)->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
            }

        }
        if ($request->district_id == "all_district" || $request->district_id > 0) {

            if ($reportTypeTarget == null) {
                $reportTypeTarget = "district_id";
            }

            if ($label_name == null) {
                $label_name = "District name";
            }

            if ($groupBy == null) {
                $groupBy = "district_id";
            }
            if ($request->district_id > 0 && count($setup_area) == 0) {$setup_area = PollisomajSetup::withTrashed()->where('upazila_id', $request->upazila_id)->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
                // $setup_area = SetupUserArea::where('district_id', $request->district_id)->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
            }
        }

        if ($request->division_id > 0 && count($setup_area) == 0) {
            if ($reportTypeTarget == null) {
                $reportTypeTarget = "district_id";
            }
            if ($groupBy == null) {
                $groupBy = "district_id";
            }

            if ($label_name == null) {
                $label_name = "District name";
            }
            $setup_area = PollisomajSetup::withTrashed()->where('district_id', $request->district_id)->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
            // $setup_area = SetupUserArea::where('division_id', $request->division_id)->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();

        }

        if ($request->region_id == "all_zone" || $request->region_id > 0) {
            if ($reportTypeTarget == null) {
                $reportTypeTarget = "district_id";
            }

            if ($groupBy == null) {
                $groupBy = "district_id";
            }

            if ($label_name == null) {
                $label_name = "District name";
            }
            if ($request->region_id > 0 && count($setup_area) == 0) {
                $setup_area = PollisomajSetup::withTrashed()->where('zone_id', $request->region_id)->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
                //$setup_area = SetupUserArea::where('region_id', $request->region_id)->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
            }

        }

        if (count($setup_area) == 0) {
            $setup_area = PollisomajSetup::withTrashed()->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
            //$setup_area = SetupUserArea::groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
        }

        if ($groupBy == "district_id") {
            $areas   = District::select('id', 'name')->whereIn('id', $setup_area)->orderBy('id', "ASC")->get();
            $area_id = District::select('id', 'name')->whereIn('id', $setup_area)->orderBy('id', "ASC")->pluck('id')->toArray();
        }

        if ($groupBy == "upazila_id") {
            $areas   = Upazila::select('id', 'name')->whereIn('id', $setup_area)->orderBy('id', "ASC")->get();
            $area_id = Upazila::select('id', 'name')->whereIn('id', $setup_area)->orderBy('id', "ASC")->pluck('id')->toArray();
        }

        $pdata = PollisomajDataModel::with(['pollisomaj_info', 'zones', 'division', 'district', 'upazilla', 'union'])
            ->whereIn($reportTypeTarget, $area_id)
            ->where($where)
            ->whereBetween('reporting_date', [$from_date, $to_date])
            ->get()->toArray();
        // dd($pdata);
        $pdata['pollisomaj'] = $pdata;
        $pdata['region']     = ($request->region_id != "all_zone") ? Region::where('id', $request->region_id)->pluck('region_name')->first() : "All";
        $pdata['division']   = ($request->division_id != null) ? Division::where('id', $request->division_id)->pluck('name')->first() : "";
        $pdata['district']   = ($request->district_id != "all_district") ? District::where('id', $request->district_id)->pluck('name')->first() : "All";
        $pdata['upazila']    = ($request->upazila_id != "all_upazila") ? Upazila::where('id', $request->upazila_id)->pluck('name')->first() : "All";
        $pdata['date']       = date('d-M-Y');
        $pdata['from_date']  = date('d-M-Y', strtotime($request->from_date));
        $pdata['to_date']    = date('d-M-Y', strtotime($request->to_date));

        if ($request->format_download == 1) {
            return redirect()->back()->with('error', "This Report Can not be generate in PDF format");
        } else {
            $view_link = 'backend.report.excel.pollisomaj-filter-data';
            return Excel::download(new MisReportExport($pdata, $view_link), 'pollisomaj-data.xlsx');
        }
    }
}
