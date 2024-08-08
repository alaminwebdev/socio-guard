<?php

namespace App\Http\Controllers\Backend\Admin\Setup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ReportHeader;
use App\Model\Admin\Setup\InformationProviderSource;
use Session;
use App\User;
use Illuminate\Support\Facades\DB;
use Auth;
use PDF;

class InfoProviderSourceController extends Controller
{
    public function view(){
    	$allData = InformationProviderSource::where('status','1')->get();
    	return view('backend.admin.setup.info-provider-view', compact('allData'));
    }

    public function add(){
    	return view('backend.admin.setup.info-provider-add');
    }

    public function store(Request $request){
    	$data = new InformationProviderSource();
        $data->name = $request->name;
        $data->created_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.source.view')->with('success','Successfully Inserted');
    }

    public function edit($id){
    	$editData = InformationProviderSource::find($id);
        return view('backend.admin.setup.info-provider-add', compact('editData'));
    }

    public function update(Request $request, $id){
    	$data = InformationProviderSource::find($id);
        $data->name = $request->name;
        if($data->isDirty('name') == true){
            $data->save();
            return redirect()->route('setup.source.view')->with('success','Successfully Updated');
        }else{
            return redirect()->back()->with('warning','You have made no changes to update');
        }
    }

    public function delete($id)
    {
        InformationProviderSource::where('id', $id)->delete();
        return response()->json('deleted');
    }
}
