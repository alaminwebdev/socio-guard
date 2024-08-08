<?php

namespace App\Http\Controllers\Backend\Admin\Setup\Region_User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\User;
use App\Model\Admin\Setup\CEP_Region\Region;
use App\Model\Admin\Setup\CEP_Region\RegionArea;
use App\Model\Admin\Setup\CEP_Region\RegionAreaDetail;
use App\Model\Admin\Setup\Region_User\RegionalManager;

class RegionManagerController extends Controller
{
	public function view() 
	{
        $data['regional_managers'] = RegionalManager::with(['region'])->orderBy('id', 'ASC')->get();                        
        // dd($data['regional_managers']->toArray());

        return view('backend.user.regional_manager.view', $data);
    }

    public function add()
    {
        $data['regions'] = Region::all();
        return view('backend.user.regional_manager.add', $data);
    }

    public function store(Request $request)
    {
		// dd($request->toArray());
    	$exist_manager = RegionalManager::where(['region_id' => $request->region_id])->count();

    	if ($exist_manager <= 0) 
    	{
    		$regional_manager = new RegionalManager;
	        $regional_manager->name = $request->name;
	        $regional_manager->pin  = $request->pin;
	        $regional_manager->region_id = $request->region_id;
	        $regional_manager->save();

	        return redirect()->route('user.region.region_manager.view')->with('success', 'Successfully Inserted');
    	}
    	else 
    	{
	        return redirect()->route('user.region.region_manager.add')->with('error', 'Already manager exist in this region');
    	}
    }

    public function edit($id)
    {
    	$data['regions'] = Region::all();
        $data['editData'] = RegionalManager::with(['region'])->find($id);
        // dd($data['editData']->toArray());

        return view('backend.user.regional_manager.edit', $data);
    }

    public function update(Request $request, $id)
    {
    	$regional_manager = RegionalManager::find($id);
		$exist_manager 	  = RegionalManager::where(['region_id' => $request->region_id])->count();
		// dd($exist_manager);

		if ($regional_manager->region_id == $request->region_id) 
		{
			$regional_manager->name = $request->name;
	        $regional_manager->pin  = $request->pin;
	        $regional_manager->save();

	        return redirect()->route('user.region.region_manager.view')->with('success', 'Successfully Updated');
		}
		else 
    	{
	        if ($exist_manager <= 0) 
	    	{
		        $regional_manager->name = $request->name;
		        $regional_manager->pin  = $request->pin;
		        $regional_manager->region_id = $request->region_id;
		        $regional_manager->save();

		        return redirect()->route('user.region.region_manager.view')->with('success', 'Successfully Updated');
	    	}
	    	else 
	    	{
		        return redirect()->route('user.region.region_manager.edit', $id)->with('error', 'Already manager exist in this region');
	    	}
    	}
    }

    public function delete($id)
    {
        // dd($id);

        RegionalManager::where('id', $id)->delete();
        return response()->json('deleted');
    }

    public function changeRegionManagerStatus(Request $request)
    {
        $regional_manager = RegionalManager::find($request->id);
        $regional_manager->status = $request->status;
        $regional_manager->save();

        return response()->json('changed');
    }
}
