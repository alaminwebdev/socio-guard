<?php

namespace App\Http\Controllers;

use App\Model\ActivityModel;
use Illuminate\Http\Request;
use App\Model\SelpIncidentModel;
use App\Model\Admin\Setup\CEP_Region\SetupUserArea;
use App\Model\PollisomajDataModel;
use App\User;
use App\Model\SelpCampaignActivity;
use App\Model\SelpCommunityActivity;
use App\Model\SelpMeetingActivity;
use App\Model\SelpPtProductionActivity;
use App\Model\SelpPtShowActivity;
use App\Model\SelpTrainingActivity;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }


    // public function generatePdf(){
    //     $data['evaluation']="Query here";        
    //     // dd($data->toArray());        
    //     // return view('load pdf view file')->with($data);
    //     $pdf = PDF::loadView('load pdf view file', $data);
    //     $pdf->SetProtection(['copy', 'print'], '', 'pass');
    //     return $pdf->stream('document.pdf');
    // }

    public function userInfoChange($id)
    {
        $incident_data  =   SelpIncidentModel::find($id);
        $user_upazila   =   SetupUserArea::where('upazila_id', $incident_data->employee_upazila_id)->whereNull('date_to')->orderBy('id','desc')->first();
        // dd($user_upazila->upazila_id);
        $user_info      =   User::find($user_upazila->user_id);
        
        $updateSelpData                         =   SelpIncidentModel::find($id);
        $updateSelpData->employee_name          =   $user_info->name;
        $updateSelpData->employee_mobile_number =   $user_info->mobile;
        $updateSelpData->employee_designation   =   $user_info->designation;
        $updateSelpData->employee_pin           =   $user_info->pin;
        $updateSelpData->save();

    }

    public function userAddressChange($incident_id, $pin)
    {
        $user_info      =   User::where('pin', $pin)->first();
        $user_upazila   =   SetupUserArea::where('user_id', $user_info->id)->whereNull('date_to')->orderBy('id','desc')->first();
        // dd($user_upazila->division_id);
        
        $updateSelpData                         =   SelpIncidentModel::find($incident_id);
        $updateSelpData->employee_name          =   $user_info->name;
        $updateSelpData->employee_mobile_number =   $user_info->mobile;
        $updateSelpData->employee_designation   =   $user_info->designation;
        $updateSelpData->employee_pin           =   $user_info->pin;
        $updateSelpData->employee_division_id   =   $user_upazila->division_id;
        $updateSelpData->employee_district_id   =   $user_upazila->district_id;
        $updateSelpData->employee_upazila_id    =   $user_upazila->upazila_id;
        $updateSelpData->save();
    }

    public function dataDeleteView()
    {
        return view('backend.testview.delete_data');
    }
    public function activityDataDelete(Request $request)
    {
        $id                 =   $request->id;
        $campaignData       =   SelpCampaignActivity::where('selp_activities_id',$id)->delete();   
        $communityData      =   SelpCommunityActivity::where('selp_activities_id',$id)->delete();   
        $meetingData        =   SelpMeetingActivity::where('selp_activities_id',$id)->delete();   
        $pTproductionData   =   SelpPtProductionActivity::where('selp_activities_id',$id)->delete();   
        $pTshowData         =   SelpPtShowActivity::where('selp_activities_id',$id)->delete();   
        $trainingData       =   SelpTrainingActivity::where('selp_activities_id',$id)->delete();   
        $activityDataData   =   ActivityModel::find($id)->delete();

        session()->flash('success','Activity Data Delete Successfully');
        return redirect()->route('dataDeleteView');   
    }
    
    public function pollishomajData(Request $request)
    {
        $id                =   $request->id;
        $pollishomajData   =   PollisomajDataModel::find($id)->delete();
        session()->flash('success','Pollishomaj Data Delete Successfully');
        return redirect()->route('dataDeleteView');  
    }
}
