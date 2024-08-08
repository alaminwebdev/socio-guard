<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Exports\MisReportExport;
use App\Http\Controllers\Controller;
use App\Model\Admin\Setup\CEP_Region\Region;
use App\Model\Admin\Setup\District;
use App\Model\Admin\Setup\Division;
use App\Model\Admin\Setup\Upazila;
use App\Model\Followup;
use App\Model\SelpIncidentModel;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class FollowupReportController extends Controller {

    public function upazilaWiseFollowupReportView() {
        $data['regions']   = getRegionByUserType();
        $data['auth_user'] = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        return view('backend.report.upazila_wise_followup_report_view', $data);
    }
    public function SelpIncidentQuery($request) {

        $query = SelpIncidentModel::query();

        if ($request->region_id) {
            $query->where('employee_zone_id', $request->region_id);
        } else if (array_intersect([5, 4, 3], auth()->user()->user_role->pluck('role_id')->toarray())) {
            $area = array_unique(User::with('setup_user_area')->find(Auth::id())->setup_user_area->pluck('region_id')->toArray());
            $query->whereIn('employee_zone_id', $area);
        }

        if ($request->division_id) {
            $query->where('employee_division_id', $request->division_id);
        } else if (array_intersect([5, 4], auth()->user()->user_role->pluck('role_id')->toarray())) {
            $area = array_unique(User::with('setup_user_area')->find(Auth::id())->setup_user_area->pluck('division_id')->toArray());
            $query->whereIn('employee_division_id', $area);
        }

        if ($request->district_id) {
            $query->where('employee_district_id', $request->district_id);
        } else if (array_intersect([5, 4], auth()->user()->user_role->pluck('role_id')->toarray())) {
            $area = array_unique(User::with('setup_user_area')->find(Auth::id())->setup_user_area->pluck('district_id')->toArray());
            $query->whereIn('employee_district_id', $area);
        }

        if ($request->upazila_id) {
            $query->where('employee_upazila_id', $request->upazila_id);
        } else if (array_intersect([5], auth()->user()->user_role->pluck('role_id')->toarray())) {
            $area = array_unique(User::with('setup_user_area')->find(Auth::id())->setup_user_area->pluck('upazila_id')->toArray());
            $query->whereIn('employee_upazila_id', $area);
        }

        return $query;
    }

    public function upazilaWiseFollowupReportGenerate(Request $request) {
        ini_set('memory_limit', -1);
        $from_date          = date('Y-m-d', strtotime($request->from_date));
        $to_date            = date('Y-m-d', strtotime($request->to_date));
        $datas['date_to']   = $to_date;
        $datas['date_from'] = $from_date;
        $datas['region']    = Region::where('id', $request->region_id)->first()->region_name ?? 'All';
        $datas['division']  = Division::where('id', $request->division_id)->first()->name ?? "All";
        $datas['district']  = District::where('id', $request->district_id)->first()->name ?? "All";
        $datas['upazila']   = Upazila::where('id', $request->upazila_id)->first()->name ?? "All";

        if ($request->report_type == 1) {
            $datas['title'] = "No.of survivors received Followup(ADR completed with decesion (office) and self/out side)";

            $datas['followups'] = Followup::orderBy('id', 'asc')->whereNotIn('id', [15])->get();

            $followups_array = [];
            foreach ($datas['followups'] as $key => $list) {
                $followups_array[] = 'sum(case when follow_up_infos.followup_findings = ' . $list->id . ' then 1 else 0 end) as followup_findings_id_' . $list->id;
            }
            $followups_db = implode(',', $followups_array);

            $datas['follow_number'] = ['1' => 'First Time', '2' => 'Second Time', '3' => 'Third Time'];
            $follow_number_array    = [];
            foreach ($datas['follow_number'] as $key => $list) {
                $follow_number_array[] = 'sum(case when follow_up_infos.followup_number = ' . $key . ' then 1 else 0 end) as followup_number_id_' . $key;
            }
            $follow_number_db = implode(',', $follow_number_array);

            $datas['selfDatas'] = $this->SelpIncidentQuery($request)
                ->select(
                    'divisions.name as division_name',
                    'districts.name as district_name',
                    'upazilas.name as upazila_name',
                    DB::raw($follow_number_db),
                    DB::raw($followups_db),
                )
                ->join('survivor_direct_services', 'survivor_direct_services.selp_incident_information_id', '=', 'selp_incident_informations.id')
                ->join('follow_up_infos', 'follow_up_infos.selp_incident_id', '=', 'selp_incident_informations.id')
                ->join('divisions', 'divisions.id', '=', 'selp_incident_informations.employee_division_id')
                ->join('districts', 'districts.id', '=', 'selp_incident_informations.employee_district_id')
                ->join('upazilas', 'upazilas.id', '=', 'selp_incident_informations.employee_upazila_id')
                ->whereIn('alternative_dispute_resolution_id', [7, 9])
                ->whereBetween('follow_up_infos.followup_date', [$from_date, $to_date])
                ->where('selp_incident_informations.status', 2)
                ->groupBy(
                    'employee_division_id',
                    'employee_district_id',
                    'employee_upazila_id',
                )
                ->orderBy('division_name', 'asc')
                ->orderBy('district_name', 'asc')
                ->orderBy('upazila_name', 'asc')
                ->get();

            if ($request->format_download == 1) {
                $pdf = PDF::loadView('backend.admin.followup.upazila_wise_followup_pdf', $datas, [], ['title' => 'Certificate', 'format' => 'A4-L', 'orientation' => 'L']);
                $pdf->SetProtection(['copy', 'print'], '', 'pass');
                return $pdf->stream('document.pdf');
            } else {
                $view_link = 'backend.admin.followup.upazila_wise_followup_excel';
                return Excel::download(new MisReportExport($datas, $view_link), 'upazila_wise_followup_report.xlsx');
            }

        } elseif ($request->report_type == 2) {
            $datas['title'] = "No.of survivors received Followup(On going court case)";

            $datas['followups'] = Followup::orderBy('id', 'asc')->whereIn('id', [13, 15])->get();

            $followups_array = [];
            foreach ($datas['followups'] as $key => $list) {
                $followups_array[] = 'sum(case when follow_up_infos.followup_findings = ' . $list->id . ' then 1 else 0 end) as followup_findings_id_' . $list->id;
            }
            $followups_db = implode(',', $followups_array);

            $datas['follow_number'] = ['1' => 'First Time', '2' => 'Second Time', '3' => 'Third Time'];
            $follow_number_array    = [];
            foreach ($datas['follow_number'] as $key => $list) {
                $follow_number_array[] = 'sum(case when follow_up_infos.followup_number = ' . $key . ' then 1 else 0 end) as followup_number_id_' . $key;
            }
            $follow_number_db = implode(',', $follow_number_array);

            $datas['selfDatas'] = $this->SelpIncidentQuery($request)
                ->select(
                    'divisions.name as division_name',
                    'districts.name as district_name',
                    'upazilas.name as upazila_name',
                    DB::raw($follow_number_db),
                    DB::raw($followups_db),
                )
            // ->join('survivor_direct_services', 'survivor_direct_services.selp_incident_information_id', '=', 'selp_incident_informations.id')
                ->join('follow_up_infos', 'follow_up_infos.selp_incident_id', '=', 'selp_incident_informations.id')
                ->join('divisions', 'divisions.id', '=', 'selp_incident_informations.employee_division_id')
                ->join('districts', 'districts.id', '=', 'selp_incident_informations.employee_district_id')
                ->join('upazilas', 'upazilas.id', '=', 'selp_incident_informations.employee_upazila_id')
            // ->whereIn('alternative_dispute_resolution_id', [7, 9])
                ->whereBetween('follow_up_infos.followup_date', [$from_date, $to_date])
                ->where('selp_incident_informations.status', 2)
                ->groupBy(
                    'employee_division_id',
                    'employee_district_id',
                    'employee_upazila_id',
                )
                ->orderBy('division_name', 'asc')
                ->orderBy('district_name', 'asc')
                ->orderBy('upazila_name', 'asc')
                ->get();

            if ($request->format_download == 1) {
                $pdf = PDF::loadView('backend.admin.followup.upazila_wise_followup_pdf', $datas, [], ['title' => 'Certificate', 'format' => 'A4-L', 'orientation' => 'L']);
                $pdf->SetProtection(['copy', 'print'], '', 'pass');
                return $pdf->stream('document.pdf');
            } else {
                $view_link = 'backend.admin.followup.upazila_wise_followup_excel';
                return Excel::download(new MisReportExport($datas, $view_link), 'upazila_wise_followup_report.xlsx');
            }

        }
    }
}
