<?php

namespace App\Http\Controllers;

use App\User;
use App\SwapnosarothiSkill;
use Illuminate\Http\Request;
use App\SwapnosarothiProfile;
use App\Model\Admin\Setup\Upazila;
use App\SwapnosarothiProfileSkill;
use App\Model\Admin\Setup\District;
use App\Model\Admin\Setup\Division;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Model\Admin\Setup\CEP_Region\Region;
use App\Model\Admin\Setup\CEP_Region\SetupUserArea;
use App\SwapnosarothiSetupGroup;

class SwapnosarothiProfileSkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $auth_user           = User::with(['setup_user_area'])->where('id', Auth::id())->first();

        $region_ids   = SetupUserArea::where('user_id', $auth_user->id)->groupBy('region_id')->pluck('region_id')->toArray();
        $division_ids = SetupUserArea::where('user_id', $auth_user->id)->groupBy('division_id')->pluck('division_id')->toArray();
        $district_ids = SetupUserArea::where('user_id', $auth_user->id)->groupBy('district_id')->pluck('district_id')->toArray();
        $upazila_ids  = SetupUserArea::where('user_id', $auth_user->id)->groupBy('upazila_id')->pluck('upazila_id')->toArray();

        $regions = Region::when($region_ids, function ($query) use ($region_ids) {
            if (count($region_ids) > 0) {
                $query->whereIn('id', $region_ids);
            }
        })->where('status', '1')->get();

        $divisions = Division::when($division_ids, function ($query) use ($division_ids) {
            if (count($division_ids) > 0) {
                $query->whereIn('id', $division_ids);
            }
        })->where('status', '1')->get();

        $districts = District::when($district_ids, function ($query) use ($district_ids) {
            if (count($district_ids) > 0) {
                $query->whereIn('id', $district_ids);
            }
        })->where('status', '1')->get();

        $upazilas = Upazila::when($upazila_ids, function ($query) use ($upazila_ids) {
            if (count($upazila_ids) > 0) {
                $query->whereIn('id', $upazila_ids);
            }
        })->where('status', '1')->get();

        // $groups = SwapnosarothiSetupGroup::when($region_ids, function ($query) use ($region_ids) {
        //     if (count($region_ids) > 0) {
        //         $query->whereIn('zone_id', $region_ids);
        //     }
        // })->when($division_ids, function ($query) use ($division_ids) {
        //     if (count($division_ids) > 0) {
        //         $query->whereIn('division_id', $division_ids);
        //     }
        // })->when($district_ids, function ($query) use ($district_ids) {
        //     if (count($district_ids) > 0) {
        //         $query->whereIn('district_id', $district_ids);
        //     }
        // })->when($upazila_ids, function ($query) use ($upazila_ids) {
        //     if (count($upazila_ids) > 0) {
        //         $query->whereIn('upazila_id', $upazila_ids);
        //     }
        // })->where('status', 1)->get();
        return view('swapnosarothi.profile-skill.index', compact('regions','divisions', 'districts', 'upazilas'));
    }

    public function profileSkillListDataTable(Request $request)
    {
        $skillDatas = SwapnosarothiSetupGroup::orderBy('status', 'asc');

        $auth_user = User::with(['setup_user_area'])->where('id', Auth::id())->first();

        $skillDatas = searchCriteriaSwapnosarothi($query = $skillDatas, $data = ['region_id' => $request->region_id, 'division_id' => $request->division_id, 'district_id' => $request->district_id, 'upazila_id' => $request->upazila_id, 'from_date' => $request->start_date, 'to_date' => $request->end_date]);
        
        return DataTables::of($skillDatas)

        ->editColumn('status', function ($skillDatas) {
            $statusBg = $skillDatas->status == 1 ? 'success' : 'warning';
            $status = $skillDatas->status == 1 ? 'Active' : 'Deactive';
            return '<span class="badge badge-'.$statusBg.'">'.  $status .'</span>';
        })
    
        ->addColumn('action_column', function ($skillDatas) use ($auth_user) {
            $links =  $skillDatas->status == 1 ?  '<a   href="'.route('swapnosarothiprofileskill.create', ['group_id' =>  $skillDatas->id]).'" class="btn btn-sm btn-info mr-2"><i class="fa fa-plus"></i>Add</a>' : '';
            $links .= '<a href="'.route('swapnosarothiprofileskill.show',$skillDatas->id).'" class="btn btn-sm btn-success mr-2"><i class="fa fa-eye"></i> View</a>';
            
            return $links;
        })
        ->addIndexColumn()
        ->escapeColumns([])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['profiles'] = SwapnosarothiProfile::where('group_id', $request->group_id)
        ->where('group_status', 'ongoing')
        ->select('id', 'name', 'group_id','fathers_name', 'mothers_name')
        ->get();

        // $exSkills = SwapnosarothiProfileSkill::where('group_table_id', $request->group_id)->groupBy('skill_table_id')->pluck('skill_table_id');
    
        // return $exSkills;

        $data['skills'] = SwapnosarothiSkill::where('status', 1)
        // ->whereNotIn('id',$exSkills)
        ->orderBy('order', 'asc')
        ->get();

        return view('swapnosarothi.profile-skill.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'skill_table_id' => 'required',
            'skill_date' => 'required|date',
        ]);

        foreach($request->addskill as $key => $skill){
            $exists = SwapnosarothiProfileSkill::where('group_table_id', $request->group_table_id)
                ->where('profile_table_id', $key)
                ->where('skill_table_id', $request->skill_table_id)->first();
            if(!$exists){
                $profileSkill = new SwapnosarothiProfileSkill;
                $profileSkill->group_table_id = $request->group_table_id;
                $profileSkill->profile_table_id = $key;
                $profileSkill->skill_table_id = $request->skill_table_id;
                $profileSkill->skill_date = $request->skill_date;
                $profileSkill->created_by = Auth::id();
                $profileSkill->save();
            }
            
        }

        $request->session()->flash("success", "Profile Skill Successfully Added!");
        return redirect()->route('swapnosarothiprofileskill.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SwapnosarothiProfileSkill  $swapnosarothiProfileSkill
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {

        $data['profiles'] = SwapnosarothiProfile::with('profile_skills.skill')->where('group_id', $id)
        ->orderByRaw("CASE WHEN group_status = 'ongoing' THEN 1 ELSE 2 END, group_status ASC")
        ->select('id', 'name', 'group_id', 'group_status', 'fathers_name', 'mothers_name')
        ->get();
        return view('swapnosarothi.profile-skill.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SwapnosarothiProfileSkill  $swapnosarothiProfileSkill
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $skillDatas = SwapnosarothiProfile::with('profile_skills.skill')->where('id', $id)->first();
        return view('swapnosarothi.profile-skill.edit', compact('skillDatas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SwapnosarothiProfileSkill  $swapnosarothiProfileSkill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SwapnosarothiProfileSkill $swapnosarothiprofileskill)
    {

        // $nextRow = SwapnosarothiProfileSkill::where('profile_table_id', $swapnosarothiprofileskill->profile->id)->where('id', '>', $swapnosarothiprofileskill->id)->orderBy('id')->first();

        // $previousRow = SwapnosarothiProfileSkill::where('profile_table_id', $swapnosarothiprofileskill->profile->id)->where('id', '<', $swapnosarothiprofileskill->id)->orderBy('id', 'desc')->first();

      
        // if(strtotime($request->skill_date) <= strtotime($previousRow->skill_date) || strtotime($request->skill_date) >= strtotime($nextRow->skill_date)){
        //     $request->session()->flash("error", "Select a date greater than ".$previousRow->skill_date->format('d M Y')." and less than ".$nextRow->skill_date->format('d M Y'));
        //     return back();
        // }
       
        $request->validate([
            'skill_date' => 'required|date',
        ]);
        $swapnosarothiprofileskill->update($request->all());
        $request->session()->flash("success", "Profile Skill Successfully Updated!");
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SwapnosarothiProfileSkill  $swapnosarothiProfileSkill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, SwapnosarothiProfileSkill $swapnosarothiprofileskill)
    {
        $swapnosarothiprofileskill->delete();

        $request->session()->flash("success", "Profile Skill Successfully Deleted!");
        return back();
    }

    public function profileSkillCheck(Request $request){
        $oldSkills = SwapnosarothiProfileSkill::where('group_table_id',  $request->group_id)->where('skill_table_id', $request->skill_id)->pluck('profile_table_id');
        return response()->json($oldSkills);
    }

}
