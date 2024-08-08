<?php

namespace App\Http\Controllers\Backend;

use App\Exports\MisReportExport;
use App\Http\Controllers\Controller;
use App\Model\Admin\Incident\SurvivorBracSupport;
use App\Model\Admin\Incident\SurvivorIncidentInformation;
use App\Model\Admin\Incident\SurvivorOtherOrganizationSupport;
use App\Model\Admin\Setup\CEP_Region\Region;
use App\Model\Admin\Setup\CEP_Region\RegionAreaDetail;
use App\Model\Admin\Setup\District;
use App\Model\Admin\Setup\Division;
use App\Model\Admin\Setup\Gender;
use App\Model\Admin\Setup\OtherOrganizationSupport;
use App\Model\Admin\Setup\SurvivorFinalSupport;
use App\Model\Admin\Setup\SurvivorSupportName;
use App\Model\Admin\Setup\SurvivorSupportOrganization;
use App\Model\Admin\Setup\Union;
use App\Model\Admin\Setup\Upazila;
use App\Model\Admin\Setup\Village;
use App\Model\Admin\Setup\ViolenceCategory;
use App\Model\Admin\Setup\ViolenceName;
use App\Model\Admin\Setup\ViolenceReason;
use App\Model\Admin\Setup\ViolenceSubCategory;
use Illuminate\Http\Request;
use PDF;
use Session;

class ReportController extends Controller
{
    public function adminSupportReport()
    {
        $data['violence_categories']    = ViolenceCategory::where('status','1')->get();
        $data['regions']                = Region::where('status','1')->get();
        $data['organization_types']     = SurvivorSupportOrganization::where('status','1')->get();
        $data['survivor_final_support'] = SurvivorFinalSupport::where('status','1')->orderBy('survivor_support_organization_id', 'asc')->get();
        return view('backend.report.admin_support_report_view', $data);
    }

    public function adminSupportReportPdf(Request $request)
    {
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
            $allDivision = RegionAreaDetail::where('region_id',$request->region_id)->where('status','1')->groupBy('division_id')->pluck('division_id')->toArray();
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
            // dd($survivor_infos->pluck('id')->toArray());

            $survivor_supports = SurvivorBracSupport::with(['survivor_incident_information'])
            ->whereHas('survivor_incident_information',function($q) use($where,$survivor_infos){
                $q->where($where)->whereIn('employee_district_id',$wherein)->whereIn('id',$survivor_infos->pluck('id'));
            })
            ->whereBetween('survivor_support_date', [$from_date, $to_date])
            ->where('survivor_final_support_id','!=','null')
            ->get();
        } else {
            $survivor_infos = SurvivorIncidentInformation::where($where)->whereBetween('created_at', [$from_date.' 00:00:00',$to_date.' 23:59:59'])->get();
            // dd($survivor_infos->pluck('id')->toArray());

            $survivor_supports = SurvivorBracSupport::with(['survivor_incident_information'])
            ->whereHas('survivor_incident_information',function($q) use($where,$survivor_infos){
                $q->where($where)->whereIn('id',$survivor_infos->pluck('id'));
            })
            ->whereBetween('survivor_support_date', [$from_date, $to_date])
            ->where('survivor_final_support_id','!=','null')
            ->get();
        }

        // dd($survivor_supports->toArray());


        if ($request->support_all == 1) {
            $supports = SurvivorFinalSupport::select('id','name')->where('survivor_support_organization_id', $request->survivor_support_organization_id)->orderBy('id', "ASC")->get();
        } else {
            $supports = SurvivorFinalSupport::select('id','name')->where('survivor_support_organization_id', $request->survivor_support_organization_id)->where('id', $request->support_id)->orderBy('id', "ASC")->get();
        }
        $violences = ViolenceCategory::select('id','name')->orderBy('id', "ASC")->get();
        // dd($supports->toArray());


        foreach ($survivor_supports as $key => $survivor_support) {
            foreach ($supports as $support_key => $support) {
                foreach ($violences as $violence_key => $violence) {
                    $pdata['informations']['support'][$support->id]['name'] = $support->name;
                    $pdata['informations']['support'][$support->id]['violence'][$violence->id]['name'] = $violence->name;
                }
            }
        }


        foreach ($survivor_supports as $key => $survivor_support) {
            if(@$survivor_support['survivor_final_support_id'] && $survivor_support['survivor_incident_information']['violence_category_id']){
                @$pdata['informations']['support'][$survivor_support['survivor_final_support_id']]['violence'][$survivor_support['survivor_incident_information']['violence_category_id']]['count'] += 1;
            }
        }

        // echo "<pre>";
        // print_r($pdata['informations']); die();






        // foreach ($survivor_infos as $survivor_key => $survivor_info) {
        //     foreach ($sources as $source_key => $source) {
        //         foreach ($violences as $violence_key => $violence) {
        //             $pdata['informations']['source'][$source->id]['name'] = $source->name;
        //             $pdata['informations']['source'][$source->id]['violence'][$violence->id]['name'] = $violence->name;
        //             if ($survivor_info->violence_reason_id == $source->id && $survivor_info->violence_category_id == $violence->id) {
        //                 @$pdata['informations']['source'][$source->id]['violence'][$violence->id]['count'] += 1;
        //             }else{
        //                 @$pdata['informations']['source'][$source->id]['violence'][$violence->id]['count'] += 0;
        //             }
        //         }
        //     }
        // }
        // echo "<pre>";
        // print_r($pdata['informations']); die();
        if (!@$pdata['informations']) {
            return redirect()->back()->with('error', "There is no data entry found in this search criteria");
        }
        $pdata['region']     = Region::where('id', $request->region_id)->first();
        $pdata['division']   = Division::where('id', $request->division_id)->first();
        $pdata['district']   = District::where('id', $request->ditrict_id)->first();
        $pdata['upazila']    = Upazila::where('id', $request->upazila_id)->first();
        $pdata['gender']    = Gender::where('id', $request->gender_id)->first();
        $pdata['date']       = date('Y-m-d');
        $pdata['from_date'] = date('Y-m-d', strtotime($request->from_date));
        $pdata['to_date'] = date('Y-m-d', strtotime($request->to_date));
        // dd($region);
        // return view('backend.report.pdf.reason_report',$pdata);
        if ($request->format_download == 1) {
            // $pdf = PDF::loadView('backend.report.pdf.reason_report', $pdata);
            $pdf = PDF::loadView('backend.report.pdf.admin-support', $pdata,[],['title' => 'Certificate','format' => 'A4-L','orientation' => 'L']);
            $pdf->SetProtection(['copy', 'print'], '', 'pass');
            return $pdf->stream('document.pdf');
        } else {
            $view_link = 'backend.report.excel.reason-report-excel';
            return Excel::download(new MisReportExport($pdata,$view_link), 'reason_report.xlsx');
        }
    }
}
