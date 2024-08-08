<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Setup\Division;
use App\Model\Admin\Setup\District;
use App\Model\Admin\Setup\Upazila;
use App\Model\Admin\Setup\Union;
use App\Model\Admin\Setup\Village;
use App\Model\Admin\Setup\Religion;
use App\Model\Admin\Setup\Gender;
use App\Model\Admin\Setup\Occupation;
use App\Model\Admin\Setup\SurvivorRelationship;
use App\Model\Admin\Setup\MaritalStatus;
use App\Model\Admin\Setup\SurvivorSupportOrganization;
use App\Model\Admin\Setup\SurvivorSupportName;
use App\Model\Admin\Setup\SuprvivorInitialSupport;
use App\Model\Admin\Setup\SurvivorSituation;
use App\Model\Admin\Setup\SurvivorIncidentPlace;
use App\Model\Admin\Setup\SurvivorViolencePlace;
use App\Model\Admin\Setup\ViolenceCategory;
use App\Model\Admin\Setup\ViolenceSubCategory;
use App\Model\Admin\Setup\ViolenceName;
use App\Model\Admin\Setup\OrganizationType;
use App\Model\Admin\Setup\OrganizationName;
use App\Model\Admin\Setup\InformationProviderSource;
use App\Model\Admin\Incident\SurvivorBracSupport;
use App\Model\Admin\Incident\SurvivorOtherOrganizationSupport;
use App\Model\Admin\Setup\OtherOrganizationSupport;
use App\Model\Admin\Setup\ViolenceReason;
use App\Model\Admin\Setup\SocialStatus;
use App\Model\Admin\Setup\EconomicCondition;
use App\Model\Admin\Incident\SurvivorIncidentInformation;
use App\Model\Admin\Incident\PerpetratorInformation;
use App\Model\Admin\Setup\SurvivorAutisticInformation;
use App\Model\Admin\Setup\FamilyMember;
use App\Model\Admin\Setup\SurvivorFinalSupport;
use App\Model\Admin\Setup\Program;
use Session;
use App\User;
use Illuminate\Support\Facades\DB;
use Auth;
use PDF;
use DataTables;
use App\Model\Admin\Setup\CEP_Region\Region;
use App\Model\Admin\Setup\CEP_Region\RegionAreaDetail;

class TestCodeController extends Controller
{
    public function misReport()
    {
        $violence_categories = ViolenceCategory::where('status','1')->get();
        return view('backend.report.mis_report_view',compact('violence_categories'));
    }

    public function misReportPdf(Request $request)
    {
        $from_year_start = '';
        $end_date = '';
        $from_year = '';
        $to_year = '';
        $month = '';

        if (isset($request->from_year) && isset($request->to_year)) {
            $month = $request->month;
            $from_year = $request->from_year;
            $to_year = $request->to_year;

            $from_year_start = $from_year.'-01-01';
            $end_date = $to_year.'-12-31';

            $from_month_start = $from_year.'-'.$month.'-01';
            $to_month_start = $to_year.'-'.$month.'-01';


            $from_month_end = $from_year.'-'.$month.'-'.get_days_in_month($month, $from_year);
            $to_month_end = $to_year.'-'.$month.'-'.get_days_in_month($month, $to_year);

            $to_year_start = $to_year.'-01-01';

            $from_year_end = $from_year.'-'.$month.'-'.get_days_in_month($month, $from_year);
            $to_year_end = $to_year.'-'.$month.'-'.get_days_in_month($month, $from_year);
        }

        ;
        $current_year = date("Y");
        $current_year_start = $current_year.'-01-01';
        $current_year_date = date("Y-m-d");

        // From Year - To Year
        if ($request->violence_sub_category_all != 1 && $request->violence_sub_category_id == null) {
            if ($request->violence_category_all == 1) {
                $data = ViolenceCategory::with(['survivor_incident_information' => function($query) use($from_year_start, $end_date, $current_year_start, $current_year_date) {
                    $query->with(['survivor_gender']);

                }]);

            } else {
                $data = ViolenceCategory::where('id', $request->violence_category_id)->with(['survivor_incident_information' => function($query) use($from_year_start, $end_date, $current_year_start, $current_year_date) {
                    $query->with(['survivor_gender']);
                }]);
            }
        } elseif ($request->violence_name_all != 1 && $request->violence_name_id == null){
            if ($request->violence_sub_category_all == 1) {
                $data = ViolenceSubCategory::where('violence_category_id', $request->violence_category_id)
                        ->with(['survivor_incident_information' => function($query) use($from_year_start, $end_date, $current_year_start, $current_year_date) {
                            $query->with(['survivor_gender']);
                        }]);
            } else {
                $data = ViolenceSubCategory::where('violence_category_id', $request->violence_category_id)->whereIn('id', $request->violence_sub_category_id)
                        ->with(['survivor_incident_information' => function($query) use($from_year_start, $end_date, $current_year_start, $current_year_date) {
                            $query->with(['survivor_gender']);
                        }]);
            }
        } else {
            if ($request->violence_name_all == 1) {
                $data = ViolenceName::where('violence_category_id', $request->violence_category_id)
                        ->with(['survivor_incident_information' => function($query) use($from_year_start, $end_date, $current_year_start, $current_year_date) {
                            $query->with(['survivor_gender']);
                        }]);
            } else {
                $data = ViolenceName::where('violence_category_id', $request->violence_category_id)->whereIn('id', $request->violence_name_id)
                        ->with(['survivor_incident_information' => function($query) use($from_year_start, $end_date, $current_year_start, $current_year_date) {
                            $query->with(['survivor_gender']);
                        }]);
            }
        }

        $incidents = $data->get();

        // dd($incidents->toArray());


        $survivor_info = [];

        foreach($incidents as $key => $incident){
            $survivor_info[$key]['rows'] = count($incidents);
            $survivor_info[$key]['type'] = $incident->name;
            if(!empty($incident['survivor_incident_information']) && count($incident['survivor_incident_information'])>0){
                /*From - To Year Survivor Incident Information*/
                $year_between = SurvivorIncidentInformation::whereIn('id',$incident['survivor_incident_information']->pluck('id'))
                ->whereBetween('created_at', [$from_year_start, $end_date])->get();

                if(!empty($year_between) && count($year_between) > 0){
                    $survivor_info[$key]['year_between']['male'] = 0;
                    $survivor_info[$key]['year_between']['female'] = 0;
                    foreach($year_between as $yb){
                        if($yb->survivor_gender->name == 'Male'){
                            $survivor_info[$key]['year_between']['male'] +=1 ;

                        }

                        if($yb->survivor_gender->name == 'Female'){
                            $survivor_info[$key]['year_between']['female'] +=1 ;

                        }
                    }
                    $survivor_info[$key]['year_between']['total'] = $survivor_info[$key]['year_between']['male'] + $survivor_info[$key]['year_between']['female'];
                }else{
                    $survivor_info[$key]['year_between']['male'] = 0;
                    $survivor_info[$key]['year_between']['female'] = 0;
                    $survivor_info[$key]['year_between']['total'] = 0;
                }

                /*Current Month Survivor Incident Information*/
                $current_month = SurvivorIncidentInformation::whereIn('id',$incident['survivor_incident_information']->pluck('id'))
                ->whereMonth('created_at', $month)->get();

                if(!empty($current_month) && count($current_month) > 0){
                    $survivor_info[$key]['current_month']['male'] = 0;
                    $survivor_info[$key]['current_month']['female'] = 0;
                    foreach($current_month as $yb){
                        if($yb->survivor_gender->name == 'Male'){
                            $survivor_info[$key]['current_month']['male'] +=1 ;

                        }

                        if($yb->survivor_gender->name == 'Female'){
                            $survivor_info[$key]['current_month']['female'] +=1 ;

                        }
                    }
                    $survivor_info[$key]['current_month']['total'] = $survivor_info[$key]['current_month']['male'] + $survivor_info[$key]['current_month']['female'];
                }else{
                    $survivor_info[$key]['current_month']['male'] = 0;
                    $survivor_info[$key]['current_month']['female'] = 0;
                    $survivor_info[$key]['current_month']['total'] = 0;
                }

                /*For Year Survivor Incident Information*/
                $for_year = SurvivorIncidentInformation::whereIn('id',$incident['survivor_incident_information']->pluck('id'))
                ->whereBetween('created_at', [$current_year_start,$current_year_date])->get();

                if(!empty($for_year) && count($for_year) > 0){
                    $survivor_info[$key]['for_year']['male'] = 0;
                    $survivor_info[$key]['for_year']['female'] = 0;
                    foreach($for_year as $yb){
                        if($yb->survivor_gender->name == 'Male'){
                            $survivor_info[$key]['for_year']['male'] +=1 ;

                        }

                        if($yb->survivor_gender->name == 'Female'){
                            $survivor_info[$key]['for_year']['female'] +=1 ;

                        }
                    }
                    $survivor_info[$key]['for_year']['total'] = $survivor_info[$key]['for_year']['male'] + $survivor_info[$key]['for_year']['female'];
                }else{
                    $survivor_info[$key]['for_year']['male'] = 0;
                    $survivor_info[$key]['for_year']['female'] = 0;
                    $survivor_info[$key]['for_year']['total'] = 0;
                }

                /*Year_to_present_month Survivor Incident Information*/
                $year_to_present_month = SurvivorIncidentInformation::whereIn('id',$incident['survivor_incident_information']->pluck('id'))
                ->whereBetween('created_at', [$from_year_start,$current_year_date])->get();

                if(!empty($year_to_present_month) && count($year_to_present_month) > 0){
                    $survivor_info[$key]['year_to_present_month']['male'] = 0;
                    $survivor_info[$key]['year_to_present_month']['female'] = 0;
                    foreach($year_to_present_month as $yb){
                        if($yb->survivor_gender->name == 'Male'){
                            $survivor_info[$key]['year_to_present_month']['male'] +=1 ;

                        }

                        if($yb->survivor_gender->name == 'Female'){
                            $survivor_info[$key]['year_to_present_month']['female'] +=1 ;

                        }
                    }
                    $survivor_info[$key]['year_to_present_month']['total'] = $survivor_info[$key]['year_to_present_month']['male'] + $survivor_info[$key]['year_to_present_month']['female'];
                }else{
                    $survivor_info[$key]['year_to_present_month']['male'] = 0;
                    $survivor_info[$key]['year_to_present_month']['female'] = 0;
                    $survivor_info[$key]['year_to_present_month']['total'] = 0;
                }


            }else{
                $survivor_info[$key]['year_between']['male'] = 0;
                $survivor_info[$key]['year_between']['female'] = 0;
                $survivor_info[$key]['year_between']['total'] = 0;

                $survivor_info[$key]['current_month']['male'] = 0;
                $survivor_info[$key]['current_month']['female'] = 0;
                $survivor_info[$key]['current_month']['total'] = 0;

                $survivor_info[$key]['for_year']['male'] = 0;
                $survivor_info[$key]['for_year']['female'] = 0;
                $survivor_info[$key]['for_year']['total'] = 0;

                $survivor_info[$key]['year_to_present_month']['male'] = 0;
                $survivor_info[$key]['year_to_present_month']['female'] = 0;
                $survivor_info[$key]['year_to_present_month']['total'] = 0;
            }
        }

        $pdata['survivor_info'] = $survivor_info;
        // dd($survivor_info);
        $pdata['from_year'] = $from_year;
        $pdata['to_year'] = $to_year;
        $pdata['month'] = date('F', mktime(0,0,0,$month,1));

        // return view('backend.report.mis_html_view', $pdata);


        $pdf = PDF::loadView('backend.report.pdf.mis_report', $pdata);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
    }


    /*Support Report*/

    public function supportReport()
    {
        $violence_categories = ViolenceCategory::where('status','1')->get();
        $survivor_final_support = SurvivorFinalSupport::where('survivor_support_organization_id', 1)->where('status','1')->get();
        return view('backend.report.support_report_view',compact('violence_categories', 'survivor_final_support'));
    }

    public function supportReportPdf(Request $request)
    {
        $from_year_start = '';
        $end_date = '';
        $from_year = '';
        $to_year = '';
        $month = '';

        if (isset($request->from_year) && isset($request->to_year)) {
            $month = $request->month;
            $from_year = $request->from_year;
            $to_year = $request->to_year;

            $from_year_start = $from_year.'-01-01';
            $end_date = $to_year.'-12-31';

            $from_month_start = $from_year.'-'.$month.'-01';
            $to_month_start = $to_year.'-'.$month.'-01';


            $from_month_end = $from_year.'-'.$month.'-'.get_days_in_month($month, $from_year);
            $to_month_end = $to_year.'-'.$month.'-'.get_days_in_month($month, $to_year);

            $to_year_start = $to_year.'-01-01';

            $from_year_end = $from_year.'-'.$month.'-'.get_days_in_month($month, $from_year);
            $to_year_end = $to_year.'-'.$month.'-'.get_days_in_month($month, $from_year);
        }

        ;
        $current_year = date("Y");
        $current_year_start = $current_year.'-01-01';
        $current_year_date = date("Y-m-d");

        $support_id = $request->brac_support_id;


        // $support = SurvivorFinalSupport::where('survivor_support_organization_id', 1)->with(['survivor_brac_support' => function($query){
        //     $query->with(['survivor_incident_information' => function ($q) {
        //         $q->with(['violencecategoryname']);
        //     }]);
        // }])->get();
        // dd($support->toArray());
        // return view('backend.report.pdf.support_report');


        // From Year - To Year
        if ($request->violence_sub_category_all != 1 && $request->violence_sub_category_id == null) {
            if ($request->violence_category_all == 1) {
                $data = ViolenceCategory::with(['survivor_incident_information' => function($query) use($from_year_start, $end_date, $current_year_start, $current_year_date, $support_id) {
                    $query->whereHas('survivor_brac_support', function($q) use($support_id){
                        $q->where('survivor_final_support_id', $support_id);
                    });
                    $query->with(['survivor_brac_support' => function($qw) use($support_id){
                        $qw->where('survivor_final_support_id', $support_id);
                    }]);
                    $query->with(['survivor_gender']);
                }]);

            } else {
                $data = ViolenceCategory::where('id', $request->violence_category_id)->with(['survivor_incident_information' => function($query) use($from_year_start, $end_date, $current_year_start, $current_year_date) {
                    $query->with(['survivor_gender', 'survivor_brac_support' => function($q){
                        $q->with(['brac_final_support']);
                    }]);
                }]);
            }
        } elseif ($request->violence_name_all != 1 && $request->violence_name_id == null){
            if ($request->violence_sub_category_all == 1) {
                $data = ViolenceSubCategory::where('violence_category_id', $request->violence_category_id)
                        ->with(['survivor_incident_information' => function($query) use($from_year_start, $end_date, $current_year_start, $current_year_date) {
                            $query->with(['survivor_gender']);
                        }]);
            } else {
                $data = ViolenceSubCategory::where('violence_category_id', $request->violence_category_id)->whereIn('id', $request->violence_sub_category_id)
                        ->with(['survivor_incident_information' => function($query) use($from_year_start, $end_date, $current_year_start, $current_year_date) {
                            $query->with(['survivor_gender']);
                        }]);
            }
        } else {
            if ($request->violence_name_all == 1) {
                $data = ViolenceName::where('violence_category_id', $request->violence_category_id)
                        ->with(['survivor_incident_information' => function($query) use($from_year_start, $end_date, $current_year_start, $current_year_date) {
                            $query->with(['survivor_gender']);
                        }]);
            } else {
                $data = ViolenceName::where('violence_category_id', $request->violence_category_id)->whereIn('id', $request->violence_name_id)
                        ->with(['survivor_incident_information' => function($query) use($from_year_start, $end_date, $current_year_start, $current_year_date) {
                            $query->with(['survivor_gender']);
                        }]);
            }
        }

        $incidents = $data->get();
        dd($incidents->toArray());


        // $pdf = PDF::loadView('backend.report.pdf.support_report');
        // $pdf->SetProtection(['copy', 'print'], '', 'pass');
        // return $pdf->stream('document.pdf');
    }

    public function platMethod()
    {
        $data['platform'] = OrganizationName::where('status', 1)->get();
        $data['regions']  = Region::where('status','1')->get();
        // dd($platform->toArray());
        return view('backend.report.platform_report_view', $data);
    }

    public function dashMethod()
    {
            // $auth_user = User::with(['setup_user_area'])->where('id', Auth::id())->first();
            // // dd($auth_user->toArray());
            // $div = [];
            // foreach ($auth_user->setup_user_area as $key => $value) {
            //     if (!empty($value)) {
            //         $div['region_id'][] = $value->region_id;
            //         $div['division_id'][] = $value->division_id;
            //         $div['district_id'][] = $value->district_id;
            //         $div['upazila_id'][] = $value->upazila_id;
            //         $div['union_id'][] = $value->union_id;
            //     }
            // }
            // $survivor_info = SurvivorIncidentInformation::whereIn('survivor_district_id', $div['district_id'])->get();
            // dd($survivor_info->toArray());

        $data['divisions']              = Division::all();
        $data['regions']                = Region::where('status','1')->get();
        $data['violence_categories']    = ViolenceCategory::where('status','1')->get();
        $data['header_left'] = '';
        $data['header_right'] = '';
        $data['report'] = [];
        return view('backend.report.dashboard_report_view', $data);
    }
}
