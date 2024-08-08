<?php

namespace App\Http\Controllers\Backend\Admin;

use PDF;
use Auth;
use App\User;
use App\Model\Civilcase;
use App\Model\Policecase;
use App\Model\BracEmployee;
use App\Model\Pititioncase;
use Illuminate\Http\Request;
use App\Exports\MisReportExport;
use App\Model\Admin\Setup\Union;
use App\Model\SelpIncidentModel;
use App\Model\Admin\Setup\Upazila;
use App\Model\Admin\Setup\Village;
use App\Model\Admin\Setup\District;
use App\Model\Admin\Setup\Division;
use App\Model\Admin\Setup\Religion;
use App\Http\Controllers\Controller;
use App\Model\Admin\Setup\Pourosova;
use Maatwebsite\Excel\Facades\Excel;
use App\Model\Admin\Setup\ViolenceName;
use App\Model\Admin\Setup\CityCorporation;
use App\Model\Admin\Setup\OrganizationName;
use App\Model\Admin\Setup\CEP_Region\Region;
use App\Model\Admin\Setup\ViolenceSubCategory;
use App\Model\Admin\Setup\SurvivorFinalSupport;
use App\Model\Admin\Setup\CEP_Region\SetupUserArea;
use App\Model\Admin\Setup\InformationProviderSource;
use App\Model\Admin\Setup\CEP_Region\RegionAreaDetail;
use App\SwapnosarothiSetupGroup;

class DefaultController extends Controller
{
    // public function sqlinject(){
    //     $data = SurvivorIncidentInformation::whereBetween('violence_date',['2016-01-01', '2016-12-31'])->get();
    //     // dd($data->toArray());
    //     foreach ($data as $key => $v) {
    //         $update = SurvivorIncidentInformation::find($v->id);
    //         $update->created_at = date('Y-m-d H:m:s', strtotime($v->violence_date));
    //         $update->save();

    //         echo "success<br>";
    //     }
    //     dd('ok');
    // }

    // public function sqlinject(){
    //     $data = DB::table('demodata2')->get();
    //     foreach ($data as $key => $v) {
    //         $update = DemoData::find($v->id);
    //         $update->survivors_final_support_id1 = $v->survivors_final_support_id1;
    //         $update->survivors_final_support_id2 = $v->survivors_final_support_id2;
    //         $update->save();
    //     }
    //     dd('ok');
    // }

    // public function sqlinject(){
    //     $aa = "createdd_at,employee_name,employee_mobile_number,employee_designation,employee_pin,employee_division_id,employee_district_id,employee_upazila_id,source,survivor_organization_name_id,violence_category_id,violence_sub_category_id,violence_name_id,violence_date,violence_time,violence_place_id,violence_reason_id,survivor_name,survivor_father_name,survivor_mother_name,survivor_husband_name,survivor_mobile_no,survivor_age,survivor_gender_id,survivor_religion_id,survivor_marital_status_id,survivor_monthly_income,survivor_occupation_id,survivor_organization_type_id,survivor_incident_place_id,survivor_autistic_id,survivor_division_id,survivor_district_id,survivor_upazila_id,survivor_village,perpetrator_name,perpetrator_marital_status_id,perpetrator_gender_id,perpetrator_age,perpetrator_place_id,perpetrator_occupation_id,perpetrator_relationship_id,perpetrator_others_relationship,perpetrator_division_id,perpetrator_district_id,perpetrator_upazila_id,case_status,survivors_situation_id,survivors_place_id,survivors_final_support_id1,survivors_final_support_id2";
    //     $expl = explode(',', $aa);
    //     $html = "CREATE TABLE `demodata` (";
    //     for ($i=0; $i < count($expl) ; $i++) {
    //         $html .=$expl[$i]." char(191) NULL,";
    //     }
    //     $html .=")";
    //     dd($html);
    // }

    // public function sqlinject(){
    //     $alldata = DemoData::all();
    //     foreach ($alldata as $key => $v) {
    //         $datum = DemoData::find($v->id);
    //         $datum->violence_category_id = ViolenceCategory::where('name',$datum->violence_category_id)->first()['id'] ?? null;
    //         $datum->violence_sub_category_id = ViolenceSubCategory::where([['violence_category_id',$datum->violence_category_id],['name',$datum->violence_sub_category_id]])->first()['id'] ?? null;
    //         $datum->violence_name_id = ViolenceName::where([['violence_category_id',$datum->violence_category_id],['violence_sub_category_id',$datum->violence_sub_category_id],['name',$datum->violence_name_id]])->first()['id'] ?? null;
    //         $datum->survivor_religion_id = Gender::where('name',$datum->survivor_religion_id)->first()['id'] ?? null;
    //         $datum->violence_place_id = SurvivorViolencePlace::where('name',$datum->violence_place_id)->first()['id'] ?? null;
    //         $datum->violence_reason_id = ViolenceReason::where('name',$datum->violence_reason_id)->first()['id'] ?? null;
    //         $datum->survivor_religion_id = Religion::where('name',$datum->survivor_religion_id)->first()['id'] ?? null;
    //         $datum->save();
    //     }

    //     dd('ViolenceCategory');

    // }

    // public function sqlinject(){
    //     $alldata = DemoData::all();
    //     foreach ($alldata as $key => $v) {
    //         $datum = DemoData::find($v->id);
    //         $datum->survivor_marital_status_id = MaritalStatus::where('name',$datum->survivor_marital_status_id)->first()['id'] ?? null;
    //         $datum->survivor_occupation_id = Occupation::where('name',$datum->survivor_occupation_id)->first()['id'] ?? null;
    //         $datum->survivor_organization_type_id = OrganizationType::where('name',$datum->survivor_organization_type_id)->first()['id'] ?? null;
    //         $datum->survivor_incident_place_id = SurvivorIncidentPlace::where('name',$datum->survivor_incident_place_id)->first()['id'] ?? null;
    //         $datum->survivor_autistic_id =SurvivorAutisticInformation::where('name',$datum->survivor_autistic_id)->first()['id'] ?? null;
    //         $datum->perpetrator_place_id =PerpetratorPlace::where('name',$datum->perpetrator_place_id)->first()['id'] ?? null;
    //         $datum->perpetrator_relationship_id =SurvivorRelationship::where('name',$datum->perpetrator_relationship_id)->first()['id'] ?? null;
    //         $datum->perpetrator_others_relationship =SurvivorRelationship::where('name',$datum->perpetrator_others_relationship)->first()['id'] ?? null;
    //         $datum->survivors_place_id =SurvivorIncidentPlace::where('name',$datum->survivors_place_id)->first()['id'] ?? null;
    //         $datum->survivors_situation_id =SurvivorSituation::where('name',$datum->survivors_situation_id)->first()['id'] ?? null;
    //         $datum->save();
    //     }
    //         dd('MaritalStatus');
    // }

    // public function sqlinject(){
    //     $alldata = DemoData::all();
    //     foreach ($alldata as $key => $v) {
    //         $datum = DemoData::find($v->id);
    //         $datum->survivors_final_support_id1 =SurvivorFinalSupport::where('name',$datum->survivors_final_support_id1)->first()['id'] ?? $v->survivors_final_support_id1;
    //         $datum->survivors_final_support_id2 =SurvivorFinalSupport::where('name',$datum->survivors_final_support_id2)->first()['id'] ?? $v->survivors_final_support_id2;
    //         $datum->save();
    //     }
    //     dd('SurvivorBracSupport');
    // }

    // public function sqlinject(){
    //     $alldata = DemoData::all();
    //     foreach ($alldata as $key => $v) {
    //         $datum = DemoData::find($v->id);
    //         $datum->employee_division_id =Division::where('name',$datum->employee_division_id)->first()['id'] ?? $datum->employee_division_id;
    //         $datum->employee_district_id =District::where([['division_id',$datum->employee_division_id],['name',$datum->employee_district_id]])->first()['id'] ?? $datum->employee_district_id;
    //         $datum->employee_upazila_id =Upazila::where([['district_id',$datum->employee_district_id],['name',$datum->employee_upazila_id]])->first()['id'] ?? $datum->employee_upazila_id;
    //         $datum->survivor_division_id =Division::where('name',$datum->survivor_division_id)->first()['id'] ?? $datum->survivor_division_id;
    //         $datum->survivor_district_id =District::where([['division_id',$datum->survivor_division_id],['name',$datum->survivor_district_id]])->first()['id'] ?? $datum->survivor_district_id;
    //         $datum->survivor_upazila_id =Upazila::where([['district_id',$datum->survivor_district_id],['name',$datum->survivor_upazila_id]])->first()['id'] ?? $datum->survivor_upazila_id;
    //         $datum->perpetrator_division_id =Division::where('name',$datum->perpetrator_division_id)->first()['id'] ?? $datum->perpetrator_division_id;
    //         $datum->perpetrator_district_id =District::where([['division_id',$datum->perpetrator_division_id],['name',$datum->perpetrator_district_id]])->first()['id'] ?? $datum->perpetrator_district_id;
    //         $datum->perpetrator_upazila_id =Upazila::where([['district_id',$datum->perpetrator_district_id],['name',$datum->perpetrator_upazila_id]])->first()['id'] ?? $datum->perpetrator_upazila_id;
    //         $datum->save();
    //     }
    //     dd('employee_division_id');
    // }

    // public function sqlinject(){
    //     $alldata = DemoData::all();
    //     foreach ($alldata as $key => $v) {
    //         $datum = DemoData::find($v->id);
    //         $datum->createdd_at =date('Y-m-d H:i:s',strtotime($v->createdd_at)) ;
    //         $datum->violence_date =date('Y-m-d',strtotime($v->violence_date)) ;
    //         $datum->violence_time =date('H:i:s',strtotime($v->violence_time)) ;
    //         $datum->save();
    //     }
    //     dd('created_date');
    // }

    // public function sqlinject(){
    //     $alldata = DemoData::all();
    //     foreach ($alldata as $key => $v) {
    //         $data = $v->toArray();
    //         // if ($data['created_at'] == NULL) {
    //         //     dd($data['created_at']);
    //         // }
    //         // $data['createdd_at'] = $data['created_at'];
    //         $incident = SurvivorIncidentInformation::orderBy('id','DESC')->first();
    //         if($incident == null){
    //             $firstReg = 0;
    //             $survivor_id = $firstReg+1;
    //         }else{
    //             $incident = SurvivorIncidentInformation::orderBy('id','DESC')->first()->survivor_id;
    //             $survivor_id = $incident+1;
    //         }

    //         $data['survivor_id'] = $survivor_id;
    //         if (isset($data['violence_reason_id'])) {
    //             if ($data['violence_reason_id'] == 1) {
    //                 $data['violence_reason_id'] = null;
    //             }else{
    //                 $data['violence_reason_id'] = $data['violence_reason_id'];
    //             }
    //         }

    //         if (isset($data['perpetrator_family_member_id'])) {
    //             if ($data['perpetrator_family_member_id'] == 1) {
    //                 $data['perpetrator_family_member_id'] = null;
    //             }else{
    //                 $data['perpetrator_family_member_id'] = $data['perpetrator_family_member_id'];
    //             }
    //         }

    //         $data['violence_date'] = $v->violence_date ? date('Y-m-d',strtotime($v->violence_date)) : null;
    //         if(isset($v->survivor_organization_type_id)){
    //             $data['survivor_organization_type_id'] = $v->survivor_organization_type_id;
    //         }
    //         $data['created_by'] = Auth::user()->id;
    //         if($v->provider_applicable_status==null){
    //             $data['provider_applicable_status'] = '0';
    //         }else{
    //             $data['provider_applicable_status'] = $v->provider_applicable_status;
    //         }
    //         if($v->violence_applicable_status==null){
    //             $data['violence_applicable_status'] = '0';
    //         }else{
    //             $data['violence_applicable_status'] = $v->violence_applicable_status;
    //         }
    //         if($v->survivor_applicable_status==null){
    //             $data['survivor_applicable_status'] = '0';
    //         }else{
    //             $data['survivor_applicable_status'] = $v->survivor_applicable_status;
    //         }
    //         if($v->case_applicable_status==null){
    //             $data['case_applicable_status'] = '0';
    //         }else{
    //             $data['case_applicable_status'] = $v->case_applicable_status;
    //         }
    //         if($v->current_situation_applicable_status==null){
    //             $data['current_situation_applicable_status'] = '0';
    //         }else{
    //             $data['current_situation_applicable_status'] = $v->current_situation_applicable_status;
    //         }

    //         $saveData = SurvivorIncidentInformation::create($data);
    //         DB::transaction(function() use($v,$data,$saveData){
    //             if($saveData){
    //                 if(isset($v->survivors_final_support_id1)){
    //                     // $brac_support_count = count($v->survivors_final_support_id1);
    //                     // for ($j=0; $j < $brac_support_count; $j++) {
    //                         $brac_support = new SurvivorBracSupport();
    //                         $brac_support->survivor_incident_info_id = $saveData->id;
    //                         $brac_support->survivor_id = $saveData->survivor_id;
    //                         // $brac_support->survivor_support_applicable_status = $v->survivor_support_applicable_status;
    //                         $brac_support->survivor_support_date = $v->survivor_support_date ? date('Y-m-d',strtotime($v->survivor_support_date)) : null;
    //                         $brac_support->survivor_final_support_id = $v->survivors_final_support_id1;
    //                         $brac_support->brac_program_id = $v->brac_program_id;
    //                         $brac_support->brac_support_description = $v->brac_support_description;
    //                         $brac_support->save();
    //                     // }
    //                 }else{
    //                     $brac_support = new SurvivorBracSupport();
    //                     $brac_support->survivor_incident_info_id = $saveData->id;
    //                     $brac_support->survivor_id = $saveData->survivor_id;
    //                     if($v->survivor_support_date==null){
    //                         $brac_support->survivor_support_date = null;
    //                     }else{
    //                         $brac_support->survivor_support_date = date('Y-m-d',strtotime($v->survivor_support_date));
    //                     }
    //                     $brac_support->save();
    //                 }
    //                 if(isset($v->survivors_final_support_id2)){
    //                     // $other_support_count = count($v->survivor_final_support_other_id);
    //                     // for ($k=0; $k < $other_support_count; $k++) {
    //                         $other_support = new SurvivorOtherOrganizationSupport();
    //                         $other_support->survivor_incident_info_id = $saveData->id;
    //                         $other_support->survivor_id = $saveData->survivor_id;
    //                         $other_support->survivor_final_support_id = $v->survivors_final_support_id2;
    //                         $other_support->other_program = $v->other_program;
    //                         $other_support->other_organization_support_description = $v->other_organization_support_description;
    //                         $other_support->save();
    //                     // }
    //                 }else{
    //                     $other_support = new SurvivorOtherOrganizationSupport();
    //                     $other_support->survivor_incident_info_id = $saveData->id;
    //                     $other_support->survivor_id = $saveData->survivor_id;
    //                     $other_support->save();
    //                 }
    //             }
    //         });
    //     }
    //         dd('success');
    // }

    public function PageNotFound()
    {
        return view('backend.unauthorize');
    }

    public function getDivision(Request $request)
    {
        $region_id       = $request->region_id;
        $admin_role_i    = loginUserRole()->user_role->pluck('role_id')->toArray();
        $groupByDivision = SetupUserArea::where('user_id', Auth::id())->pluck('division_id')->toArray();

        if ($admin_role_i[0] != 5 && $admin_role_i[0] != 4) {
            if (count(session()->get('userareaaccess.sdivisions')) != 0) {
                $allDivision = RegionAreaDetail::with(['regional_division'])
                    ->whereIn('division_id', session()->get('userareaaccess.sdivisions'))
                    ->where('status', '1')
                    ->groupBy('division_id')
                    ->get();
            } else {
                $allDivision = RegionAreaDetail::with(['regional_division'])
                    ->where('region_id', $region_id)
                    ->where('status', '1')
                    ->groupBy('division_id')
                    ->get();
            }
        } else {
            if (count(session()->get('userareaaccess.sdivisions')) != 0) {
                $allDivision = RegionAreaDetail::with(['regional_division'])
                    ->whereIn('division_id', session()->get('userareaaccess.sdivisions'))
                    ->where('region_id', $region_id)->whereIn('division_id', array_unique($groupByDivision))
                    ->where('status', '1')
                    ->groupBy('division_id')
                    ->get();
            } else {
                $allDivision = RegionAreaDetail::with(['regional_division'])
                    ->where('region_id', $region_id)
                    ->whereIn('division_id', array_unique($groupByDivision))
                    ->where('status', '1')
                    ->groupBy('division_id')
                    ->get();
            }
        }
        // if (count(session()->get('userareaaccess.sdivisions')) != 0) {
        //   $allDivision = RegionAreaDetail::with(['regional_division'])->whereIn('division_id', session()->get('userareaaccess.sdivisions'))->where('region_id', $region_id)->where('status', '1')->groupBy('division_id')->get();
        // } else {
        //     $allDivision = RegionAreaDetail::with(['regional_division'])->where('region_id', $region_id)->where('status', '1')->groupBy('division_id')->get();
        // }

        return response()->json($allDivision);
    }

    public function getgetDistricByRegion(Request $request)
    {
        $region_id    = $request->region_id;
        $division_id  = $request->division_id;
        $admin_role_i = loginUserRole()->user_role->pluck('role_id')->toArray();

        $groupByDistrict = SetupUserArea::where('user_id', Auth::id())->pluck('district_id')->toArray();

        if ($admin_role_i[0] != 5 && $admin_role_i[0] != 4) {

            if (count(session()->get('userareaaccess.sdistricts')) != 0) {
                $allDistrict = RegionAreaDetail::with(['regional_district'])

                    ->whereIn('district_id', session()->get('userareaaccess.sdistricts'))
                    ->where([['division_id', $division_id], ['region_id', $region_id]])
                    ->where('status', '1')
                    ->groupBy('district_id')->get();
            } else {
                $allDistrict = RegionAreaDetail::with(['regional_district'])
                    ->where([['division_id', $division_id], ['region_id', $region_id]])
                    ->where('status', '1')
                    ->groupBy('district_id')
                    ->get();
            }
        } else {

            if (count(session()->get('userareaaccess.sdistricts')) != 0) {
                $allDistrict = RegionAreaDetail::with(['regional_district'])->whereIn('district_id', session()->get('userareaaccess.sdistricts'))->where([['division_id', $division_id], ['region_id', $region_id]])->whereIn('district_id', array_unique($groupByDistrict))->where('status', '1')->groupBy('district_id')->get();
            } else {
                $allDistrict = RegionAreaDetail::with(['regional_district'])->where([['division_id', $division_id], ['region_id', $region_id]])->whereIn('district_id', array_unique($groupByDistrict))->where('status', '1')->groupBy('district_id')->get();
            }
        }

        // if (count(session()->get('userareaaccess.sdistricts')) != 0) {
        //     $allDistrict = RegionAreaDetail::with(['regional_district'])->whereIn('district_id', session()->get('userareaaccess.sdistricts'))->where([['division_id', $division_id], ['region_id', $region_id]])->where('status', '1')->groupBy('district_id')->get();
        // } else {
        //     $allDistrict = RegionAreaDetail::with(['regional_district'])->where([['division_id', $division_id], ['region_id', $region_id]])->where('status', '1')->groupBy('district_id')->get();
        // }

        // dd($allDistrict);
        return response()->json($allDistrict);
    }

    public function getUpazilaByRegion(Request $request)
    {
        $region_id      = $request->region_id;
        $district_id    = $request->district_id;
        $user_id        = Auth::id();
        $admin_role_i   = loginUserRole()->user_role->pluck('role_id')->toArray();
        $groupByUpazila = SetupUserArea::where('user_id', $user_id)->pluck('upazila_id')->toArray();
        if ($admin_role_i[0] != 5) {

            $allUpazila = Upazila::where('district_id', $district_id)->get();
        } else {

            $allUpazila = Upazila::where('district_id', $district_id)->whereIn('id', array_unique($groupByUpazila))->get();
        }

        // if (count(session()->get('userareaaccess.supazilas')) != 0) {
        //     $allUpazila = SetupUserArea::with(['setup_user_upazila'])
        //         ->whereIn('upazila_id', session()
        //                 ->get('userareaaccess.supazilas'))
        //         ->where([['district_id', $district_id]])
        //         ->where('status', '1')
        //         ->groupBy('upazila_id')
        //         ->get();
        //     if (count($allUpazila) == 0) {
        //         $allUpazila = Upazila::where('district_id', $district_id)->where('status', '1')->get();
        //     }
        //     return response()->json($allUpazila);
        // } else {
        //     $allUpazila = Upazila::where('district_id', $district_id)->where('status', '1')->get();
        // }

        // dd($allUpazila);
        return response()->json($allUpazila);
    }

    public function getDistrict(Request $request)
    {
        $division_id        = $request->division_id;
        $allDistrict        = District::where('division_id', $division_id)->get();
        $allCityCorporation = CityCorporation::where('division_id', $division_id)->get();
        return response()->json([$allDistrict, $allCityCorporation]);
    }

    public function getUpazila(Request $request)
    {
        $district_id = $request->district_id;

        $allUpazila = Upazila::where('district_id', $district_id)->get();

        $allPourosova = Pourosova::where('district_id', $district_id)->get();
        return response()->json([$allUpazila, $allPourosova]);
    }

    public function getDistrictMaster(Request $request)
    {
        $division_id = $request->division_id;
        $allDistrict = District::where('division_id', $division_id)->get();
        // $allCityCorporation = CityCorporation::where('division_id',$division_id)->get();
        return response()->json($allDistrict);
    }

    public function getUpazilaMaster(Request $request)
    {
        $district_id = $request->district_id;
        $allUpazila  = Upazila::where('district_id', $district_id)->get();
        // $allPourosova = Pourosova::where('district_id',$district_id)->get();
        return response()->json($allUpazila);
    }

    public function getUnion(Request $request)
    {
        $upazila_id = $request->upazila_id;
        $allUnion   = Union::where('upazila_id', $upazila_id)->get();
        return response()->json($allUnion);
    }

    public function getVillage(Request $request)
    {
        $union_id    = $request->union_id;
        $allVillages = Village::where('union_id', $union_id)->get();
        return response()->json($allVillages);
    }

    public function getViolenceSubCategory(Request $request)
    {
        $violence_category_id = $request->violence_category_id;
        $allSubCategory       = ViolenceSubCategory::where('violence_category_id', $violence_category_id)->get();
        return response()->json($allSubCategory);
    }

    public function getViolenceName(Request $request)
    {
        $violence_sub_category_id = $request->violence_sub_category_id;
        $allViolenceName          = ViolenceName::where('violence_sub_category_id', $violence_sub_category_id)->get();
        return response()->json($allViolenceName);
    }

    public function getOrganizationName(Request $request)
    {
        $organization_type_id = $request->organization_type_id;
        $allOrganizationType  = OrganizationName::where('support_organization_id', $organization_type_id)->get();
        return response()->json($allOrganizationType);
    }

    public function getSupportName(Request $request)
    {
        $survivor_support_organization_id = $request->survivor_support_organization_id;
        $allSupportName                   = SurvivorFinalSupport::where('survivor_support_organization_id', $survivor_support_organization_id)->get();
        return response()->json($allSupportName);
    }

    public function getCaseList(Request $request)
    {
        $case_type = $request->case_type;
        if ($case_type == 1) {
            $allCases = Civilcase::where('status', 1)->get();
        }

        if ($case_type == 2) {
            $allCases = Policecase::where('status', 1)->get();
        }

        if ($case_type == 3) {
            $allCases = Pititioncase::where('status', 1)->get();
        }

        return response()->json($allCases);
    }

    public function getEmployees()
    {
        $data = BracEmployee::all();

        foreach ($data as $key => $d) {
            $sub                  = substr($d->LevelDate, 0, 10);
            $subbb                = substr($d->TransferDate, 0, 10);
            $subbbb               = substr($d->StatusDate, 0, 10);
            $update               = BracEmployee::find($d->id);
            $update->LevelDate    = $sub;
            $update->TransferDate = $subbb;
            $update->StatusDate   = $subbbb;
            $update->save();
        }
    }

    public function getEmployeeApi(Request $request)
    {
        // $string = file_get_contents("http://api.brac.net/v1/staffs?Key=c20f2758-9cd2-4a8d-9473-8fb89b9a677e&q=ProgramID=18&fields=PIN,StaffName,DesignationName,EmailID,MobileNo");
        $i = "";
        for ($i = 100000; $i <= 105000; $i++) {
            // $string[] = json_decode(file_get_contents("http://api.brac.net/v1/staffs/".$i."/?Key=7f50671f-09ce-4b68-ac75-5861b1fd22da&fields=StaffPIN,StaffName,DesignationName,EmailID,MobileNo,Age,Sex,DateOfBirth"), true);
            $string[] = json_decode(file_get_contents("http://api.brac.net/v1/staffs/" . $i . "/?Key=7f50671f-09ce-4b68-ac75-5861b1fd22da"), true);
        }

        $js_array = [];
        foreach ($string as $key => $s) {
            $js_array = array_merge($js_array, (array) $s);
        }

        $data = '';
        foreach ($js_array as $key => $value) {
            $data                       = new BracEmployee();
            $data->StaffPIN             = $value['StaffPIN'];
            $data->StaffName            = @$value['StaffName'];
            $data->DateOfBirth          = substr(@$value['DateOfBirth'], 0, 10);
            $data->Age                  = @$value['Age'];
            $data->Sex                  = @$value['Sex'];
            $data->MobileNo             = @$value['MobileNo'];
            $data->EmailID              = @$value['EmailID'];
            $data->Religion             = @$value['Religion'];
            $data->EducationID          = @$value['EducationID'];
            $data->LastEducation        = @$value['LastEducation'];
            $data->EducationGroupID     = @$value['EducationGroupID'];
            $data->EducationGroupName   = @$value['EducationGroupName'];
            $data->JoiningDate          = substr(@$value['JoiningDate'], 0, 10);
            $data->DesignationID        = @$value['DesignationID'];
            $data->DesignationName      = @$value['DesignationName'];
            $data->DesignationGroupID   = @$value['DesignationGroupID'];
            $data->DesignationGroupName = @$value['DesignationGroupName'];
            $data->LastPromotionDate    = @$value['LastPromotionDate'];
            $data->JobLevel             = @$value['JobLevel'];
            $data->LevelDate            = substr(@$value['LevelDate'], 0, 10);
            $data->TransferDate         = substr(@$value['TransferDate'], 0, 10);
            $data->JobBase              = @$value['JobBase'];
            $data->Status               = @$value['Status'];
            $data->StatusDate           = substr(@$value['StatusDate'], 0, 10);
            $data->BloodGroup           = @$value['BloodGroup'];
            $data->ProgramID            = @$value['ProgramID'];
            $data->HR_ProgramID         = @$value['HR_ProgramID'];
            $data->ProgramName          = @$value['ProgramName'];
            $data->ProjectID            = @$value['ProjectID'];
            $data->HR_ProjectID         = @$value['HR_ProjectID'];
            $data->ProjectName          = @$value['ProjectName'];
            $data->DivisionID           = @$value['DivisionID'];
            $data->HR_DivisionID        = @$value['HR_DivisionID'];
            $data->DivisionName         = @$value['DivisionName'];
            $data->DistrictID           = @$value['DistrictID'];
            $data->HR_DistrictID        = @$value['HR_DistrictID'];
            $data->DistrictName         = @$value['DistrictName'];
            $data->UpazilaID            = @$value['UpazilaID'];
            $data->HR_UpazilaID         = @$value['HR_UpazilaID'];
            $data->UpazilaName          = @$value['UpazilaName'];
            $data->BranchID             = @$value['BranchID'];
            $data->HR_BranchID          = @$value['HR_BranchID'];
            $data->BranchName           = @$value['BranchName'];
            $data->RegionID             = @$value['RegionID'];
            $data->RegionName           = @$value['RegionName'];
            $data->save();
        }
    }

    public function getSwapnoSarothiGroups(Request $request)
    {
        $region_id      = $request->region_id;
        $division_id    = $request->division_id;
        $district_id    = $request->district_id;
        $upazila_id     = $request->upazila_id;
        $union_id       = $request->union_id;

        $groups = SwapnosarothiSetupGroup::when($region_id, function ($query) use ($region_id) {
            $query->where('zone_id', $region_id);
        })->when($division_id, function ($query) use ($division_id) {
            $query->where('division_id', $division_id);
        })->when($district_id, function ($query) use ($district_id) {
            $query->where('district_id', $district_id);
        })->when($upazila_id, function ($query) use ($upazila_id) {
            $query->where('upazila_id', $upazila_id);
        })->when($union_id, function ($query) use ($union_id) {
            $query->where('union_id', $union_id);
        })->where('status', 1)
            ->get();

        return response()->json($groups);
    }
}
