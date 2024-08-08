<?php

namespace App\Http\Controllers\Report;

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
use App\Model\SelpIncidentModel;
use App\Model\Admin\Setup\CEP_Region\SetupUserArea;

class SelpPlaceWiseReportController extends Controller
{
    // public function ageWiseReportView()
    // {
    //     $data['platform'] = OrganizationName::where('status', 1)->get();
    //     $data['regions']  = Region::where('status','1')->get();
    //     $data['autistics'] = SurvivorAutisticInformation::where('status','1')->get();
    //     $data['genders'] = Gender::all();
    //     // dd($platform->toArray());
    //     return view('selp.view.selp_age_wise_report_view', $data);
    // }

    public function placeWiseViolenceReportGenerate(Request $request)
    {
        ini_set('memory_limit', -1);
        $from_date = date('Y-m-d', strtotime($request->from_date));
        $to_date = date('Y-m-d', strtotime($request->to_date));
        $where[] = ['status', 2];
        $wherein = [];
        $setup_area = [];
        $reportTypeTarget=null;
        $groupBy=null;

        if($request->upazila_id == "all_upazila" || $request->upazila_id > 0)
        {
            $reportTypeTarget="employee_upazila_id";
            $groupBy='upazila_id';
            if($request->upazila_id > 0)
            {
                $setup_area = SetupUserArea::withTrashed()->where('upazila_id', $request->upazila_id)->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
            }

        }
        if($request->district_id=="all_district" || $request->district_id > 0)
        {
            
            if($reportTypeTarget==null){
                $reportTypeTarget="employee_district_id";
            }

            if($groupBy==null){
                $groupBy="district_id";
            }
            if($request->district_id > 0 && count($setup_area) == 0)
            {  
                $setup_area = SetupUserArea::withTrashed()->where('district_id', $request->district_id)->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
            }
        }

        if($request->division_id > 0  && count($setup_area) == 0)
        {
            if($reportTypeTarget==null){
                $reportTypeTarget="employee_district_id";
            }
            if($groupBy==null){
                $groupBy="district_id";
            }
            
            $setup_area = SetupUserArea::withTrashed()->where('division_id', $request->division_id)->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
            
        }
        
        if($request->region_id=="all_zone" || $request->region_id > 0)
        {
            if($reportTypeTarget==null){
                $reportTypeTarget="employee_district_id";
            }
            
            if($groupBy==null){
                $groupBy="district_id";
            }
            if($request->region_id > 0 && count($setup_area) == 0)
            {
                $setup_area = SetupUserArea::withTrashed()->where('region_id', $request->region_id)->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();                  
            }

        }

        if(count($setup_area)==0){
            $setup_area = SetupUserArea::withTrashed()->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
        }
                                  
        if($groupBy == "district_id"){
            $areas      = District::select('id','name')->whereIn('id', $setup_area)->orderBy('id', "ASC")->get();
            $area_id    = District::select('id','name')->whereIn('id', $setup_area)->orderBy('id', "ASC")->pluck('id')->toArray();
        }

        if($groupBy == "upazila_id"){
            $areas      = Upazila::select('id','name')->whereIn('id', $setup_area)->orderBy('id', "ASC")->get();
            $area_id    = Upazila::select('id','name')->whereIn('id', $setup_area)->orderBy('id', "ASC")->pluck('id')->toArray();
        }

        $districts      = District::select('id','name')->orderBy('id', "ASC")->get();
        $violences      = ViolenceCategory::select('id','name')->orderBy('id', "ASC")->get();
        $violence_place = SurvivorViolencePlace::select('id','name')->orderBy('id', "ASC")->get();

            foreach ($areas as $district_key => $district) {
                foreach ($violences as $violence_key => $violence) {
                    foreach ($violence_place as $place_key => $place) {
                        $pdata['informations']['district'][$district->id]['name'] = $district->name;
                        $pdata['informations']['district'][$district->id]['violence'][$violence->id]['name']                =  $violence->name;
                        $pdata['informations']['district'][$district->id]['violence'][$violence->id]['place'][$place_key]   =  SelpIncidentModel::select('id', 'violence_place_id' , 'employee_district_id', 'employee_upazila_id')->where($reportTypeTarget,$district->id)->where('violence_reason_id',$violence->id)->where('violence_place_id', $place->id)->where($where)->whereNotNull('violence_reason_id')->whereBetween('posting_date', [$from_date,$to_date])->count();
                        // dd($pdata['informations']);
                    }
                }
            }

        // $rtm =   SelpIncidentModel::select('id', 'violence_place_id' , 'employee_district_id')->where('employee_district_id',1)->where('violence_reason_id',$violence->id)->where('violence_place_id', $place->id)->where($where)->whereNotNull('violence_reason_id')->whereBetween('created_at', [$from_date.' 00:00:00',$to_date.' 23:59:59'])->count();
        // dd($pdata['informations']);

        // echo "<pre>";
        // print_r($pdata['informations']); die();
        $pdata['region']    = ($request->region_id != "all_zone") ?  Region::where('id', $request->region_id)->pluck('region_name')->first() : "All";
        $pdata['division']  = ($request->division_id != null) ?  Division::where('id', $request->division_id)->pluck('name')->first() : "";
        $pdata['district']  = ($request->district_id != "all_district") ?  District::where('id', $request->district_id)->pluck('name')->first() : "All";
        $pdata['upazila']   = ($request->upazila_id != "all_upazila") ?  Upazila::where('id', $request->upazila_id)->pluck('name')->first() : "All";
        $pdata['date']      = date('d-M-Y');
        $pdata['from_date'] = date('d-M-Y', strtotime($request->from_date));
        $pdata['to_date']   = date('d-M-Y', strtotime($request->to_date));
        $pdata['violence_count']= count($violences);
        $pdata['violence_place']= $violence_place;
        // dd(gettype($pdata['violence']));

        if (!@$pdata['informations']) {
            return redirect()->back()->with('error', "There is no data entry found in this search criteria");
        }

        if ($request->format_download == 1) {
            // return view('selp.pdf.selp_place_wise_violence_report_pdf', $pdata);
            $pdf = PDF::loadView('selp.pdf.selp_place_wise_violence_report_pdf', $pdata,[],['title' => 'Certificate','format' => 'A4-L','orientation' => 'L']);
            $pdf->SetProtection(['copy', 'print'], '', 'pass');
            return $pdf->stream('document.pdf');
        } else {
            $view_link = 'selp.excel.selp_place_wise_violence_report_excel';
            return Excel::download(new MisReportExport($pdata,$view_link), 'selp_place_wise_violence_report.xlsx');
        }
    }
}

