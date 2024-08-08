<?php

namespace App\Http\Controllers\Backend;

use App\Exports\MisReportExport;
use App\Http\Controllers\Controller;
use App\Model\Admin\Incident\PerpetratorInformation;
use App\Model\Admin\Incident\SurvivorBracSupport;
use App\Model\Admin\Incident\SurvivorIncidentInformation;
use App\Model\Admin\Incident\SurvivorOtherOrganizationSupport;
use App\Model\Admin\Setup\CEP_Region\Region;
use App\Model\Admin\Setup\CEP_Region\RegionAreaDetail;
use App\Model\Admin\Setup\District;
use App\Model\Admin\Setup\Division;
use App\Model\Admin\Setup\EconomicCondition;
use App\Model\Admin\Setup\FamilyMember;
use App\Model\Admin\Setup\Gender;
use App\Model\Admin\Setup\InformationProviderSource;
use App\Model\Admin\Setup\LegelInitiativeReason;
use App\Model\Admin\Setup\MaritalStatus;
use App\Model\Admin\Setup\Occupation;
use App\Model\Admin\Setup\OrganizationName;
use App\Model\Admin\Setup\OrganizationType;
use App\Model\Admin\Setup\OtherOrganizationSupport;
use App\Model\Admin\Setup\PerpetratorPlace;
use App\Model\Admin\Setup\Program;
use App\Model\Admin\Setup\Religion;
use App\Model\Admin\Setup\SocialStatus;
use App\Model\Admin\Setup\SuprvivorInitialSupport;
use App\Model\Admin\Setup\SurvivorAutisticInformation;
use App\Model\Admin\Setup\SurvivorFinalSupport;
use App\Model\Admin\Setup\SurvivorIncidentPlace;
use App\Model\Admin\Setup\SurvivorRelationship;
use App\Model\Admin\Setup\SurvivorSituation;
use App\Model\Admin\Setup\SurvivorSupportName;
use App\Model\Admin\Setup\SurvivorSupportOrganization;
use App\Model\Admin\Setup\SurvivorViolencePlace;
use App\Model\Admin\Setup\Union;
use App\Model\Admin\Setup\Upazila;
use App\Model\Admin\Setup\Village;
use App\Model\Admin\Setup\ViolenceCategory;
use App\Model\Admin\Setup\ViolenceName;
use App\Model\Admin\Setup\ViolenceReason;
use App\Model\Admin\Setup\ViolenceSubCategory;
use App\User;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Session;

class SupportReportController extends Controller
{
    public function supportReport()
    {
        $data['violence_categories'] = ViolenceCategory::where('status','1')->get();
        $data['regions']  = Region::where('status','1')->get();
        $data['organization_types'] = SurvivorSupportOrganization::where('status','1')->get();
        $data['survivor_final_support'] = SurvivorFinalSupport::where('status','1')->orderBy('survivor_support_organization_id', 'asc')->get();
        return view('backend.report.support_report_view', $data);
    }

    public function supportReportPdf(Request $request)
    {

        ini_set('memory_limit', -1);
        // dd($request->all());
        $from_date = date('Y-m-d', strtotime($request->from_date));
        $to_date = date('Y-m-d', strtotime($request->to_date));
        $where[] = ['status','=','1'];
        $wherein = [];

        $support_id = $request->brac_support_id;

        $params = [
        'from_date' => $from_date,
        'to_date' =>$to_date,
        'support_id' =>$support_id
        ];
        // From Year - To Year
        if ($request->violence_sub_category_all != 1 && $request->violence_sub_category_id == null) {
            // For Violence Category All
            if ($request->violence_category_all == 1) {
                if ($request->survivor_support_organization_id == 1) {
                    $data = ViolenceCategory::with(['survivor_incident_information' => function($query) use($params) {
                        $query->whereHas('survivor_brac_support', function($q) use($params){
                            $q->where('survivor_final_support_id', $params['support_id']);
                        });
                        $query->with(['survivor_brac_support' => function($qw) use($params){
                            $qw->where('survivor_final_support_id', $params['support_id']);
                        }]);
                        $query->with(['survivor_gender']);
                    }]);
                } else {
                    $data = ViolenceCategory::with(['survivor_incident_information' => function($query) use($params) {
                        $query->whereHas('survivor_other_organization_support', function($q) use($params){
                            $q->where('survivor_final_support_id', $params['support_id']);
                        });
                        $query->with(['survivor_other_organization_support' => function($qw) use($params){
                            $qw->where('survivor_final_support_id', $params['support_id']);
                        }]);
                        $query->with(['survivor_gender']);
                    }]);
                }
            } else {
            // For Violence Category Single
                if ($request->survivor_support_organization_id == 1) {
                    $data = ViolenceCategory::where('id', $request->violence_category_id)->with(['survivor_incident_information' => function($query) use($params) {
                        $query->whereHas('survivor_brac_support', function($q) use($params){
                            $q->where('survivor_final_support_id', $params['support_id']);
                        });
                        $query->with(['survivor_brac_support' => function($qw) use($params){
                            $qw->where('survivor_final_support_id', $params['support_id']);
                        }]);
                        $query->with(['survivor_gender']);
                    }]);
                } else {
                    $data = ViolenceCategory::where('id', $request->violence_category_id)->with(['survivor_incident_information' => function($query) use($params) {
                        $query->whereHas('survivor_other_organization_support', function($q) use($params){
                            $q->where('survivor_final_support_id', $params['support_id']);
                        });
                        $query->with(['survivor_other_organization_support' => function($qw) use($params){
                            $qw->where('survivor_final_support_id', $params['support_id']);
                        }]);
                        $query->with(['survivor_gender']);
                    }]);
                }
            }
        } elseif ($request->violence_name_all != 1 && $request->violence_name_id == null){
            // For Violence Sub Category All
            if ($request->violence_sub_category_all == 1) {
                if ($request->survivor_support_organization_id == 1) {
                    $data = ViolenceSubCategory::where('violence_category_id', $request->violence_category_id)
                    ->with(['survivor_incident_information' => function($query) use($params) {
                        $query->whereHas('survivor_brac_support', function($q) use($params){
                            $q->where('survivor_final_support_id', $params['support_id']);
                        });
                        $query->with(['survivor_brac_support' => function($qw) use($params){
                            $qw->where('survivor_final_support_id', $params['support_id']);
                        }]);
                        $query->with(['survivor_gender']);
                    }]);
                } else {
                    $data = ViolenceSubCategory::where('violence_category_id', $request->violence_category_id)
                    ->with(['survivor_incident_information' => function($query) use($params) {
                        $query->whereHas('survivor_other_organization_support', function($q) use($params){
                            $q->where('survivor_final_support_id', $params['support_id']);
                        });
                        $query->with(['survivor_other_organization_support' => function($qw) use($params){
                            $qw->where('survivor_final_support_id', $params['support_id']);
                        }]);
                        $query->with(['survivor_gender']);
                    }]);
                }
            } else {
            // For Violence Sub Category Single
                if ($request->survivor_support_organization_id == 1) {
                    $data = ViolenceSubCategory::where('violence_category_id', $request->violence_category_id)->whereIn('id', $request->violence_sub_category_id)
                    ->with(['survivor_incident_information' => function($query) use($params) {
                        $query->whereHas('survivor_brac_support', function($q) use($params){
                            $q->where('survivor_final_support_id', $params['support_id']);
                        });
                        $query->with(['survivor_brac_support' => function($qw) use($params){
                            $qw->where('survivor_final_support_id', $params['support_id']);
                        }]);
                        $query->with(['survivor_gender']);
                    }]);
                } else {
                    $data = ViolenceSubCategory::where('violence_category_id', $request->violence_category_id)->whereIn('id', $request->violence_sub_category_id)
                    ->with(['survivor_incident_information' => function($query) use($params) {
                        $query->whereHas('survivor_other_organization_support', function($q) use($params){
                            $q->where('survivor_final_support_id', $params['support_id']);
                        });
                        $query->with(['survivor_other_organization_support' => function($qw) use($params){
                            $qw->where('survivor_final_support_id', $params['support_id']);
                        }]);
                        $query->with(['survivor_gender']);
                    }]);
                }
            }
        } else {
            // For Violence Name All
            if ($request->violence_name_all == 1) {
                if ($request->survivor_support_organization_id == 1) {
                    $data = ViolenceName::where('violence_category_id', $request->violence_category_id)
                    ->with(['survivor_incident_information' => function($query) use($params) {
                        $query->whereHas('survivor_brac_support', function($q) use($params){
                            $q->where('survivor_final_support_id', $params['support_id']);
                        });
                        $query->with(['survivor_brac_support' => function($qw) use($params){
                            $qw->where('survivor_final_support_id', $params['support_id']);
                        }]);
                        $query->with(['survivor_gender']);
                    }]);
                } else {
                    $data = ViolenceName::where('violence_category_id', $request->violence_category_id)
                    ->with(['survivor_incident_information' => function($query) use($params) {
                        $query->whereHas('survivor_other_organization_support', function($q) use($params){
                            $q->where('survivor_final_support_id', $params['support_id']);
                        });
                        $query->with(['survivor_other_organization_support' => function($qw) use($params){
                            $qw->where('survivor_final_support_id', $params['support_id']);
                        }]);
                        $query->with(['survivor_gender']);
                    }]);
                }
            } else {
            // For Violence Name Single
                if ($request->survivor_support_organization_id == 1) {
                    $data = ViolenceName::where('violence_category_id', $request->violence_category_id)->whereIn('id', $request->violence_name_id)
                    ->with(['survivor_incident_information' => function($query) use($params) {
                        $query->whereHas('survivor_brac_support', function($q) use($params){
                            $q->where('survivor_final_support_id', $params['support_id']);
                        });
                        $query->with(['survivor_brac_support' => function($qw) use($params){
                            $qw->where('survivor_final_support_id', $params['support_id']);
                        }]);
                        $query->with(['survivor_gender']);
                    }]);
                } else {
                    $data = ViolenceName::where('violence_category_id', $request->violence_category_id)->whereIn('id', $request->violence_name_id)
                    ->with(['survivor_incident_information' => function($query) use($params) {
                        $query->whereHas('survivor_other_organization_support', function($q) use($params){
                            $q->where('survivor_final_support_id', $params['support_id']);
                        });
                        $query->with(['survivor_other_organization_support' => function($qw) use($params){
                            $qw->where('survivor_final_support_id', $params['support_id']);
                        }]);
                        $query->with(['survivor_gender']);
                    }]);
                }
            }
        }

        $incidents = $data->get();
        // dd($incidents->toArray());
        // if($request->region_all != 1){
        //     $allDistrict = RegionAreaDetail::where('region_id',$request->region_id)->where('status','1')->groupBy('district_id')->pluck('district_id')->toArray();
        //     $wherein = $allDistrict;
        // }else{
        //     $allDistrict = RegionAreaDetail::where('status','1')->groupBy('district_id')->pluck('district_id')->toArray();
        //     $wherein = $allDistrict;
        // }
        if (!empty($request->region_id) && empty($request->division_id)) {
            //Only Region
            $allDistrict = RegionAreaDetail::where('region_id',$request->region_id)->where('status','1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein = $allDistrict;
        } elseif (!empty($request->region_id) && !empty($request->division_id) && empty($request->district_id)) {
            //Region and Division
            $allDivision = RegionAreaDetail::where('region_id',$request->region_id)->where('status','1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein = $allDivision;
        } else {
            //District and Upazila
            if($request->district_id) {
                $where[] = ['employee_district_id','=',$request->district_id];
            }
            if($request->upazila_id) {
                $where[] = ['employee_upazila_id','=',$request->upazila_id];
            }
        }
        // dd($wherein);
        $survivor_info = [];

        foreach($incidents as $key => $incident){
            $survivor_info[$key]['rows'] = count($incidents);
            $survivor_info[$key]['type'] = $incident->name;
            if(!empty($incident['survivor_incident_information']) && count($incident['survivor_incident_information'])>0){
                if ($request->survivor_support_organization_id == 1) {
                    if ($wherein != null) {
                        // $year_between = SurvivorIncidentInformation::whereHas('survivor_brac_support', function($query) use ($from_date,$to_date){
                        //     $query->whereBetween('survivor_support_date', [$from_date, $to_date]);
                        // })
                        // ->where($where)
                        // ->whereIn('employee_district_id',$wherein)
                        // ->whereIn('id',$incident['survivor_incident_information']
                        // ->pluck('id'))
                        // ->get();

                        $year_between = SurvivorBracSupport::with(['survivor_incident_information'])
                        ->whereHas('survivor_incident_information',function($q) use($where,$incident,$wherein){
                            $q->where($where)->whereIn('employee_district_id',$wherein)->whereIn('id',$incident['survivor_incident_information']->pluck('id'));
                        })
                        ->whereBetween('survivor_support_date', [$from_date, $to_date])
                        ->where('survivor_final_support_id','!=','null')
                        ->where('survivor_final_support_id', $request->brac_support_id)
                        ->get();

                        $survivor_count = SurvivorBracSupport::with(['survivor_incident_information'])
                        ->whereHas('survivor_incident_information',function($q) use($where,$incident,$wherein){
                            $q->where($where)->whereIn('employee_district_id',$wherein)->whereIn('id',$incident['survivor_incident_information']->pluck('id'));
                        })
                        ->whereBetween('survivor_support_date', [$from_date, $to_date])
                        ->where('survivor_final_support_id','!=','null')
                        ->where('survivor_final_support_id', $request->brac_support_id)
                        ->groupBy('survivor_id')
                        ->get();

                    } else {
                        // $year_between = SurvivorIncidentInformation::select('id','violence_category_id')->with(['survivor_brac_support'])->whereHas('survivor_brac_support', function($query) use ($from_date,$to_date){
                        //     $query->whereBetween('survivor_support_date', [$from_date, $to_date]);
                        // })
                        // // $year_between = SurvivorIncidentInformation::select('id')->with(['survivor_brac_support' => function($query) use ($from_date,$to_date){
                        // //     $query->whereBetween('survivor_support_date', [$from_date, $to_date]);
                        // // }])
                        // ->where($where)
                        // ->whereIn('id',$incident['survivor_incident_information']
                        // ->pluck('id'))
                        // ->get();
                        // dd($year_between->toArray());

                        $year_between = SurvivorBracSupport::with(['survivor_incident_information'])
                        ->whereHas('survivor_incident_information',function($q) use($where,$incident){
                            $q->where($where)->whereIn('id',$incident['survivor_incident_information']->pluck('id'));
                        })
                        ->whereBetween('survivor_support_date', [$from_date, $to_date])
                        ->where('survivor_final_support_id','!=','null')
                        ->where('survivor_final_support_id', $request->brac_support_id)
                        ->get();
                        // dd($year_between->toArray());

                        $survivor_count = SurvivorBracSupport::with(['survivor_incident_information'])
                        ->whereHas('survivor_incident_information',function($q) use($where,$incident){
                            $q->where($where)->whereIn('id',$incident['survivor_incident_information']->pluck('id'));
                        })
                        ->whereBetween('survivor_support_date', [$from_date, $to_date])
                        ->where('survivor_final_support_id','!=','null')
                        ->where('survivor_final_support_id', $request->brac_support_id)
                        ->groupBy('survivor_id')
                        ->get();
                        // dd($survivor_count->toArray());
                    }
                } else {
                    if ($wherein != null) {
                        // $year_between = SurvivorIncidentInformation::whereHas('survivor_other_organization_support', function($query) use ($from_date,$to_date){
                        //     $query->whereBetween('survivor_other_support_date', [$from_date, $to_date]);
                        // })
                        // ->where($where)
                        // ->whereIn('employee_district_id',$wherein)
                        // ->whereIn('id',$incident['survivor_incident_information']
                        // ->pluck('id'))
                        // ->get();

                        $year_between = SurvivorOtherOrganizationSupport::with(['survivor_incident_information'])
                        ->whereHas('survivor_incident_information',function($q) use($where,$incident,$wherein){
                            $q->where($where)->whereIn('employee_district_id',$wherein)->whereIn('id',$incident['survivor_incident_information']->pluck('id'));
                        })
                        ->whereBetween('survivor_other_support_date', [$from_date, $to_date])
                        ->where('survivor_final_support_id','!=','null')
                        ->where('survivor_final_support_id', $request->brac_support_id)
                        ->get();

                        $survivor_count = SurvivorOtherOrganizationSupport::with(['survivor_incident_information'])
                        ->whereHas('survivor_incident_information',function($q) use($where,$incident,$wherein){
                            $q->where($where)->whereIn('employee_district_id',$wherein)->whereIn('id',$incident['survivor_incident_information']->pluck('id'));
                        })
                        ->whereBetween('survivor_other_support_date', [$from_date, $to_date])
                        ->where('survivor_final_support_id','!=','null')
                        ->where('survivor_final_support_id', $request->brac_support_id)
                        ->groupBy('survivor_id')
                        ->get();

                    } else {
                        // $year_between = SurvivorIncidentInformation::whereHas('survivor_other_organization_support', function($query) use ($from_date,$to_date){
                        //     $query->whereBetween('survivor_other_support_date', [$from_date, $to_date]);
                        // })
                        // ->where($where)
                        // ->whereIn('id',$incident['survivor_incident_information']
                        // ->pluck('id'))
                        // ->get();

                        $year_between = SurvivorOtherOrganizationSupport::with(['survivor_incident_information'])
                        ->whereHas('survivor_incident_information',function($q) use($where,$incident){
                            $q->where($where)->whereIn('id',$incident['survivor_incident_information']->pluck('id'));
                        })
                        ->whereBetween('survivor_other_support_date', [$from_date, $to_date])
                        ->where('survivor_final_support_id','!=','null')
                        ->where('survivor_final_support_id', $request->brac_support_id)
                        ->get();

                        $survivor_count = SurvivorOtherOrganizationSupport::with(['survivor_incident_information'])
                        ->whereHas('survivor_incident_information',function($q) use($where,$incident){
                            $q->where($where)->whereIn('id',$incident['survivor_incident_information']->pluck('id'));
                        })
                        ->whereBetween('survivor_other_support_date', [$from_date, $to_date])
                        ->where('survivor_final_support_id','!=','null')
                        ->where('survivor_final_support_id', $request->brac_support_id)
                        ->groupBy('survivor_id')
                        ->get();
                    }
                }

                //dd($year_between->toArray());


                if(!empty($year_between) && count($year_between) > 0){
                    $survivor_info[$key]['year_between']['male'] = 0;
                    $survivor_info[$key]['year_between']['female'] = 0;
                    $survivor_info[$key]['year_between']['survivor_total'] = 0;
                    foreach($year_between as $yb){
                        if(!empty($yb['survivor_incident_information']['survivor_gender']) && $yb['survivor_incident_information']['survivor_gender']['name'] == 'Male'){
                            $survivor_info[$key]['year_between']['male'] +=1 ;
                        }

                        if(!empty($yb['survivor_incident_information']['survivor_gender']) && $yb['survivor_incident_information']['survivor_gender']['name'] == 'Female'){
                            $survivor_info[$key]['year_between']['female'] +=1 ;

                        }
                    }
                    $survivor_info[$key]['year_between']['total'] = $survivor_info[$key]['year_between']['male'] + $survivor_info[$key]['year_between']['female'];
                    $survivor_info[$key]['year_between']['survivor_total'] = count($survivor_count);
                }else{
                    $survivor_info[$key]['year_between']['male'] = 0;
                    $survivor_info[$key]['year_between']['female'] = 0;
                    $survivor_info[$key]['year_between']['total'] = 0;
                    $survivor_info[$key]['year_between']['survivor_total'] = 0;
                }

            }else{
                $survivor_info[$key]['year_between']['male'] = 0;
                $survivor_info[$key]['year_between']['female'] = 0;
                $survivor_info[$key]['year_between']['total'] = 0;
                $survivor_info[$key]['year_between']['survivor_total'] = 0;
            }
        }

        $pdata['survivor_info'] = $survivor_info;
        // dd($pdata['survivor_info']);
        $pdata['from_date'] = $from_date;
        $pdata['to_date'] = $to_date;
        $pdata['support_name'] = SurvivorFinalSupport::where('id', $support_id)->first();
        // dd($pdata['support_name']->toArray());

        // return view('backend.report.mis_html_view', $pdata);

        if ($request->format_download == 1) {
            $pdf = PDF::loadView('backend.report.pdf.support_report', $pdata);
            $pdf->SetProtection(['copy', 'print'], '', 'pass');
            return $pdf->stream('document.pdf');
        } else {
            $view_link = 'backend.report.excel.support-report-excel';
            return Excel::download(new MisReportExport($pdata,$view_link), 'support_report.xlsx');
        }
    }
}
