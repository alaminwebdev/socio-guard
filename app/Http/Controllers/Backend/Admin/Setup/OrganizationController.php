<?php

namespace App\Http\Controllers\Backend\Admin\Setup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ReportHeader;
use App\Model\Admin\Setup\SurvivorSupportOrganization;
use App\Model\Admin\Setup\OrganizationName;
use Session;
use App\User;
use Illuminate\Support\Facades\DB;
use Auth;
use PDF;

class OrganizationController extends Controller
{
    public function view(){
        
    	$allData = OrganizationName::where('status','1')->get();
    	return view('backend.admin.setup.organization-view', compact('allData'));
    }

    public function add(){
        $organization_types = SurvivorSupportOrganization::where('status','1')->get();
    	return view('backend.admin.setup.organization-add', compact('organization_types'));
    }

    public function store(Request $request){
    	$data = new OrganizationName();
        $data->support_organization_id = $request->support_organization_id;
        $data->name = $request->name;
        $data->created_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.organization.view')->with('success','Successfully Inserted');
    }

    public function edit($id){
    	$editData = OrganizationName::find($id);
        $organization_types = SurvivorSupportOrganization::where('status','1')->get();
        return view('backend.admin.setup.organization-add', compact('editData','organization_types'));
    }

    public function update(Request $request, $id){
    	$data = OrganizationName::find($id);
        $data->support_organization_id = $request->support_organization_id;
        $data->name = $request->name;
        $data->save();
        return redirect()->route('setup.organization.view')->with('success','Successfully Updated');
    }

    public function delete($id)
    {
        OrganizationName::where('id', $id)->delete();
        return response()->json('deleted');
    }
}
