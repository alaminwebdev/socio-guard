<?php

namespace App\Http\Controllers;

use App\Exports\MisReportExport;
use App\Http\Controllers\Controller;
use App\Model\Admin\Incident\PerpetratorInformation;
use App\Model\Admin\Incident\SurvivorBracSupport;
use App\Model\Admin\Incident\SurvivorIncidentInformation;
use App\Model\Admin\Incident\SurvivorOtherOrganizationSupport;
use App\Model\Admin\Setup\CEP_Region\Region;
use App\Model\Admin\Setup\CEP_Region\RegionAreaDetail;
use App\Model\Admin\Setup\CEP_Region\SetupUserArea;
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
use App\Model\Civilcase;
use App\Model\Education;
use App\Model\Judgementstatus;
use App\Model\Pititioncase;
use App\Model\Policecase;
use App\User;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Session;
use App\Model\SelpIncidentModel;
use App\Model\PollisomajData;
use App\Model\PollisomajDataModel;
use App\Model\SurvivorCourtCaseModel;

class CourtCaseReportController extends Controller
{
    public function index(Request $request){
        $data['platform'] = OrganizationName::where('status', 1)->get();
        $data['regions']  = Region::where('status','1')->get();
        $data['autistics'] = SurvivorAutisticInformation::where('status','1')->get();
        $data['genders'] = Gender::all();

        $data['allJudjement']=Judgementstatus::where('status',1)->get();
        $data['allCivilCase']=Civilcase::where('status',1)->get();

        // for ($i=0; $i <count($allJudjement) ; $i++) { 
        //     if(!isset($formatJudjement[$allJudjement[$i]->id])){
        //         $formatJudjement[$allJudjement[$i]->id]=['status_title'=>$allJudjement[$i]->title,'count'=>0];
        //     }
        // }
        return view('selp.view.courtcasereport.courtcase_report',$data);
       
    }

    public function generateCourtcaseReport(Request $request){
        //dd($request->all());
        $from_date = date('Y-m-d', strtotime($request->from_date));
        $to_date = date('Y-m-d', strtotime($request->to_date));
        $where[] = ['selp_incident_informations.status',2];
        $wherein = [];
        $label_name='';
        $reportType='';
        $locations='';

        if ($request->region_id == "all_zone" && $request->format_download == 1) {
            return redirect()->back()->with('error', "This Report Can not be generate in PDF format");
        }

        //$request->upazila_id="all_upazila";
        if(!empty($request->region_id) && $request->region_id == "all_zone"){
            $label_name='District name';
            $reportType=1;
            $allDistrict = SetupUserArea::whereNotNull('district_id')->where('status','1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein = $allDistrict;
            $areas = District::select('id','name')->whereIn('id', $wherein)->orderBy('id', "ASC")->get();
        }elseif (!empty($request->region_id) && empty($request->division_id) && $request->upazila_id != "all_upazila") {
            //Only Region
            $label_name='District name';
            $reportType=1;
            $allDistrict = SetupUserArea::where('region_id',$request->region_id)->whereNotNull('district_id')->where('status','1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein = $allDistrict;
            $areas = District::select('id','name')->whereIn('id', $wherein)->orderBy('id', "ASC")->get();
            
        } elseif (!empty($request->region_id) && !empty($request->division_id) && empty($request->district_id)) {
            //Region and Division
            $allDistrict = SetupUserArea::where('region_id',$request->region_id)->where('division_id',$request->division_id)->whereNotNull('district_id')->where('status','1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein = $allDistrict;
            $label_name='District name';
            $reportType=1;
            $areas = District::select('id','name')->whereIn('id', $wherein)->orderBy('id', "ASC")->get();
                    
        } elseif (!empty($request->region_id) && !empty($request->division_id) && !empty($request->district_id) && $request->upazila_id != "all_upazila" && empty($request->upazila_id) ){
            //dd("Single District");
            $allDistrict = SetupUserArea::where('region_id',$request->region_id)->where('division_id',$request->division_id)->whereNotNull('district_id')->where('status','1')->where('district_id',$request->district_id)->pluck('district_id')->toArray();
            $wherein = $allDistrict;
            $label_name='District name';
            $reportType=1;
            if ($request->district_id == "all_district") {
                $areas = District::select('id','name')->whereIn('id', $wherein)->orderBy('id', "ASC")->get();
            } else {
                $areas = District::select('id','name')->where('id', $request->district_id)->orderBy('id', "ASC")->get();
            }
            
        } elseif(!empty($request->region_id) && empty($request->division_id) && empty($request->district_id) &&  $request->upazila_id == "all_upazila") {
            // dd("all upazila");
            $allUpazila  = SetupUserArea::where('region_id',$request->region_id)->whereNotNull('upazila_id')->where('status','1')->groupBy('upazila_id')->pluck('upazila_id')->toArray();
            $wherein = $allUpazila;
            $label_name='Upazilla name';
            $reportType=2;
            $areas = Upazila::select('id','name')->whereIn('id', $wherein)->orderBy('id', "ASC")->get();
            
        } elseif (!empty($request->region_id) && !empty($request->division_id) && !empty($request->district_id) && ($request->upazila_id == "all_upazila" || !empty($request->upazila_id) )) {
            $allUpazila  = SetupUserArea::where('region_id',$request->region_id)->where('division_id',$request->division_id)->where('district_id',$request->district_id)->whereNotNull('upazila_id')->where('status','1')->groupBy('upazila_id')->pluck('upazila_id')->toArray();
            $wherein = $allUpazila;
            $label_name='Upazilla name';
            $reportType=2;
            if ($request->upazila_id == "all_upazila") {
                $areas = Upazila::select('id','name')->whereIn('id', $wherein)->orderBy('id', "ASC")->get();
            } else {
                $areas = Upazila::select('id','name')->where('id', $request->upazila_id)->orderBy('id', "ASC")->get();
            }
        } else {
            //District and Upazila
            if($request->district_id) {
                $where[] = ['district_id','=',$request->district_id];
                $label_name='District name';
                $reportType=2;
            }
            if($request->upazila_id) {
                $where[] = ['upazilla_id','=',$request->upazila_id];
                $label_name='Upazilla name';
                $reportType=2;
            }
            
        }
        // dd($wherein);

        if ($wherein != null) {

            if(!empty($request->upazila_id)){
                if ($request->upazila_id == "all_upazila") {
                    $courtCase=SurvivorCourtCaseModel::leftJoin('selp_incident_informations','selp_incident_informations.selp_incident_ref','=','survivor_court_cases.selp_incident_ref')->leftJoin('upazilas','upazilas.id','=','selp_incident_informations.employee_upazila_id')->select(
                        'upazilas.name',
                        'selp_incident_informations.employee_zone_id',
                        'selp_incident_informations.employee_district_id',
                        'selp_incident_informations.employee_upazila_id',
                        'survivor_court_cases.*',
                        DB::raw('COUNT(survivor_court_cases.court_case_id) as courtcase_total')
                    )
                    ->where($where)
                    ->whereNotNull('case_start_date')
                    ->where('survivor_court_cases.case_type',1)
                    ->whereIn('selp_incident_informations.employee_upazila_id',$wherein)
                    ->whereBetween('survivor_court_cases.case_start_date', [$from_date.' 00:00:00',$to_date.' 23:59:59'])
                    ->groupBy('survivor_court_cases.court_case_id')
                    ->groupBy('survivor_court_cases.case_type')
                    ->get();
                 
                    $locations=Upazila::join('selp_incident_informations','selp_incident_informations.employee_upazila_id','=','upazilas.id')->select('upazilas.*')->whereIn('upazilas.id',$wherein)->get();

                } else {
                    $courtCase=SurvivorCourtCaseModel::leftJoin('selp_incident_informations','selp_incident_informations.selp_incident_ref','=','survivor_court_cases.selp_incident_ref')->leftJoin('upazilas','upazilas.id','=','selp_incident_informations.employee_upazila_id')->select(
                        'upazilas.name',
                        'selp_incident_informations.employee_zone_id',
                        'selp_incident_informations.employee_district_id',
                        'selp_incident_informations.employee_upazila_id',
                        'survivor_court_cases.*',
                        DB::raw('COUNT(survivor_court_cases.court_case_id) as courtcase_total')

                    )
                    ->where($where)
                    ->whereNotNull('case_start_date')
                    ->where('survivor_court_cases.case_type',1)
                    ->where('selp_incident_informations.employee_upazila_id',$request->upazila_id)
                    ->whereBetween('survivor_court_cases.case_start_date', [$from_date.' 00:00:00',$to_date.' 23:59:59'])
                    ->groupBy('survivor_court_cases.court_case_id')
                    ->groupBy('survivor_court_cases.case_type')
                    ->get();

                    $locations=Upazila::join('selp_incident_informations','selp_incident_informations.employee_upazila_id','=','upazilas.id')->select('upazilas.*')->where('upazilas.id',$request->upazila_id)->get();
                    
                }
                
            } else {
                



                $courtCase=SelpIncidentModel::leftJoin('survivor_court_cases','survivor_court_cases.selp_incident_ref','=','selp_incident_informations.selp_incident_ref')
                    ->select(
                    'selp_incident_informations.employee_zone_id',
                    'selp_incident_informations.employee_district_id',
                    'selp_incident_informations.employee_upazila_id',
                    'survivor_court_cases.*',
                     DB::raw('COUNT(survivor_court_cases.court_case_id) as courtcase_total'))
                    ->where($where)
                     ->whereNotNull('case_start_date')
                    ->whereIn('selp_incident_informations.employee_district_id',$wherein)
                    ->whereBetween('survivor_court_cases.case_start_date', [$from_date.' 00:00:00',$to_date.' 23:59:59'])
                    ->groupBy('survivor_court_cases.court_case_id')
                    ->groupBy('survivor_court_cases.case_type')
                    ->get();

                    //dd($courtCase);

                    $locations=District::join('selp_incident_informations','selp_incident_informations.employee_district_id','=','districts.id')->select('districts.*')->whereIn('districts.id',$wherein)->get();
                
            }

        } else {
            //dd($request->district_id);
            $courtCase=SurvivorCourtCaseModel::leftJoin('selp_incident_informations','selp_incident_informations.selp_incident_ref','=','survivor_court_cases.selp_incident_ref')->leftJoin('districts','districts.id','=','selp_incident_informations.employee_district_id')->select(
                        'districts.name as district_name',
                        'selp_incident_informations.employee_zone_id',
                        'selp_incident_informations.employee_district_id',
                        'selp_incident_informations.employee_upazila_id',
                        'survivor_court_cases.*',
                        DB::raw('COUNT(survivor_court_cases.court_case_id) as courtcase_total')
                    )
                    ->where($where)
                    ->whereNotNull('case_start_date')
                    //->where('survivor_court_cases.case_type',1)
                    ->where('selp_incident_informations.employee_district_id',$request->district_id)
                    ->whereBetween('survivor_court_cases.case_start_date', [$from_date.' 00:00:00',$to_date.' 23:59:59'])
                    ->groupBy('survivor_court_cases.court_case_id')
                    ->groupBy('survivor_court_cases.case_type')
                    ->get();

                    $locations=District::join('selp_incident_informations','selp_incident_informations.employee_district_id','=','districts.id')->select('districts.*')->where('districts.id',$request->district_id)->get();
            
        }

        $allJudjement=Judgementstatus::where('status',1)->get();
        $formatJudjement=array();

        for ($i=0; $i <count($allJudjement) ; $i++) { 
            if(!isset($formatJudjement[$allJudjement[$i]->id])){
                $formatJudjement[$allJudjement[$i]->id]=['status_title'=>$allJudjement[$i]->title,'count'=>0];
            }
        }

        $allCivilCase=Civilcase::where('status',1)->get();
        $formatCivilcase=array();

        for ($i=0; $i <count($allCivilCase) ; $i++) { 
            if(!isset($formatCivilcase[$allCivilCase[$i]->id])){
                $formatCivilcase[$allCivilCase[$i]->id]=['case_title'=>$allCivilCase[$i]->title,'status'=>$formatJudjement];
            }
        }

        $allPoliceCase=Policecase::where('status',1)->get();
        $formatPolicecase=array();

        for ($i=0; $i <count($allPoliceCase) ; $i++) { 
            if(!isset($formatPolicecase[$allPoliceCase[$i]->id])){
                $formatPolicecase[$allPoliceCase[$i]->id]=['case_title'=>$allPoliceCase[$i]->title,'status'=>$formatJudjement];
            }
        }

        $allPititionCase=Pititioncase::where('status',1)->get();
        $formatPititioncase=array();

        for ($i=0; $i <count($allPititionCase) ; $i++) { 
            if(!isset($formatPititioncase[$allPititionCase[$i]->id])){
                $formatPititioncase[$allPititionCase[$i]->id]=['case_title'=>$allPititionCase[$i]->title,'status'=>$formatJudjement];
            }
        }


       
        $locationAndCases=array();
        

        for ($i=0; $i <count($locations) ; $i++) { 
            if(!isset($locationAndCases[$locations[$i]->id])){
                $locationAndCases[$locations[$i]->id]=array(
                    "record_id"=>$locations[$i]->id,
                    "label"=>$locations[$i]->name,
                    "civilcase"=>$formatCivilcase,
                    "policecase"=>$formatPolicecase,
                    "pititioncase"=>$formatPititioncase
                );
            }
        }

        // if (!@$pdata['locationAndCases']) {
        //     return redirect()->back()->with('error', "There is no data entry found in this search criteria");
        // }
        
        //dd($locationAndCases);
        $data['locationAndCases']=$locationAndCases;
        $data['label_name']=$label_name;
        $data['reportType']=$reportType;
        $data['allJudjement']=$allJudjement;
        $data['allCivilCase']=$allCivilCase;
        $data['allPoliceCase']=$allPoliceCase;
        $data['allPititionCase']=$allPititionCase;
        $data['region']    = ($request->region_id != "all_zone") ?  Region::where('id', $request->region_id)->pluck('region_name')->first() : "All";
        $data['division']  = ($request->division_id != null) ?  Division::where('id', $request->division_id)->pluck('name')->first() : "";
        $data['district']  = ($request->district_id != "all_district") ?  District::where('id', $request->district_id)->pluck('name')->first() : "All";
        $data['upazila']   = ($request->upazila_id != "all_upazila") ?  Upazila::where('id', $request->upazila_id)->pluck('name')->first() : "All";
        $data['date']      = date('d-M-Y');
        $data['from_date'] = date('d-M-Y', strtotime($request->from_date));
        $data['to_date']   = date('d-M-Y', strtotime($request->to_date));
        //dd($courtCase);
        if ($request->format_download == 1) {
            $pdf = PDF::loadView('selp.pdf.casereport.case_report',$data,[],['title' => 'Certificate','format' => 'A4-L','orientation' => 'L']);
            $pdf->SetProtection(['copy', 'print'], '', 'pass');
            return $pdf->stream('document.pdf');
        }else{
            $view_link = 'selp.excel.casereport.case_report';
            return Excel::download(new MisReportExport($data,$view_link), 'court_case_report.xlsx');
        }
                                                        
        
    }
}
