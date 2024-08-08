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
use App\Model\Admin\Setup\SurvivorViolencePlace;
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
use App\Model\Admin\Setup\LegelInitiativeReason;
use App\Model\Admin\Setup\SocialStatus;
use App\Model\Admin\Setup\EconomicCondition;
use App\Model\Admin\Incident\SurvivorIncidentInformation;
use App\Model\Admin\Incident\PerpetratorInformation;
use App\Model\Admin\Setup\SurvivorAutisticInformation;
use App\Model\Admin\Setup\FamilyMember;
use App\Model\Admin\Setup\SurvivorFinalSupport;
use App\Model\Admin\Setup\Program;
use App\Model\Admin\Setup\PerpetratorPlace;
use App\Model\Admin\Setup\CEP_Region\RegionAreaDetail;
use App\Model\Admin\Setup\CEP_Region\Region;
use App\Model\Adrmoneyrecover;
use App\Model\AlternativeDisputeResolution;
use App\Model\BracEmployee;
use App\Model\Bracprogramname;
use App\Model\Bracsupporttypes;
use App\Model\Civilcase;
use App\Model\Education;
use App\Model\Followup;
use App\Model\Householdtype;
use App\Model\Judgementstatus;
use App\Model\Moneyrecover;
use App\Model\Pititioncase;
use App\Model\Policecase;
use App\Model\SelpComingOrFailour;
use App\Model\SelpFirstInitiative;
use App\Model\Selpzone;
use App\Model\Survivorinitiative;
use App\Model\ViolenceLocation;
use Session;
use App\User;
use Illuminate\Support\Facades\DB;
use Auth;
use PDF;
use DataTables;

class IncidentController extends Controller
{
    public function view()
    {
        $divisions = Division::all();
        $regions            = Region::where('status','1')->get();
        $violence_categories = ViolenceCategory::where('status','1')->get();
        $auth_user                  = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        // dd($auth_user->toArray());
        return view('backend.admin.incident.incident-view',compact('divisions','violence_categories', 'regions'));
    }

    public function getViolence(Request $request)
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
            $where[] = ['survivor_union_id','=',$request->union_id];
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
        $data = SurvivorIncidentInformation::where($where)->orderBy('violence_date','desc')->get();
        // dd($data->toArray());

        $html['thsource'] = '<th width="5%">Sl.</th>';
        $html['thsource'] .= '<th>Incident ID</th>';
        $html['thsource'] .= '<th>Date</th>';
        $html['thsource'] .= '<th>Survivor Name</th>';
        $html['thsource'] .= '<th>Gender</th>';
        $html['thsource'] .= '<th>Age</th>';
        $html['thsource'] .= '<th width="10%">Action</th>';
        $html['tdsource'] = '';
        foreach ($data as $key => $v)
        {
            $html['tdsource'] .= '<tr>';
            $html['tdsource'] .= '<td>'.($key+1).'</td>';
            $html['tdsource'] .= '<td>'.$v->survivor_id.'</td>';
            $html['tdsource'] .= '<td>'.date("d-m-Y",strtotime($v->violence_date)).'</td>';
            $html['tdsource'] .= '<td>'.$v->survivor_name.'</td>';
            $html['tdsource'] .= '<td>'.$v['survivor_gender']['name'].'</td>';
            $html['tdsource'] .= '<td>'.$v->survivor_age.'</td>';
            $html['tdsource'] .= '<td> <a class="btn btn-sm btn-info" title="edit" href="'.route('incident.violence.edit',$v->id).'"><i class="fa fa-edit"></i></a> <a class="btn btn-sm btn-info" target="_blank" title="details" href="'.route('incident.violence.details',$v->id).'"><i class="fa fa-eye"></i></a> </td>';
            $html['tdsource'] .= '</tr>';
        }

        return response()->json(@$html);
    }

    public function add()
    {
        $incident = SurvivorIncidentInformation::orderBy('id','DESC')->first();
        if($incident == null){
            $firstReg = 0;
            $survivor_id = $firstReg+1;
        }else{
            $incident = SurvivorIncidentInformation::orderBy('id','DESC')->first()->survivor_id;
            $survivor_id = $incident+1;
        }
        $divisions = Division::all();
        $sources = InformationProviderSource::where('status','1')->get();
        $organization_types = SurvivorSupportOrganization::where('status','1')->get();
        $genders = Gender::where('status','1')->get();
        $survivor_relationships = SurvivorRelationship::where('status','1')->get();
        $religions = Religion::where('status','1')->get();
        $marital_statuses = MaritalStatus::where('status','1')->get();
        $occupations = Occupation::where('status','1')->orderBy('name', 'asc')->get();
        $violence_categories = ViolenceCategory::where('status','1')->get();
        $survivor_place = SurvivorIncidentPlace::where('status','1')->get();
        $violence_place = SurvivorViolencePlace::where('status','1')->get();
        $perpetrator_place = PerpetratorPlace::where('status','1')->get();
        $survivor_initial_support = SuprvivorInitialSupport::where('status','1')->get();
        $survivor_situation = SurvivorSituation::where('status','1')->get();
        $brac_support = SurvivorFinalSupport::where('survivor_support_organization_id','1')->where('status','1')->get();
        $other_support = SurvivorFinalSupport::where('survivor_support_organization_id','2')->where('status','1')->get();
        $violenc_reasons = ViolenceReason::where('status','1')->get();
        $legel_initiative_reasons = LegelInitiativeReason::where('status','1')->get();
        $social_statuses = SocialStatus::where('status','1')->get();
        $economic_conditions = EconomicCondition::where('status','1')->get();
        $challenges = SurvivorAutisticInformation::where('status','1')->get();
        $family_members = FamilyMember::where('status','1')->get();
        $programs = Program::all();
        $organization_names = OrganizationName::all();
        return view('backend.admin.incident.incident-add',compact('divisions','perpetrator_place','sources','organization_types','genders','violence_place','survivor_relationships','religions','marital_statuses','occupations','violence_categories','survivor_place','survivor_initial_support','survivor_situation','brac_support','other_support','violenc_reasons','social_statuses','economic_conditions','challenges','family_members','programs','survivor_id','organization_names','legel_initiative_reasons'));
    }

    public function store(Request $request)
    {
        // dd($request->toArray());
        $data = $request->all();
        $incident = SurvivorIncidentInformation::orderBy('id','DESC')->first();
        if($incident == null){
            $firstReg = 0;
            $survivor_id = $firstReg+1;
        }else{
            $incident = SurvivorIncidentInformation::orderBy('id','DESC')->first()->survivor_id;
            $survivor_id = $incident+1;
        }

        // $violence = implode(',', $data['violence_incident_place_id']);
        $data['survivor_id'] = $survivor_id;
        if (isset($data['violence_reason_id'])) {
            if ($data['violence_reason_id'] == 1) {
                $data['violence_reason_id'] = null;
            }else{
                $data['violence_reason_id'] = implode(',', $data['violence_reason_id']);
            }
        }


        if (isset($data['perpetrator_family_member_id'])) {
            if ($data['perpetrator_family_member_id'] == 1) {
                $data['perpetrator_family_member_id'] = null;
            }else{
                $data['perpetrator_family_member_id'] = implode(',', $data['perpetrator_family_member_id']);
            }
        }

        $data['violence_date'] = $request->violence_date ? date('Y-m-d',strtotime($request->violence_date)) : null;
        if(isset($request->survivor_organization_type_id)){
            $data['survivor_organization_type_id'] = implode(',', $request->survivor_organization_type_id);
        }
        $data['created_by'] = Auth::user()->id;
        if($request->provider_applicable_status==null){
            $data['provider_applicable_status'] = '0';
        }else{
            $data['provider_applicable_status'] = $request->provider_applicable_status;
        }
        if($request->violence_applicable_status==null){
            $data['violence_applicable_status'] = '0';
        }else{
            $data['violence_applicable_status'] = $request->violence_applicable_status;
        }
        if($request->survivor_applicable_status==null){
            $data['survivor_applicable_status'] = '0';
        }else{
            $data['survivor_applicable_status'] = $request->survivor_applicable_status;
        }
        if($request->case_applicable_status==null){
            $data['case_applicable_status'] = '0';
        }else{
            $data['case_applicable_status'] = $request->case_applicable_status;
        }
        if($request->current_situation_applicable_status==null){
            $data['current_situation_applicable_status'] = '0';
        }else{
            $data['current_situation_applicable_status'] = $request->current_situation_applicable_status;
        }

        // dd($request->toArray());
        $saveData = SurvivorIncidentInformation::create($data);
        DB::transaction(function() use($request,$data,$saveData){
            if($saveData){
                if(isset($request->survivor_final_support_id)){
                    $brac_support_count = count($request->survivor_final_support_id);
                    for ($j=0; $j < $brac_support_count; $j++) {
                        $brac_support = new SurvivorBracSupport();
                        $brac_support->survivor_incident_info_id = $saveData->id;
                        $brac_support->survivor_id = $saveData->survivor_id;
                        $brac_support->survivor_support_applicable_status = $request->survivor_support_applicable_status;
                        $brac_support->survivor_support_date = date("Y-m-d", strtotime($request->survivor_support_date[$j]));
                        $brac_support->survivor_final_support_id = $request->survivor_final_support_id[$j];
                        $brac_support->brac_program_id = $request->brac_program_id[$j];
                        $brac_support->brac_support_description = $request->brac_support_description;
                        $brac_support->save();
                    }
                }else{
                    $brac_support = new SurvivorBracSupport();
                    $brac_support->survivor_incident_info_id = $saveData->id;
                    $brac_support->survivor_id = $saveData->survivor_id;
                    if($request->survivor_support_date==null){
                        $brac_support->survivor_support_date = null;
                    }else{
                        $brac_support->survivor_support_date = date('Y-m-d',strtotime($request->survivor_support_date));
                    }
                    $brac_support->save();
                }
                if(isset($request->survivor_final_support_other_id)){
                    $other_support_count = count($request->survivor_final_support_other_id);
                    for ($k=0; $k < $other_support_count; $k++) {
                        $other_support = new SurvivorOtherOrganizationSupport();
                        $other_support->survivor_incident_info_id = $saveData->id;
                        $other_support->survivor_id = $saveData->survivor_id;
                        $other_support->survivor_final_support_id = $request->survivor_final_support_other_id[$k];
                        $other_support->other_program = $request->other_program[$k];
                        $brac_support->survivor_other_support_date = date("Y-m-d", strtotime($request->survivor_other_support_date[$k]));
                        $other_support->other_organization_support_description = $request->other_organization_support_description;
                        $other_support->save();
                    }
                }else{
                    $other_support = new SurvivorOtherOrganizationSupport();
                    $other_support->survivor_incident_info_id = $saveData->id;
                    $other_support->survivor_id = $saveData->survivor_id;
                    $other_support->save();
                }
            }
        });
        $insertId['id'] = $saveData->id;
        return redirect()->route('incident.violence.edit',$insertId)->with('success','Succuessfully data inserted');

    }

    public function edit($insertId)
    {
    	$editIncident = SurvivorIncidentInformation::with(['perpetrator_info','survivor_brac_support','survivor_other_organization_support'])->find($insertId);
        // dd($editIncident->toArray());

        $divisions = Division::all();
        $sources = InformationProviderSource::where('status','1')->get();
        $organization_types = SurvivorSupportOrganization::where('status','1')->get();
        $genders = Gender::where('status','1')->get();
        $survivor_relationships = SurvivorRelationship::where('status','1')->get();
        $religions = Religion::where('status','1')->get();
        $marital_statuses = MaritalStatus::where('status','1')->get();
        $occupations = Occupation::where('status','1')->orderBy('name', 'asc')->get();
        $violence_categories = ViolenceCategory::where('status','1')->get();
        $violence_place = SurvivorViolencePlace::where('status','1')->get();
        $survivor_place = SurvivorIncidentPlace::where('status','1')->get();
        $perpetrator_place = PerpetratorPlace::where('status','1')->get();
        $survivor_initial_support = SuprvivorInitialSupport::where('status','1')->get();
        $survivor_situation = SurvivorSituation::where('status','1')->get();
        $brac_support = SurvivorFinalSupport::where('survivor_support_organization_id','1')->where('status','1')->get();
        $other_support = SurvivorFinalSupport::where('survivor_support_organization_id','2')->where('status','1')->get();
        $violenc_reasons = ViolenceReason::where('status','1')->get();
        $legel_initiative_reasons = LegelInitiativeReason::where('status','1')->get();
        $social_statuses = SocialStatus::where('status','1')->get();
        $economic_conditions = EconomicCondition::where('status','1')->get();
        $challenges = SurvivorAutisticInformation::where('status','1')->get();
        $family_members = FamilyMember::where('status','1')->get();
        $programs = Program::all();
        $organization_names = OrganizationName::all();
        return view('backend.admin.incident.incident-add',compact('editIncident','divisions','sources','organization_types','genders','survivor_relationships','religions','marital_statuses','occupations','violence_categories','survivor_place','survivor_initial_support','survivor_situation','brac_support','other_support','violenc_reasons','social_statuses','economic_conditions','challenges','family_members','programs','violence_place','organization_names','perpetrator_place','legel_initiative_reasons'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        // dd($data);
        if(isset($request->violence_date)){
            $data['violence_date'] = date('Y-m-d',strtotime($request->violence_date));
        }
        if(isset($request->survivor_organization_type_id)){
            $data['survivor_organization_type_id'] = implode(',', $request->survivor_organization_type_id);
        }
        $data['updated_by'] = Auth::user()->id;

        if (isset($data['violence_reason_id'])) {
            if ($data['violence_reason_id'] == 1) {
                $data['violence_reason_id'] = null;
            }else{
                $data['violence_reason_id'] = implode(',', $data['violence_reason_id']);
            }
        }


        if (isset($data['perpetrator_family_member_id'])) {
            if ($data['perpetrator_family_member_id'] == 1) {
                $data['perpetrator_family_member_id'] = null;
            }else{
                $data['perpetrator_family_member_id'] = implode(',', $data['perpetrator_family_member_id']);
            }
        }

        if($request->case_status=='No'){
            $data['thana_name'] = null;
            $data['court_name'] = null;
        }
        if($request->case_status=='Under Process'){
            $data['not_filing_reason'] = null;
        }
        if($request->case_status=='Yes'){
            $data['not_filing_reason'] = null;
        }
        if($request->case_status=='Resolved through local arbitration'){
            $data['thana_name'] = null;
            $data['court_name'] = null;
            $data['not_filing_reason'] = null;
        }
        if($request->provider_source_id!='0'){
            $data['provider_other_source'] = null;
        }

        if($request->provider_info_save){
            $data['provider_applicable_status'] = $request->provider_applicable_status;
        }
        if($request->violence_incident_save){
            $data['violence_applicable_status'] = $request->violence_applicable_status;
        }
        if($request->survivor_info_save){
            $data['survivor_applicable_status'] = $request->survivor_applicable_status;
        }
        if($request->legal_info_save){
            $data['case_applicable_status'] = $request->case_applicable_status;
        }
        if($request->initial_support_save){
            $data['current_situation_applicable_status'] = $request->current_situation_applicable_status;
        }

        $updateData = SurvivorIncidentInformation::find($id);
        DB::transaction(function() use($request,$data,$id,$updateData){
            if($updateData->update($data)){
                if(isset($request->survivor_final_support_id)){
                    SurvivorBracSupport::where('survivor_incident_info_id',$id)->delete();
                    $brac_support_count = count($request->survivor_final_support_id);
                    for ($j=0; $j < $brac_support_count; $j++) {
                        $brac_support = new SurvivorBracSupport();
                        $brac_support->survivor_incident_info_id = $id;
                        $brac_support->survivor_id = SurvivorIncidentInformation::find($id)['survivor_id'];
                        if(isset($request->survivor_support_applicable_status)){
                            $brac_support->survivor_support_applicable_status = $request->survivor_support_applicable_status;
                        }else{
                            $brac_support->survivor_support_applicable_status = '0';
                        }
                        // $brac_support->survivor_support_date = $request->survivor_support_date ? date('Y-m-d',strtotime($request->survivor_support_date)) : null;
                        $brac_support->survivor_support_date = date("Y-m-d", strtotime($request->survivor_support_date[$j]));
                        $brac_support->survivor_final_support_id = $request->survivor_final_support_id[$j];
                        $brac_support->brac_program_id = $request->brac_program_id[$j];
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
            }
        });
        $insertId['id'] = $id;
        return redirect()->route('incident.violence.edit',$insertId)->with('success','Succuessfully data updated');
    }

    public function details($id)
    {
        $data['incident'] = SurvivorIncidentInformation::with(['perpetrator_info','survivor_brac_support','survivor_other_organization_support'])->find($id);
        // dd($data['incident']);
        $survivor_id = $data['incident']['survivor_id'];
        $survivor_name = $data['incident']['survivor_name'];
        // return view('backend.admin.incident.dummy-incident-view',$data);
        // $pdf = PDF::loadView('backend.admin.incident.pdf.incident-pdf', $data);
        $pdf = PDF::loadView('backend.admin.incident.single-incident', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        $fileName =  $survivor_id .'_'. $survivor_name . '.' . 'pdf' ;
        return $pdf->stream($fileName);
    }


    public function getIncidentDatatable(Request $request)
    {
        // dd($request->all());
        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date = date("Y-m-d", strtotime($request->to_date));
        // dd(Auth::id());
        // $auth_user      = User::with(['setup_user' => function ($query){
        //     $query->with(['setup_user_area']);
        // }])->where('id', Auth::id())->first();

        $auth_user      = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        // dd($auth_user->toArray());

        $incidents = SurvivorIncidentInformation::select('id', 'survivor_id', 'survivor_name', 'survivor_gender_id', 'survivor_age','violence_date','created_at');

        // $allDivisions = RegionAreaDetail::where('region_id', $request->region_id)->where('status','1')->groupBy('division_id')->pluck('division_id')->toArray();
        $reagionDivision            = RegionAreaDetail::where('region_id',$request->region_id)->where('division_id', $request->division_id)->where('status','1')->groupBy('district_id')->pluck('district_id')->toArray();
        $allDistrict    = RegionAreaDetail::where('region_id',$request->region_id)->where('status','1')->groupBy('district_id')->pluck('district_id')->toArray();
        // dd($allDivisions);

        if (!empty($request->region_id) && empty($request->division_id)) {
            $incidents->whereIn('employee_district_id', $allDistrict);
        } else if(!empty($request->division_id) && empty($request->district_id)){
            $incidents->whereIn('employee_district_id', $reagionDivision);
        } else {
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
                $incidents->where('survivor_union_id', $request->union_id);
            }
        }

        // if($request->division_id) {
        //     $incidents->where('employee_division_id', $request->division_id);
        // }
        // if($request->district_id) {
        //     $incidents->where('employee_district_id', $request->district_id);
        // }
        // if($request->upazila_id) {
        //     $incidents->where('employee_upazila_id', $request->upazila_id);
        // }
        // if($request->union_id) {
        //     $incidents->where('survivor_union_id', $request->union_id);
        // }
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
            $incidents->where('created_at', '>=', $from_date.' 00:00:00');
        }
        if($request->to_date) {
            $incidents->where('created_at', '<=', $to_date.' 23:59:59');
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
        ->editColumn('created_at', function ($incidents){
            return date('Y-m-d', strtotime($incidents->created_at));
        })
        ->addColumn('action_column', function(SurvivorIncidentInformation $incident) use($auth_user){
                // dd($auth_user->designation);
            $links = '<a href="'.route('incident.violence.edit', $incident->id).'" class="btn btn-sm btn-info" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
            <a href="'.route('incident.violence.details', $incident->id).'" target="__blank" class="btn btn-sm btn-primary" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                          // $auth_user      = User::with(['setup_user_area'])->where('id', Auth::id())->first();
            if ($auth_user->role_id == 2) {
                $links .=   '<a href="'.route('incident.violence.delete', $incident->id).'" class="btn btn-sm btn-danger deleteincident" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>';
            }
            return $links;
        })
        ->rawColumns(['action_column'])
        ->make(true);
    }






    public function delete($id)
    {

        SurvivorBracSupport::where('survivor_incident_info_id', $id)->delete();
        SurvivorOtherOrganizationSupport::where('survivor_incident_info_id', $id)->delete();
        SurvivorIncidentInformation::where('id', $id)->delete();

        return redirect()->route('incident.violence.view')->with('success','Succuessfully data Deleted');
    }

    public function testlist()
    {
        $divisions          = Division::all();
        $regions            = Region::where('status','1')->get();
        $violence_categories= ViolenceCategory::where('status','1')->get();
        $auth_user          = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        // dd($auth_user->toArray());
        return view('backend.admin.incident.incident_testlist',compact('divisions','violence_categories', 'regions'));
    }

    public function getIncidentTestDatatable(Request $request)
    {
        // dd($request->all());
        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date = date("Y-m-d", strtotime($request->to_date));

        $auth_user      = User::with(['setup_user_area'])->where('id', Auth::id())->first();

        $incidents = SurvivorIncidentInformation::select('id', 'survivor_id', 'survivor_name', 'survivor_gender_id', 'survivor_age','violence_date','created_at');

        $reagionDivision            = RegionAreaDetail::where('region_id',$request->region_id)->where('division_id', $request->division_id)->where('status','1')->groupBy('district_id')->pluck('district_id')->toArray();
        $allDistrict  = RegionAreaDetail::where('region_id',$request->region_id)->where('status','1')->groupBy('district_id')->pluck('district_id')->toArray();

        if (!empty($request->region_id) && empty($request->division_id)) {
            $incidents->whereIn('employee_district_id', $allDistrict);
        } else if(!empty($request->division_id) && empty($request->district_id)){
            $incidents->whereIn('employee_district_id', $reagionDivision);
        } else {
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
                $incidents->where('survivor_union_id', $request->union_id);
            }
        }

        if($request->violence_category_id) {
            $incidents->whereNull('violence_category_id');
        }
        if($request->gender) {
            $incidents->whereNull('survivor_gender_id');
        }
        if($request->age) {
            $incidents->whereNull('survivor_age');
        }
        if($request->reason) {
            $incidents->whereNull('violence_reason_id');
        }
        if($request->district_check) {
            $incidents->whereNull('employee_district_id');
        }
        if($request->from_date) {
            $incidents->where('created_at', '>=', $from_date.' 00:00:00');
        }
        if($request->to_date) {
            $incidents->where('created_at', '<=', $to_date.' 23:59:59');
        }

        $incidents->orderBy('id', 'DESC');


        return DataTables::of($incidents)
        ->addIndexColumn()
        ->editColumn('created_at', function ($incidents){
            return date('Y-m-d', strtotime($incidents->created_at));
        })
        ->addColumn('action_column', function(SurvivorIncidentInformation $incident) use($auth_user){
                // dd($auth_user->designation);
            $links = '<a href="'.route('incident.violence.edit', $incident->id).'" class="btn btn-sm btn-info" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
            <a href="'.route('incident.violence.details', $incident->id).'" target="__blank" class="btn btn-sm btn-primary" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>';
            if ($auth_user->role_id == 2) {
                $links .=   '<a href="'.route('incident.violence.delete', $incident->id).'" class="btn btn-sm btn-danger deleteincident" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>';
            }
            return $links;
        })
        ->rawColumns(['action_column'])
        ->make(true);
    }






    public function viewEmployeesList()
    {
        $divisions          = Division::all();
        $regions            = Region::where('status','1')->get();
        $violence_categories= ViolenceCategory::where('status','1')->get();
        $auth_user          = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        // dd($auth_user->toArray());
        return view('backend.admin.incident.incident_employeeslist',compact('divisions','violence_categories', 'regions'));
    }

    public function getEmployeesDatatable(Request $request)
    {
        // dd($request->all());
        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date = date("Y-m-d", strtotime($request->to_date));

        $incidents = BracEmployee::select('id','StaffName','Sex','Age','DateOfBirth','MobileNo','EmailID','DesignationName');

        if($request->gender) {
            $incidents->where('Sex', $request->gender);
        }
        if($request->age) {
            $incidents->where('Age', $request->age);
        }
        if($request->mobile_number) {
            $incidents->whereNotNull('MobileNo');
        }
        if($request->from_date) {
            $incidents->where('DateOfBirth', '>=', $from_date);
        }
        if($request->to_date) {
            $incidents->where('DateOfBirth', '<=', $to_date);
        }

        $incidents->orderBy('id', 'DESC');


        return DataTables::of($incidents)
        ->addIndexColumn()
        ->rawColumns([''])
        ->make(true);
    }



    public function addIncident()
    {
        $data['user_info']              =   Auth::user();
        $data['divisions']              =   Division::where('status',1)->get();
        $data['selpZone']               =   Selpzone::where('status',1)->get();
        $data['informationProvider']    =   InformationProviderSource::where('status',1)->get();
        $data['bracProgram']            =   Bracprogramname::where('status',1)->get();
        $data['genders']                =   Gender::where('status',1)->get();
        $data['selpInitiatives']        =   SelpFirstInitiative::where('status',1)->get();
        $data['educations']             =   Education::where('status',1)->get();
        $data['religions']              =   Religion::where('status',1)->get();
        $data['houseHoldType']          =   Householdtype::where('status',1)->get();
        $data['disputeTypes']           =   ViolenceName::where('status',1)->get();
        $data['maritalStatus']          =   MaritalStatus::where('status',1)->get();
        $data['organizalAffiliation']   =   SurvivorSupportName::where('status',1)->get();
        $data['violenceReason']         =   ViolenceReason::where('status',1)->get();
        $data['violenceLocation']       =   ViolenceLocation::where('status',1)->get();
        $data['violencePlace']          =   SurvivorViolencePlace::where('status',1)->get();
        $data['disabilityStatus']       =   SurvivorAutisticInformation::where('status',1)->get();
        $data['perpetratorRelation']    =   SurvivorRelationship::where('status',1)->get();
        $data['occupations']             =   Occupation::where('status',1)->get();
        $data['survivorInitiatives']    =   Survivorinitiative::where('status',1)->get();
        $data['selpFailour']            =   SelpComingOrFailour::where('status',1)->get();
        $data['adrs']                    =   AlternativeDisputeResolution::where('status',1)->get();
        $data['adrMoneyRecover']        =   Adrmoneyrecover::where('status',1)->get();
        $data['civilCase']              =   Civilcase::where('status',1)->get();
        $data['policeCase']             =   Policecase::where('status',1)->get();
        $data['petitionCase']           =   Pititioncase::where('status',1)->get();
        $data['moneyRecoverCourteCase'] =   Moneyrecover::where('status',1)->get();
        $data['judgementStatus']        =   Judgementstatus::where('status',1)->get();
        $data['findingsFromFollowUp']   =   Followup::where('status',1)->get();
        $data['violenceTypes']          =   ViolenceName::where('status',1)->get();
        $data['bracSupport']            =   Bracsupporttypes::where('status',1)->get();

        return view('backend.admin.selp_incident.incident_form_new', $data);
        // return view('backend.admin.selp_incident.incident_form',
        //         compact('bracSupport','violenceTypes','findingsFromFollowUp','judgementStatus',
                        
        //         'moneyRecoverCourteCase','petitionCase','policeCase','civilCase','adrMoneyRecover','adr',
        //         'selpFailour','survivorInitiatives','occupation','perpetratorRelation','disabilityStatus','violencePlace',
        //         'violenceLocation','violenceReason','organizalAffiliation','maritalStatus','disputeTypes','houseHoldType',
        //         'religion','education','selpInitiatives','gender','bracProgram','informationProvider','selpZone','divisions'
        //         )
        //         );
    }


    public function redirectForNewIncident(Request $request){
       return redirect()->route('incident.selp.add',['addNew'=>true]);
    }
}
