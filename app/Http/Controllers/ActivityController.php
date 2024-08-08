<?php

namespace App\Http\Controllers;

use App\Exports\MisReportExport;
use App\Http\Controllers\Controller;
use App\Model\ActivityModel;
use App\Model\Admin\Setup\Division;
use App\Model\Pititioncase;
use App\Model\SelpCampaignActivity;
use App\Model\SelpCommunityActivity;
use App\Model\SelpMeetingActivity;
use App\Model\SelpPtProductionActivity;
use App\Model\SelpPtShowActivity;
use App\Model\SelpTrainingActivity;
use App\Model\Selpzone;
use App\Model\Setup\CampaignEvent;
use App\Model\Setup\CommunityEvent;
use App\Model\Setup\MeetingEvent;
use App\Model\Setup\PTproductionEvent;
use App\Model\Setup\PTshowEvent;
use App\Model\Setup\TrainingEvent;
use App\User;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Session;

class ActivityController extends Controller
{
    private function formatIncidentId($id)
    {
        if ($id < 10) {
            return '00' . $id;
        }

        if ($id < 100) {
            return '0' . $id;
        }

        return $id;
    }

    public function index(Request $request)
    {
    }

    public function addActivity(Request $request)
    {
        // dd($request->step);
        if ((bool) $request->query('addnew')) {
            // $request->session()->forget('current_activity_store_session');
            $request->session()->forget('activity_edit_mode');
        }
        // if (!$request->session()->has('current_activity_store_session')) {
        //     $request->session()->put('current_activity_store_session', uniqid("ACTIVITY_ID_", true));
        // }

        if ($request->step == 1) {
            $request->session()->put('activity_edit_mode', true);
        }
        //$data['regions']   = Region::get();

        $data['regions']   = getRegionByUserType();
        $data['step']      = $request->step;
        $data['events']    = Pititioncase::all();
        $data['auth_user'] = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        $data['user_info'] = Auth::user();
        $data['divisions'] = Division::where('status', 1)->get();
        $data['selpZone']  = Selpzone::where('status', 1)->get();

        $data['meeting_event']       = MeetingEvent::where('status', 1)->get();
        $data['training_event']      = TrainingEvent::where('status', 1)->get();
        $data['community_event']     = CommunityEvent::where('status', 1)->get();
        $data['campaign_event']      = CampaignEvent::where('status', 1)->get();
        $data['pt_show_event']       = PTshowEvent::where('status', 1)->get();
        $data['pt_production_event'] = PTproductionEvent::where('status', 1)->get();
        $data['activityData']        = ActivityModel::with(['meeting_activity'])->where('selp_activity_ref', $request->selp_activity_ref)->get();
        $data['activityDataObj']     = ActivityModel::with(['meeting_activity'])->where('selp_activity_ref', $request->selp_activity_ref)->first();
        return view('backend.activity.create')->with($data);
    }

    public function redirectForNewActivity(Request $request)
    {
        return redirect('/activity/add?addnew=true');
    }

    public function activityList()
    {
        //$data['regions']       = Region::get();

        // $data['regions']       = getRegionByUserType();
        // $data['activity_data'] = ActivityModel::all();
        // dd($data['activity_data']);
        // return view('backend.activity.list')->with($data);

        $auth_user = User::with(['setup_user_area'])->where('id', Auth::id())->first();

        if ($auth_user->user_role[0]['role_id'] == 4) {
            return redirect()->route('activity.pending.list');
        } else {
            return redirect()->route('activity.draft.list');
        }
    }

    public function editActivityData(Request $request, $ref)
    {

        $request->session()->put('activity_edit_mode', true);
        return redirect()->route('activity.add', ['selp_activity_ref' => $ref]);
    }

    public function addActivityStep1(Request $request)
    {
        $request->validate([
            "reporting_date" => 'required',
        ]);

        $activityData = ActivityModel::with(['meeting_activity'])->where('selp_activity_ref', $request->selp_activity_ref)->get();
        if (count($activityData) > 0) {
            $activityDataUpdate                         = ActivityModel::find($activityData[0]->id);
            $activityDataUpdate->reporting_date         = $request->reporting_date != null ? date("Y-m-d", strtotime($request->reporting_date)) : null;
            $activityDataUpdate->employee_id            = $request->input('employee_id');
            $activityDataUpdate->employee_pin           = $request->input('employee_pin');
            $activityDataUpdate->employee_name          = $request->input('employee_name');
            $activityDataUpdate->employee_mobile_number = $request->input('employee_mobile_number');
            $activityDataUpdate->employee_designation   = $request->input('employee_designation');
            $activityDataUpdate->employee_zone_id       = $request->input('employee_zone_id');
            $activityDataUpdate->employee_division_id   = $request->input('employee_division_id');
            $activityDataUpdate->employee_district_id   = $request->input('employee_district_id');
            $activityDataUpdate->employee_upazila_id    = $request->input('employee_upazila_id');
            $activityDataUpdate->save();
        } else {

            $pollisomajNewData                         = new ActivityModel;
            $pollisomajNewData->selp_activity_ref      = uniqid("ACTIVITY_ID_", true);
            $pollisomajNewData->reporting_date         = $request->reporting_date != null ? date("Y-m-d", strtotime($request->reporting_date)) : null;
            $pollisomajNewData->employee_id            = Auth::id();
            $pollisomajNewData->employee_pin           = $request->input('employee_pin');
            $pollisomajNewData->employee_name          = $request->input('employee_name');
            $pollisomajNewData->employee_mobile_number = $request->input('employee_mobile_number');
            $pollisomajNewData->employee_designation   = $request->input('employee_designation');
            $pollisomajNewData->employee_zone_id       = $request->input('employee_zone_id');
            $pollisomajNewData->employee_division_id   = $request->input('employee_division_id');
            $pollisomajNewData->employee_district_id   = $request->input('employee_district_id');
            $pollisomajNewData->employee_upazila_id    = $request->input('employee_upazila_id');

            $pollisomajNewData->save();
        }

        if ($request->has('save_destroy')) {
            // $request->session()->forget('current_activity_store_session');
            $request->session()->forget('activity_edit_mode');
            return redirect()->route('activity.draft.list');
        }
        $data['regions']             = getRegionByUserType();
        $data['step']                = $request->step;
        $data['auth_user']           = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        $data['meeting_event']       = MeetingEvent::where('status', 1)->get();
        $data['training_event']      = TrainingEvent::where('status', 1)->get();
        $data['community_event']     = CommunityEvent::where('status', 1)->get();
        $data['campaign_event']      = CampaignEvent::where('status', 1)->get();
        $data['pt_show_event']       = PTshowEvent::where('status', 1)->get();
        $data['pt_production_event'] = PTproductionEvent::where('status', 1)->get();
        if (count($activityData) > 0) {
            $data['activityData']    = $activityData;
            $data['activityDataObj'] = ActivityModel::with(['meeting_activity'])->where('selp_activity_ref', $request->selp_activity_ref)->first();
        } else {
            $data['activityData'][]  = $pollisomajNewData;
            $data['activityDataObj'] = ActivityModel::with(['meeting_activity'])->where('selp_activity_ref', $data['activityData'][0]->selp_activity_ref)->first();
        }

        // dd($data['activityData']->toArray());
        return view('backend.activity.create')->with($data);
    }

    public function addActivityStep2(Request $request)
    {
        
        // $rules = [
        //     'starting_date.*'   => 'required',
        //     'ending_date.*'     => 'required',
        // ];

        // $messages = [
        //     'starting_date.*.required' => 'Starting date field is required',
        //     'ending_date.*.required'   => 'Ending date field is required',
        // ];
    
        // Validate the request
        // $request->validate($rules, $messages);

        $activityData = ActivityModel::with(['meeting_activity'])->where('selp_activity_ref', $request->selp_activity_ref)->get();



        if ($request->has('id')) {
            $delete_meeting = SelpMeetingActivity::whereNotIn('id', $request->id)->where('selp_activities_id', $activityData[0]->id)->delete();
        }

        $extra_data['tab']  = $request->tab;
        $extra_data['step'] = $request->step;
        if (count($activityData) > 0) {
            DB::beginTransaction();

            if ($request->has('event_id') && $request->event_id != null) {
                for ($i = 0; $i < count($request->event_id); $i++) {
                    if ($request->event_id[$i] != null) {
                        if (isset($request->id[$i]) && $request->id[$i] != null) {

                            $meeting                     = SelpMeetingActivity::find($request->id[$i]);

                            if ($request->participant_total[$i] == 0 || $request->participant_total[$i] == "" || $request->participant_total[$i] == null) {

                                $meeting->delete();
                            } else {
                                $meeting->selp_activities_id = $activityData[0]->id;
                                $meeting->selp_activity_ref  = $activityData[0]->selp_activity_ref;
                                $meeting->event_id                     = $request->event_id[$i];
                                $meeting->no_of_event                  = $request->no_of_event[$i];
                                $meeting->starting_date                = $request->starting_date[$i] != null ? date("Y-m-d", strtotime($request->starting_date[$i])) : null;
                                $meeting->ending_date                  = $request->ending_date[$i] != null ? date("Y-m-d", strtotime($request->ending_date[$i])) : null;
                                $meeting->participant_boys             = $request->participant_boys[$i];
                                $meeting->participant_girls            = $request->participant_girls[$i];
                                $meeting->participant_men              = $request->participant_men[$i];
                                $meeting->participant_women            = $request->participant_women[$i];
                                $meeting->participant_other_gender     = $request->participant_other_gender[$i];
                                $meeting->participant_total            = $request->participant_total[$i];
                                $meeting->participant_pwd_boys         = $request->participant_pwd_boys[$i];
                                $meeting->participant_pwd_girls        = $request->participant_pwd_girls[$i];
                                $meeting->participant_pwd_men          = $request->participant_pwd_men[$i];
                                $meeting->participant_pwd_women        = $request->participant_pwd_women[$i];
                                $meeting->participant_pwd_other_gender = $request->participant_pwd_other_gender[$i];
                                $meeting->participant_pwd_total        = $request->participant_pwd_total[$i];

                                $meeting->save();
                            }
                        } else {
                            if ($request->event_id[$i] && empty($request->no_of_event[$i])) {
                                return redirect(url('/') . '/activity/add?step=2&selp_activity_ref=' . $activityData[0]->selp_activity_ref)->with('error', 'Enter No. of Events!');
                            }
                            # code...
                            $meeting                     = new SelpMeetingActivity();
                            $meeting->selp_activities_id = $activityData[0]->id;
                            $meeting->selp_activity_ref  = $activityData[0]->selp_activity_ref;

                            $meeting->event_id                     = $request->event_id[$i];
                            $meeting->no_of_event                  = $request->no_of_event[$i];
                            $meeting->starting_date                = $request->starting_date[$i] != null ? date("Y-m-d", strtotime($request->starting_date[$i])) : null;
                            $meeting->ending_date                  = $request->ending_date[$i] != null ? date("Y-m-d", strtotime($request->ending_date[$i])) : null;
                            $meeting->participant_boys             = $request->participant_boys[$i];
                            $meeting->participant_girls            = $request->participant_girls[$i];
                            $meeting->participant_men              = $request->participant_men[$i];
                            $meeting->participant_women            = $request->participant_women[$i];
                            $meeting->participant_other_gender     = $request->participant_other_gender[$i];
                            $meeting->participant_total            = $request->participant_total[$i];
                            $meeting->participant_pwd_boys         = $request->participant_pwd_boys[$i];
                            $meeting->participant_pwd_girls        = $request->participant_pwd_girls[$i];
                            $meeting->participant_pwd_men          = $request->participant_pwd_men[$i];
                            $meeting->participant_pwd_women        = $request->participant_pwd_women[$i];
                            $meeting->participant_pwd_other_gender = $request->participant_pwd_other_gender[$i];
                            $meeting->participant_pwd_total        = $request->participant_pwd_total[$i];

                            $meeting->save();
                        }
                    }
                }
            }

            DB::commit();
        } else {
            return redirect()->route('activity.add');
        }

        if ($request->has('save_destroy')) {
            // $request->session()->forget('current_activity_store_session');
            $request->session()->forget('activity_edit_mode');
            return redirect()->route('activity.draft.list');
        }
        $data['regions']             = getRegionByUserType();
        $data['step']                = $request->step;
        $data['auth_user']           = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        $data['meeting_event']       = MeetingEvent::where('status', 1)->get();
        $data['training_event']      = TrainingEvent::where('status', 1)->get();
        $data['community_event']     = CommunityEvent::where('status', 1)->get();
        $data['campaign_event']      = CampaignEvent::where('status', 1)->get();
        $data['pt_show_event']       = PTshowEvent::where('status', 1)->get();
        $data['pt_production_event'] = PTproductionEvent::where('status', 1)->get();
        $data['activityData']        = $activityData;
        $data['activityDataObj']     = ActivityModel::with(['training_activity'])->where('selp_activity_ref', $request->selp_activity_ref)->first();
        // dd($data['activityData']->toArray());
        return view('backend.activity.create')->with($data);
    }

    public function addActivityStep3(Request $request)
    {
        // dd($request->all());
        $activityData = ActivityModel::with(['meeting_activity'])->where('selp_activity_ref', $request->selp_activity_ref)->get();
        if ($request->has('id')) {
            $delete_training = SelpTrainingActivity::whereNotIn('id', $request->id)->where('selp_activities_id', $activityData[0]->id)->delete();
        }

        $extra_data['tab']  = $request->tab;
        $extra_data['step'] = $request->step;
        if (count($activityData) > 0) {
            DB::beginTransaction();

            if ($request->has('event_id') && $request->event_id != null) {
                for ($i = 0; $i < count($request->event_id); $i++) {
                    if ($request->event_id[$i] != null) {
                        if (isset($request->id[$i]) && $request->id[$i] != null) {
                            # code...
                            $meeting                     = SelpTrainingActivity::find($request->id[$i]);
                            if ($request->participant_total[$i] == 0 || $request->participant_total[$i] == "" || $request->participant_total[$i] == null) {

                                $meeting->delete();
                            } else {
                                $meeting->selp_activities_id = $activityData[0]->id;
                                $meeting->selp_activity_ref  = $activityData[0]->selp_activity_ref;

                                $meeting->event_id                     = $request->event_id[$i];
                                $meeting->no_of_event                  = $request->no_of_event[$i];
                                $meeting->starting_date                = $request->starting_date[$i] != null ? date("Y-m-d", strtotime($request->starting_date[$i])) : null;
                                $meeting->ending_date                  = $request->ending_date[$i] != null ? date("Y-m-d", strtotime($request->ending_date[$i])) : null;
                                $meeting->participant_boys             = $request->participant_boys[$i];
                                $meeting->participant_girls            = $request->participant_girls[$i];
                                $meeting->participant_men              = $request->participant_men[$i];
                                $meeting->participant_women            = $request->participant_women[$i];
                                $meeting->participant_other_gender     = $request->participant_other_gender[$i];
                                $meeting->participant_total            = $request->participant_total[$i];
                                $meeting->participant_pwd_boys         = $request->participant_pwd_boys[$i];
                                $meeting->participant_pwd_girls        = $request->participant_pwd_girls[$i];
                                $meeting->participant_pwd_men          = $request->participant_pwd_men[$i];
                                $meeting->participant_pwd_women        = $request->participant_pwd_women[$i];
                                $meeting->participant_pwd_other_gender = $request->participant_pwd_other_gender[$i];
                                $meeting->participant_pwd_total        = $request->participant_pwd_total[$i];

                                $meeting->save();
                            }
                        } else {
                            if ($request->event_id[$i] && empty($request->no_of_event[$i])) {
                                return redirect(url('/') . '/activity/add?step=3&selp_activity_ref=' . $activityData[0]->selp_activity_ref)->with('error', 'Enter No. of Events!');
                            }
                            # code...
                            $meeting                     = new SelpTrainingActivity();
                            $meeting->selp_activities_id = $activityData[0]->id;
                            $meeting->selp_activity_ref  = $activityData[0]->selp_activity_ref;

                            $meeting->event_id                     = $request->event_id[$i];
                            $meeting->no_of_event                  = $request->no_of_event[$i];
                            $meeting->starting_date                = $request->starting_date[$i] != null ? date("Y-m-d", strtotime($request->starting_date[$i])) : null;
                            $meeting->ending_date                  = $request->ending_date[$i] != null ? date("Y-m-d", strtotime($request->ending_date[$i])) : null;
                            $meeting->participant_boys             = $request->participant_boys[$i];
                            $meeting->participant_girls            = $request->participant_girls[$i];
                            $meeting->participant_men              = $request->participant_men[$i];
                            $meeting->participant_women            = $request->participant_women[$i];
                            $meeting->participant_other_gender     = $request->participant_other_gender[$i];
                            $meeting->participant_total            = $request->participant_total[$i];
                            $meeting->participant_pwd_boys         = $request->participant_pwd_boys[$i];
                            $meeting->participant_pwd_girls        = $request->participant_pwd_girls[$i];
                            $meeting->participant_pwd_men          = $request->participant_pwd_men[$i];
                            $meeting->participant_pwd_women        = $request->participant_pwd_women[$i];
                            $meeting->participant_pwd_other_gender = $request->participant_pwd_other_gender[$i];
                            $meeting->participant_pwd_total        = $request->participant_pwd_total[$i];

                            $meeting->save();
                        }
                    }
                }
            }

            DB::commit();
        } else {
            return redirect()->route('activity.add');
        }

        if ($request->has('save_destroy')) {
            // $request->session()->forget('current_activity_store_session');
            $request->session()->forget('activity_edit_mode');
            return redirect()->route('activity.draft.list');
        }
        $data['regions']             = getRegionByUserType();
        $data['step']                = $request->step;
        $data['auth_user']           = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        $data['meeting_event']       = MeetingEvent::where('status', 1)->get();
        $data['training_event']      = TrainingEvent::where('status', 1)->get();
        $data['community_event']     = CommunityEvent::where('status', 1)->get();
        $data['campaign_event']      = CampaignEvent::where('status', 1)->get();
        $data['pt_show_event']       = PTshowEvent::where('status', 1)->get();
        $data['pt_production_event'] = PTproductionEvent::where('status', 1)->get();
        $data['activityData']        = $activityData;
        $data['activityDataObj']     = ActivityModel::with(['meeting_activity'])->where('selp_activity_ref', $request->selp_activity_ref)->first();
        // dd($data['activityData']->toArray());
        return view('backend.activity.create')->with($data);
    }

    public function addActivityStep4(Request $request)
    {
        // dd($request->all());
        $activityData = ActivityModel::with(['meeting_activity'])->where('selp_activity_ref', $request->selp_activity_ref)->get();
        if ($request->has('id')) {
            $delete_community = SelpCommunityActivity::whereNotIn('id', $request->id)->where('selp_activities_id', $activityData[0]->id)->delete();
        }

        $extra_data['tab']  = $request->tab;
        $extra_data['step'] = $request->step;
        if (count($activityData) > 0) {
            DB::beginTransaction();

            if ($request->has('event_id') && $request->event_id != null) {
                for ($i = 0; $i < count($request->event_id); $i++) {
                    if ($request->event_id[$i] != null) {
                        if (isset($request->id[$i]) && $request->id[$i] != null) {
                            # code...
                            $meeting                     = SelpCommunityActivity::find($request->id[$i]);

                            if ($request->participant_total[$i] == 0 || $request->participant_total[$i] == "" || $request->participant_total[$i] == null) {

                                $meeting->delete();
                            } else {
                                $meeting->selp_activities_id = $activityData[0]->id;
                                $meeting->selp_activity_ref  = $activityData[0]->selp_activity_ref;

                                $meeting->event_id                     = $request->event_id[$i];
                                $meeting->no_of_event                  = $request->no_of_event[$i];
                                $meeting->starting_date                = $request->starting_date[$i] != null ? date("Y-m-d", strtotime($request->starting_date[$i])) : null;
                                $meeting->ending_date                  = $request->ending_date[$i] != null ? date("Y-m-d", strtotime($request->ending_date[$i])) : null;
                                $meeting->participant_boys             = $request->participant_boys[$i];
                                $meeting->participant_girls            = $request->participant_girls[$i];
                                $meeting->participant_men              = $request->participant_men[$i];
                                $meeting->participant_women            = $request->participant_women[$i];
                                $meeting->participant_other_gender     = $request->participant_other_gender[$i];
                                $meeting->participant_total            = $request->participant_total[$i];
                                $meeting->participant_pwd_boys         = $request->participant_pwd_boys[$i];
                                $meeting->participant_pwd_girls        = $request->participant_pwd_girls[$i];
                                $meeting->participant_pwd_men          = $request->participant_pwd_men[$i];
                                $meeting->participant_pwd_women        = $request->participant_pwd_women[$i];
                                $meeting->participant_pwd_other_gender = $request->participant_pwd_other_gender[$i];
                                $meeting->participant_pwd_total        = $request->participant_pwd_total[$i];

                                $meeting->save();
                            }
                        } else {
                            if ($request->event_id[$i] && empty($request->no_of_event[$i])) {
                                return redirect(url('/') . '/activity/add?step=4&selp_activity_ref=' . $activityData[0]->selp_activity_ref)->with('error', 'Enter No. of Events!');
                            }
                            # code...
                            $meeting                     = new SelpCommunityActivity();
                            $meeting->selp_activities_id = $activityData[0]->id;
                            $meeting->selp_activity_ref  = $activityData[0]->selp_activity_ref;

                            $meeting->event_id                     = $request->event_id[$i];
                            $meeting->no_of_event                  = $request->no_of_event[$i];
                            $meeting->starting_date                = $request->starting_date[$i] != null ? date("Y-m-d", strtotime($request->starting_date[$i])) : null;
                            $meeting->ending_date                  = $request->ending_date[$i] != null ? date("Y-m-d", strtotime($request->ending_date[$i])) : null;
                            $meeting->participant_boys             = $request->participant_boys[$i];
                            $meeting->participant_girls            = $request->participant_girls[$i];
                            $meeting->participant_men              = $request->participant_men[$i];
                            $meeting->participant_women            = $request->participant_women[$i];
                            $meeting->participant_other_gender     = $request->participant_other_gender[$i];
                            $meeting->participant_total            = $request->participant_total[$i];
                            $meeting->participant_pwd_boys         = $request->participant_pwd_boys[$i];
                            $meeting->participant_pwd_girls        = $request->participant_pwd_girls[$i];
                            $meeting->participant_pwd_men          = $request->participant_pwd_men[$i];
                            $meeting->participant_pwd_women        = $request->participant_pwd_women[$i];
                            $meeting->participant_pwd_other_gender = $request->participant_pwd_other_gender[$i];
                            $meeting->participant_pwd_total        = $request->participant_pwd_total[$i];

                            $meeting->save();
                        }
                    }
                }
            }

            DB::commit();
        } else {
            return redirect()->route('activity.add');
        }

        if ($request->has('save_destroy')) {
            // $request->session()->forget('current_activity_store_session');
            $request->session()->forget('activity_edit_mode');
            return redirect()->route('activity.draft.list');
        }
        $data['regions']             = getRegionByUserType();
        $data['step']                = $request->step;
        $data['auth_user']           = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        $data['meeting_event']       = MeetingEvent::where('status', 1)->get();
        $data['training_event']      = TrainingEvent::where('status', 1)->get();
        $data['community_event']     = CommunityEvent::where('status', 1)->get();
        $data['campaign_event']      = CampaignEvent::where('status', 1)->get();
        $data['pt_show_event']       = PTshowEvent::where('status', 1)->get();
        $data['pt_production_event'] = PTproductionEvent::where('status', 1)->get();
        $data['activityData']        = $activityData;
        $data['activityDataObj']     = ActivityModel::with(['meeting_activity'])->where('selp_activity_ref', $request->selp_activity_ref)->first();
        return view('backend.activity.create')->with($data);
    }

    public function addActivityStep5(Request $request)
    {
        // dd($request->all());
        $activityData = ActivityModel::with(['meeting_activity'])->where('selp_activity_ref', $request->selp_activity_ref)->get();
        if ($request->has('id')) {
            $delete_campaign = SelpCampaignActivity::whereNotIn('id', $request->id)->where('selp_activities_id', $activityData[0]->id)->delete();
        }

        $extra_data['tab']  = $request->tab;
        $extra_data['step'] = $request->step;
        if (count($activityData) > 0) {
            DB::beginTransaction();

            if ($request->has('event_id') && $request->event_id != null) {
                for ($i = 0; $i < count($request->event_id); $i++) {
                    if ($request->event_id[$i] != null) {
                        if (isset($request->id[$i]) && $request->id[$i] != null) {
                            # code...
                            $meeting                     = SelpCampaignActivity::find($request->id[$i]);

                            if ($request->participant_total[$i] == 0 || $request->participant_total[$i] == "" || $request->participant_total[$i] == null) {

                                $meeting->delete();
                            } else {
                                $meeting->selp_activities_id = $activityData[0]->id;
                                $meeting->selp_activity_ref  = $activityData[0]->selp_activity_ref;

                                $meeting->event_id                     = $request->event_id[$i];
                                $meeting->no_of_event                  = $request->no_of_event[$i];
                                $meeting->starting_date                = $request->starting_date[$i] != null ? date("Y-m-d", strtotime($request->starting_date[$i])) : null;
                                $meeting->ending_date                  = $request->ending_date[$i] != null ? date("Y-m-d", strtotime($request->ending_date[$i])) : null;
                                $meeting->participant_boys             = $request->participant_boys[$i];
                                $meeting->participant_girls            = $request->participant_girls[$i];
                                $meeting->participant_men              = $request->participant_men[$i];
                                $meeting->participant_women            = $request->participant_women[$i];
                                $meeting->participant_other_gender     = $request->participant_other_gender[$i];
                                $meeting->participant_total            = $request->participant_total[$i];
                                $meeting->participant_pwd_boys         = $request->participant_pwd_boys[$i];
                                $meeting->participant_pwd_girls        = $request->participant_pwd_girls[$i];
                                $meeting->participant_pwd_men          = $request->participant_pwd_men[$i];
                                $meeting->participant_pwd_women        = $request->participant_pwd_women[$i];
                                $meeting->participant_pwd_other_gender = $request->participant_pwd_other_gender[$i];
                                $meeting->participant_pwd_total        = $request->participant_pwd_total[$i];

                                $meeting->save();
                            }
                        } else {
                            if ($request->event_id[$i] && empty($request->no_of_event[$i])) {
                                return redirect(url('/') . '/activity/add?step=5&selp_activity_ref=' . $activityData[0]->selp_activity_ref)->with('error', 'Enter No. of Events!');
                            }
                            # code...
                            $meeting                     = new SelpCampaignActivity();
                            $meeting->selp_activities_id = $activityData[0]->id;
                            $meeting->selp_activity_ref  = $activityData[0]->selp_activity_ref;

                            $meeting->event_id                     = $request->event_id[$i];
                            $meeting->no_of_event                  = $request->no_of_event[$i];
                            $meeting->starting_date                = $request->starting_date[$i] != null ? date("Y-m-d", strtotime($request->starting_date[$i])) : null;
                            $meeting->ending_date                  = $request->ending_date[$i] != null ? date("Y-m-d", strtotime($request->ending_date[$i])) : null;
                            $meeting->participant_boys             = $request->participant_boys[$i];
                            $meeting->participant_girls            = $request->participant_girls[$i];
                            $meeting->participant_men              = $request->participant_men[$i];
                            $meeting->participant_women            = $request->participant_women[$i];
                            $meeting->participant_other_gender     = $request->participant_other_gender[$i];
                            $meeting->participant_total            = $request->participant_total[$i];
                            $meeting->participant_pwd_boys         = $request->participant_pwd_boys[$i];
                            $meeting->participant_pwd_girls        = $request->participant_pwd_girls[$i];
                            $meeting->participant_pwd_men          = $request->participant_pwd_men[$i];
                            $meeting->participant_pwd_women        = $request->participant_pwd_women[$i];
                            $meeting->participant_pwd_other_gender = $request->participant_pwd_other_gender[$i];
                            $meeting->participant_pwd_total        = $request->participant_pwd_total[$i];

                            $meeting->save();
                        }
                    }
                }
            }

            DB::commit();
        } else {
            return redirect()->route('activity.add');
        }

        if ($request->has('save_destroy')) {
            // $request->session()->forget('current_activity_store_session');
            $request->session()->forget('activity_edit_mode');
            return redirect()->route('activity.draft.list');
        }
        $data['regions']             = getRegionByUserType();
        $data['step']                = $request->step;
        $data['auth_user']           = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        $data['meeting_event']       = MeetingEvent::where('status', 1)->get();
        $data['training_event']      = TrainingEvent::where('status', 1)->get();
        $data['community_event']     = CommunityEvent::where('status', 1)->get();
        $data['campaign_event']      = CampaignEvent::where('status', 1)->get();
        $data['pt_show_event']       = PTshowEvent::where('status', 1)->get();
        $data['pt_production_event'] = PTproductionEvent::where('status', 1)->get();
        $data['activityData']        = $activityData;
        $data['activityDataObj']     = ActivityModel::with(['meeting_activity'])->where('selp_activity_ref', $request->selp_activity_ref)->first();
        return view('backend.activity.create')->with($data);
    }

    public function addActivityStep6(Request $request)
    {
        // dd($request->all());
        $activityData = ActivityModel::with(['meeting_activity'])->where('selp_activity_ref', $request->selp_activity_ref)->get();
        if ($request->has('id')) {
            $delete_pt_show = SelpPtShowActivity::whereNotIn('id', $request->id)->where('selp_activities_id', $activityData[0]->id)->delete();
        }

        $extra_data['tab']  = $request->tab;
        $extra_data['step'] = $request->step;
        if (count($activityData) > 0) {
            DB::beginTransaction();

            if ($request->has('event_id') && $request->event_id != null) {
                for ($i = 0; $i < count($request->event_id); $i++) {
                    if ($request->event_id[$i] != null) {
                        if (isset($request->id[$i]) && $request->id[$i] != null) {
                            # code...
                            $meeting                     = SelpPtShowActivity::find($request->id[$i]);
                            if ($request->participant_total[$i] == 0 || $request->participant_total[$i] == "" || $request->participant_total[$i] == null) {

                                $meeting->delete();
                            } else {
                                $meeting->selp_activities_id = $activityData[0]->id;
                                $meeting->selp_activity_ref  = $activityData[0]->selp_activity_ref;

                                $meeting->event_id                     = $request->event_id[$i];
                                $meeting->no_of_event                  = $request->no_of_event[$i];
                                $meeting->starting_date                = $request->starting_date[$i] != null ? date("Y-m-d", strtotime($request->starting_date[$i])) : null;
                                $meeting->ending_date                  = $request->ending_date[$i] != null ? date("Y-m-d", strtotime($request->ending_date[$i])) : null;
                                $meeting->participant_boys             = $request->participant_boys[$i];
                                $meeting->participant_girls            = $request->participant_girls[$i];
                                $meeting->participant_men              = $request->participant_men[$i];
                                $meeting->participant_women            = $request->participant_women[$i];
                                $meeting->participant_other_gender     = $request->participant_other_gender[$i];
                                $meeting->participant_total            = $request->participant_total[$i];
                                $meeting->participant_pwd_boys         = $request->participant_pwd_boys[$i];
                                $meeting->participant_pwd_girls        = $request->participant_pwd_girls[$i];
                                $meeting->participant_pwd_men          = $request->participant_pwd_men[$i];
                                $meeting->participant_pwd_women        = $request->participant_pwd_women[$i];
                                $meeting->participant_pwd_other_gender = $request->participant_pwd_other_gender[$i];
                                $meeting->participant_pwd_total        = $request->participant_pwd_total[$i];

                                $meeting->save();
                            }
                        } else {
                            if ($request->event_id[$i] && empty($request->no_of_event[$i])) {
                                return redirect(url('/') . '/activity/add?step=6&selp_activity_ref=' . $activityData[0]->selp_activity_ref)->with('error', 'Enter No. of Events!');
                            }
                            # code...
                            $meeting                     = new SelpPtShowActivity();
                            $meeting->selp_activities_id = $activityData[0]->id;
                            $meeting->selp_activity_ref  = $activityData[0]->selp_activity_ref;

                            $meeting->event_id                     = $request->event_id[$i];
                            $meeting->no_of_event                  = $request->no_of_event[$i];
                            $meeting->starting_date                = $request->starting_date[$i] != null ? date("Y-m-d", strtotime($request->starting_date[$i])) : null;
                            $meeting->ending_date                  = $request->ending_date[$i] != null ? date("Y-m-d", strtotime($request->ending_date[$i])) : null;
                            $meeting->participant_boys             = $request->participant_boys[$i];
                            $meeting->participant_girls            = $request->participant_girls[$i];
                            $meeting->participant_men              = $request->participant_men[$i];
                            $meeting->participant_women            = $request->participant_women[$i];
                            $meeting->participant_other_gender     = $request->participant_other_gender[$i];
                            $meeting->participant_total            = $request->participant_total[$i];
                            $meeting->participant_pwd_boys         = $request->participant_pwd_boys[$i];
                            $meeting->participant_pwd_girls        = $request->participant_pwd_girls[$i];
                            $meeting->participant_pwd_men          = $request->participant_pwd_men[$i];
                            $meeting->participant_pwd_women        = $request->participant_pwd_women[$i];
                            $meeting->participant_pwd_other_gender = $request->participant_pwd_other_gender[$i];
                            $meeting->participant_pwd_total        = $request->participant_pwd_total[$i];

                            $meeting->save();
                        }
                    }
                }
            }

            DB::commit();
        } else {
            return redirect()->route('activity.add');
        }

        if ($request->has('save_destroy')) {
            // $request->session()->forget('current_activity_store_session');
            $request->session()->forget('activity_edit_mode');
            return redirect()->route('activity.draft.list');
        }
        $data['regions']             = getRegionByUserType();
        $data['step']                = $request->step;
        $data['auth_user']           = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        $data['meeting_event']       = MeetingEvent::where('status', 1)->get();
        $data['training_event']      = TrainingEvent::where('status', 1)->get();
        $data['community_event']     = CommunityEvent::where('status', 1)->get();
        $data['campaign_event']      = CampaignEvent::where('status', 1)->get();
        $data['pt_show_event']       = PTshowEvent::where('status', 1)->get();
        $data['pt_production_event'] = PTproductionEvent::where('status', 1)->get();
        $data['activityData']        = $activityData;
        $data['activityDataObj']     = ActivityModel::with(['meeting_activity'])->where('selp_activity_ref', $request->selp_activity_ref)->first();
        return view('backend.activity.create')->with($data);
    }

    public function addActivityStep7(Request $request)
    {
        // dd($request->all());
        $activityData = ActivityModel::with(['meeting_activity'])->where('selp_activity_ref', $request->selp_activity_ref)->get(); // dd($activityData[0]->id);
        if ($request->has('id')) {
            $delete_pt_production = SelpPtProductionActivity::whereNotIn('id', $request->id)->where('selp_activities_id', $activityData[0]->id)->delete();
        }
        $auth_user          = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        $extra_data['tab']  = $request->tab;
        $extra_data['step'] = $request->step;
        if (count($activityData) > 0) {
            DB::beginTransaction();

            if ($request->has('event_id') && $request->event_id != null) {
                for ($i = 0; $i < count($request->event_id); $i++) {
                    if ($request->event_id[$i] != null) {
                        if (isset($request->id[$i]) && $request->id[$i] != null) {
                            # code...
                            $meeting                     = SelpPtProductionActivity::find($request->id[$i]);
                            if ($request->participant_total[$i] == 0 || $request->participant_total[$i] == "" || $request->participant_total[$i] == null) {

                                $meeting->delete();
                            } else {
                                $meeting->selp_activities_id = $activityData[0]->id;
                                $meeting->selp_activity_ref  = $activityData[0]->selp_activity_ref;

                                $meeting->event_id                     = $request->event_id[$i];
                                $meeting->no_of_event                  = $request->no_of_event[$i];
                                $meeting->starting_date                = $request->starting_date[$i] != null ? date("Y-m-d", strtotime($request->starting_date[$i])) : null;
                                $meeting->ending_date                  = $request->ending_date[$i] != null ? date("Y-m-d", strtotime($request->ending_date[$i])) : null;
                                $meeting->participant_boys             = $request->participant_boys[$i];
                                $meeting->participant_girls            = $request->participant_girls[$i];
                                $meeting->participant_men              = $request->participant_men[$i];
                                $meeting->participant_women            = $request->participant_women[$i];
                                $meeting->participant_other_gender     = $request->participant_other_gender[$i];
                                $meeting->participant_total            = $request->participant_total[$i];
                                $meeting->participant_pwd_boys         = $request->participant_pwd_boys[$i];
                                $meeting->participant_pwd_girls        = $request->participant_pwd_girls[$i];
                                $meeting->participant_pwd_men          = $request->participant_pwd_men[$i];
                                $meeting->participant_pwd_women        = $request->participant_pwd_women[$i];
                                $meeting->participant_pwd_other_gender = $request->participant_pwd_other_gender[$i];
                                $meeting->participant_pwd_total        = $request->participant_pwd_total[$i];
                                $meeting->save();
                            }
                        } else {

                            if ($request->event_id[$i] && empty($request->no_of_event[$i])) {
                                return redirect(url('/') . '/activity/add?step=7&selp_activity_ref=' . $activityData[0]->selp_activity_ref)->with('error', 'Enter No. of Events!');
                            }
                            $meeting                     = new SelpPtProductionActivity();
                            $meeting->selp_activities_id = $activityData[0]->id;
                            $meeting->selp_activity_ref  = $activityData[0]->selp_activity_ref;

                            $meeting->event_id                     = $request->event_id[$i];
                            $meeting->no_of_event                  = $request->no_of_event[$i];
                            $meeting->starting_date                = $request->starting_date[$i] != null ? date("Y-m-d", strtotime($request->starting_date[$i])) : null;
                            $meeting->ending_date                  = $request->ending_date[$i] != null ? date("Y-m-d", strtotime($request->ending_date[$i])) : null;
                            $meeting->participant_boys             = $request->participant_boys[$i];
                            $meeting->participant_girls            = $request->participant_girls[$i];
                            $meeting->participant_men              = $request->participant_men[$i];
                            $meeting->participant_women            = $request->participant_women[$i];
                            $meeting->participant_other_gender     = $request->participant_other_gender[$i];
                            $meeting->participant_total            = $request->participant_total[$i];
                            $meeting->participant_pwd_boys         = $request->participant_pwd_boys[$i];
                            $meeting->participant_pwd_girls        = $request->participant_pwd_girls[$i];
                            $meeting->participant_pwd_men          = $request->participant_pwd_men[$i];
                            $meeting->participant_pwd_women        = $request->participant_pwd_women[$i];
                            $meeting->participant_pwd_other_gender = $request->participant_pwd_other_gender[$i];
                            $meeting->participant_pwd_total        = $request->participant_pwd_total[$i];
                            $meeting->save();
                        }
                    }
                }
            }

            $activity = ActivityModel::find($activityData[0]->id);

            if ($request->dm_approve == 2) {
                $activity->status = 2;
                if ($activity->approved_at == null) {
                    $activity->approved_at = date('Y-m-d H:i:s', strtotime('now'));
                    $activity->approved_by = auth()->user()->id;
                }
            } else if ($auth_user->user_role[0]['role_id'] == 1 && $activityData[0]->status == 2) {
                $activity->status = 2;
            } else {
                $activity->status = 1;
                if ($activity->submited_at == null) {
                    $activity->submited_at = date('Y-m-d H:i:s', strtotime('now'));
                }
            }

            $activity->save();

            DB::commit();
        } else {
            return redirect()->route('activity.add');
        }

        $request->session()->forget('activity_edit_mode');
        if ($request->dm_approve == 2 || $auth_user->user_role[0]['role_id'] == 1) {
            return redirect()->route('activity.approved.list')->with('success', 'Data Approved Successfully');
        } else {
            return redirect()->route('activity.pending.list')->with('success', 'Data Submitted Successfully');
        }

        $data['regions']             = getRegionByUserType();
        $data['step']                = $request->step;
        $data['auth_user']           = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        $data['meeting_event']       = MeetingEvent::where('status', 1)->get();
        $data['training_event']      = TrainingEvent::where('status', 1)->get();
        $data['community_event']     = CommunityEvent::where('status', 1)->get();
        $data['campaign_event']      = CampaignEvent::where('status', 1)->get();
        $data['pt_show_event']       = PTshowEvent::where('status', 1)->get();
        $data['pt_production_event'] = PTproductionEvent::where('status', 1)->get();
        $data['activityData']        = $activityData;
        $data['activityDataObj']     = ActivityModel::with(['meeting_activity'])->where('selp_activity_ref', $request->selp_activity_ref)->first();
        return view('backend.activity.create')->with($data);
    }

    // Draft List
    public function viewActivityDraftList()
    {
        $divisions = Division::all();
        //$regions   = Region::where('status', '1')->get();

        $regions   = getRegionByUserType();
        $auth_user = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        return view('backend.activity.activity-draft-list', compact('auth_user', 'divisions', 'regions'));
    }

    public function getActivityDraftList(Request $request)
    {
        // dd($request->all());
        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date   = date("Y-m-d", strtotime($request->to_date));

        $auth_user = User::with(['setup_user_area'])->where('id', Auth::id())->first();

        // if ($auth_user->user_role[0]['role_id'] == 5) {
        //     $incidents = ActivityModel::select('id', 'selp_activity_ref', 'reporting_date', 'employee_id', 'employee_name','employee_pin','status','created_at')->where('employee_id', $auth_user->id);
        // } else {
        // }
        $incidents = ActivityModel::select('id', 'selp_activity_ref', 'reporting_date', 'employee_id', 'employee_name', 'employee_pin', 'status', 'created_at');

        $incidents = searchCriteria($query = $incidents, $data = ['region_id' => $request->region_id, 'division_id' => $request->division_id, 'district_id' => $request->district_id, 'upazila_id' => $request->upazila_id, 'from_reporting_date' => $request->from_date, 'to_reporting_date' => $request->to_date]);
        // $allDivisions = RegionAreaDetail::where('region_id', $request->region_id)->where('status','1')->groupBy('division_id')->pluck('division_id')->toArray();
        // $reagionDivision    = RegionAreaDetail::where('region_id',$request->region_id)->where('division_id', $request->division_id)->where('status','1')->groupBy('district_id')->pluck('district_id')->toArray();
        // // dd($reagionDivision);
        // $allDistrict        = RegionAreaDetail::where('region_id',$request->region_id)->where('status','1')->groupBy('district_id')->pluck('district_id')->toArray();
        // // dd($allDistrict);

        // if (!empty($request->region_id) && empty($request->division_id)) {
        //     $incidents->whereIn('employee_district_id', $allDistrict);
        // } else if(!empty($request->division_id) && empty($request->district_id)){
        //     $incidents->whereIn('employee_district_id', $reagionDivision);
        // } else {
        //     // if($request->division_id) {
        //     //     $incidents->where('employee_division_id', $request->division_id);
        //     // }
        //     if($request->district_id) {
        //         $incidents->where('employee_district_id', $request->district_id);
        //     }
        //     if($request->upazila_id) {
        //         $incidents->where('employee_upazila_id', $request->upazila_id);
        //     }
        //     if($request->union_id) {
        //         $incidents->where('survivor_union_id', $request->union_id);
        //     }
        // }
        // if($request->from_date) {
        //     $incidents->where('reporting_date', '>=', $from_date);
        // }
        // if($request->to_date) {
        //     $incidents->where('reporting_date', '<=', $to_date);
        // }
        // $incidents->whereBetween('posting_date', [$from_date,$to_date]);
        $incidents->where('status', 0);
        $incidents->orderBy('id', 'DESC');

        return DataTables::of($incidents)
            ->addIndexColumn()
            ->editColumn('reporting_date', function ($incidents) {
                return $incidents->reporting_date != null ? date("d-m-Y", strtotime($incidents->reporting_date)) : '';
            })
            ->editColumn('created_at', function ($incidents) {
                return date('d-m-Y', strtotime($incidents->created_at));
            })
            ->editColumn('selp_activity_ref', function ($incidents) {
                $incident_ref      = explode('.', $incidents->selp_activity_ref);
                $selp_activity_ref = $this->formatIncidentId($incidents->id); //$incident_ref[1];
                return $selp_activity_ref;
            })
            ->addColumn('action_column', function (ActivityModel $incident) use ($auth_user) {
                // dd($auth_user->designation);
                // if ($auth_user->user_role[0]['role_id'] == 1 || $auth_user->user_role[0]['role_id'] == 4) {
                //     $links = '<a href="'.route('activity.data.single.pdf.view', $incident->id).'" target="__blank" class="btn btn-sm btn-danger" title="PDF"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                //     <a href="'.route('activity.data.single.excel.view', $incident->id).'" target="__blank" class="btn btn-sm btn-success" title="Excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>';
                //     return $links;
                // }
                if ($auth_user->user_role[0]['role_id'] == 5) {
                    $links = '<a href="' . route('activity.data.edit', $incident->selp_activity_ref) . '" class="btn btn-sm btn-info" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
                <a href="' . route('activity.data.single.pdf.view', $incident->id) . '" target="__blank" class="btn btn-sm btn-danger" title="PDF"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                <a href="' . route('activity.data.single.excel.view', $incident->id) . '" target="__blank" class="btn btn-sm btn-success" title="Excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>';
                    return $links;
                } else {
                    $links = '<a href="' . route('activity.data.single.pdf.view', $incident->id) . '" target="__blank" class="btn btn-sm btn-danger" title="PDF"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                <a href="' . route('activity.data.single.excel.view', $incident->id) . '" target="__blank" class="btn btn-sm btn-success" title="Excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>';
                    return $links;
                }
                // <a href="#" class="btn btn-sm btn-danger delete_incident"  action_type="inc_del" id="'.$incident->id.'" title="Delete"><i action_type="inc_del" class="fa fa-trash delete_incident" id="'.$incident->id.'" aria-hidden="true"></i></a>
            })
            ->editColumn('status', function ($list) {
                $actionBtn = '';
                if ($list->status == 0 || $list->status == null) {
                    $actionBtn = '<span class="badge badge-warning">Draft</span>';
                } elseif ($list->status == 2) {
                    $actionBtn = '<span class="badge badge-success">Approved</span>';
                } else {
                    $actionBtn = '<span class="badge badge-primary">Submitted for Approval</span>';
                }
                return $actionBtn;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    // Pending List
    public function viewActivityPendingList()
    {
        $divisions = Division::all();
        //$regions   = Region::where('status', '1')->get();

        $regions   = getRegionByUserType();
        $auth_user = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        return view('backend.activity.activity-pending-list', compact('auth_user', 'divisions', 'regions'));
    }

    public function getActivityPendingList(Request $request)
    {
        // dd($request->all());
        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date   = date("Y-m-d", strtotime($request->to_date));

        $auth_user = User::with(['setup_user_area'])->where('id', Auth::id())->first();

        // if ($auth_user->user_role[0]['role_id'] == 5) {
        //     $incidents = ActivityModel::select('id', 'selp_activity_ref', 'reporting_date', 'employee_id', 'employee_name','employee_pin','status','created_at')->where('employee_id', $auth_user->id);
        // } else {
        // }
        $incidents = ActivityModel::select('id', 'selp_activity_ref', 'reporting_date', 'employee_id', 'employee_name', 'employee_pin', 'status', 'created_at');
        $incidents = searchCriteria($query = $incidents, $data = ['region_id' => $request->region_id, 'division_id' => $request->division_id, 'district_id' => $request->district_id, 'upazila_id' => $request->upazila_id, 'from_reporting_date' => $request->from_date, 'to_reporting_date' => $request->to_date]);
        $incidents->where('status', 1);
        $incidents->orderBy('id', 'DESC');

        return DataTables::of($incidents)
            ->addIndexColumn()
            ->editColumn('reporting_date', function ($incidents) {
                return $incidents->reporting_date != null ? date("d-m-Y", strtotime($incidents->reporting_date)) : '';
            })
            ->editColumn('created_at', function ($incidents) {
                return date('d-m-Y', strtotime($incidents->created_at));
            })
            ->editColumn('selp_activity_ref', function ($incidents) {
                $incident_ref      = explode('.', $incidents->selp_activity_ref);
                $selp_activity_ref = $this->formatIncidentId($incidents->id); //$incident_ref[1];
                return $selp_activity_ref;
            })
            ->addColumn('action_column', function (ActivityModel $incident) use ($auth_user) {
                // dd($auth_user);
                if ($auth_user->user_role[0]['role_id'] == 4) {
                    $links = '<a href="' . route('activity.data.edit', $incident->selp_activity_ref) . '" class="btn btn-sm btn-info" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                    $links .= '<a href="' . route('activity.data.single.pdf.view', $incident->id) . '" target="__blank" class="btn btn-sm btn-danger" title="PDF"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                <a href="' . route('activity.data.single.excel.view', $incident->id) . '" target="__blank" class="btn btn-sm btn-success" title="Excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>';
                } elseif ($auth_user->user_role[0]['role_id'] == 5) {
                    // $links = '<a href="' . route('activity.data.edit', $incident->selp_activity_ref) . '" class="btn btn-sm btn-info" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                    // $links .=   '&nbsp;<a href="#" class="btn btn-sm btn-danger delete_incident"  action_type="inc_del" id="'.$incident->id.'" title="Delete"><i action_type="inc_del" class="fa fa-trash delete_incident" id="'.$incident->id.'" aria-hidden="true"></i></a>&nbsp';
                    $links = '&nbsp;<a href="' . route('activity.data.single.pdf.view', $incident->id) . '" target="__blank" class="btn btn-sm btn-danger" title="PDF"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                <a href="' . route('activity.data.single.excel.view', $incident->id) . '" target="__blank" class="btn btn-sm btn-success" title="Excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>';
                } elseif ($auth_user->user_role[0]['role_id'] == 1) {
                    $links = '&nbsp;<a href="#" class="btn btn-sm btn-danger delete_incident"  action_type="inc_del" id="' . $incident->id . '" title="Delete"><i action_type="inc_del" class="fa fa-trash delete_incident" id="' . $incident->id . '" aria-hidden="true"></i></a>&nbsp';
                    $links .= '<a href="' . route('activity.data.single.pdf.view', $incident->id) . '" target="__blank" class="btn btn-sm btn-danger" title="PDF"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                <a href="' . route('activity.data.single.excel.view', $incident->id) . '" target="__blank" class="btn btn-sm btn-success" title="Excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>';
                } else {
                    $links = '<a href="' . route('activity.data.single.pdf.view', $incident->id) . '" target="__blank" class="btn btn-sm btn-danger" title="PDF"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                <a href="' . route('activity.data.single.excel.view', $incident->id) . '" target="__blank" class="btn btn-sm btn-success" title="Excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>';
                }
                return $links;
            })
            ->editColumn('status', function ($list) {
                $actionBtn = '';
                if ($list->status == 0 || $list->status == null) {
                    $actionBtn = '<span class="badge badge-warning">Draft</span>';
                } elseif ($list->status == 2) {
                    $actionBtn = '<span class="badge badge-success">Approved</span>';
                } else {
                    $actionBtn = '<span class="badge badge-primary">Submitted for Approval</span>';
                }
                return $actionBtn;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    // Approved List
    public function viewActivityApproveList()
    {
        $divisions = Division::all();
        $regions   = getRegionByUserType();
        $auth_user = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        return view('backend.activity.activity-approved-list', compact('auth_user', 'divisions', 'regions'));
    }

    public function getActivityApproveList(Request $request)
    {
        // dd($request->all());
        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date   = date("Y-m-d", strtotime($request->to_date));

        $auth_user = User::with(['setup_user_area'])->where('id', Auth::id())->first();

        // if ($auth_user->user_role[0]['role_id'] == 5) {
        //     $incidents = ActivityModel::select('id', 'selp_activity_ref', 'reporting_date', 'employee_id', 'employee_name','employee_pin','status','created_at')->where('employee_id', $auth_user->id);
        // } else {
        // }
        $incidents = ActivityModel::select('id', 'selp_activity_ref', 'reporting_date', 'employee_id', 'employee_name', 'employee_pin', 'status', 'created_at');
        $incidents = searchCriteria($query = $incidents, $data = ['region_id' => $request->region_id, 'division_id' => $request->division_id, 'district_id' => $request->district_id, 'upazila_id' => $request->upazila_id, 'from_reporting_date' => $request->from_date, 'to_reporting_date' => $request->to_date]);
        $incidents->where('status', 2);
        $incidents->orderBy('id', 'DESC');

        return DataTables::of($incidents)
            ->addIndexColumn()
            ->editColumn('reporting_date', function ($incidents) {
                return $incidents->reporting_date != null ? date("d-m-Y", strtotime($incidents->reporting_date)) : '';
            })
            ->editColumn('created_at', function ($incidents) {
                return date('d-m-Y', strtotime($incidents->created_at));
            })
            ->editColumn('selp_activity_ref', function ($incidents) {
                $incident_ref      = explode('.', $incidents->selp_activity_ref);
                $selp_activity_ref = $this->formatIncidentId($incidents->id); //$incident_ref[1];
                return $selp_activity_ref;
            })
            ->addColumn('action_column', function (ActivityModel $incident) use ($auth_user) {

                if ($auth_user->user_role[0]['role_id'] == 4 && $incident->status == 2) {
                    // $links = '<a href="' . route('activity.data.edit', $incident->selp_activity_ref) . '" class="btn btn-sm btn-info" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a> ';
                    $links = '<a href="' . route('activity.data.single.pdf.view', $incident->id) . '" target="__blank" class="btn btn-sm btn-danger" title="PDF"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                <a href="' . route('activity.data.single.excel.view', $incident->id) . '" target="__blank" class="btn btn-sm btn-success" title="Excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>';
                } elseif ($auth_user->user_role[0]['role_id'] == 1) {
                    $links = '<a href="' . route('activity.data.edit', $incident->selp_activity_ref) . '" class="btn btn-sm btn-info" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
                    <a href="#" class="btn btn-sm btn-danger delete_incident"  action_type="inc_del" id="' . $incident->id . '" title="Delete"><i action_type="inc_del" class="fa fa-trash delete_incident" id="' . $incident->id . '" aria-hidden="true"></i></a>&nbsp';
                    $links .= '<a href="' . route('activity.data.single.pdf.view', $incident->id) . '" target="__blank" class="btn btn-sm btn-danger" title="PDF"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                        <a href="' . route('activity.data.single.excel.view', $incident->id) . '" target="__blank" class="btn btn-sm btn-success" title="Excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>';
                } else {
                    $links = '<a href="' . route('activity.data.single.pdf.view', $incident->id) . '" target="__blank" class="btn btn-sm btn-danger" title="PDF"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                <a href="' . route('activity.data.single.excel.view', $incident->id) . '" target="__blank" class="btn btn-sm btn-success" title="Excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>';
                }
                return $links;
            })
            ->editColumn('status', function ($list) {
                $actionBtn = '';
                if ($list->status == 0 || $list->status == null) {
                    $actionBtn = '<span class="badge badge-warning">Draft</span>';
                } elseif ($list->status == 2) {
                    $actionBtn = '<span class="badge badge-success">Approved</span>';
                } else {
                    $actionBtn = '<span class="badge badge-primary">Pending for Approval</span>';
                }
                return $actionBtn;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    public function singleExcelViewActivityData($id)
    {
        $pdata['activity'] = ActivityModel::with(['meeting_activity', 'training_activity', 'community_activity', 'campaign_activity', 'pt_show_activity', 'pt_production_activity', 'zones', 'division', 'district', 'upazilla'])->find($id);
        // dd($pdata['activity']['id']);
        $view_link = 'backend.activity.single-activity-excel-view';
        // return view($view_link,$pdata);
        // return Excel::download(new MisReportExport($pdata,$view_link), 'pollisomaj-data.xlsx');
        return Excel::download(new MisReportExport($pdata, $view_link), 'Activity_Data_Entry_No' . '_' . $pdata['activity']['id'] . '.' . 'xlsx');
    }

    public function singlePdfViewActivityData($id)
    {
        $pdata['activity'] = ActivityModel::with(['meeting_activity', 'training_activity', 'community_activity', 'campaign_activity', 'pt_show_activity', 'pt_production_activity', 'zones', 'division', 'district', 'upazilla'])->find($id);
        // $view_link = 'backend.activity.single-activity-pdf-view';
        // return view($view_link,$pdata);
        $pdf = PDF::loadView('backend.activity.single-activity-pdf-view', $pdata);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        $fileName = 'Activity_Data_Entry_No' . '_' . $pdata['activity']['id'] . '.' . 'xlsx';
        return $pdf->stream($fileName);
    }

    public function deleteActivityData(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $pollisomaj_tbl = ActivityModel::find($id)->delete();
            DB::commit();
            return "Deleted Successfully";
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
