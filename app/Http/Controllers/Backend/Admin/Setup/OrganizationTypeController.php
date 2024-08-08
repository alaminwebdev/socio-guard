<?php

namespace App\Http\Controllers\Backend\Admin\Setup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ReportHeader;
use App\Model\Admin\Setup\OrganizationType;
use Session;
use App\User;
use Illuminate\Support\Facades\DB;
use Auth;
use PDF;

class OrganizationTypeController extends Controller
{
    public function view(){
    	$allData = OrganizationType::where('status','1')->get();
    	return view('backend.admin.setup.organization-type-view', compact('allData'));
    }

    public function add(){
    	return view('backend.admin.setup.organization-type-add');
    }

    public function store(Request $request){
    	$data = new OrganizationType();
        $data->name = $request->name;
        $data->created_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.organization.type.view')->with('success','Successfully Inserted');
    }

    public function edit($id){
    	$editData = OrganizationType::find($id);
        return view('backend.admin.setup.organization-type-add', compact('editData'));
    }

    public function update(Request $request, $id){
    	$data = OrganizationType::find($id);
        $data->name = $request->name;
        $data->save();
        return redirect()->route('setup.organization.type.view')->with('success','Successfully Updated');
    }
}
