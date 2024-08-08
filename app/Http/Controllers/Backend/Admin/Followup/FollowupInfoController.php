<?php

namespace App\Http\Controllers\Backend\Admin\Followup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use DataTables;
use App\User;
use Carbon\Carbon;
use App\Model\Admin\Setup\Division;
use App\Model\Admin\Setup\District;
use App\Model\Admin\Setup\Upazila;
use App\Model\Admin\Setup\Union;
use App\Model\Admin\Followup\FollowupInfo;
use App\Model\Admin\Followup\FollowupQuestion;
use App\Model\Admin\Followup\FollowupQuestionAnswer;
use App\Model\Admin\Followup\FollowupQuestionAnswerDetail;
use App\Model\Admin\Setup\SurvivorIncidentPlace;
use App\Model\Admin\Setup\ViolenceCategory;
use App\Model\Admin\Incident\SurvivorIncidentInformation;
use App\Model\Admin\Setup\CEP_Region\RegionAreaDetail;
use App\Model\Admin\Setup\CEP_Region\Region;

class FollowupInfoController extends Controller
{
	public function view()
	{
		$data['divisions'] = Division::select('id', 'name')->get();
        $data['violence_categories'] = ViolenceCategory::where('status','1')->get();
        $data['regions']            = Region::where('status','1')->get();
		return view('backend.admin.followup.info_view', $data);
	}

    public function individualView($id='')
    {
        $data['incident'] = SurvivorIncidentInformation::with(['survivor_brac_support' => function ($query) {
                                $query->with(['brac_final_support']);
                            }, 'survivor_other_organization_support' => function ($query) {
                                $query->with(['other_organization_final_support']);
                            }])
                            ->select('id', 'survivor_id', 'survivor_name', 'violence_date', 'case_status')
                            ->find($id);

        $data['followup_info'] = FollowupQuestionAnswer::with(['followup_done_by'])
                                ->where(['survivor_incident_info_id' => $id])
                                ->first();

        // $data['followups'] = FollowupQuestion::with(['question_answer' => function ($query) {
        //                         $query->with(['followup_question_answer', 'question_answer_option']);
        //                     }])->get();

        $data['followups'] = FollowupQuestion::with(['question_answer' => function ($query) use ($id) {
                                $query->with(['question_answer_option']);
                                $query->whereHas('followup_question_answer', function ($q) use ($id){
                                    $q->where('survivor_incident_info_id', $id);
                                });
                            }])->get();

        // dd($data['followups']->toArray());

        return view('backend.admin.followup.info_individual_view', $data);
    }

    public function getViewDatatable(Request $request)
    {
        $incidents = SurvivorIncidentInformation::select('id', 'survivor_id', 'survivor_name', 'violence_date', 'case_status');

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
            ->addColumn('followup_no', function(SurvivorIncidentInformation $incident) {
                $output = '<ol>';
                if($incident->followup_info) {
                    foreach($incident->followup_info as $value) {
                        $output .= '<li>'.$value->followup_no.'</li>';
                    }
                }
                $output .= '</ol>';
                return $output;
            })
            ->addColumn('last_followup_date', function(SurvivorIncidentInformation $incident) {
                $output = '<ol>';
                if($incident->followup_info) {
                    foreach($incident->followup_info as $value) {
                        $output .= '<li>'.date("Y-m-d h:i A", strtotime($value->followup_date)).'</li>';
                    }
                }
                $output .= '</ol>';
                return $output;
            })
            ->addColumn('action_column', function(SurvivorIncidentInformation $incident){
                $links = '<a href="'.route('followup.info.add', $incident->id).'" class="btn btn-sm btn-info" title="Follow-Up">Follow-Up</a>
                          <a href="'.route('followup.info.individual.view', $incident->id).'" class="btn btn-sm btn-success" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                return $links;
            })
            ->rawColumns(['followup_no', 'last_followup_date', 'action_column'])
            ->make(true);
    }

    public function add($id='')
    {
        $data['incident_places'] = SurvivorIncidentPlace::all();
        $data['questions'] = FollowupQuestion::with(['followup_question_option'])->get();
        $data['incident']  = SurvivorIncidentInformation::with(['survivor_brac_support' => function ($query) {
                                $query->with(['brac_final_support']);
                            }, 'survivor_other_organization_support' => function ($query) {
                                $query->with(['other_organization_final_support']);
                            }])
                            ->select('id', 'survivor_id', 'survivor_name', 'violence_date', 'case_status')
                            ->find($id);

        // dd($data['incident']->toArray());

        $data['followup_info'] = FollowupQuestionAnswer::with(['followup_done_by'])
                                ->where(['survivor_incident_info_id' => $id])
                                ->first();

        return view('backend.admin.followup.info_add', $data);
    }

    public function store(Request $request)
    {
        // dd($request->toArray());

        $followup_no = FollowupQuestionAnswer::where(['survivor_id' => $request->survivor_id])->count();

        $answer = new FollowupQuestionAnswer;
        $answer->survivor_incident_info_id = $request->survivor_incident_info_id;
        $answer->survivor_id   = $request->survivor_id;
        $answer->remark        = $request->remark;
        $answer->followup_date = date("Y-m-d", strtotime($request->followup_date)).' '.date("H:i:s", strtotime("now"));
        $answer->created_by    = Auth::user()->id;
        $answer->followup_no   = ++$followup_no;
        $answer->save();
        foreach($request->question as $key => $value)
        {
            $answer_detail = new FollowupQuestionAnswerDetail;
            $answer_detail->followup_question_answer_id = $answer->id;
            $answer_detail->question_id = $request->question[$key];
            $answer_detail->answer = $request->option[$key];
            $answer_detail->save();
        }

        return redirect()->route('followup.info.view')->with('success', 'Successfully Inserted');
    }
}
