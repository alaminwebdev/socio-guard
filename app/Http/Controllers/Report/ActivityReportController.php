<?php

namespace App\Http\Controllers\Report;

use App\Exports\MisReportExport;
use App\Http\Controllers\Controller;
use App\Model\ActivityModel;
use App\Model\Admin\Setup\CEP_Region\Region;
use App\Model\Admin\Setup\CEP_Region\SetupUserArea;
use App\Model\Admin\Setup\District;
use App\Model\Admin\Setup\Division;
use App\Model\Admin\Setup\Gender;
use App\Model\Admin\Setup\OrganizationName;
use App\Model\Admin\Setup\SurvivorAutisticInformation;
use App\Model\Admin\Setup\Upazila;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class ActivityReportController extends Controller {
    public function activityReportView() {
        $data['platform']  = OrganizationName::where('status', 1)->get();
        $data['regions']   = getRegionByUserType();
        $data['autistics'] = SurvivorAutisticInformation::where('status', '1')->get();
        $data['genders']   = Gender::all();
        $data['auth_user'] = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        // dd($platform->toArray());
        return view('selp.view.selp_activity_report_view', $data);
    }

    public function activityReportExcel(Request $request) {
        ini_set('memory_limit', -1);

        $from_date        = date('Y-m-d', strtotime($request->from_date));
        $to_date          = date('Y-m-d', strtotime($request->to_date));
        $where[]          = ['status', 2];
        $wherein          = [];
        $setup_area       = [];
        $reportTypeTarget = null;
        $groupBy          = null;
        $label_name       = null;

        if ($request->upazila_id == "all_upazila" || $request->upazila_id > 0) {
            $reportTypeTarget = "employee_upazila_id";
            $groupBy          = 'upazila_id';
            $label_name       = 'Upazila Name';
            if ($request->upazila_id > 0) {
                $setup_area = SetupUserArea::withTrashed()->where('upazila_id', $request->upazila_id)->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
            }

        }
        if ($request->district_id == "all_district" || $request->district_id > 0) {

            if ($reportTypeTarget == null) {
                $reportTypeTarget = "employee_district_id";
            }

            if ($label_name == null) {
                $label_name = "District name";
            }

            if ($groupBy == null) {
                $groupBy = "district_id";
            }
            if ($request->district_id > 0 && count($setup_area) == 0) {
                $setup_area = SetupUserArea::withTrashed()->where('district_id', $request->district_id)->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
            }
        }

        if ($request->division_id > 0 && count($setup_area) == 0) {
            if ($reportTypeTarget == null) {
                $reportTypeTarget = "employee_district_id";
            }
            if ($groupBy == null) {
                $groupBy = "district_id";
            }

            if ($label_name == null) {
                $label_name = "District name";
            }
            $setup_area = SetupUserArea::withTrashed()->where('division_id', $request->division_id)->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();

        }

        if ($request->region_id == "all_zone" || $request->region_id > 0) {
            if ($reportTypeTarget == null) {
                $reportTypeTarget = "employee_district_id";
            }

            if ($groupBy == null) {
                $groupBy = "district_id";
            }

            if ($label_name == null) {
                $label_name = "District name";
            }
            if ($request->region_id > 0 && count($setup_area) == 0) {
                $setup_area = SetupUserArea::withTrashed()->where('region_id', $request->region_id)->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
            }

        }

        if (count($setup_area) == 0) {
            $setup_area = SetupUserArea::withTrashed()->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
        }

        if ($groupBy == "district_id") {
            $areas   = District::select('id', 'name')->whereIn('id', $setup_area)->orderBy('id', "ASC")->get();
            $area_id = District::select('id', 'name')->whereIn('id', $setup_area)->orderBy('id', "ASC")->pluck('id')->toArray();
        }

        if ($groupBy == "upazila_id") {
            $areas   = Upazila::select('id', 'name')->whereIn('id', $setup_area)->orderBy('id', "ASC")->get();
            $area_id = Upazila::select('id', 'name')->whereIn('id', $setup_area)->orderBy('id', "ASC")->pluck('id')->toArray();
        }

        $pdata = ActivityModel::with(['meeting_activity', 'training_activity', 'community_activity', 'campaign_activity', 'pt_show_activity', 'pt_production_activity', 'zones', 'division', 'district', 'upazilla'])
            ->whereIn($reportTypeTarget, $area_id)
            ->where($where)
            ->whereBetween('reporting_date', [$from_date, $to_date])
            ->get()->toArray();
        // dd($pdata);
        $pdata['activities'] = $pdata;

        if (!@$pdata['activities']) {
            return redirect()->back()->with('error', "There is no data entry found in this search criteria");
        }

        $pdata['region']    = ($request->region_id != "all_zone") ? Region::where('id', $request->region_id)->pluck('region_name')->first() : "All";
        $pdata['division']  = ($request->division_id != null) ? Division::where('id', $request->division_id)->pluck('name')->first() : "";
        $pdata['district']  = ($request->district_id != "all_district") ? District::where('id', $request->district_id)->pluck('name')->first() : "All";
        $pdata['upazila']   = ($request->upazila_id != "all_upazila") ? Upazila::where('id', $request->upazila_id)->pluck('name')->first() : "All";
        $pdata['date']      = date('d-M-Y');
        $pdata['from_date'] = date('d-M-Y', strtotime($request->from_date));
        $pdata['to_date']   = date('d-M-Y', strtotime($request->to_date));

        if ($request->format_download == 1) {
            return redirect()->back()->with('error', "This Report Can not be generate in PDF format");
        } else {
            $view_link = 'backend.report.excel.activity-filter-data';
            return Excel::download(new MisReportExport($pdata, $view_link), 'activity-data.xlsx');
        }
    }

    public function activityReport(Request $request) {
        ini_set('memory_limit', -1);
        // dd($request->all());
        $from_date        = date('Y-m-d', strtotime($request->from_date));
        $to_date          = date('Y-m-d', strtotime($request->to_date));
        $where[]          = ['status', 2];
        $wherein          = [];
        $setup_area       = [];
        $reportTypeTarget = null;
        $groupBy          = null;
        $label_name       = null;

        if ($request->upazila_id == "all_upazila" || $request->upazila_id > 0) {
            $reportTypeTarget = "employee_upazila_id";
            $groupBy          = 'upazila_id';
            $label_name       = 'Upazila Name';
            if ($request->upazila_id > 0) {
                $setup_area = SetupUserArea::withTrashed()->where('upazila_id', $request->upazila_id)->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
            }

        }
        if ($request->district_id == "all_district" || $request->district_id > 0) {

            if ($reportTypeTarget == null) {
                $reportTypeTarget = "employee_district_id";
            }

            if ($label_name == null) {
                $label_name = "District name";
            }

            if ($groupBy == null) {
                $groupBy = "district_id";
            }
            if ($request->district_id > 0 && count($setup_area) == 0) {
                $setup_area = SetupUserArea::withTrashed()->where('district_id', $request->district_id)->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
            }
        }

        if ($request->division_id > 0 && count($setup_area) == 0) {
            if ($reportTypeTarget == null) {
                $reportTypeTarget = "employee_district_id";
            }
            if ($groupBy == null) {
                $groupBy = "district_id";
            }

            if ($label_name == null) {
                $label_name = "District name";
            }
            $setup_area = SetupUserArea::withTrashed()->where('division_id', $request->division_id)->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();

        }

        if ($request->region_id == "all_zone" || $request->region_id > 0) {
            if ($reportTypeTarget == null) {
                $reportTypeTarget = "employee_district_id";
            }

            if ($groupBy == null) {
                $groupBy = "district_id";
            }

            if ($label_name == null) {
                $label_name = "District name";
            }
            if ($request->region_id > 0 && count($setup_area) == 0) {
                $setup_area = SetupUserArea::withTrashed()->where('region_id', $request->region_id)->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
            }

        }

        if (count($setup_area) == 0) {
            $setup_area = SetupUserArea::withTrashed()->groupBy($groupBy)->whereNotNull($groupBy)->pluck($groupBy)->toArray();
        }

        if ($groupBy == "district_id") {
            $areas   = District::select('id', 'name')->whereIn('id', $setup_area)->orderBy('id', "ASC")->get();
            $area_id = District::select('id', 'name')->whereIn('id', $setup_area)->orderBy('id', "ASC")->pluck('id')->toArray();
        }

        if ($groupBy == "upazila_id") {
            $areas   = Upazila::select('id', 'name')->whereIn('id', $setup_area)->orderBy('id', "ASC")->get();
            $area_id = Upazila::select('id', 'name')->whereIn('id', $setup_area)->orderBy('id', "ASC")->pluck('id')->toArray();
        }

        $activity_data = ActivityModel::select('id', 'employee_zone_id', 'employee_division_id', 'employee_district_id', 'employee_upazila_id', 'reporting_date')
            ->whereIn($reportTypeTarget, $area_id)
            ->where($where)
            ->whereBetween('reporting_date', [$from_date, $to_date])
            ->get();
        // dd($activity_data->toArray());
        foreach ($activity_data as $activity_key => $activity) {
            $pdata['information'][$activity->id]['reporting_date'] = @$activity->reporting_date;
            $pdata['information'][$activity->id]['zone']           = @$activity->zones->region_name;
            $pdata['information'][$activity->id]['division']       = @$activity->division->name;
            $pdata['information'][$activity->id]['district']       = @$activity->district->name;
            $pdata['information'][$activity->id]['upazila']        = @$activity->upazilla->name;
            // dd($pdata);

            // Meeting/Workshop
            if ($request->category_type == null || $request->category_type == 1) {
                foreach ($activity->meeting_activity as $meeting_key => $meeting) {
                    $pdata['information'][$activity->id]['meeting'][$meeting_key]['id']                           = $meeting->id;
                    $pdata['information'][$activity->id]['meeting'][$meeting_key]['category_name']                = "Meeting/Workshop";
                    $pdata['information'][$activity->id]['meeting'][$meeting_key]['event']                        = @$meeting->event_name->name;
                    $pdata['information'][$activity->id]['meeting'][$meeting_key]['no_of_event']                  = $meeting->no_of_event;
                    $pdata['information'][$activity->id]['meeting'][$meeting_key]['starting_date']                = $meeting->starting_date;
                    $pdata['information'][$activity->id]['meeting'][$meeting_key]['ending_date']                  = $meeting->ending_date;
                    $pdata['information'][$activity->id]['meeting'][$meeting_key]['participant_boys']             = $meeting->participant_boys;
                    $pdata['information'][$activity->id]['meeting'][$meeting_key]['participant_girls']            = $meeting->participant_girls;
                    $pdata['information'][$activity->id]['meeting'][$meeting_key]['participant_men']              = $meeting->participant_men;
                    $pdata['information'][$activity->id]['meeting'][$meeting_key]['participant_women']            = $meeting->participant_women;
                    $pdata['information'][$activity->id]['meeting'][$meeting_key]['participant_other_gender']     = $meeting->participant_other_gender;
                    $pdata['information'][$activity->id]['meeting'][$meeting_key]['participant_total']            = $meeting->participant_total;
                    $pdata['information'][$activity->id]['meeting'][$meeting_key]['participant_pwd_boys']         = $meeting->participant_pwd_boys;
                    $pdata['information'][$activity->id]['meeting'][$meeting_key]['participant_pwd_girls']        = $meeting->participant_pwd_girls;
                    $pdata['information'][$activity->id]['meeting'][$meeting_key]['participant_pwd_men']          = $meeting->participant_pwd_men;
                    $pdata['information'][$activity->id]['meeting'][$meeting_key]['participant_pwd_women']        = $meeting->participant_pwd_women;
                    $pdata['information'][$activity->id]['meeting'][$meeting_key]['participant_pwd_other_gender'] = $meeting->participant_pwd_other_gender;
                    $pdata['information'][$activity->id]['meeting'][$meeting_key]['participant_pwd_total']        = $meeting->participant_pwd_total;
                }
            }
            // Training/Orientation
            if ($request->category_type == null || $request->category_type == 2) {
                foreach ($activity->training_activity as $training_key => $training) {
                    $pdata['information'][$activity->id]['training'][$training_key]['id']                           = $training->id;
                    $pdata['information'][$activity->id]['training'][$training_key]['category_name']                = "Training/Orientation";
                    $pdata['information'][$activity->id]['training'][$training_key]['event']                        = @$training->event_name->name;
                    $pdata['information'][$activity->id]['training'][$training_key]['no_of_event']                  = $training->no_of_event;
                    $pdata['information'][$activity->id]['training'][$training_key]['starting_date']                = $training->starting_date;
                    $pdata['information'][$activity->id]['training'][$training_key]['ending_date']                  = $training->ending_date;
                    $pdata['information'][$activity->id]['training'][$training_key]['participant_boys']             = $training->participant_boys;
                    $pdata['information'][$activity->id]['training'][$training_key]['participant_girls']            = $training->participant_girls;
                    $pdata['information'][$activity->id]['training'][$training_key]['participant_men']              = $training->participant_men;
                    $pdata['information'][$activity->id]['training'][$training_key]['participant_women']            = $training->participant_women;
                    $pdata['information'][$activity->id]['training'][$training_key]['participant_other_gender']     = $training->participant_other_gender;
                    $pdata['information'][$activity->id]['training'][$training_key]['participant_total']            = $training->participant_total;
                    $pdata['information'][$activity->id]['training'][$training_key]['participant_pwd_boys']         = $training->participant_pwd_boys;
                    $pdata['information'][$activity->id]['training'][$training_key]['participant_pwd_girls']        = $training->participant_pwd_girls;
                    $pdata['information'][$activity->id]['training'][$training_key]['participant_pwd_men']          = $training->participant_pwd_men;
                    $pdata['information'][$activity->id]['training'][$training_key]['participant_pwd_women']        = $training->participant_pwd_women;
                    $pdata['information'][$activity->id]['training'][$training_key]['participant_pwd_other_gender'] = $training->participant_pwd_other_gender;
                    $pdata['information'][$activity->id]['training'][$training_key]['participant_pwd_total']        = $training->participant_pwd_total;

                }
            }

            //Community Level Awareness
            if ($request->category_type == null || $request->category_type == 3) {
                foreach ($activity->community_activity as $community_key => $community) {
                    $pdata['information'][$activity->id]['community'][$community_key]['id']                           = $community->id;
                    $pdata['information'][$activity->id]['community'][$community_key]['category_name']                = "Community Level Awareness";
                    $pdata['information'][$activity->id]['community'][$community_key]['event']                        = @$community->event_name->name;
                    $pdata['information'][$activity->id]['community'][$community_key]['no_of_event']                  = $community->no_of_event;
                    $pdata['information'][$activity->id]['community'][$community_key]['starting_date']                = $community->starting_date;
                    $pdata['information'][$activity->id]['community'][$community_key]['ending_date']                  = $community->ending_date;
                    $pdata['information'][$activity->id]['community'][$community_key]['participant_boys']             = $community->participant_boys;
                    $pdata['information'][$activity->id]['community'][$community_key]['participant_girls']            = $community->participant_girls;
                    $pdata['information'][$activity->id]['community'][$community_key]['participant_men']              = $community->participant_men;
                    $pdata['information'][$activity->id]['community'][$community_key]['participant_women']            = $community->participant_women;
                    $pdata['information'][$activity->id]['community'][$community_key]['participant_other_gender']     = $community->participant_other_gender;
                    $pdata['information'][$activity->id]['community'][$community_key]['participant_total']            = $community->participant_total;
                    $pdata['information'][$activity->id]['community'][$community_key]['participant_pwd_boys']         = $community->participant_pwd_boys;
                    $pdata['information'][$activity->id]['community'][$community_key]['participant_pwd_girls']        = $community->participant_pwd_girls;
                    $pdata['information'][$activity->id]['community'][$community_key]['participant_pwd_men']          = $community->participant_pwd_men;
                    $pdata['information'][$activity->id]['community'][$community_key]['participant_pwd_women']        = $community->participant_pwd_women;
                    $pdata['information'][$activity->id]['community'][$community_key]['participant_pwd_other_gender'] = $community->participant_pwd_other_gender;
                    $pdata['information'][$activity->id]['community'][$community_key]['participant_pwd_total']        = $community->participant_pwd_total;

                }
            }
            //Campaign and Day Observation
            if ($request->category_type == null || $request->category_type == 4) {
                foreach ($activity->campaign_activity as $campaign_key => $campaign) {
                    $pdata['information'][$activity->id]['campaign'][$campaign_key]['id']                           = $campaign->id;
                    $pdata['information'][$activity->id]['campaign'][$campaign_key]['category_name']                = "Campaign and Day Observation";
                    $pdata['information'][$activity->id]['campaign'][$campaign_key]['event']                        = @$campaign->event_name->name;
                    $pdata['information'][$activity->id]['campaign'][$campaign_key]['no_of_event']                  = $campaign->no_of_event;
                    $pdata['information'][$activity->id]['campaign'][$campaign_key]['starting_date']                = $campaign->starting_date;
                    $pdata['information'][$activity->id]['campaign'][$campaign_key]['ending_date']                  = $campaign->ending_date;
                    $pdata['information'][$activity->id]['campaign'][$campaign_key]['participant_boys']             = $campaign->participant_boys;
                    $pdata['information'][$activity->id]['campaign'][$campaign_key]['participant_girls']            = $campaign->participant_girls;
                    $pdata['information'][$activity->id]['campaign'][$campaign_key]['participant_men']              = $campaign->participant_men;
                    $pdata['information'][$activity->id]['campaign'][$campaign_key]['participant_women']            = $campaign->participant_women;
                    $pdata['information'][$activity->id]['campaign'][$campaign_key]['participant_other_gender']     = $campaign->participant_other_gender;
                    $pdata['information'][$activity->id]['campaign'][$campaign_key]['participant_total']            = $campaign->participant_total;
                    $pdata['information'][$activity->id]['campaign'][$campaign_key]['participant_pwd_boys']         = $campaign->participant_pwd_boys;
                    $pdata['information'][$activity->id]['campaign'][$campaign_key]['participant_pwd_girls']        = $campaign->participant_pwd_girls;
                    $pdata['information'][$activity->id]['campaign'][$campaign_key]['participant_pwd_men']          = $campaign->participant_pwd_men;
                    $pdata['information'][$activity->id]['campaign'][$campaign_key]['participant_pwd_women']        = $campaign->participant_pwd_women;
                    $pdata['information'][$activity->id]['campaign'][$campaign_key]['participant_pwd_other_gender'] = $campaign->participant_pwd_other_gender;
                    $pdata['information'][$activity->id]['campaign'][$campaign_key]['participant_pwd_total']        = $campaign->participant_pwd_total;

                }
            }
            //PT Show
            if ($request->category_type == null || $request->category_type == 5) {
                foreach ($activity->pt_show_activity as $pt_show_key => $pt_show) {
                    $pdata['information'][$activity->id]['pt_show'][$pt_show_key]['id']                           = $pt_show->id;
                    $pdata['information'][$activity->id]['pt_show'][$pt_show_key]['category_name']                = "PT Show";
                    $pdata['information'][$activity->id]['pt_show'][$pt_show_key]['event']                        = @$pt_show->event_name->name;
                    $pdata['information'][$activity->id]['pt_show'][$pt_show_key]['no_of_event']                  = $pt_show->no_of_event;
                    $pdata['information'][$activity->id]['pt_show'][$pt_show_key]['starting_date']                = $pt_show->starting_date;
                    $pdata['information'][$activity->id]['pt_show'][$pt_show_key]['ending_date']                  = $pt_show->ending_date;
                    $pdata['information'][$activity->id]['pt_show'][$pt_show_key]['participant_boys']             = $pt_show->participant_boys;
                    $pdata['information'][$activity->id]['pt_show'][$pt_show_key]['participant_girls']            = $pt_show->participant_girls;
                    $pdata['information'][$activity->id]['pt_show'][$pt_show_key]['participant_men']              = $pt_show->participant_men;
                    $pdata['information'][$activity->id]['pt_show'][$pt_show_key]['participant_women']            = $pt_show->participant_women;
                    $pdata['information'][$activity->id]['pt_show'][$pt_show_key]['participant_other_gender']     = $pt_show->participant_other_gender;
                    $pdata['information'][$activity->id]['pt_show'][$pt_show_key]['participant_total']            = $pt_show->participant_total;
                    $pdata['information'][$activity->id]['pt_show'][$pt_show_key]['participant_pwd_boys']         = $pt_show->participant_pwd_boys;
                    $pdata['information'][$activity->id]['pt_show'][$pt_show_key]['participant_pwd_girls']        = $pt_show->participant_pwd_girls;
                    $pdata['information'][$activity->id]['pt_show'][$pt_show_key]['participant_pwd_men']          = $pt_show->participant_pwd_men;
                    $pdata['information'][$activity->id]['pt_show'][$pt_show_key]['participant_pwd_women']        = $pt_show->participant_pwd_women;
                    $pdata['information'][$activity->id]['pt_show'][$pt_show_key]['participant_pwd_other_gender'] = $pt_show->participant_pwd_other_gender;
                    $pdata['information'][$activity->id]['pt_show'][$pt_show_key]['participant_pwd_total']        = $pt_show->participant_pwd_total;
                }
            }
            //PT Production Workshop
            if ($request->category_type == null || $request->category_type == 6) {
                foreach ($activity->pt_production_activity as $pt_production_key => $pt_production) {
                    $pdata['information'][$activity->id]['pt_production'][$pt_production_key]['id']                           = $pt_production->id;
                    $pdata['information'][$activity->id]['pt_production'][$pt_production_key]['category_name']                = "PT Production Workshop";
                    $pdata['information'][$activity->id]['pt_production'][$pt_production_key]['event']                        = @$pt_production->event_name->name;
                    $pdata['information'][$activity->id]['pt_production'][$pt_production_key]['no_of_event']                  = $pt_production->no_of_event;
                    $pdata['information'][$activity->id]['pt_production'][$pt_production_key]['starting_date']                = $pt_production->starting_date;
                    $pdata['information'][$activity->id]['pt_production'][$pt_production_key]['ending_date']                  = $pt_production->ending_date;
                    $pdata['information'][$activity->id]['pt_production'][$pt_production_key]['participant_boys']             = $pt_production->participant_boys;
                    $pdata['information'][$activity->id]['pt_production'][$pt_production_key]['participant_girls']            = $pt_production->participant_girls;
                    $pdata['information'][$activity->id]['pt_production'][$pt_production_key]['participant_men']              = $pt_production->participant_men;
                    $pdata['information'][$activity->id]['pt_production'][$pt_production_key]['participant_women']            = $pt_production->participant_women;
                    $pdata['information'][$activity->id]['pt_production'][$pt_production_key]['participant_other_gender']     = $pt_production->participant_other_gender;
                    $pdata['information'][$activity->id]['pt_production'][$pt_production_key]['participant_total']            = $pt_production->participant_total;
                    $pdata['information'][$activity->id]['pt_production'][$pt_production_key]['participant_pwd_boys']         = $pt_production->participant_pwd_boys;
                    $pdata['information'][$activity->id]['pt_production'][$pt_production_key]['participant_pwd_girls']        = $pt_production->participant_pwd_girls;
                    $pdata['information'][$activity->id]['pt_production'][$pt_production_key]['participant_pwd_men']          = $pt_production->participant_pwd_men;
                    $pdata['information'][$activity->id]['pt_production'][$pt_production_key]['participant_pwd_women']        = $pt_production->participant_pwd_women;
                    $pdata['information'][$activity->id]['pt_production'][$pt_production_key]['participant_pwd_other_gender'] = $pt_production->participant_pwd_other_gender;
                    $pdata['information'][$activity->id]['pt_production'][$pt_production_key]['participant_pwd_total']        = $pt_production->participant_pwd_total;
                }
            }
        }
        // dd($pdata['information']);

        if (!@$pdata['information']) {
            return redirect()->back()->with('error', "There is no data entry found in this search criteria");
        }
        // dd($request->region_id);
        $pdata['region']    = ($request->region_id != "all_zone") ? Region::where('id', $request->region_id)->pluck('region_name')->first() : "All";
        $pdata['division']  = ($request->division_id != null) ? Division::where('id', $request->division_id)->pluck('name')->first() : "";
        $pdata['district']  = ($request->district_id != "all_district") ? District::where('id', $request->district_id)->pluck('name')->first() : "All";
        $pdata['upazila']   = ($request->upazila_id != "all_upazila") ? Upazila::where('id', $request->upazila_id)->pluck('name')->first() : "All";
        $pdata['date']      = date('d-M-Y');
        $pdata['from_date'] = date('d-M-Y', strtotime($request->from_date));
        $pdata['to_date']   = date('d-M-Y', strtotime($request->to_date));
        // dd($pdata);

        if ($request->format_download == 1) {
            $pdf = PDF::loadView('selp.pdf.activity.activity-filter-data-pdf', $pdata, [], ['title' => 'Certificate', 'format' => 'A4-L', 'orientation' => 'L']);
            $pdf->SetProtection(['copy', 'print'], '', 'pass');
            // $fileName =  'Complain_id' .'_'. $data['incident']->id . '.' . 'pdf' ;
            return $pdf->stream('activity-filter-data.pdf');
        } else {
            $view_link = 'selp.excel.activity.activity-filter-data-excel';
            return Excel::download(new MisReportExport($pdata, $view_link), 'activity-filter-data.xlsx');
        }
    }
}
