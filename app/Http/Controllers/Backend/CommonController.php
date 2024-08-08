<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Model\Admin\Account\PayFixation;
use App\Model\Admin\Account\Paygrade;
use App\Model\Admin\Employee\Employee;
use App\Model\Admin\Hrm\Holiday;
use App\Model\Admin\Setup\Organogram;
use App\Model\Admin\Setup\Upazila;
use App\Model\Admin\Vehicle\PurchaseRequisition;
use App\Model\Admin\Vehicle\Vehicle;
use App\User;
use DB;
use Illuminate\Http\Request;

class CommonController extends Controller
{
   public function delete(Request $request){
    $delete=DB::table($request->table)->where('id', $request->id)->delete();
}

public function getDesignation(Request $request){
    $designations=Organogram::where('department_id',$request->department_id)->orderBy('sort_order','asc')->get();
    echo '<option value="">--Select Post--</option>';
    foreach ($designations as $designation) {
        echo '<option value="'.$designation->academic_designation_id.'">'.$designation['designation']->designation_name_en.'</option>';
    }
}

public function getLeaveAuthority(Request $request){
   $designations=Organogram::where('academic_designation_id',$request->academy_designation_id)->first();
   $leave_authority=Organogram::where('sort_order','<=', $designations->sort_order)->orderBy('sort_order','asc')->get();
        // return $authority;
   echo '<option value="">--Select Post--</option>';
   foreach ($leave_authority as $la) {
      echo '<option value="'.$la->academic_designation_id.'">'.$la['designation']->designation_name_en.'</option>';
  }
}

public function getPresentUpazila(Request $request){
    $upazilas=Upazila::where('district_id',$request->pre_district_id)->get();
    echo '<option value="">--Select Upazila--</option>';
    foreach ($upazilas as $upazila) {
        echo '<option value="'.$upazila->id.'">'.$upazila->name.'</option>';
    }
}
public function getPermanentUpazila(Request $request){
    $upazilas=Upazila::where('district_id',$request->per_district_id)->get();
    echo '<option value="">--Select Upazila--</option>';
    foreach ($upazilas as $upazila) {
        echo '<option value="'.$upazila->id.'">'.$upazila->name.'</option>';
    }
}
public function getEmployee(Request $request){
    $employees=Employee::with(['userInfo'])
    ->where('department_id',$request->department_id)
    ->where('academy_designation_id',$request->academy_designation_id)->get();
    echo '<option value="">--Select Employee--</option>';
    foreach ($employees as $employee) {
        echo '<option value="'.$employee->user_id.'">'.$employee['userInfo']->name.'</option>';
    }
}
public function getEmployeeByDes(Request $request){
    $employees=Employee::with(['userInfo'])
    ->where('academy_designation_id',$request->academy_designation_id)->get();
    echo '<option value="">--Select Employee--</option>';
    foreach ($employees as $employee) {
        echo '<option value="'.$employee->user_id.'">'.$employee['userInfo']->name.'</option>';
    }
}

public function getEmployeeByDept(Request $request){
    $employees=Employee::with(['userInfo'])
    ->where('department_id',$request->department_id)
    ->get();
    echo '<option value="">--Select Employee--</option>';
    foreach ($employees as $employee) {
        echo '<option value="'.$employee->user_id.'">'.$employee['userInfo']->name.'</option>';
    }
}

public function getEmployeeDetail(Request $request){
    $employee_detail=Employee::with(['userInfo'])->where('user_id',$request->employee_user_id)->first();
    return response()->json($employee_detail);
}
public function getEmployeePaygrade(Request $request){
    $data=PayFixation::with('paygrade')->where('user_id',$request->employee_user_id)
    ->first();
    return response()->json($data);
}
public function getPaygrade(Request $request){
    $paygrades=Paygrade::where('payscale_id',$request->payscale_id)->get();
    echo '<option value="">--Select Paygrade--</option>';
    foreach ($paygrades as $payrade) {
        echo '<option value="'.$payrade->id.'">'.$payrade->paygrade_name.'</option>';
    }
}

public function getHoliday(){
    $hds=Holiday::whereYear('holiday_date',date('Y'))->get();
    $holidays=[];
    foreach ($hds as $key => $hd) {
            // $holidays[$hd->id]['id']=$hd->id;
        $holidays[$key]=$hd->holiday_date;
    }
    echo json_encode($holidays);
        // return response()->json($holidays);
}

public function getLicence(Request $request){
    $data['licence_no'] = Employee::where('user_id',$request->driver_id)->first()->licence_no;
    return response()->json($data);
}

public function getRequisitionNo(Request $request){
    $requisition_no = PurchaseRequisition::where('vehicle_registration_no',$request->vehicle_registration_no)->get();
    echo '<option value="">--Select Purchase Requisition No--</option>';
    foreach ($requisition_no as $rn) {
        echo '<option value="'.$rn->requisition_no.'">'.$rn->requisition_no.'</option>';
    }
        // return response()->json($requisition_no);
}

public function getRequisitionAll(Request $request){
    $requisition = PurchaseRequisition::with(['approved_items','approved_items.accessories'])
    ->where('requisition_no',$request->purchase_requisition_no)->first();
    // if (!empty($previous_requisition)) {
    //     return response()->json($previous_requisition);
    // }else{
    //     return response()->json('msg');
    // }
    return response()->json($requisition);
}

public function getDriver(Request $request){
    $vehicle_driver_id  = Vehicle::where('registration_no',$request->vehicle_registration_no)->first()->driver_id;
    $driver_info        = User::find($vehicle_driver_id);
    return response()->json($driver_info);
}

}
