<?php

namespace App\Http\Controllers\Backend\Admin\Setup\CEP_Region;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\User;
use App\Model\Admin\Setup\Division;
use App\Model\Admin\Setup\District;
use App\Model\Admin\Setup\Upazila;
use App\Model\Admin\Setup\Union;
use App\Model\Admin\Setup\Village;
use App\Model\Admin\Setup\CEP_Region\Region;
use App\Model\Admin\Setup\CEP_Region\RegionArea;
use App\Model\Admin\Setup\CEP_Region\RegionAreaDetail;
use App\Model\Admin\Setup\Region_User\RegionalManager;
use App\Model\Admin\Setup\CEP_Region\DistrictManager;
use App\Model\Admin\Setup\CEP_Region\DistrictManagerDetail;

class DistrictManagerController extends Controller
{
	public function view() 
	{
        $data['district_managers'] = DistrictManager::with(['region', 'district_manager_detail' => function ($query) {
                                        $query->with(['manager_division', 'manager_district', 'manager_upazila']);
                                    }])
                                    ->orderBy('id', 'ASC')
                                    ->get();
                                    
        // dd($data['district_managers']->toArray());

        return view('backend.admin.setup.cep_region.district_manager.view', $data);
    }

    public function add()
    {
        $data['regions'] = Region::get();
        return view('backend.admin.setup.cep_region.district_manager.add', $data);
    }

    public function store(Request $request)
    {
		// dd($request->toArray());

        $district_manager = new DistrictManager;
        $district_manager->region_id     = $request->region_id;
        $district_manager->employee_name = $request->employee_name;
        $district_manager->employee_pin  = $request->employee_pin;
        $district_manager->employee_id   = Auth::user()->id;
        $district_manager->save();

        foreach($request->division_id as $key => $value)
        {
            $district_manager_detail = new DistrictManagerDetail;
            $district_manager_detail->district_manager_id = $district_manager->id;
            $district_manager_detail->division_id = $request->division_id[$key];
            $district_manager_detail->district_id = $request->district_id[$key];
            $district_manager_detail->upazila_id  = $request->upazila_id[$key];
            $district_manager_detail->save();
        }

        return redirect()->route('setup.cepregion.district_manager.view')->with('success', 'Successfully Inserted');
    }

    public function edit($id)
    {
        $data['divisions'] = Division::select('id', 'name')->get();
        $data['districts'] = District::select('id', 'division_id', 'name')->get();
        $data['upazilas']  = Upazila::select('id', 'division_id', 'district_id', 'name')->get();
        $data['regions']   = Region::select('id', 'region_name')->get();
        $data['editData']  = DistrictManager::with(['region', 'district_manager_detail' => function ($query) {
                                $query->with(['manager_division', 'manager_district', 'manager_upazila']);
                            }])
                            ->find($id);

        // dd($data['editData']->toArray());

        return view('backend.admin.setup.cep_region.district_manager.edit', $data);
    }

    public function update(Request $request, $id)
    {
        // dd($request->toArray());

        $district_manager = DistrictManager::find($id);
        $district_manager->region_id     = $request->region_id;
        $district_manager->employee_name = $request->employee_name;
        $district_manager->employee_pin  = $request->employee_pin;
        $district_manager->employee_id   = Auth::user()->id;
        $district_manager->save();

        DistrictManagerDetail::where('district_manager_id', $id)->delete();

        foreach($request->division_id as $key => $value)
        {
            $district_manager_detail = new DistrictManagerDetail;
            $district_manager_detail->district_manager_id = $district_manager->id;
            $district_manager_detail->division_id = $request->division_id[$key];
            $district_manager_detail->district_id = $request->district_id[$key];
            $district_manager_detail->upazila_id  = $request->upazila_id[$key];
            $district_manager_detail->save();
        }

        return redirect()->route('setup.cepregion.district_manager.view')->with('success', 'Successfully Updated');
    }

    public function delete($id)
    {
        DistrictManager::where('id', $id)->delete();
        DistrictManagerDetail::where('district_manager_id', $id)->delete();
        
        return response()->json('deleted');
    }

    public function getDistrictUpazila(Request $request)
    {
        $district_id = $request->district_id;
        $upazilas    = getDistrictUpazila($district_id, $upazila_id='');

        // dd($upazilas->toArray());

        return response()->json($upazilas);
    }

    public function changeDistrictManagerStatus(Request $request)
    {
        $district_manager = DistrictManagerDetail::find($request->id);
        $district_manager->status = $request->status;
        $district_manager->save();

        return response()->json('changed');
    }
}
