<?php

namespace App\Http\Controllers\Backend\Admin\Setup\CEP_Region;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

class RegionController extends Controller
{
    private function isDistrictAlreadyUsed($district_id){
        $previousArea=RegionAreaDetail::where('district_id',$district_id)->get();
        for($i=0;$i<count($previousArea);$i++){
            $data=RegionAreaDetail::withTrashed()->find($previousArea[$i]->id);
            $data->deleted_at=time();
            $data->date_to=date('Y-m-d');
            $data->save();
        }
        return count($previousArea)>0 ? true : false;
    }


	public function view() 
	{
        $data['regions'] = Region::orderBy('id', 'ASC')->get();                        
        // dd($data['regions']->toArray());

        return view('backend.admin.setup.cep_region.region.view', $data);
    }

    public function areaView() 
    {
        $data['region_areas'] = RegionArea::with(['region', 'region_area_detail' => function ($query) {
                                    $query->withTrashed();
                                    $query->with(['regional_division', 'regional_district']);
                                }])
                                ->orderBy('id', 'ASC')
                                ->get();
                                    
        // dd($data['region_areas']->toArray());

        return view('backend.admin.setup.cep_region.region.area_view', $data);
    }

    public function add()
    {
        return view('backend.admin.setup.cep_region.region.add');
    }

    public function areaAdd()
    {
        $data['regions']   = Region::all();
        $data['divisions'] = Division::all();

        return view('backend.admin.setup.cep_region.region.area_add', $data);
    }

    public function store(Request $request)
    {
		// dd($request->toArray());

        $region = new Region;
        $region->region_name = $request->region_name;
        $region->save();

        return redirect()->route('setup.cepregion.region.view')->with('success', 'Successfully Inserted');
    }

    public function areaStore(Request $request)
    {
        // dd($request->toArray());

        $region_area = new RegionArea;
        $region_area->region_id = $request->region_id;
        $region_area->save();

        foreach($request->division_id as $key => $value)
        {
            $region_area_detail = new RegionAreaDetail;
            $region_area_detail->region_area_id = $region_area->id;
            $region_area_detail->region_id   = $request->region_id;
            $region_area_detail->division_id = $request->division_id[$key];
            $region_area_detail->district_id = $request->district_id[$key];
            $region_area_detail->date_from = date_create($request->date_from[$key]);
            $region_area_detail->date_to = $request->date_to[$key]!=null ? $request->date_to[$key] : null;
            $region_area_detail->deleted_at = $request->date_to[$key]!=null ? $request->date_to[$key] : null;
            //$this->isDistrictAlreadyUsed($region_area_detail->district_id);
            $region_area_detail->save();
        }

        return redirect()->route('setup.cepregion.region.areaView')->with('success', 'Successfully Inserted');
    }

    public function edit($id)
    {
        $data['editData'] = Region::find($id);
        // dd($data['editData']->toArray());

        return view('backend.admin.setup.cep_region.region.edit', $data);
    }

    public function areaEdit($id)
    {
        $data['regions']   = Region::all();
        $data['divisions'] = Division::all();
        $data['districts'] = District::all();
        $data['editData']  = RegionArea::with(['region', 'region_area_detail' => function ($query) {
                                $query->with(['regional_division', 'regional_district']);
                            }])->find($id);

        // dd($data['editData']->toArray());

        return view('backend.admin.setup.cep_region.region.area_edit', $data);
    }

    public function update(Request $request, $id)
    {
		// dd($request->toArray());

        $region = Region::find($id);
        $region->region_name = $request->region_name;
        $region->save();

        return redirect()->route('setup.cepregion.region.view')->with('success', 'Successfully Updated');
    }

    public function areaUpdate(Request $request, $id)
    {
        //dd($request->toArray());

        $region_area = RegionArea::find($id);
        $region_area->region_id = $request->region_id;
        $region_area->save();
        $prevRegionAreas=RegionAreaDetail::where('region_area_id', $id)->get();
        foreach($prevRegionAreas as $area){
            RegionAreaDetail::find($area->id)->delete();
        }
        
        

        foreach($request->division_id as $key => $value)
        {
            $region_area_detail = new RegionAreaDetail;
            $region_area_detail->region_area_id = $region_area->id;
            $region_area_detail->region_id   = $request->region_id;
            $region_area_detail->division_id = $request->division_id[$key];
            $region_area_detail->district_id = $request->district_id[$key];
            
            //$this->isDistrictAlreadyUsed($region_area_detail->district_id);

            /**
             * Check for district duplication for same area and region
             * 
             *  
            */
            
            $existingData=RegionAreaDetail::withTrashed()->where('region_area_id',$region_area_detail->region_area_id)->where('region_id',$request->region_id)->where('division_id',$request->division_id[$key])->where('district_id',$request->district_id[$key])->get();
            
            if(count($existingData)==0){
                $region_area_detail->date_from = date_create($request->date_from[$key]);
                $region_area_detail->save();
            }
            else{
                $getPrevData=RegionAreaDetail::withTrashed()->find($existingData[0]->id);
                if($request->date_to[$key]!=null){
                    $getPrevData->deleted_at=$request->date_to[$key];
                    //$getPrevData->date_from=date_create($request->date_from[$key]);
                    $getPrevData->date_to=$request->date_to[$key];
                    $getPrevData->save();
                }else{
                    $getPrevData->deleted_at=null;
                    $getPrevData->date_from=date_create($request->date_from[$key]);
                    $getPrevData->date_to=null;
                    $getPrevData->save();
                }
                
            }
            
        }

        

        return redirect()->route('setup.cepregion.region.areaView')->with('success', 'Successfully Updated');
    }

    public function delete($id)
    {
        // dd($id);

        Region::where('id', $id)->delete();
        return response()->json('deleted');
    }

    public function areaDelete($id)
    {
        // dd($id);

        RegionArea::where('id', $id)->delete();
        RegionAreaDetail::where('region_area_id', $id)->delete();

        return response()->json('deleted');
    }

    public function getDivisionDistrict(Request $request)
    {
        $division_id = $request->division_id;
        $districts   = getdistrict($division_id, $district_id='');

        return response()->json($districts);
    }

    public function changeRegionStatus(Request $request)
    {
        $region = Region::find($request->id);
        $region->status = $request->status;
        $region->save();

        return response()->json('changed');
    }

    public function changeRegionAreaStatus(Request $request)
    {
        //return $request->all();
        $region_area = RegionAreaDetail::find($request->id);
        $region_area->status = $request->status;
        $region_area->save();

        return response()->json('changed');
    }

    public function isDistrictActive(Request $request){
        $previousArea=RegionAreaDetail::where('district_id',$request->district_id)->get();
        if(count($previousArea)>0){
            return response()->json([
                'status' => 200,
                'url'=>route('setup.cepregion.region.areaEdit',['id'=>$previousArea[0]->region_area_id])
            ]);
        }else{
            return response()->json([
                'status' => 404,
            ]);
        }
    }
}
