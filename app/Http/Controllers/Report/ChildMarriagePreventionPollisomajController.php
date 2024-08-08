<?php

namespace App\Http\Controllers\Report;

use App\Exports\MisReportExport;
use App\Http\Controllers\Controller;
use App\Model\Admin\Setup\CEP_Region\Region;
use App\Model\Admin\Setup\Division;
use App\Model\Admin\Setup\District;
use App\Model\Admin\Setup\Upazila;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

use App\Model\PollisomajDataModel;
use App\Model\PollisomajSetup;

class ChildMarriagePreventionPollisomajController extends Controller
{
    public function pollisomajChildMarriagePrevention(Request $request){
        ini_set('memory_limit', -1);
        //dd($request->all());
        $from_date = date('Y-m-d', strtotime($request->from_date));
        $to_date = date('Y-m-d', strtotime($request->to_date));
        $where[] = ['pollisomaj_data.flag',2];
        $wherein = [];
        $setup_area = [];
        $label_name=null;
        $reportTypeTarget=null;
        $groupBy=null;

        if($request->upazila_id == "all_upazila" || $request->upazila_id > 0)
        {
            $reportTypeTarget="employee_upazila_id";
            $groupBy='upazila_id';
            $label_name='Upazila Name';
            if($request->upazila_id > 0)
            {
                // $setup_area = SetupUserArea::where('upazila_id', $request->upazila_id)->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
                $setup_area = PollisomajSetup::withTrashed()->where('upazila_id', $request->upazila_id)->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
            }

        }
        if($request->district_id=="all_district" || $request->district_id > 0)
        {
            
            if($reportTypeTarget==null){
                $reportTypeTarget="employee_district_id";
            }

            if($label_name==null){
                $label_name="District name";
            }

            if($groupBy==null){
                $groupBy="district_id";
            }
            if($request->district_id > 0 && count($setup_area) == 0)
            {   $setup_area = PollisomajSetup::withTrashed()->where('upazila_id', $request->upazila_id)->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
                // $setup_area = SetupUserArea::where('district_id', $request->district_id)->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
            }
        }

        if($request->division_id > 0  && count($setup_area) == 0)
        {
            if($reportTypeTarget==null){
                $reportTypeTarget="employee_district_id";
            }
            if($groupBy==null){
                $groupBy="district_id";
            }

            if($label_name==null){
                $label_name="District name";
            }
            $setup_area = PollisomajSetup::withTrashed()->where('district_id', $request->district_id)->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
            // $setup_area = SetupUserArea::where('division_id', $request->division_id)->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
            
        }
        
        if($request->region_id=="all_zone" || $request->region_id > 0)
        {
            if($reportTypeTarget==null){
                $reportTypeTarget="employee_district_id";
            }
            
            if($groupBy==null){
                $groupBy="district_id";
            }

            if($label_name==null){
                $label_name="District name";
            }
            if($request->region_id > 0 && count($setup_area) == 0)
            {
                $setup_area = PollisomajSetup::withTrashed()->where('zone_id', $request->region_id)->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
                //$setup_area = SetupUserArea::where('region_id', $request->region_id)->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();                  
            }

        }

        if(count($setup_area)==0){
            $setup_area=PollisomajSetup::withTrashed()->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
            //$setup_area = SetupUserArea::groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
        }
            
        //dd($setup_area);
        if($groupBy == "district_id"){
            $areas      = District::select('id','name')->whereIn('id', $setup_area)->orderBy('id', "ASC")->get();
            $area_id    = District::select('id','name')->whereIn('id', $setup_area)->orderBy('id', "ASC")->pluck('id')->toArray();
        }

        if($groupBy == "upazila_id"){
            $areas      = Upazila::select('id','name')->whereIn('id', $setup_area)->orderBy('id', "ASC")->get();
            $area_id    = Upazila::select('id','name')->whereIn('id', $setup_area)->orderBy('id', "ASC")->pluck('id')->toArray();
        }

        //dd($area_id);

        if($groupBy == "upazila_id"){
            //dd($area_id);
            $child_marriage_prevention_number    = PollisomajDataModel::join('upazilas','upazilas.id','=','pollisomaj_data.upazilla_id')
                                                            ->select(
                                                                'upazilas.name',
                                                                'pollisomaj_data.upazilla_id',DB::raw('SUM(pollisomaj_data.number_of_child_marriage) as child_marriage_prevention'))
                                                        ->where($where)
                                                        // ->whereNotNull('pollisomaj_data.number_of_child_marriage')
                                                        ->whereIn('pollisomaj_data.upazilla_id',$area_id)
                                                        ->whereBetween('pollisomaj_data.reporting_date', [$from_date,$to_date])
                                                        ->groupBy('pollisomaj_data.upazilla_id')
                                                        ->get();
        }

        if($groupBy == "district_id"){
            //dd($area_id);
            $child_marriage_prevention_number    = PollisomajDataModel::join('districts','districts.id','=','pollisomaj_data.district_id')->select(
                'districts.name',
                'pollisomaj_data.district_id',DB::raw('SUM(pollisomaj_data.number_of_child_marriage) as child_marriage_prevention'))
                ->where($where)
                // ->whereNotNull('pollisomaj_data.number_of_child_marriage')
                ->whereIn('pollisomaj_data.district_id',$area_id)
                ->whereBetween('pollisomaj_data.reporting_date', [$from_date,$to_date])
                ->groupBy('pollisomaj_data.district_id')
                ->get();
        }
        

        // if ($wherein != null) {

        //     if(!empty($request->upazila_id)){
        //         if ($request->upazila_id == "all_upazila") {
        //             //dd($wherein);
        //             $child_marriage_prevention_number    = PollisomajDataModel::
        //                                                     join('upazilas','upazilas.id','=','pollisomaj_data.upazilla_id')->select(
        //                                                         'upazilas.name',
        //                                                         'pollisomaj_data.upazilla_id',DB::raw('SUM(pollisomaj_data.number_of_child_marriage) as child_marriage_prevention'))
        //                                                 ->where($where)
        //                                                 ->whereNotNull('pollisomaj_data.number_of_child_marriage')
        //                                                 ->whereIn('pollisomaj_data.upazilla_id',$wherein)
        //                                                 ->whereBetween('pollisomaj_data.reporting_date', [$from_date,$to_date])
        //                                                 ->groupBy('pollisomaj_data.upazilla_id')
        //                                                 ->get();
        //         //dd($child_marriage_prevention_number);
        //         } else {
                    
        //             $child_marriage_prevention_number    = PollisomajDataModel::
        //                                                     join('upazilas','upazilas.id','=','pollisomaj_data.upazilla_id')->select(
        //                                                         'upazilas.name',
        //                                                         'pollisomaj_data.upazilla_id',DB::raw('SUM(pollisomaj_data.number_of_child_marriage) as child_marriage_prevention'))
        //                                                     ->where($where)
        //                                                     ->whereNotNull('pollisomaj_data.number_of_child_marriage')
        //                                                     ->where('pollisomaj_data.upazilla_id',$request->upazila_id)
        //                                                     ->groupBy('pollisomaj_data.upazilla_id')
        //                                                     ->whereBetween('pollisomaj_data.reporting_date', [$from_date,$to_date])
        //                                                     ->get();
        //         }
                
        //     } else {
        //         //dd($request->all());
        //         $child_marriage_prevention_number    = PollisomajDataModel::join('districts','districts.id','=','pollisomaj_data.district_id')->select(
        //                                                 'districts.name',
        //                                                 'pollisomaj_data.district_id',DB::raw('SUM(pollisomaj_data.number_of_child_marriage) as child_marriage_prevention'))
        //                                                 ->where($where)
        //                                                 ->whereNotNull('pollisomaj_data.number_of_child_marriage')
        //                                                 ->whereIn('pollisomaj_data.district_id',$wherein)
        //                                                 ->whereBetween('pollisomaj_data.reporting_date', [$from_date,$to_date])
        //                                                 ->groupBy('pollisomaj_data.district_id')
        //                                                 ->get();
        //     }

        // } else {
        //     //dd($request->district_id);
        //     $child_marriage_prevention_number     = PollisomajDataModel::join('districts','districts.id','=','pollisomaj_data.district_id')->select(
        //                                             'districts.name',
        //                                             'pollisomaj_data.district_id',DB::raw('SUM(pollisomaj_data.number_of_child_marriage) as child_marriage_prevention'))
        //                                             ->where($where)
        //                                             ->whereNotNull('pollisomaj_data.number_of_child_marriage')
        //                                             ->where('pollisomaj_data.district_id',$request->district_id)
        //                                             ->groupBy('pollisomaj_data.district_id')
        //                                             ->whereBetween('pollisomaj_data.reporting_date', [$from_date,$to_date])
        //                                             ->get();
        // }


        //dd($child_marriage_prevention_number);
        $data['label_name']=$label_name;
        $data['date']=now();
        $data['child_marriage_prevention_number']=$child_marriage_prevention_number;
        $data['region']    = ($request->region_id != "all_zone") ?  Region::where('id', $request->region_id)->pluck('region_name')->first() : "All";
        $data['division']  = ($request->division_id != null) ?  Division::where('id', $request->division_id)->pluck('name')->first() : "";
        $data['district']  = ($request->district_id != "all_district") ?  District::where('id', $request->district_id)->pluck('name')->first() : "All";
        $data['upazila']   = ($request->upazila_id != "all_upazila") ?  Upazila::where('id', $request->upazila_id)->pluck('name')->first() : "All";
        $data['date']      = date('d-M-Y');
        $data['from_date'] = date('d-M-Y', strtotime($request->from_date));
        $data['to_date']   = date('d-M-Y', strtotime($request->to_date));


        if ($request->format_download == 1) {
            $pdf = PDF::loadView('selp.pdf.pollisomaj.child_marriage_prevent', $data,[],['title' => 'Certificate','format' => 'A4-L','orientation' => 'L']);
            $pdf->SetProtection(['copy', 'print'], '', 'pass');
            return $pdf->stream('document.pdf');
        }else{
            $view_link = 'selp.excel.pollisomaj.child_marriage_prevent';
            return Excel::download(new MisReportExport($data,$view_link), 'child_marriage_reported.xlsx');
        }
        
    }
}
