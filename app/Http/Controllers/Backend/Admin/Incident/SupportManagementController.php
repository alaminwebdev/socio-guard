<?php

namespace App\Http\Controllers\Backend\Admin\Incident;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Setup\Division;
use App\Model\Admin\Setup\District;
use App\Model\Admin\Setup\Upazila;
use App\Model\Admin\Setup\Union;
use App\Model\Admin\Setup\Village;
use App\Model\Admin\Setup\Religion;
use App\Model\Admin\Setup\Gender;
use App\Model\Admin\Setup\Occupation;
use App\Model\Admin\Setup\SurvivorRelationship;
use App\Model\Admin\Setup\MaritalStatus;
use App\Model\Admin\Setup\SurvivorSupportOrganization;
use App\Model\Admin\Setup\SurvivorSupportName;
use App\Model\Admin\Setup\SuprvivorInitialSupport;
use App\Model\Admin\Setup\SurvivorSituation;
use App\Model\Admin\Setup\SurvivorIncidentPlace;
use App\Model\Admin\Setup\ViolenceCategory;
use App\Model\Admin\Setup\ViolenceSubCategory;
use App\Model\Admin\Setup\ViolenceName;
use App\Model\Admin\Setup\OrganizationType;
use App\Model\Admin\Setup\OrganizationName;
use App\Model\Admin\Setup\InformationProviderSource;
use App\Model\Admin\Incident\SurvivorBracSupport;
use App\Model\Admin\Incident\SurvivorOtherOrganizationSupport;
use App\Model\Admin\Setup\OtherOrganizationSupport;
use App\Model\Admin\Setup\ViolenceReason;
use App\Model\Admin\Setup\SocialStatus;
use App\Model\Admin\Setup\EconomicCondition;
use App\Model\Admin\Incident\SurvivorIncidentInformation;
use App\Model\Admin\Incident\PerpetratorInformation;
use App\Model\Admin\Setup\SurvivorAutisticInformation;
use App\Model\Admin\Setup\FamilyMember;
use App\Model\Admin\Setup\SurvivorFinalSupport;
use App\Model\Admin\Setup\Program;
use App\Model\Admin\Setup\CEP_Region\Region;
use App\Model\Admin\Setup\CEP_Region\RegionAreaDetail;
use Session;
use App\User;
use Illuminate\Support\Facades\DB;
use Auth;
use PDF;
use DataTables;

class SupportManagementController extends Controller
{
    public function view()
    {
        $divisions = Division::all();
        $violence_categories = ViolenceCategory::where('status','1')->get();
        $regions            = Region::where('status','1')->get();
    	return view('backend.admin.support_manage.incident-support-manage-view',compact('divisions','violence_categories','regions'));
    }

    public function getIncident(Request $request)
    {
        if($request->division_id !=''){
            $where[] = ['employee_division_id','=',$request->division_id];
        }
        if($request->district_id !=''){
            $where[] = ['employee_district_id','=',$request->district_id];
        }
        if($request->upazila_id !=''){
            $where[] = ['employee_upazila_id','=',$request->upazila_id];
        }
        if($request->union_id !=''){
            $where[] = ['employee_union_id','=',$request->union_id];
        }
        if($request->start_date !=''){
            $where[] = ['violence_date' ,'>=',date('Y-m-d',strtotime($request->start_date))];
        }
        if($request->end_date !=''){
            $where[] = ['violence_date' ,'<=',date('Y-m-d',strtotime($request->end_date))];
        }
        if($request->violence_category_id !=''){
            $where[] = ['violence_category_id','=',$request->violence_category_id];
        }
        if($request->violence_sub_category_id !=''){
            $where[] = ['violence_sub_category_id','=',$request->violence_sub_category_id];
        }
        if($request->violence_name_id !=''){
            $where[] = ['violence_name_id','=',$request->violence_name_id];
        }
        $where[] = ['status' ,'=','1'];
        // dd($where);
        $data = SurvivorIncidentInformation::where($where)->orderBy('violence_date','desc')->get();
        // dd($data);

        $html['thsource'] = '<th width="5%">Sl.</th>';
        $html['thsource'] .= '<th>Incident ID</th>';
        $html['thsource'] .= '<th>Date</th>';
        $html['thsource'] .= '<th>Survivor Name</th>';
        $html['thsource'] .= '<th>Gender</th>';
        $html['thsource'] .= '<th>Age</th>';
        $html['thsource'] .= '<th width="10%">Action</th>';
        $html['tdsource'] = '';
        foreach ($data as $key => $v) {
            $html['tdsource'] .= '<tr>';
            $html['tdsource'] .= '<td>'.($key+1).'</td>';
            $html['tdsource'] .= '<td>'.$v->survivor_id.'</td>';
            $html['tdsource'] .= '<td>'.date("d-m-Y",strtotime($v->violence_date)).'</td>';
            $html['tdsource'] .= '<td>'.$v->survivor_name.'</td>';
            $html['tdsource'] .= '<td>'.$v['survivor_gender']['name'].'</td>';
            $html['tdsource'] .= '<td>'.$v->survivor_age.'</td>';
            $html['tdsource'] .= '<td> <a class="btn btn-sm btn-info" title="Add" href="'.route('support.barck.manage.add',$v->id).'"><i class="fa fa-plus-circle"></i>Add</a> </td>';
            $html['tdsource'] .= '</tr>';
        }

        return response()->json(@$html);
    }

    public function add($id)
    {
    	$editIncident = SurvivorIncidentInformation::with(['perpetrator_info','survivor_brac_support','survivor_other_organization_support'])->find($id);
        // dd($editIncident->toArray());
        $brac_support = SurvivorFinalSupport::where('survivor_support_organization_id','1')->where('status','1')->get();
        $other_support = SurvivorFinalSupport::where('survivor_support_organization_id','2')->where('status','1')->get();
        $programs = Program::all();
        return view('backend.admin.support_manage.incident-support-add',compact('editIncident','brac_support','other_support','programs'));
    }

    public function store(Request $request, $id)
    {
        // dd($request->all());
        if(isset($request->survivor_final_support_id)){
            SurvivorBracSupport::where('survivor_incident_info_id',$id)->delete();
            $brac_support_count = count($request->survivor_final_support_id);
            for ($j=0; $j < $brac_support_count; $j++) {
                $brac_support = new SurvivorBracSupport();
                $brac_support->survivor_incident_info_id = $id;
                $brac_support->survivor_id = SurvivorIncidentInformation::find($id)['survivor_id'];
                $brac_support->survivor_final_support_id = $request->survivor_final_support_id[$j];
                $brac_support->brac_program_id = $request->brac_program_id[$j];
                $brac_support->survivor_support_date = date("Y-m-d", strtotime($request->survivor_support_date[$j]));
                $brac_support->brac_support_description = $request->brac_support_description;
                $brac_support->save();
            }
        }
        if(isset($request->survivor_final_support_other_id)){
            SurvivorOtherOrganizationSupport::where('survivor_incident_info_id',$id)->delete();
            $other_support_count = count($request->survivor_final_support_other_id);
            for ($k=0; $k < $other_support_count; $k++) {
                $brac_support = new SurvivorOtherOrganizationSupport();
                $brac_support->survivor_incident_info_id = $id;
                $brac_support->survivor_id = SurvivorIncidentInformation::find($id)['survivor_id'];
                $brac_support->survivor_final_support_id = $request->survivor_final_support_other_id[$k];
                $brac_support->other_program = $request->other_program[$k];
                $brac_support->survivor_other_support_date = date("Y-m-d", strtotime($request->survivor_other_support_date[$k]));
                $brac_support->other_organization_support_description = $request->other_organization_support_description;
                $brac_support->save();
            }
        }
        return redirect()->route('support.barck.manage.view')->with('success','Succuessfully data inseted');
    }

    public function getIncidentDatatable(Request $request)
    {
        // dd($request->all());
        // $a = date("Y-m-d", strtotime($request->from_date));
        // $b = date("Y-m-d", strtotime($request->to_date));
        // dd(Auth::id());
        $auth_user      = User::with(['setup_user' => function ($query){
            $query->with(['setup_user_area']);
        }])->where('id', Auth::id())->first();
        // dd($auth_user->toArray());
        $incidents = SurvivorIncidentInformation::select('id', 'survivor_id', 'survivor_name', 'survivor_gender_id', 'survivor_age','violence_date');

        $allDivisions = RegionAreaDetail::where('region_id', $request->region_id)->where('status','1')->groupBy('division_id')->pluck('division_id')->toArray();
        // dd($allDivisions);

        if (!empty($request->region_id) && empty($request->division_id)) {
            $incidents->whereIn('employee_division_id', $allDivisions);
        } else {
            if($request->division_id) {
                $incidents->where('employee_division_id', $request->division_id);
            }
        }

        // if($request->division_id) {
        //     $incidents->where('employee_division_id', $request->division_id);
        // }
        if($request->district_id) {
            $incidents->where('employee_district_id', $request->district_id);
        }
        if($request->upazila_id) {
            $incidents->where('employee_upazila_id', $request->upazila_id);
        }
        if($request->union_id) {
            $incidents->where('employee_union_id', $request->union_id);
        }
        if($request->violence_category_id) {
            $incidents->where('violence_category_id', $request->violence_category_id);
        }
        if($request->violence_sub_category_id) {
            $incidents->where('violence_sub_category_id', $request->violence_sub_category_id);
        }
        if($request->violence_name_id) {
            $incidents->where('violence_name_id', $request->violence_name_id);
        }
        if($request->survivor_id) {
            $incidents->where('survivor_id', $request->survivor_id);
        }
        if($request->from_date) {
            $incidents->whereDate('violence_date', '>=', date("Y-m-d", strtotime($request->from_date)));
        }
        if($request->to_date) {
            $incidents->whereDate('violence_date', '<=', date("Y-m-d", strtotime($request->to_date)));
        }

        $incidents->orderBy('id', 'DESC');

        return DataTables::of($incidents)
            ->addIndexColumn()
            // ->addColumn('survivor_gender_id', function(SurvivorIncidentInformation $incident) {
            //     $output = '<ol>';
            //     if($incident->survivor_gender_id) {
            //         foreach($incident->survivor_gender_id as $value) {
            //             $output .= '<li>'.$value->name.'</li>';
            //         }
            //     }
            //     $output .= '</ol>';
            //     return $output;
            // })
            ->addColumn('action_column', function(SurvivorIncidentInformation $incident){
                $links = '<a href="'.route('support.barck.manage.add', $incident->id).'" class="btn btn-sm btn-info" title="Add Support">Add Support</a>';
                return $links;
            })
            ->rawColumns(['action_column'])
            ->make(true);
    }

}
