<?php

namespace App\Http\Controllers\Backend;

use App\Exports\MisReportExport;
use App\Http\Controllers\Controller;
use App\Model\Admin\Incident\PerpetratorInformation;
use App\Model\Admin\Incident\SurvivorBracSupport;
use App\Model\Admin\Incident\SurvivorIncidentInformation;
use App\Model\Admin\Incident\SurvivorOtherOrganizationSupport;
use App\Model\Admin\Setup\CEP_Region\Region;
use App\Model\Admin\Setup\CEP_Region\RegionAreaDetail;
use App\Model\Admin\Setup\District;
use App\Model\Admin\Setup\Division;
use App\Model\Admin\Setup\EconomicCondition;
use App\Model\Admin\Setup\FamilyMember;
use App\Model\Admin\Setup\Gender;
use App\Model\Admin\Setup\InformationProviderSource;
use App\Model\Admin\Setup\LegelInitiativeReason;
use App\Model\Admin\Setup\MaritalStatus;
use App\Model\Admin\Setup\Occupation;
use App\Model\Admin\Setup\OrganizationName;
use App\Model\Admin\Setup\OrganizationType;
use App\Model\Admin\Setup\OtherOrganizationSupport;
use App\Model\Admin\Setup\PerpetratorPlace;
use App\Model\Admin\Setup\Program;
use App\Model\Admin\Setup\Religion;
use App\Model\Admin\Setup\SocialStatus;
use App\Model\Admin\Setup\SuprvivorInitialSupport;
use App\Model\Admin\Setup\SurvivorAutisticInformation;
use App\Model\Admin\Setup\SurvivorFinalSupport;
use App\Model\Admin\Setup\SurvivorIncidentPlace;
use App\Model\Admin\Setup\SurvivorRelationship;
use App\Model\Admin\Setup\SurvivorSituation;
use App\Model\Admin\Setup\SurvivorSupportName;
use App\Model\Admin\Setup\SurvivorSupportOrganization;
use App\Model\Admin\Setup\SurvivorViolencePlace;
use App\Model\Admin\Setup\Union;
use App\Model\Admin\Setup\Upazila;
use App\Model\Admin\Setup\Village;
use App\Model\Admin\Setup\ViolenceCategory;
use App\Model\Admin\Setup\ViolenceName;
use App\Model\Admin\Setup\ViolenceReason;
use App\Model\Admin\Setup\ViolenceSubCategory;
use App\User;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Session;

class DistrictWiseReportController extends Controller
{
    public function districtWiseReport()
    {
        $data['platform'] = OrganizationName::where('status', 1)->get();
        $data['regions']  = Region::where('status','1')->get();
        $data['reasons'] = ViolenceReason::where('status','1')->get();
        // dd($platform->toArray());
        return view('backend.report.district_wise_report_view', $data);
    }

    public function districtWiseReportPdf(Request $request)
    {
        ini_set('memory_limit', -1);
        // dd($request->toArray());
        $from_date = date('Y-m-d', strtotime($request->from_date));
        $to_date = date('Y-m-d', strtotime($request->to_date));
        $where[] = ['status','=','1'];
        $wherein = [];

        if (!empty($request->region_id) && empty($request->division_id)) {
            //Only Region
            $allDistrict = RegionAreaDetail::where('region_id',$request->region_id)->where('status','1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein = $allDistrict;
        } elseif (!empty($request->region_id) && !empty($request->division_id) && empty($request->district_id)) {
            //Region and Division
            $allDivision = RegionAreaDetail::where('region_id',$request->region_id)->where('status','1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein = $allDivision;
        } else {
            //District and Upazila
            if($request->district_id) {
                $where[] = ['employee_district_id','=',$request->district_id];
            }
            if($request->upazila_id) {
                $where[] = ['employee_upazila_id','=',$request->upazila_id];
            }
        }

        if ($wherein != null) {
            $survivor_infos = SurvivorIncidentInformation::where($where)->whereIn('employee_district_id',$wherein)->whereBetween('created_at', [$from_date.' 00:00:00',$to_date.' 23:59:59'])->get();
        } else {
            $survivor_infos = SurvivorIncidentInformation::where($where)->whereBetween('created_at', [$from_date.' 00:00:00',$to_date.' 23:59:59'])->get();
        }

        // dd($survivor_infos->toArray());

        if ($request->district_all == 1) {
            $sources    = District::select('id','name')->whereHas('region_area')->where('status', 1)->orderBy('id', "ASC")->get();
        } else {
            $allDistrict = RegionAreaDetail::where('region_id',$request->region_id)->where('status','1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein = $allDistrict;
            $sources    = District::select('id','name')->whereIn('id', $wherein)->whereHas('region_area')->where('status', 1)->orderBy('id', "ASC")->get();
        }
        // dd($sources->toArray());
        // $sources    = District::select('id','name')->whereHas('region_area')->where('status', 1)->orderBy('id', "ASC")->get();
        $violences  = ViolenceCategory::select('id','name')->orderBy('id', "ASC")->get();

        // dd($violences->toArray());

        foreach ($survivor_infos as $survivor_key => $survivor_info) {
            foreach ($sources as $source_key => $source) {
                foreach ($violences as $violence_key => $violence) {
                    $pdata['informations']['source'][$source->id]['name'] = $source->name;
                    $pdata['informations']['source'][$source->id]['violence'][$violence->id]['name'] = $violence->name;
                    if ($survivor_info->employee_district_id == $source->id && $survivor_info->violence_category_id == $violence->id) {
                        @$pdata['informations']['source'][$source->id]['violence'][$violence->id]['count'] += 1;
                    }else{
                        @$pdata['informations']['source'][$source->id]['violence'][$violence->id]['count'] += 0;
                    }
                }
            }
        }
        // echo "<pre>";
        // print_r($pdata['informations']); die();
        if (!@$pdata['informations']) {
            return redirect()->back()->with('error', "There is no data entry found in this search criteria");
        }
        $pdata['region']     = Region::where('id', $request->region_id)->first();
        $pdata['division']   = Division::where('id', $request->division_id)->first();
        $pdata['district']   = District::where('id', $request->ditrict_id)->first();
        $pdata['upazila']    = Upazila::where('id', $request->upazila_id)->first();
        $pdata['date']       = date('Y-m-d');
        $pdata['from_date']  = date('Y-m-d', strtotime($request->from_date));
        $pdata['to_date']    = date('Y-m-d', strtotime($request->to_date));

        if ($request->format_download == 1) {
            // $pdf = PDF::loadView('backend.report.pdf.reason_report', $pdata);
            $pdf = PDF::loadView('backend.report.pdf.district_wise_report', $pdata,[],['title' => 'Certificate','format' => 'A4-L','orientation' => 'L']);
            $pdf->SetProtection(['copy', 'print'], '', 'pass');
            return $pdf->stream('document.pdf');
        } else {
            $view_link = 'backend.report.excel.district-wise-report-excel';
            return Excel::download(new MisReportExport($pdata,$view_link), 'district_wise_report.xlsx');
        }
    }
}

