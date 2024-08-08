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

class SourceReportController extends Controller
{
    public function sourceReport()
    {
        $data['platform'] = OrganizationName::where('status', 1)->get();
        $data['regions']  = Region::where('status','1')->get();
        $data['sources'] = InformationProviderSource::where('status','1')->get();
        // dd($platform->toArray());
        return view('backend.report.source_report_view', $data);
    }

    public function sourceReportPdf(Request $request)
    {
        // dd($request->toArray());
        $from_date = date('Y-m-d', strtotime($request->from_date));
        $to_date = date('Y-m-d', strtotime($request->to_date));
        $where[] = ['status','=','1'];
        $wherein = [];

        $params = [
            'from_date' => $from_date,
            'to_date' =>$to_date,
        ];

        if ($request->source_all == 1) {
            $data = InformationProviderSource::with(['survivor_incident_information' => function($query){
                $query->with(['survivor_gender']);
            }]);
        } else {
            $data = InformationProviderSource::where('id', $request->source_id)->with(['survivor_incident_information' => function($query) use($params) {
                $query->with(['survivor_gender']);
            }]);
        }

        $incidents = $data->get();
        // dd($incidents->toArray());

        // if($request->region_all != 1){
        //     $allDistrict = RegionAreaDetail::where('region_id',$request->region_id)->where('status','1')->groupBy('district_id')->pluck('district_id')->toArray();
        //     $wherein = $allDistrict;
        // }else{
        //     $allDistrict = RegionAreaDetail::where('status','1')->groupBy('district_id')->pluck('district_id')->toArray();
        //     $wherein = $allDistrict;
        // }

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
        // if($request->division_id !=''){
        //     $where[] = ['employee_division_id','=',$request->division_id];
        // }
        // if($request->district_id !=''){
        //     $where[] = ['employee_district_id','=',$request->district_id];
        // }
        // if($request->upazila_id !=''){
        //     $where[] = ['employee_upazila_id','=',$request->upazila_id];
        // }


        $survivor_info = [];

        foreach($incidents as $key => $incident){
            $survivor_info[$key]['rows'] = count($incidents);
            $survivor_info[$key]['type'] = $incident->name;
            if(!empty($incident['survivor_incident_information']) && count($incident['survivor_incident_information'])>0){
                /*From - To Year Survivor Incident Information*/
                // $year_between = SurvivorIncidentInformation::whereIn('id',$incident['survivor_incident_information']->pluck('id'))
                // ->whereBetween('violence_date', [$from_year_start, $end_date])->get();
                if ($wherein != null) {
                    $year_between = SurvivorIncidentInformation::where($where)->whereIn('employee_district_id',$wherein)->whereIn('id',$incident['survivor_incident_information']->pluck('id'))
                    ->whereBetween('created_at', [$from_date.' 00:00:00',$to_date.' 23:59:59'])->get();
                } else {
                    $year_between = SurvivorIncidentInformation::where($where)->whereIn('id',$incident['survivor_incident_information']->pluck('id'))
                    ->whereBetween('created_at', [$from_date.' 00:00:00',$to_date.' 23:59:59'])->get();
                }

                if(!empty($year_between) && count($year_between) > 0){
                    $survivor_info[$key]['year_between']['male'] = 0;
                    $survivor_info[$key]['year_between']['female'] = 0;
                    foreach($year_between as $yb){

                            // dd($yb->survivor_gender->toArray());
                        if(!empty($yb->survivor_gender) && $yb->survivor_gender->name == 'Male'){
                            $survivor_info[$key]['year_between']['male'] +=1 ;

                        }

                        if(!empty($yb->survivor_gender) && $yb->survivor_gender->name == 'Female'){
                            $survivor_info[$key]['year_between']['female'] +=1 ;

                        }

                    }
                    $survivor_info[$key]['year_between']['total'] = $survivor_info[$key]['year_between']['male'] + $survivor_info[$key]['year_between']['female'];
                }else{
                    $survivor_info[$key]['year_between']['male'] = 0;
                    $survivor_info[$key]['year_between']['female'] = 0;
                    $survivor_info[$key]['year_between']['total'] = 0;
                }

            }else{
                $survivor_info[$key]['year_between']['male'] = 0;
                $survivor_info[$key]['year_between']['female'] = 0;
                $survivor_info[$key]['year_between']['total'] = 0;
            }
        }

        $pdata['survivor_info'] = $survivor_info;
        // dd($survivor_info);
        $pdata['from_date'] = $from_date;
        $pdata['to_date'] = $to_date;

        // return view('backend.report.pdf.platform_report', $pdata);

        if ($request->format_download == 1) {
            $pdf = PDF::loadView('backend.report.pdf.source_report', $pdata);
            $pdf->SetProtection(['copy', 'print'], '', 'pass');
            return $pdf->stream('document.pdf');
        } else {
            $view_link = 'backend.report.excel.mis-report-excel';
            return Excel::download(new MisReportExport($pdata,$view_link), 'source_report.xlsx');
        }
    }
}

