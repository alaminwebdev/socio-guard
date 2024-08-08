<?php

namespace App\Http\Controllers\Backend\Admin\Setup;

use PDF;
use Auth;
use Session;
use App\User;
use DataTables;
use App\Model\ReportHeader;
use Illuminate\Http\Request;
use App\Model\PollisomajSetup;
use App\Model\Admin\Setup\Union;
use App\Model\SelpIncidentModel;
use App\Model\Admin\Setup\Upazila;
use App\Model\Admin\Setup\Village;
use Illuminate\Support\Facades\DB;
use App\Model\Admin\Setup\District;
use App\Model\Admin\Setup\Division;
use App\Http\Controllers\Controller;
use App\Imports\VIllageDataImport;
use App\Model\Admin\Setup\Pourosova;
use Maatwebsite\Excel\Facades\Excel;
use App\Model\Admin\Setup\CityCorporation;
use App\Model\Admin\Incident\SurvivorIncidentInformation;

class SetupController extends Controller
{
	//Division
    public function viewDivision(){
		$allData=Division::all();
		return view('backend.admin.setup.division-view',compact('allData'));
	}

	public function addDivision(){
		return view('backend.admin.setup.division-add');
	}

	public function storeDivision(Request $request){
		$data = new Division;
		$data->name = $request->name;
        $data->created_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.division.view')->with('success','Successfully Inserted');
	}

	public function editDivision($id){
		$editData = Division::find($id);
        return view('backend.admin.setup.division-add',compact('editData'));
	}

	public function updateDivision(Request $request,$id){
		$data = Division::find($id);
		$data->name = $request->name;
        $data->modified_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.division.view')->with('success','Successfully Updated');
	}

	public function deleteDivision(Request $request,$id){
		$exist_data =   District::where('division_id', $id)->count();

        if ($exist_data > 0) {
            return response()->json('notdeleted');
        } else {
            Division::where('id', $id)->delete();
            return response()->json('deleted');
        }
	}

	//District
	public function viewDistrict(){
		$allData 	= District::all();
		$auth_user  = User::with(['setup_user_area'])->where('id', Auth::id())->first();
		return view('backend.admin.setup.district-view',compact('allData','auth_user'));
	}

	public function addDistrict(){
		$divisions = Division::all();
		return view('backend.admin.setup.district-add',compact('divisions'));
	}

	public function storeDistrict(Request $request){
		$district = new District();
		$district->division_id = $request->division_id;
		$district->name = $request->name;
		$district->created_by = Auth::id();
		$district->save();
		return redirect()->route('setup.district.view')->with('success','Successfully Inserted');
	}

	public function editDistrict($id){
		$editData = District::find($id);
		$divisions=Division::all();
		return view('backend.admin.setup.district-add',compact('editData','divisions'));
	}

	public function updateDistrict(Request $request,$id){
		// dd($request->all());
		$district = District::find($id);
		$district->division_id = $request->division_id;
		$district->name = $request->name;
		$district->modified_by = Auth::id();
		if($district->isDirty(['division_id', 'name']) == true){
			$district->save();
			return redirect()->route('setup.district.view')->with('success','Successfully Updated');
		}else{
			return redirect()->back()->with('warning','You have made no changes to update');
		}
	}

	public function deleteDistrict(Request $request,$id){
		$exist_data =   Upazila::where('district_id', $id)->count();
		// dd($exist_data);
        if ($exist_data > 0) {
            return response()->json('notdeleted');
        } else {
            District::where('id', $id)->delete();
            return response()->json('deleted');
        }
	}

	//Upazila
	public function viewUpazila(){
		$allData = Upazila::all();
		return view('backend.admin.setup.upazilla-view',compact('allData'));
	}

	public function addUpazila(){
		$divisions = Division::all();
		return view('backend.admin.setup.upazila-add',compact('divisions'));
	}

	public function storeUpazila(Request $request){
		$upazila = new Upazila();
		$upazila->division_id = $request->division_id;
		$upazila->district_id = $request->district_id;
		$upazila->name = $request->name;
		$upazila->created_by = Auth::id();
		$upazila->save();
		return redirect()->route('setup.upazila.view')->with('success','Successfully Inserted');
	}

	public function editUpazila($id){
		$editData = Upazila::find($id);
		$divisions = Division::all();
		return view('backend.admin.setup.upazila-add',compact('editData','divisions'));
	}

	public function updateUpazila(Request $request,$id){
		$upazila = Upazila::find($id);
		$upazila->division_id = $request->division_id;
		$upazila->district_id = $request->district_id;
		$upazila->name = $request->name;
		$upazila->modified_by = Auth::id();
		$upazila->save();
		return redirect()->route('setup.upazila.view')->with('success','Successfully Updated');
	}

	public function deleteUpazila(Request $request,$id){
		$exist_data =   Union::where('upazila_id', $id)->count();
		// dd($exist_data);
        if ($exist_data > 0) {
            return response()->json('notdeleted');
        } else {
            Upazila::where('id', $id)->delete();
            return response()->json('deleted');
        }
	}

	//Union
	public function viewUnion(){
		$data['allData'] = Union::all();
		$data['divisions'] = Division::all();
		return view('backend.admin.setup.union-view',$data);
	}

	public function addUnion(){
		$divisions = Division::all();
		return view('backend.admin.setup.union-add',compact('divisions'));
	}

	public function storeUnion(Request $request){
		$union = new Union();
		$union->division_id = $request->division_id;
		$union->district_id = $request->district_id;
		$union->upazila_id = $request->upazila_id;
		$union->name = $request->name;
		$union->created_by = Auth::id();
		$union->save();
		return redirect()->route('setup.union.view')->with('success','Successfully Inserted');
	}

	public function editUnion($id){
		$editData = Union::find($id);
		$divisions = Division::all();
		return view('backend.admin.setup.union-add',compact('divisions','editData'));
	}

	public function updateUnion(Request $request,$id){
		$union = Union::find($id);
		$union->division_id = $request->division_id;
		$union->district_id = $request->district_id;
		$union->upazila_id = $request->upazila_id;
		$union->name = $request->name;
		$union->modified_by = Auth::id();
		$union->save();
		return redirect()->route('setup.union.view')->with('success','Successfully Updated');
	}

	// public function deleteDistrict(Request $request,$id)
	// {
	// 	$data = SurvivorIncidentInformation::where('employee_district_id', $id)->get()->toArray();
	// 	if (count($data) > 0) {
	// 		return response()->json('error');
	// 	} else {
	// 		District::find($id)->delete();
	// 		return response()->json('deleted');
	// 	}

	// }

	public function deleteUnion(Request $request,$id){
		// dd($id);
		// Union::find($id)->delete();
		// return redirect()->route('setup.union.view')->with('success','Successfully Deleted');

		$data = SelpIncidentModel::where('survivor_union_id', $id)->get();
		// dd($data);
		if (count($data) > 0) {
			return redirect()->route('setup.union.view')->with('error','There are some entries found under this Union');
		} else {
			Union::find($id)->delete();
			return redirect()->route('setup.union.view')->with('success','Successfully Deleted');
		}
	}

	public function getUnion(Request $request)
	{

        $auth_user      = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        
        $unions = Union::select('id', 'division_id', 'district_id', 'upazila_id', 'name');
		// dd();
		if($request->division_id) {
			$unions->where('division_id', $request->division_id);
		}
		if($request->district_id) {
			$unions->where('district_id', $request->district_id);
		}
		if($request->upazila_id) {
			$unions->where('upazila_id', $request->upazila_id);
		}
        
        $unions->orderBy('id', 'ASC');


        return DataTables::of($unions)
        ->addIndexColumn()
		->addColumn('division', function($unions){
            return @$unions['division']['name'] ." - ". @$unions['division_id'];
        })
		->addColumn('district', function($unions){
            return @$unions['district']['name'] ." - ".  @$unions['district_id'];
        })
		->addColumn('upazila', function($unions){
            return @$unions['upazila']['name'] ." - ". @$unions['upazila_id'];
        })
		->addColumn('name', function($unions){
            return @$unions['name']." - ". @$unions['id'];
        })
        ->addColumn('action_column', function(Union $union){
            $links = '<a href="'.route('setup.union.edit', $union->id).'" class="btn btn-sm btn-info" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
					<a href="'.route('setup.union.delete', $union->id).'" target="__blank" class="btn btn-sm btn-danger" title="View"><i class="fa fa-trash" aria-hidden="true"></i></a>';
            return $links;
        })
        ->addIndexColumn()
        ->escapeColumns([])
        ->make(true);

    }

	//Village
	public function viewVillage(){
		$allData = Village::with('division', 'district', 'upazila', 'union')->where('status', 1)->get();
		return view('backend.admin.setup.village-view',compact('allData'));
	}

	public function addVillage(){
		$divisions = Division::all();
		return view('backend.admin.setup.village-add',compact('divisions'));
	}
	public function importVillage(){
		ini_set('memory_limit', -1);
		$data = Excel::import(new VIllageDataImport,request()->file('village'));
    	return back();
	}

	public function storeVillage(Request $request){
		$village = new Village();
		$village->division_id = $request->division_id;
		$village->district_id = $request->district_id;
		$village->upazila_id = $request->upazila_id;
		$village->union_id = $request->union_id;
		$village->name = $request->name;
		$village->created_by = Auth::id();
		$village->save();
		return redirect()->route('setup.village.view')->with('success','Successfully Inserted');
	}

	public function editVillage($id){
		$editData = Village::find($id);
		$divisions = Division::all();
		return view('backend.admin.setup.village-add',compact('editData','divisions'));
	}

	public function updateVillage(Request $request,$id){
		$village = Village::find($id);
		$village->division_id = $request->division_id;
		$village->district_id = $request->district_id;
		$village->upazila_id = $request->upazila_id;
		$village->union_id = $request->union_id;
		$village->name = $request->name;
		$village->modified_by = Auth::id();
		$village->save();
		return redirect()->route('setup.village.view')->with('success','Successfully Updated');
	}

	public function deleteVillage(Request $request,$id){

		$exist_data =   PollisomajSetup::where('village_id', $id)->count();
		// dd($exist_data);
        if ($exist_data > 0) {
            return response()->json('notdeleted');
        } else {
            Village::where('id', $id)->delete();
            return response()->json('deleted');
        }
	}

	//City Corporation
	public function viewCityCorporation(){
		$allData = CityCorporation::all();
		return view('backend.admin.setup.city-corporation-view',compact('allData'));
	}

	public function addCityCorporation(){
		$divisions = Division::all();
		return view('backend.admin.setup.city-corporation-add',compact('divisions'));
	}

	public function storeCityCorporation(Request $request){
		$corporation = new CityCorporation();
		$corporation->division_id = $request->division_id;
		$corporation->name = $request->name;
		$corporation->created_by = Auth::id();
		$corporation->save();
		return redirect()->route('setup.city-corporation.view')->with('success','Successfully Inserted');
	}

	public function editCityCorporation($id){
		$editData = CityCorporation::find($id);
		$divisions=Division::all();
		return view('backend.admin.setup.city-corporation-add',compact('editData','divisions'));
	}

	public function updateCityCorporation(Request $request,$id){
		$corporation = CityCorporation::find($id);
		$corporation->division_id = $request->division_id;
		$corporation->name = $request->name;
		$corporation->modified_by = Auth::id();
		$corporation->save();
		return redirect()->route('setup.city-corporation.view')->with('success','Successfully Updated');
	}

	//Pourosova
	public function viewPourosova(){
		$allData = Pourosova::all();
		return view('backend.admin.setup.pourosova-view',compact('allData'));
	}

	public function addPourosova(){
		$divisions = Division::all();
		return view('backend.admin.setup.pourosova-add',compact('divisions'));
	}

	public function storePourosova(Request $request){
		$pourosova = new Pourosova();
		$pourosova->division_id = $request->division_id;
		$pourosova->district_id = $request->district_id;
		$pourosova->name = $request->name;
		$pourosova->created_by = Auth::id();
		$pourosova->save();
		return redirect()->route('setup.pourosova.view')->with('success','Successfully Inserted');
	}

	public function editPourosova($id){
		$editData = Pourosova::find($id);
		$divisions=Division::all();
		return view('backend.admin.setup.pourosova-add',compact('editData','divisions'));
	}

	public function updatePourosova(Request $request,$id){
		$pourosova = Pourosova::find($id);
		$pourosova->division_id = $request->division_id;
		$pourosova->district_id = $request->district_id;
		$pourosova->name = $request->name;
		$pourosova->modified_by = Auth::id();
		$pourosova->save();
		return redirect()->route('setup.pourosova.view')->with('success','Successfully Updated');
	}
}
