<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Model\Admin\Setup\InformationProviderSource;
use App\Imports\SurvivorImport;
use App\Model\Admin\Incident\SurvivorIncidentInformation;
use App\User;

class DataMigrationController extends Controller
{
    public function view()
    {
    	return view('backend.migration.insert-data');
    }

    public function add(Request $request)
    {
    	$data = Excel::import(new SurvivorImport,request()->file('file'));
    	return back();
    }

    public function staffApi(Request $request)
	{
		// $string = file_get_contents("http://api.brac.net/v1/staffs?Key=c20f2758-9cd2-4a8d-9473-8fb89b9a677e&q=ProgramID=18&amp;fields=PIN,StaffName,DesignationName,EmailID,MobileNo");
		$string = file_get_contents("http://api.brac.net/v1/staffs?Key=c20f2758-9cd2-4a8d-9473-8fb89b9a677e&q=ProgramID=18&fields=PIN,StaffName,DesignationName,EmailID,MobileNo");
        $json = json_decode($string, true);
            // dd($json);
        foreach ($json as $key => $value) {
            $data = User::where('pin',$value['PIN'])->first();
            // dd($data->toArray());
            if(empty($data)){
    			$add_user 					= new User;
    			$add_user->name 			= $value['StaffName'];
    			$add_user->designation 		= $value['DesignationName'];
    			$add_user->email 			= $value['EmailID'];
    			$add_user->mobile 			= $value['MobileNo'];
    			$add_user->pin 				= $value['PIN'];
    			$add_user->save();
            }
		}
	}


	public function platformReportPdf(Request $request)
    {
        $data = SurvivorIncidentInformation::with(['survivor_gender'])->limit(5)->get();
        dd($data->toArray());
    }
}
