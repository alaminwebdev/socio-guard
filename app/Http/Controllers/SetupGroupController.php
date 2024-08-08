<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\SwapnosarothiSetupGroup;
use App\Model\Admin\Setup\Village;
use App\Model\Admin\Setup\Division;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Model\Admin\Setup\CEP_Region\Region;

class SetupGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['regions']   = getRegionByUserType();
        $data['auth_user'] = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        return view('swapnosarothi.group-setup.index', $data);
    }

    /**
     * Display list with Datatable.
     *
     */
    public function groupListDataTable(Request $request)
    {
        $grouDatas = SwapnosarothiSetupGroup::query();
        $auth_user = User::with(['setup_user_area'])->where('id', Auth::id())->first();

        $grouDatas = searchCriteriaSwapnosarothi($query = $grouDatas, $data = ['region_id' => $request->region_id, 'division_id' => $request->division_id, 'district_id' => $request->district_id, 'upazila_id' => $request->upazila_id, 'start_date' => $request->start_date, 'end_date' => $request->end_date]);

        return DataTables::of($grouDatas)
        
        ->editColumn('status', function ($grouDatas) {
            $statusBg = $grouDatas->status == 1 ? 'success' : 'warning';
            $status = $grouDatas->status == 1 ? 'Active' : 'Deactive';
            return '<span class="badge badge-'.$statusBg.'">'.  $status .'</span>';
        })
        ->editColumn('start_date', function ($grouDatas) {
            return date('d-m-Y', strtotime($grouDatas->start_date));
        })
        ->editColumn('end_date', function ($grouDatas) {
            return $grouDatas->end_date ? date('d-m-Y', strtotime($grouDatas->end_date)) : '';
        })
        ->editColumn('created_at', function ($grouDatas) {
            return $grouDatas->created_at ? date('d-m-Y', strtotime($grouDatas->created_at)) : '';
        })
        ->addColumn('action_column', function ($grouDatas) use ($auth_user) {
            $links = '';
            if ($auth_user->user_role[0]['role_id'] == 1) {
                $links = '<a href="' . route('swapnosarothisetupgroup.edit', $grouDatas->id) . '" class="btn btn-sm btn-info" title="Edit"><i class="fa fa-edit"></i></a> ';
                $links .= '<form action="' . route('swapnosarothisetupgroup.destroy', $grouDatas->id) . '" method="POST"  class=" d-inline" title="Delete"> '.  csrf_field() . method_field("DELETE") .' <button type="submit" class="btn btn-sm btn-danger" style="min-width:auto"><i class="fa fa-trash"></i></button></form>';
            }

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
    public function create()
    {
        $zones = Region::all();
        return view('swapnosarothi.group-setup.create', compact('zones'));
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
            "group_id" => 'required',
            "start_date" => 'required|date',
            "end_date" => 'nullable|date',
            "group_name" => 'required',
            "zone_id" => 'required',
            "division_id" => 'required',
            "district_id" => 'required',
            "upazila_id" => 'required',
            "union_id" => 'required',
            "village_id" => 'required',
        ]);

        // Check if the group_id already exists in the database
        $existingGroup = SwapnosarothiSetupGroup::where('group_id', $request->group_id)->first();
        if ($existingGroup) {
            // If the group_id exists, modify it before saving
            $request->merge(['group_id' => $this->generateNewGroupId()]);
        }

        $requestData = $request->all();

        $groupId = SwapnosarothiSetupGroup::create($requestData);

        if ($request->has('village_id')) {
            $groupId->villages()->attach($request->village_id);
        }

        $request->session()->flash("success", "Group successfully Created!");
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SwapnosarothiSetupGroup  $swapnosarothiSetupGroup
     * @return \Illuminate\Http\Response
     */
    public function show(SwapnosarothiSetupGroup $swapnosarothiSetupGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SwapnosarothiSetupGroup  $swapnosarothiSetupGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(SwapnosarothiSetupGroup $swapnosarothisetupgroup)
    {
        $zones = Region::all();
        $editData = $swapnosarothisetupgroup;

        $villages = Village::where('union_id', $editData->union_id)->get();
        return view('swapnosarothi.group-setup.edit', compact('zones', 'editData', 'villages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SwapnosarothiSetupGroup  $swapnosarothiSetupGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SwapnosarothiSetupGroup $swapnosarothisetupgroup)
    {
        $request->validate([
            "group_id" => 'required',
            "start_date" => 'required|date',
            "end_date" => 'nullable|date',
            "group_name" => 'required',
            "zone_id" => 'required',
            "division_id" => 'required',
            "district_id" => 'required',
            "upazila_id" => 'required',
            "union_id" => 'required',
            "village_id" => 'required',
        ]);

        $swapnosarothisetupgroup->update($request->all());

        if ($request->has('village_id')) {
            $swapnosarothisetupgroup->villages()->sync($request->village_id);
        }

        $request->session()->flash("success", "Group successfully Updated!");
        return redirect()->route('swapnosarothisetupgroup.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SwapnosarothiSetupGroup  $swapnosarothiSetupGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,SwapnosarothiSetupGroup $swapnosarothisetupgroup)
    {
        $swapnosarothisetupgroup->delete();
        $request->session()->flash("success", "Group successfully Deleted!");
        return redirect()->route('swapnosarothisetupgroup.index');
    }

    /**
     * get setup id
     * use this group setup page
     */
    public function getSetupId()
    {
        $latestSetup = SwapnosarothiSetupGroup::latest()->first();
        $id = $latestSetup ? $latestSetup->group_id + 1 : 1;

        return response()->json($id);
    }

    private function generateNewGroupId()
    {
        $maxGroupId = SwapnosarothiSetupGroup::max('group_id');
        return $maxGroupId + 1;
    }
}
