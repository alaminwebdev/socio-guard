<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Exports\MisReportExport;
use App\Model\DirectServiceType;
use App\Model\SelpIncidentModel;
use App\Model\Admin\Setup\Upazila;
use Illuminate\Support\Facades\DB;
use App\Model\Admin\Setup\District;
use App\Model\Admin\Setup\Division;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Query\JoinClause;
use App\Model\Admin\Setup\CEP_Region\Region;
use App\Model\AlternativeDisputeResolution;
use App\Model\Civilcase;
use App\Model\Pititioncase;
use App\Model\Policecase;

class SurvivorDirectServiceReportController extends Controller
{

    public function index()
    {
        $data['regions']   = getRegionByUserType();
        $data['auth_user'] = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        return view('backend.survivor_report.index', $data);
    }

    public function SelpIncidentQuery($request)
    {

        $query = SelpIncidentModel::query();

        if ($request->region_id) {
            if ($request->division_id) {
                $previousZoneInfo = getPreviousZoneIdsFromDivision($request->division_id);
                if (!empty($previousZoneInfo)) {
                    // Extract region_ids and date_to values
                    $regionIds      = array_keys($previousZoneInfo);
                    //$dateToValues   = array_values($previousZoneInfo);
                    $updateReigonIds = array_unique(array_merge($regionIds, [(int)$request->region_id]));
                } else {
                    $updateReigonIds = [(int)$request->region_id];
                }
                $query->whereIn('employee_zone_id', $updateReigonIds);
            } else {
                $query->where('employee_zone_id', $request->region_id);
            }
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

    public function survivorDirectServiceReportGenerate(Request $request)
    {
        ini_set('memory_limit', -1);
        $from_date = date('Y-m-d', strtotime($request->from_date));
        $to_date   = date('Y-m-d', strtotime($request->to_date));
        //$where[]          = ['status', 2];
        $datas['date_to']   = $to_date;
        $datas['date_from'] = $from_date;
        $datas['region']    = Region::where('id', $request->region_id)->first()->region_name ?? 'All';
        $datas['division']  = Division::where('id', $request->division_id)->first()->name ?? "All";
        $datas['district']  = District::where('id', $request->district_id)->first()->name ?? "All";
        $datas['upazila']   = Upazila::where('id', $request->upazila_id)->first()->name ?? "All";

        if ($request->report_type == 1) {
            $datas['title'] = "Survivor wise direct service";

            $selp_infos = $this->SelpIncidentQuery($request)
                ->with(['direct_services.direct_adrs', 'direct_services.court_case'])
                ->select(
                    'selp_incident_informations.id',
                    'posting_date',
                    'divisions.name as division_name',
                    'districts.name as district_name',
                    'upazilas.name as upazila_name',
                    'regions.region_name',
                    'survivor_name',
                    'survivor_father_name',
                    'survivor_mother_name',
                    'survivor_husband_name',
                    'survivor_age',
                    'survivor_mobile_number',
                    'survivor_mobile_number_on_request',
                    'survivor_gender_id',
                    'main_defendants_name',
                    'survivor_disability_status',
                    'violence_reason_id',
                    'date_of_dispute'
                )
                // ->addSelect(DB::raw('(SELECT count(*) FROM survivor_direct_services WHERE selp_incident_information_id = selp_incident_informations.id) as adrCount'))
                // ->addSelect(DB::raw('(SELECT count(*) FROM survivor_court_cases WHERE selp_incident_information_id = selp_incident_informations.id) as courtCasesCount'))
                ->join('regions', 'regions.id', '=', 'selp_incident_informations.employee_zone_id')
                ->join('divisions', 'divisions.id', '=', 'selp_incident_informations.employee_division_id')
                ->join('districts', 'districts.id', '=', 'selp_incident_informations.employee_district_id')
                ->join('upazilas', 'upazilas.id', '=', 'selp_incident_informations.employee_upazila_id')
                ->whereBetween('posting_date', [$from_date, $to_date])
                ->where('selp_incident_informations.status', 2)
                //->whereIn('selp_incident_informations.id', [36430, 36425, 30949,50751,50883,49256, 48260, 47970,46453,50870])
                //->orderBy('id', 'desc')
                //->limit(1000)
                ->get();
            //return  $selp_infos;
            $datas['directServices'] = $selp_infos;
        }

        //return view('backend.survivor_report.reportexcel', $datas);

        $view_link = 'backend.survivor_report.reportexcel';
        return Excel::download(new MisReportExport($datas, $view_link), 'survivor_wise_direct_service.xlsx');

        // if ($request->format_download == 1) {
        //     $pdf = PDF::loadView('backend.childmarriageinformation.upazila_wise_child_assistance_report_pdf', $datas, [], ['title' => 'Certificate', 'format' => 'A4-L', 'orientation' => 'L']);
        //     $pdf->SetProtection(['copy', 'print'], '', 'pass');
        //     return $pdf->stream('document.pdf');
        // } else {
        //     $view_link = 'backend.childmarriageinformation.upazila_wise_child_assistance_report_excel';
        //     return Excel::download(new MisReportExport($datas, $view_link), 'upazila_wise_child_assistance_report_excel.xlsx');
        // }

    }

    public function survivorDirectServiceReportGenerateModified(Request $request)
    {
        ini_set('memory_limit', -1);

        $from_date          = date('Y-m-d', strtotime($request->from_date));
        $to_date            = date('Y-m-d', strtotime($request->to_date));
        $data['date_to']   = $to_date;
        $data['date_from'] = $from_date;
        $data['region']    = Region::where('id', $request->region_id)->first()->region_name ?? 'All';
        $data['division']  = Division::where('id', $request->division_id)->first()->name ?? "All";
        $data['district']  = District::where('id', $request->district_id)->first()->name ?? "All";
        $data['upazila']   = Upazila::where('id', $request->upazila_id)->first()->name ?? "All";

        if ($request->report_type == 1) {
            $data['title'] = "Survivor wise direct service";

            $selp_infos = $this->SelpIncidentQuery($request)
                ->select(

                    'selp_incident_informations.id',
                    'posting_date',
                    'divisions.name as division_name',
                    'districts.name as district_name',
                    'upazilas.name as upazila_name',
                    'regions.region_name',
                    'survivor_name',
                    'survivor_father_name',
                    'survivor_mother_name',
                    'survivor_husband_name',
                    'survivor_age',
                    'survivor_mobile_number',
                    'survivor_mobile_number_on_request',
                    'survivor_gender_id',
                    'main_defendants_name',
                    'survivor_disability_status',
                    'violence_reason_id',
                    'date_of_dispute',

                    'direct_service_types.id as direct_service_type_id',
                    'direct_service_types.service_type_id',
                    'direct_service_types.service_date',
                    'survivor_direct_services.starting_date',

                    'survivor_direct_services.id as survivor_direct_service_id',
                    'survivor_direct_services.alternative_dispute_resolution_id',
                    'survivor_direct_services.starting_date as adr_starting_date',
                    'survivor_direct_services.closing_date as adr_closing_date',

                    'survivor_court_cases.id as survivor_court_case_id',
                    'survivor_court_cases.case_type',
                    'survivor_court_cases.court_case_id',
                    'survivor_court_cases.case_judjement_date',
                )
                ->join('regions', 'regions.id', '=', 'selp_incident_informations.employee_zone_id')
                ->join('divisions', 'divisions.id', '=', 'selp_incident_informations.employee_division_id')
                ->join('districts', 'districts.id', '=', 'selp_incident_informations.employee_district_id')
                ->join('upazilas', 'upazilas.id', '=', 'selp_incident_informations.employee_upazila_id')
                ->join('direct_service_types', 'direct_service_types.selp_incident_id', '=', 'selp_incident_informations.id')
                ->leftJoin('survivor_direct_services', function ($join) {
                    $join->on('survivor_direct_services.selp_incident_information_id', '=', 'selp_incident_informations.id')
                        ->where('direct_service_types.service_type_id', '=', 3);
                })
                ->leftJoin('survivor_court_cases', function ($join) {
                    $join->on('survivor_court_cases.selp_incident_information_id', '=', 'selp_incident_informations.id')
                        ->where('direct_service_types.service_type_id', '=', 4);
                })
                ->where('selp_incident_informations.status', 2)
                ->where(function ($query) use ($from_date, $to_date) {
                    $query->whereIn('direct_service_types.service_type_id', [1, 2, 5, 6])
                        ->whereBetween('direct_service_types.service_date', [$from_date, $to_date])
                        ->orWhere(function ($query) use ($from_date, $to_date) {
                            $query->where('direct_service_types.service_type_id', 3)
                                ->where(function ($query) use ($from_date, $to_date) {
                                    $query->whereBetween('survivor_direct_services.starting_date', [$from_date, $to_date]);
                                });
                        })
                        ->orWhere(function ($query) use ($from_date, $to_date) {
                            $query->where('direct_service_types.service_type_id', 4)
                                ->where(function ($query) use ($from_date, $to_date) {
                                    $query->whereBetween('survivor_court_cases.case_judjement_date', [$from_date, $to_date]);
                                });
                        });
                })
                ->orderBy('id', 'asc')
                ->get();

            $selp_infos = $selp_infos->groupBy('id');
            $direct_service = [];


            foreach ($selp_infos as $id => $direct_services) {
                $surviovor_info = null;
                $service_types = [];

                foreach ($direct_services as $service) {
                    $service_type = $service['service_type_id'];

                    if ($service_type == 3) {
                        $adr_title = $this->getADRTitleName($service->alternative_dispute_resolution_id);
                        $service_types[$service_type][] = [
                            'id'                    => $service->survivor_direct_service_id,
                            'title'                 => $adr_title,
                            'starting_date'         => $service->adr_starting_date,
                            'closing_date'          => $service->adr_closing_date,
                        ];
                    } else if ($service_type == 4) {
                        $case_title = $this->getCaseTitleName($service->case_type, $service->court_case_id);
                        $service_types[$service_type][] = [
                            'id'                    => $service->survivor_court_case_id,
                            'title'                 => $case_title,
                            'case_type'             => $service->case_type,
                            'case_judjement_date'   => $service->case_judjement_date,
                        ];
                    } else if ($service_type == 1 || $service_type == 2 || $service_type == 5 || $service_type == 6) {
                        $service_types[$service_type] = [
                            'id'                    => $service->direct_service_type_id,
                            'service_date'          => $service->service_date,
                        ];
                    }

                    // Keep the surviovor information only once
                    if ($surviovor_info === null) {
                        $surviovor_info = [
                            'id'                                => $service['id'],
                            'posting_date'                      => $service->posting_date,
                            'division_name'                     => $service->division_name,
                            'district_name'                     => $service->district_name,
                            'upazila_name'                      => $service->upazila_name,
                            'region_name'                       => $service->region_name,
                            'survivor_name'                     => $service->survivor_name,
                            'survivor_father_name'              => $service->survivor_father_name,
                            'survivor_mother_name'              => $service->survivor_mother_name,
                            'survivor_husband_name'             => $service->survivor_husband_name,
                            'survivor_age'                      => $service->survivor_age,
                            'survivor_mobile_number'            => $service->survivor_mobile_number,
                            'survivor_mobile_number_on_request' => $service->survivor_mobile_number_on_request,
                            'survivor_gender_id'                => $service->survivor_gender_id,
                            'survivor_gender'                   => @$service->survivor_gender->name,
                            'main_defendants_name'              => $service->main_defendants_name,
                            'survivor_disability_status'        => @$service->survivor_disability_status,
                            'survivor_disability_name'          => @$service->survivor_disability->name,
                            'violence_reason_id'                => $service->violence_reason_id,
                            'violence_reason'                   => @$service->types_of_disputes->name,
                            'date_of_dispute'                   => $service->date_of_dispute,
                            'service_type_id'                   => $service->service_type_id,
                            'service_date'                      => $service->service_date,
                        ];
                    }
                }

                if (!empty($service_types)) {
                    $surviovor_info['service_types'] = $service_types;
                }

                $direct_service[$id] = $surviovor_info;
            }
            $data['directServices'] = $direct_service;
            //dd($data['directServices']);
        }

        return view('backend.survivor_report.survivor_wise_direct_service', $data);

        $view_link = 'backend.survivor_report.reportexcel';
        return Excel::download(new MisReportExport($data, $view_link), 'survivor_wise_direct_service.xlsx');
    }

    public function getCaseTitleName($caseType, $caseId)
    {
        $title = null;

        switch ($caseType) {
            case 1:
                $title = Civilcase::where('id', $caseId)->value('title');
                break;
            case 2:
                $title = Policecase::where('id', $caseId)->value('title');
                break;
            case 3:
                $title = Pititioncase::where('id', $caseId)->value('title');
                break;
        }
        return $title ?? null;
    }

    public function getADRTitleName($ADRId)
    {
        $title = AlternativeDisputeResolution::where('id', $ADRId)->value('title');
        return $title ?? null;
    }
}
