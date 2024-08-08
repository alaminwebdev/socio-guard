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

class TestSupportController extends Controller
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
        }

        $incidents = $data->get();

        $survivor_info = [];

        foreach($incidents as $key => $incident){
            $survivor_info[$key]['rows'] = count($incidents);
            $survivor_info[$key]['type'] = $incident->name;
            if(!empty($incident['survivor_incident_information']) && count($incident['survivor_incident_information'])>0){

                // $year_between = SurvivorIncidentInformation::whereHas('survivor_brac_support', function($query) use ($from_date,$to_date){
                //     $query->whereBetween('survivor_support_date', [$from_date, $to_date]);
                // })
                // ->where($where)
                // ->whereIn('id',$incident['survivor_incident_information']->pluck('id'))
                // ->get();



                $year_between = SurvivorIncidentInformation::whereHas('survivorBracSupportReport', function($query) use ($from_date,$to_date, $incident){
                            // $query->whereNotNull('survivor_final_support_id');
                            $query->whereBetween('survivor_support_date', [$from_date, $to_date]);
                            // $query->whereBetween('survivor_support_date', ["2020-11-01", "2020-12-31"]);
                            // $query->whereIn('survivor_incident_info_id', $incident['survivor_incident_information']->pluck('id'));
                })
                ->withCount(['survivorBracSupportReport'])
                ->where($where)
                ->whereIn('id',$incident['survivor_incident_information']->pluck('id'))
                ->get();

                dd($year_between->sum('survivor_brac_support_report_count'));

                if(!empty($year_between) && count($year_between) > 0){
                    $survivor_info[$key]['year_between']['male'] = 0;
                    $survivor_info[$key]['year_between']['female'] = 0;
                    foreach($year_between as $yb){
                        if(!empty($yb->survivor_gender) && $yb->survivor_gender->name == 'Male'){
                            $survivor_info[$key]['year_between']['male'] +=1 ;

                        }

                        if(!empty($yb->survivor_gender) && $yb->survivor_gender->name == 'Female'){
                            $survivor_info[$key]['year_between']['female'] +=1 ;

                        }
                    }
                    $survivor_info[$key]['year_between']['total'] = $survivor_info[$key]['year_between']['male'] + $survivor_info[$key]['year_between']['female'];
                }else{
                    $survivor_info[$key]['year_between']['male'] = 0;
                    $survivor_info[$key]['year_between']['female'] = 0;
                    $survivor_info[$key]['year_between']['total'] = 0;
                }

            }else{
                $survivor_info[$key]['year_between']['male'] = 0;
                $survivor_info[$key]['year_between']['female'] = 0;
                $survivor_info[$key]['year_between']['total'] = 0;
            }
        }

        $pdata['survivor_info'] = $survivor_info;
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
