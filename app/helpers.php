<?php

use App\Model\Admin\Hrm\Holiday;
use App\Model\Admin\Setup\CEP_Region\DistrictManager;
use App\Model\Admin\Setup\CEP_Region\DistrictManagerDetail;
use App\Model\Admin\Setup\CEP_Region\Region;
use App\Model\Admin\Setup\CEP_Region\RegionAreaDetail;
use App\Model\Admin\Setup\CEP_Region\SetupUserArea;
use App\Model\Admin\Setup\CityCorporation;
use App\Model\Admin\Setup\District;
use App\Model\Admin\Setup\Division;
use App\Model\Admin\Setup\OrganizationName;
use App\Model\Admin\Setup\Pourosova;
use App\Model\Admin\Setup\Union;
use App\Model\Admin\Setup\Upazila;
use App\Model\Admin\Setup\Village;
use App\Model\Admin\Setup\ViolenceName;
use App\Model\Admin\Setup\ViolenceSubCategory;
use App\Model\Admin\Vehicle\VehicleRequisition;
use App\Model\Civilcase;
use App\Model\Menu;
use App\Model\MenuPermission;
use App\Model\MenuRoute;
use App\Model\Participant\MealItem;
use App\Model\Pititioncase;
use App\Model\Policecase;
use App\Model\PollisomajSetup;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

if (!function_exists('toRawSql')) {
    function toRawSql($query)
    {
        $format       = $query->toSql();
        $replacements = $query->getBindings();
        $to_raw_sql   = preg_replace_callback('/\?/', function ($matches) use (&$replacements) {
            return array_shift($replacements);
        }, $format);
        dd($to_raw_sql);
    }
}
//login user role
function loginUserRole()
{
    return User::with(['user_role' => function ($q) {
        $q->with('role_details')->select('id', 'role_id', 'user_id');
    }])->select('id', 'name', 'email', 'designation', 'pin', 'mobile')->find(Auth::id());
}

function bn2en($number)
{
    $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "AM", "PM", "am", "pm", "cusec", "litre", "horse", "Jan", "Feb", "Mar", "Apr", "May", "Jun", 'Jul', "Aug", "Sep", "Oct", "Nov", "Dec");
    $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০", "এ.এম", "পি.এম", "এ.এম", "পি.এম", "কিউসেক", "লিটার/সে.", "অশ্বশক্তি", "জানু", "ফেব্রু", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "অগাস্ট", "সেপ্টেম্", "অক্টো", "নভেম্", "ডিসেম্");
    return str_replace($bn, $en, $number);
}

function en2bn($number)
{
    $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "AM", "PM", "am", "pm", "cusec", "litre", "horse", "Jan", "Feb", "Mar", "Apr", "May", "Jun", 'Jul', "Aug", "Sep", "Oct", "Nov", "Dec");
    $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০", "এ.এম", "পি.এম", "এ.এম", "পি.এম", "কিউসেক", "লিটার/সে.", "অশ্বশক্তি", "জানু", "ফেব্রু", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "অগাস্ট", "সেপ্টেম্", "অক্টো", "নভেম্", "ডিসেম্");
    return str_replace($en, $bn, $number);
}

function searchCriteria($query, $data = ['region_id' => null, 'division_id' => null, 'district_id' => null, 'upazila_id' => null, 'from_posting_date' => null, 'to_posting_date' => null, 'from_reporting_date' => null, 'to_reporting_date' => null])
{
    if (@$data['region_id']) {
        // if ($data['division_id']) {
        //     $previousZoneInfo = getPreviousZoneIdsFromDivision($data['division_id']);
        //     if (!empty($previousZoneInfo)) {
        //         // Extract region_ids and date_to values
        //         $regionIds      = array_keys($previousZoneInfo);
        //         //$dateToValues   = array_values($previousZoneInfo);
        //         $updateReigonIds = array_unique(array_merge($regionIds, [(int)$data['region_id']]));
        //     } else {
        //         $updateReigonIds = [(int)$data['region_id']];
        //     }
        //     $query->whereIn('employee_zone_id', $updateReigonIds);
        // } else {
        //     $query->where('employee_zone_id', $data['region_id']);
        // }
        $query->where('employee_zone_id', $data['region_id']);
    } else if (count(session()->get('userareaaccess.sregions')) > 0) {
        $query->whereIn('employee_zone_id', session()->get('userareaaccess.sregions'));
    }

    if (@$data['division_id']) {
        $query->where('employee_division_id', $data['division_id']);
    } else if (count(session()->get('userareaaccess.sdivisions')) > 0) {
        $query->whereIn('employee_division_id', session()->get('userareaaccess.sdivisions'));
    }

    if (@$data['district_id']) {
        $query->where('employee_district_id', $data['district_id']);
    } else if (count(session()->get('userareaaccess.sdistricts')) > 0) {
        $query->whereIn('employee_district_id', session()->get('userareaaccess.sdistricts'));
    }

    if (@$data['upazila_id']) {
        $query->where('employee_upazila_id', $data['upazila_id']);
    } else if (count(session()->get('userareaaccess.supazilas')) > 0) {
        $query->whereIn('employee_upazila_id', session()->get('userareaaccess.supazilas'));
    }

    if (@$data['from_posting_date']) {
        $from_date = date("Y-m-d", strtotime($data['from_posting_date']));
        $query->where('posting_date', '>=', $from_date);
    }
    if (@$data['to_posting_date']) {
        $to_date = date("Y-m-d", strtotime($data['to_posting_date']));
        $query->where('posting_date', '<=', $to_date);
    }

    if (@$data['from_reporting_date']) {
        $from_date = date("Y-m-d", strtotime($data['from_reporting_date']));
        $query->where('reporting_date', '>=', $from_date);
    }
    if (@$data['to_reporting_date']) {
        $to_date = date("Y-m-d", strtotime($data['to_reporting_date']));
        $query->where('reporting_date', '<=', $to_date);
    }
    if (@$data['from_start_date']) {
        $from_date = date("Y-m-d", strtotime($data['from_start_date']));
        $query->where('start_date', '>=', $from_date);
    }
    if (@$data['to_start_date']) {
        $to_date = date("Y-m-d", strtotime($data['to_start_date']));
        $query->where('start_date', '<=', $to_date);
    }
    if (@$data['group_id']) {
        $query->where('group_id', $data['group_id']);
    }
    if (@$data['group_status']) {
        $query->where('group_status', $data['group_status']);
    }
    if (@$data['profile_union']) {
        $query->where('union_id', $data['profile_union']);
    }
    if (@$data['profile_village']) {
        $query->where('village_id', $data['profile_village']);
    }
    return $query;
}

function searchCriteriaPollishomaj($query, $data = ['region_id' => null, 'division_id' => null, 'district_id' => null, 'upazila_id' => null, 'from_date' => null, 'to_date' => null])
{
    if (@$data['region_id']) {
        $query->where('zone_id', $data['region_id']);
    } else if (count(session()->get('userareaaccess.sregions')) > 0) {
        $query->whereIn('zone_id', session()->get('userareaaccess.sregions'));
    }

    if (@$data['division_id']) {
        $query->where('division_id', $data['division_id']);
    } else if (count(session()->get('userareaaccess.sdivisions')) > 0) {
        $query->whereIn('division_id', session()->get('userareaaccess.sdivisions'));
    }

    if (@$data['district_id']) {
        $query->where('district_id', $data['district_id']);
    } else if (count(session()->get('userareaaccess.sdistricts')) > 0) {
        $query->whereIn('district_id', session()->get('userareaaccess.sdistricts'));
    }

    if (@$data['upazila_id']) {
        $query->where('upazilla_id', $data['upazila_id']);
    } else if (count(session()->get('userareaaccess.supazilas')) > 0) {
        $query->whereIn('upazilla_id', session()->get('userareaaccess.supazilas'));
    }

    if (@$data['from_date']) {
        $from_date = date("Y-m-d", strtotime($data['from_date']));
        $query->where('reporting_date', '>=', $from_date);
    }
    if (@$data['to_date']) {
        $to_date = date("Y-m-d", strtotime($data['to_date']));
        $query->where('reporting_date', '<=', $to_date);
    }
    return $query;
}

function searchCriteriaSwapnosarothi($query, $data = ['region_id' => null, 'division_id' => null, 'district_id' => null, 'upazila_id' => null, 'from_date' => null, 'to_date' => null])
{
    if (@$data['region_id']) {
        $query->where('zone_id', $data['region_id']);
    } else if (count(session()->get('userareaaccess.sregions')) > 0) {
        $query->whereIn('zone_id', session()->get('userareaaccess.sregions'));
    }

    if (@$data['division_id']) {
        $query->where('division_id', $data['division_id']);
    } else if (count(session()->get('userareaaccess.sdivisions')) > 0) {
        $query->whereIn('division_id', session()->get('userareaaccess.sdivisions'));
    }

    if (@$data['district_id']) {
        $query->where('district_id', $data['district_id']);
    } else if (count(session()->get('userareaaccess.sdistricts')) > 0) {
        $query->whereIn('district_id', session()->get('userareaaccess.sdistricts'));
    }

    if (@$data['upazila_id']) {
        $query->where('upazila_id', $data['upazila_id']);
    } else if (count(session()->get('userareaaccess.supazilas')) > 0) {
        $query->whereIn('upazila_id', session()->get('userareaaccess.supazilas'));
    }

    if (@$data['from_date']) {
        $from_date = date("Y-m-d", strtotime($data['from_date']));
        $query->where('start_date', '>=', $from_date);
    }
    if (@$data['to_date']) {
        $to_date = date("Y-m-d", strtotime($data['to_date']));
        $query->where('end_date', '<=', $to_date);
    }
    return $query;
}

function searchCriteriaSwapnosarothiProfile(
    $query,
    $data = [
        'region_id'             => null,
        'division_id'           => null,
        'district_id'           => null,
        'upazila_id'            => null,
        'from_posting_date'     => null,
        'to_posting_date'       => null,
        'from_reporting_date'   => null,
        'to_reporting_date'     => null,
        'from_start_date'       => null,
        'to_start_date'         => null,
        'group_id'              => null,
        'group_status'          => null,
        'profile_union'         => null,
        'profile_village'       => null,
        'status'                => null
    ]
) {

    $division_id    = $data['division_id'];
    $district_id    = $data['district_id'];
    $upazila_id     = $data['upazila_id'];
    $union_id       = @$data['profile_union'];
    $village_id     = @$data['profile_village'];
    $status         = @$data['status'];

    $s_regions      = session()->get('userareaaccess.sregions');
    $s_divisions    = session()->get('userareaaccess.sdivisions');
    $s_districts    = session()->get('userareaaccess.sdistricts');
    $s_upazilas     = session()->get('userareaaccess.supazilas');
    $s_unions       = session()->get('userareaaccess.sunions');

    if ($data['region_id']) {
        $query->where('employee_zone_id', $data['region_id']);
    } else if (count($s_regions) > 0) {
        $query->whereIn('employee_zone_id', $s_regions);
    }

    if ($division_id) {
        $query->where('employee_division_id', $division_id);
    } else if (count($s_divisions) > 0) {
        $query->whereIn('employee_division_id', $s_divisions);
    }

    if ($district_id) {
        $query->where('employee_district_id', $district_id);
    } else if (count($s_districts) > 0) {
        $query->whereIn('employee_district_id', $s_districts);
    }

    if ($upazila_id) {
        $query->where('employee_upazila_id', $upazila_id);
    } else if (count($s_upazilas) > 0) {
        $query->whereIn('employee_upazila_id', $s_upazilas);
    }

    if (@$data['from_posting_date']) {
        $from_date = date("Y-m-d", strtotime($data['from_posting_date']));
        $query->where('posting_date', '>=', $from_date);
    }
    if (@$data['to_posting_date']) {
        $to_date = date("Y-m-d", strtotime($data['to_posting_date']));
        $query->where('posting_date', '<=', $to_date);
    }

    if (@$data['from_reporting_date']) {
        $from_date = date("Y-m-d", strtotime($data['from_reporting_date']));
        $query->where('reporting_date', '>=', $from_date);
    }
    if (@$data['to_reporting_date']) {
        $to_date = date("Y-m-d", strtotime($data['to_reporting_date']));
        $query->where('reporting_date', '<=', $to_date);
    }
    if (@$data['from_start_date']) {
        $from_date = date("Y-m-d", strtotime($data['from_start_date']));
        $query->where('start_date', '>=', $from_date);
    }
    if (@$data['to_start_date']) {
        $to_date = date("Y-m-d", strtotime($data['to_start_date']));
        $query->where('start_date', '<=', $to_date);
    }
    if (@$data['group_id']) {
        $query->where('group_id', $data['group_id']);
    }
    if (@$data['group_status']) {
        $query->where('group_status', $data['group_status']);
    }

    if ($union_id) {
        $query->where('union_id', $union_id);
    } else if (count($s_unions) > 0) {
        $query->whereIn('union_id', $s_unions);
    }

    if ($village_id) {
        $query->where('village_id', $village_id);
    }

    return $query;
}

function searchCriteriaPreviousSwapnosarothiProfile(
    $query,
    $data = [
        'previous_zone_info'    => [],
        'division_id'           => null,
        'district_id'           => null,
        'upazila_id'            => null,
        'group_id'              => null,
        'group_status'          => null,
        'profile_union'         => null,
        'profile_village'       => null,
        'status'                => null
    ]
) {

    $previous_zone_info = $data['previous_zone_info'];
    $division_id        = $data['division_id'];
    $district_id        = $data['district_id'];
    $upazila_id         = $data['upazila_id'];
    $union_id           = @$data['profile_union'];
    $village_id         = @$data['profile_village'];
    $status             = @$data['status'];

    $s_divisions    = session()->get('userareaaccess.sdivisions');
    $s_districts    = session()->get('userareaaccess.sdistricts');
    $s_upazilas     = session()->get('userareaaccess.supazilas');
    $s_unions       = session()->get('userareaaccess.sunions');

    if ($previous_zone_info) {
        $query->where(function ($query) use ($previous_zone_info, $status) {
            foreach ($previous_zone_info as $regionId => $dateTo) {
                $query->orWhere(function ($subquery) use ($regionId, $dateTo, $status) {
                    $subquery->where('employee_zone_id', $regionId)->where('created_at', '<=', $dateTo)->where('status', $status);
                });
            }
        });
    }else{
        return $query;
    }

    if ($division_id) {
        $query->where('employee_division_id', $division_id);
    } else if (count($s_divisions) > 0) {
        $query->whereIn('employee_division_id', $s_divisions);
    }

    if ($district_id) {
        $query->where('employee_district_id', $district_id);
    } else if (count($s_districts) > 0) {
        $query->whereIn('employee_district_id', $s_districts);
    }

    if ($upazila_id) {
        $query->where('employee_upazila_id', $upazila_id);
    } else if (count($s_upazilas) > 0) {
        $query->whereIn('employee_upazila_id', $s_upazilas);
    }

    if (@$data['group_id']) {
        $query->where('group_id', $data['group_id']);
    }
    if (@$data['group_status']) {
        $query->where('group_status', $data['group_status']);
    }

    if ($union_id) {
        $query->where('union_id', $union_id);
    } else if (count($s_unions) > 0) {
        $query->whereIn('union_id', $s_unions);
    }

    if ($village_id) {
        $query->where('village_id', $village_id);
    }

    return $query;
}

function getPreviousZoneIdsFromDivision($divisionId, $currentZone = null)
{
    $prev_zone = RegionAreaDetail::where('division_id', $divisionId)
        ->where('status', '1')
        ->when($currentZone, function ($query, $currentZone) {
            $query->where('region_id', '!=', $currentZone);
        })
        ->whereNotNull('date_to')
        ->withTrashed()
        ->get();

    // Extract distinct region_id values from the result
    $distinctRegionIds = $prev_zone->pluck('date_to', 'region_id')->unique()->toArray();

    return $distinctRegionIds;
}

function applyRegionConditions($query, $regionId, $dateTo, $status, $division_id)
{
    return $query->orWhere(function ($query) use ($regionId, $dateTo, $status, $division_id) {
        $query->where('employee_zone_id', $regionId)
            ->where('employee_division_id', $division_id)
            ->whereIn('employee_district_id', session()->get('userareaaccess.sdistricts'))
            ->whereIn('employee_upazila_id', session()->get('userareaaccess.supazilas'))
            ->where('created_at', '<=', $dateTo)
            ->where('status', $status);
    });
}


function checkCurrentRegion($region_id, $selpIncident)
{

    if (count($selpIncident) > 0) {
        if ($region_id == $selpIncident[0]->employee_zone_id) {
            return 'selected';
        }
    }
    return 'asdas';
}

function checkCurrentPollisomajRegion($region_id, $pollisomajData)
{

    if (count($pollisomajData) > 0) {
        if ($region_id == $pollisomajData[0]->zone_id) {
            return 'selected';
        }
    }
    return 'asdas';
}

function getUserDivisions($region_id = '', $user_division_list = array())
{
    if (count(session()->get('userareaaccess.sdivisions')) != 0) {
        $allDivision = RegionAreaDetail::with(['regional_division'])->whereIn('division_id', session()->get('userareaaccess.sdivisions'))->where('region_id', $region_id)->where('status', '1')->groupBy('division_id')->get();
    } else {
        $allDivision = RegionAreaDetail::with(['regional_division'])->where('region_id', $region_id)->where('status', '1')->groupBy('division_id')->get();
    }

    $area_division_id = [];
    $html             = '<option value="">Select Division</option>';
    foreach ($allDivision as $area) {
        // $html .='<option value="'.$area->regional_division->id.'">'.$area->regional_division->name.'</option>';
        if (!in_array($area->division_id, $area_division_id)) {
            if ($area->regional_division->id == $area->regional_division->id) {
                $select = 'selected';
            } else {
                $select = '';
            }
            $html .= '<option value="' . $area->regional_division->id . '" ' . $select . '>' . $area->regional_division->name . '</option>';
            // $html .= '<option value="' . $area->regional_division->id . '">' . $area->regional_division->name . '</option>';
        }

        $area_division_id[] = $area->division_id;
    }
    return $html;
}

function getRegionByUserType()
{
    $groupByZone = SetupUserArea::where('user_id', Auth::id())->whereNull('date_to')->pluck('region_id');

    $admin_role_i = loginUserRole()->user_role->pluck('role_id')->toArray();
    if ($admin_role_i[0] != 5 && $admin_role_i[0] != 4 && $admin_role_i[0] != 3) {

        $regions = Region::where('status', '1')->get();
    } else {

        $regions = Region::where('status', '1')->whereIn('id', array_unique($groupByZone->toArray()))->get();
    }
    return $regions;
}
function getRegionalDivision($region_id = '', $division_id = '')
{
    // $region_area = RegionAreaDetail::with(['regional_division'])
    //     ->where(['region_id' => $region_id])
    //     ->where(['status' => 1])
    //     ->get();

    $groupByDivision = SetupUserArea::where('user_id', Auth::id())->pluck('division_id')->toArray();

    $admin_role_i = loginUserRole()->user_role->pluck('role_id')->toArray();
    if ($admin_role_i[0] != 5 && $admin_role_i[0] != 4) {
        $region_area = RegionAreaDetail::with(['regional_division'])
            ->where(['region_id' => $region_id])
            ->where(['status' => 1])
            ->get();
    } else {
        $region_area = RegionAreaDetail::with(['regional_division'])
            ->where(['region_id' => $region_id])
            ->whereIn('division_id', array_unique($groupByDivision))
            ->where(['status' => 1])
            ->get();
    }

    //dd($region_area->toArray());

    $area_division_id = [];

    $html = '<option value="">Select Division</option>';
    foreach ($region_area as $area) {
        if (!in_array($area->division_id, $area_division_id)) {
            if ($area->division_id == $division_id) {
                $select = 'selected';
            } else {
                $select = '';
            }
            $html .= '<option value="' . $area->regional_division->id . '" ' . $select . '>' . $area->regional_division->name . '</option>';
        }

        $area_division_id[] = $area->division_id;
    }

    // dd($area_division_id);
    return $html;
}

function getRegionalDivisionManager($region_id = '', $division_manager_id = '')
{
    $division_managers = DistrictManager::where(['region_id' => $region_id])
        ->orderBy('id', 'ASC')
        ->get();
    // dd($division_managers->toArray());

    $html = '<option value="">Select District Manager</option>';
    foreach ($division_managers as $division_manager) {
        if ($division_manager->id == $division_manager_id) {
            $select = 'selected';
        } else {
            $select = '';
        }
        $html .= '<option value="' . $division_manager->id . '" ' . $select . '>' . $division_manager->employee_name . '</option>';
    }

    return $html;
}

function getDistrictManagerDivision($district_manager_id = '', $division_id = '')
{
    $district_manager_divisions = DistrictManagerDetail::with(['manager_division'])
        ->where(['district_manager_id' => $district_manager_id])
        ->orderBy('id', 'ASC')
        ->get();

    // dd($district_manager_divisions->toArray());

    $area_division_id = '';
    $html             = '<option value="">Select Division</option>';
    foreach ($district_manager_divisions as $district_manager_division) {
        if ($area_division_id != $district_manager_division->division_id) {
            if ($district_manager_division->id == $division_id) {
                $select = 'selected';
            } else {
                $select = '';
            }
            $html .= '<option value="' . $district_manager_division->division_id . '" ' . $select . '>' . $district_manager_division->manager_division->name . '</option>';
        }

        $area_division_id = $district_manager_division->division_id;
    }

    return $html;
}

function getDistrictUpazila($district_id, $upazila_id = '')
{
    $upazilas = Upazila::where(['district_id' => $district_id])
        ->orderBy('id', 'ASC')
        ->get();

    $html = '<option value="">Select Upazila</option>';
    foreach ($upazilas as $upazila) {
        if ($upazila->id == $upazila_id) {
            $select = 'selected';
        } else {
            $select = '';
        }
        $html .= '<option value="' . $upazila->id . '" ' . $select . '>' . $upazila->name . '</option>';
    }

    return $html;
}

function getUpazilaUnion($upazila_id, $union_id = '')
{
    $unions = Union::where(['upazila_id' => $upazila_id])
        ->orderBy('id', 'ASC')
        ->get();

    $html = '<option value="">Select Union</option>';
    foreach ($unions as $union) {
        if ($union->id == $union_id) {
            $select = 'selected';
        } else {
            $select = '';
        }
        $html .= '<option value="' . $union->id . '" ' . $select . '>' . $union->name . '</option>';
    }

    return $html;
}

function getUpazilaPollisomaj($upazila_id, $union_id = '', $pollisomaj_id = '')
{
    $arr         = array($upazila_id, $union_id);
    $pollisomajs = PollisomajSetup::when($arr, function ($query, $arr) {
        if ($arr[1] != null) {
            $query->where('union_id', $arr[1]);
        } else {
            $query->where('upazila_id', $arr[0]);
        }
    })
        ->orderBy('id', 'ASC')
        ->get();
    $html = '<option value="">Select Pollisomaj</option>';
    foreach ($pollisomajs as $pollisomaj) {
        if ($pollisomaj->id == $pollisomaj_id) {
            $select = 'selected';
        } else {
            $select = '';
        }
        $html .= '<option value="' . $pollisomaj->pollisomaj_no . '" ' . $select . '>' . $pollisomaj->pollisomaj_no . '</option>';
    }

    return $html;
}

function getUnionVillage($union_id, $village_id = '')
{
    $villages = Village::where(['union_id' => $union_id])
        ->orderBy('id', 'ASC')
        ->get();

    $html = '<option value="">Select Village</option>';
    foreach ($villages as $village) {
        if ($village->id == $village_id) {
            $select = 'selected';
        } else {
            $select = '';
        }
        $html .= '<option value="' . $village->id . '" ' . $select . '>' . $village->name . '</option>';
    }

    return $html;
}

function getRegionalDivisionDistrict($region_id = '', $division_id = '', $district_id = '')
{
    $groupByDistrict = SetupUserArea::where('user_id', Auth::id())->pluck('district_id')->toArray();

    $admin_role_i = loginUserRole()->user_role->pluck('role_id')->toArray();
    if ($admin_role_i[0] != 5 && $admin_role_i[0] != 4) {
        $region_area = RegionAreaDetail::with(['regional_district'])
            ->where(['region_id' => $region_id, 'division_id' => $division_id])
            ->get();
    } else {
        $region_area = RegionAreaDetail::with(['regional_district'])
            ->where(['region_id' => $region_id, 'division_id' => $division_id])
            ->whereIn('district_id', array_unique($groupByDistrict))
            ->get();
    }

    //dd($region_area->toArray());

    $area_district_id = '';
    $html             = '<option value="">Select District</option>';
    foreach ($region_area as $area) {
        if ($area_district_id != $area->regional_district['id']) {
            if ($area->regional_district['id'] == $district_id) {
                $select = 'selected';
            } else {
                $select = '';
            }
            $html .= '<option value="' . $area->regional_district['id'] . '" ' . $select . '>' . $area->regional_district['name'] . '</option>';
        }

        $area_district_id = $area->regional_district['id'];
    }

    return $html;
}

function getRegionalDivisionDistrictUpazila($region_id = '', $division_id = '', $district_id = '')
{
    $region_area = SetupUserArea::where(['user_id' => Auth::id(), 'region_id' => $region_id, 'division_id' => $division_id, 'district_id' => $district_id])
        ->get();

    //dd($region_area->toArray());

    $area_district_id = '';
    $html             = '<option value="">Select District</option>';
    foreach ($region_area as $area) {
        if ($area_district_id != $area->regional_district['id']) {
            if ($area->regional_district['id'] == $district_id) {
                $select = 'selected';
            } else {
                $select = '';
            }
            $html .= '<option value="' . $area->regional_district['id'] . '" ' . $select . '>' . $area->regional_district['name'] . '</option>';
        }

        $area_district_id = $area->regional_district['id'];
    }

    return $html;
}

function getdivision($division_id = null)
{
    $divisions = Division::where([['id', $division_id], ['status', '1']])->get();
    $html      = '<option value="">Select District</option>';
    foreach ($divisions as $division) {
        if ($division['id'] == $division_id) {
            $select = 'selected';
        } else {
            $select = '';
        }
        $html .= '<option value="' . $division['id'] . '" ' . $select . '>' . $division['name'] . '</option>';
    }

    return $html;
}
function getdistrict($division_id = null, $district_id = null)
{
    $districts = District::where([['division_id', $division_id], ['status', '1']])->get();
    $html      = '<option value="">Select District</option>';
    foreach ($districts as $district) {
        if ($district['id'] == $district_id) {
            $select = 'selected';
        } else {
            $select = '';
        }
        $html .= '<option value="' . $district['id'] . '" ' . $select . '>' . $district['name'] . '</option>';
    }

    return $html;
}

function getupazila($district_id = null, $upazila_id = null)
{
    // dd(array($district_id,$upazila_id));
    $groupByUpazila = SetupUserArea::where('user_id', Auth::id())->pluck('upazila_id')->toArray();
    $admin_role_i   = loginUserRole()->user_role->pluck('role_id')->toArray();
    if ($admin_role_i[0] != 5) {

        $upazilas = Upazila::where([['district_id', $district_id], ['status', '1']])->get();
    } else {
        $upazilas = Upazila::where([['district_id', $district_id], ['status', '1']])
            ->whereIn('id', array_unique($groupByUpazila))
            ->get();
    }

    $html = '<option value="">Select Upazila</option>';
    foreach ($upazilas as $upazila) {
        if ($upazila['id'] == $upazila_id) {
            $select = 'selected';
        } else {
            $select = '';
        }
        $html .= '<option value="' . $upazila['id'] . '" ' . $select . '>' . $upazila['name'] . '</option>';
    }

    return $html;
}

function getunion($upazila_id = null, $union_id = null)
{
    $unions = Union::where([['upazila_id', $upazila_id], ['status', '1']])->get();
    $html   = '<option value="">Select Union</option>';
    foreach ($unions as $union) {
        if ($union['id'] == $union_id) {
            $select = 'selected';
        } else {
            $select = '';
        }
        $html .= '<option value="' . $union['id'] . '" ' . $select . '>' . $union['name'] . '</option>';
    }

    return $html;
}

function getvillage($union_id = null, $village_id = null)
{

    $villages = Village::where('union_id', $union_id)->get();
    //return $villages;
    $html = '<option value="">Select Village</option>';
    foreach ($villages as $village) {
        if ($village['id'] == $village_id) {
            $select = 'selected';
        } else {
            $select = '';
        }
        $html .= '<option value="' . $village['id'] . '" ' . $select . '>' . $village['name'] . '</option>';
    }

    return $html;
}

function getcitycorporation($division_id = null, $city_corporation_id = null)
{
    $citycorporations = CityCorporation::where([['division_id', $division_id], ['status', '1']])->get();
    $html             = '';
    foreach ($citycorporations as $citycorporation) {
        if ($citycorporation['id'] == $city_corporation_id) {
            $select = 'selected';
        } else {
            $select = '';
        }
        $html .= '<option value="' . $citycorporation['id'] . '" ' . $select . '>' . $citycorporation['name'] . '</option>';
    }

    return $html;
}

function getpourosova($district_id = null, $pourosova_id = null)
{
    $pourosovas = Pourosova::where([['district_id', $district_id], ['status', '1']])->get();
    $html       = '';
    foreach ($pourosovas as $pourosova) {
        if ($pourosova['id'] == $pourosova_id) {
            $select = 'selected';
        } else {
            $select = '';
        }
        $html .= '<option value="' . $pourosova['id'] . '" ' . $select . '>' . $pourosova['name'] . '</option>';
    }

    return $html;
}

function getorganizationname($support_organization_id = null, $organization_name_id = null)
{
    $organization_names = OrganizationName::where([['support_organization_id', $support_organization_id], ['status', '1']])->get();
    $html               = '';
    foreach ($organization_names as $organization) {
        if ($organization['id'] == $organization_name_id) {
            $select = 'selected';
        } else {
            $select = '';
        }
        $html .= '<option value="' . $organization['id'] . '" ' . $select . '>' . $organization['name'] . '</option>';
    }

    return $html;
}

function violencesubcat($violence_category_id = null, $violence_sub_category_id = null)
{
    $violencesubcats = ViolenceSubCategory::where([['violence_category_id', $violence_category_id], ['status', '1']])->get();
    $html            = '';
    foreach ($violencesubcats as $subcat) {
        if ($subcat['id'] == $violence_sub_category_id) {
            $select = 'selected';
        } else {
            $select = '';
        }
        $html .= '<option value="' . $subcat['id'] . '" ' . $select . '>' . $subcat['name'] . '</option>';
    }

    return $html;
}

function violencename($violence_sub_category_id = null, $violence_name_id = null)
{
    $violencenames = ViolenceName::where([['violence_sub_category_id', $violence_sub_category_id], ['status', '1']])->get();
    $html          = '';
    foreach ($violencenames as $vname) {
        if ($vname['id'] == $violence_name_id) {
            $select = 'selected';
        } else {
            $select = '';
        }
        $html .= '<option value="' . $vname['id'] . '" ' . $select . '>' . $vname['name'] . '</option>';
    }

    return $html;
}

function vehicle_requisition_time($registration_no, $report_time, $release_time)
{
    $report_date              = date('Y-m-d', strtotime($report_time));
    $requisition_vehicle_info = VehicleRequisition::where('assigned_vehicle', $registration_no)
        ->whereDate('report_time', $report_date)
        ->get();

    // dd($requisition_vehicle_info->toArray());

    $count = 0;
    foreach ($requisition_vehicle_info as $key => $info) {
        if ($info->assigned_vehicle == $registration_no) {
            $info_report_time     = date('Y-m-d h:m a', strtotime($info->report_time));
            $info_release_time    = date('Y-m-d h:m a', strtotime($info->release_time));
            $vehicle_report_time  = date('Y-m-d h:m a', strtotime($report_time));
            $vehicle_release_time = date('Y-m-d h:m a', strtotime($release_time));

            if ($info_report_time >= $vehicle_report_time && $info_release_time <= $vehicle_release_time) {
                $count++;
            }
        }
    }

    return $count;
}

function vehicle_requisition_info($registration_no, $report_time, $release_time)
{
    $report_date              = date('Y-m-d', strtotime($report_time));
    $requisition_vehicle_info = VehicleRequisition::where('assigned_vehicle', $registration_no)
        ->whereDate('report_time', $report_date)
        ->get();

    // dd($requisition_vehicle_info->toArray());

    return $requisition_vehicle_info;
}

function mealitemlist($text)
{
    $html = [];
    foreach ($text as $v) {
        $itemname = MealItem::where('id', $v->meal_item_id)->first();
        $html[]   = $itemname->name;
    }
    return $textoutput = implode(',', $html);
}

function totalmealsum($text)
{
    $html = [];
    foreach ($text as $v) {
        $html[] = $v->price;
    }
    return $textoutput = array_sum($html);
}

function participantlevel($data)
{
    $html = [];
    foreach ($data as $value) {
        $participant = App\Model\Admin\Training\TrainingParticipantLevel::select('name')->where('id', $value->participant_level_id)->get();
        $html[]      = $participant[0]->name;
    }
    return implode(',', $html);
}

function dressimpl($data)
{
    $html = [];
    foreach ($data as $v) {
        $html[] = $v->dress_id;
    }
    return implode(',', $html);
}

function spancount($data, $singledata, $select_id)
{
    $html = [];
    foreach ($data as $v) {
        if ($singledata == $v->$select_id) {
            $html[] = $v->$select_id;
        }
    }
    return count($html);
}

function deleteaccess($checktable, $select_column, $select_id)
{
    return $checkdata = DB::table($checktable)->where($select_column, $select_id)->first();
}

function markcount($data, $tb_column)
{
    $html = 0;
    foreach ($data as $v) {
        $html += (int) $v->$tb_column;
    }
    return $html;
}

function crudpermission($route)
{

    $auth_user = User::with(['setup_user_area'])->where('id', Auth::id())->first();
    $user_role = $auth_user->user_role[0]['role_id'];
    // $user_role = Auth::user()->role;
    // if (Auth::user()->id =='1'){
    if ($auth_user->user_role[0]['role_id'] == '1') {
        return 'success';
    } else {
        $mainmenu      = Menu::where('route', $route)->first();
        $mainmenuroute = MenuRoute::where('route', $route)->first();
        if ($mainmenu != null || $mainmenuroute != null) {
            $permission = MenuPermission::whereIn('role_id', $user_role)->where('permitted_route', $route)->first();
            if ($permission) {
                return 'success';
            } else {
                return '';
            }
        } else {
            return 'success';
        }
    }

    $mainmenuroute = MenuRoute::where('route', $route)->first();
    if ($mainmenu != null || $mainmenuroute != null) {
        $permission = MenuPermission::whereIn('role_id', $user_role)->where('permitted_route', $route)->first();
        if ($permission) {
            $request->session()->put('title', @$title->name);
            return $next($request);
        } else {
            $request->session()->put('title', @$title->name);
            return redirect()->back()->with('error', 'Access Permission Denied');
        }
    } else {
        $request->session()->put('title', @$title->name);
        return $next($request);
    }

    if (Auth::user()->role == '0') {
        $menus = App\Model\MenuPermission::get();
    } else {
        $menus = App\Model\MenuPermission::where([['permitted_route', $route], ['role_id', $auth_user->user_role[0]['role_id']]])->first();
    }
    return $menus;
}

function getWorkingDays($begin, $end)
{
    if ($begin > $end) {
        echo "start_date is in the future! <br />";
        return 0;
    } else {
        $no_days  = 0;
        $weekends = 0;
        $holiday  = Holiday::where('holiday_date', '>=', date('y-m-d', $begin))
            ->where('holiday_date', '<=', date('y-m-d', $end))->get();
        $totalHoliday = count($holiday);
        while ($begin <= $end) {
            $no_days++; // no of days in the given interval
            $what_day = date("N", $begin);
            if ($what_day > 5) { // 6 and 7 are weekend days
                $weekends++;
            };
            $begin += 86400; // +1 day
        };
        $notWorkingDays = $totalHoliday + $weekends;
        $working_days   = $no_days - $notWorkingDays;
        return $working_days;
    }
}

function getTrainerhelper($trainer_type)
{
    $trainer_type    = $trainer_type;
    $getguestspeaker = App\User::where([['status', '1'], ['usertype', 'guestspeaker']])->get();
    $getfaculty      = App\User::where([['status', '1'], ['usertype', 'admin']])->get();
    $getorganize     = App\User::where([['status', '1'], ['usertype', 'organization']])->get();
    if ($trainer_type == "Guest Speaker") {
        return $getguestspeaker;
    } else if ($trainer_type == "Faculty") {
        return $getfaculty;
    } else if ($trainer_type == "Organization") {
        return $getorganize;
    }
}

function getVenuehelper($building_id)
{
    $building_id = $building_id;
    $getvenue    = App\Model\Admin\Training\TrainingVenue::where('building_id', $building_id)->get();
    return $getvenue;
}

function dressname($data)
{
    $html = [];
    foreach ($data as $v) {
        $html[] = $v['dress']['name'];
    }
    return implode(', ', $html);
}

function sendMail($data)
{
    Mail::send($data['page'], $data, function ($message) use ($data) {
        $message->from('bcsaa.bd@gmail.com', 'BCSAA');
        $message->to($data['email_to']);
        $message->subject($data['subject']);
    });
    return true;
}

function smssend($phone, $messages)
{
    $expo    = explode(' ', $messages);
    $message = implode('%20', $expo);
    $url     = "https://api.mobireach.com.bd/SendTextMessage?Username=nano&Password=Robi@12345&From=8801847050021&To=$phone&Message=$message";
    $ch      = curl_init();
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/xml; charset=utf-8"));
    $contents = curl_exec($ch);
    curl_close($ch);
    $contents = ltrim(rtrim(trim(strip_tags(trim(preg_replace("/\s\s+/", " ", html_entity_decode($contents)))), "\n\t\r\h\v\0 ")), "%20");
    return $contents;
}

function existcourse($table, $presentstatus, $filter)
{
    if ($presentstatus == 'rrunning') {
        if ($filter == 'yes') {
            if ($table == 'training_batches') {
                return $courses = DB::table('training_batches')
                    ->selectRaw('training_courses.*')
                    ->groupBy('training_batches.course_id')
                    ->leftJoin('training_courses', 'training_courses.id', '=', 'training_batches.course_id')
                    ->where([['training_batches.registration_start_date', '<=', date('Y-m-d')], ['training_batches.end_date', '>=', date('Y-m-d')]])
                    ->get();
            } else {
                return $courses = DB::table($table)
                    ->selectRaw('training_courses.*')
                    ->groupBy($table . '.course_id')
                    ->leftJoin('training_courses', 'training_courses.id', '=', $table . '.course_id')
                    ->leftJoin('training_batches', 'training_batches.course_id', '=', 'training_courses.id')
                    ->where([['training_batches.registration_start_date', '<=', date('Y-m-d')], ['training_batches.end_date', '>=', date('Y-m-d')]])
                    ->get();
            }
        } else {
            return $courses = DB::table('training_batches')
                ->selectRaw('training_courses.*')
                ->groupBy('training_batches.course_id')
                ->leftJoin('training_courses', 'training_courses.id', '=', 'training_batches.course_id')
                ->where([['training_batches.registration_start_date', '<=', date('Y-m-d')], ['training_batches.end_date', '>=', date('Y-m-d')]])
                ->get();
        }
    } else {
        if ($filter == 'yyes') {
            return $courses = DB::table($table)
                ->selectRaw('training_courses.*')
                ->groupBy($table . '.course_id')
                ->leftJoin('training_courses', 'training_courses.id', '=', $table . '.course_id')
                ->get();
        } else {
            return $courses = DB::table('training_courses')
                ->selectRaw('training_courses.*')
                ->get();
        }
    }
}

function existbatch($table, $data, $presentstatus, $filter)
{
    if ($presentstatus == 'rrunning') {
        if ($filter == 'yes') {
            return $batches = DB::table($table)
                ->selectRaw('training_batches.*')
                ->groupBy($table . '.batch_id')
                ->leftJoin('training_batches', 'training_batches.id', '=', $table . '.batch_id')
                ->where('training_batches.course_id', $data)
                ->where([['training_batches.registration_start_date', '<=', date('Y-m-d')], ['training_batches.end_date', '>=', date('Y-m-d')], ['training_batches.status', '1']])
                ->get();
        } else {
            return $batches = DB::table('training_batches')
                ->selectRaw('*')
                ->where('course_id', $data)
                ->where([['registration_start_date', '<=', date('Y-m-d')], ['end_date', '>=', date('Y-m-d')], ['training_batches.status', '1']])
                ->get();
        }
    } else {
        if ($filter == 'yyes') {
            return $batches = DB::table($table)
                ->selectRaw('training_batches.*')
                ->groupBy($table . '.batch_id')
                ->leftJoin('training_batches', 'training_batches.id', '=', $table . '.batch_id')
                ->where([['training_batches.course_id', $data], ['training_batches.status', '1']])
                ->get();
        } else {
            return $batches = DB::table('training_batches')
                ->selectRaw('*')
                ->where([['course_id', $data], ['status', '1']])
                ->get();
        }
    }
}

function existmodule($table, $data, $presentstatus, $filter)
{
    if ($presentstatus == 'rrunning') {
        if ($filter == 'yes') {
            return $modules = DB::table($table)
                ->selectRaw('training_course_modules.*')
                ->groupBy($table . '.module_id')
                ->leftJoin('training_course_modules', 'training_course_modules.id', '=', $table . '.module_id')
                ->where('training_course_modules.batch_id', $data)
                ->leftJoin('training_batches', 'training_batches.id', '=', 'training_course_modules.batch_id')
                ->where([['training_batches.registration_start_date', '<=', date('Y-m-d')], ['training_batches.end_date', '>=', date('Y-m-d')]])
                ->get();
        } else {
            return $modules = DB::table('training_course_modules')
                ->selectRaw('training_course_modules.*')
                ->where('training_course_modules.batch_id', $data)
                ->leftJoin('training_batches', 'training_batches.id', '=', 'training_course_modules.batch_id')
                ->where([['training_batches.registration_start_date', '<=', date('Y-m-d')], ['training_batches.end_date', '>=', date('Y-m-d')]])
                ->get();
        }
    } else {
        if ($filter == 'yyes') {
            return $modules = DB::table($table)
                ->selectRaw('training_course_modules.*')
                ->groupBy($table . '.module_id')
                ->leftJoin('training_course_modules', 'training_course_modules.id', '=', $table . '.module_id')
                ->where('training_course_modules.batch_id', $data)
                ->get();
        } else {
            return $modules = DB::table('training_course_modules')
                ->selectRaw('*')
                ->where('batch_id', $data)
                ->get();
        }
    }
}

function existsession($table, $data, $presentstatus, $filter)
{
    if ($presentstatus == 'rrunning') {
        if ($filter == 'yes') {
            return $sessions = DB::table($table)
                ->selectRaw('training_sessions.*')
                ->groupBy($table . '.session_id')
                ->leftJoin('training_sessions', 'training_sessions.id', '=', $table . '.session_id')
                ->where('training_sessions.module_id', $data)
                ->leftJoin('training_batches', 'training_batches.id', '=', 'training_sessions.batch_id')
                ->where([['training_batches.registration_start_date', '<=', date('Y-m-d')], ['training_batches.end_date', '>=', date('Y-m-d')]])
                ->get();
        } else {
            return $sessions = DB::table('training_sessions')
                ->selectRaw('training_sessions.*')
                ->where('training_sessions.module_id', $data)
                ->leftJoin('training_batches', 'training_batches.id', '=', 'training_sessions.batch_id')
                ->where([['training_batches.registration_start_date', '<=', date('Y-m-d')], ['training_batches.end_date', '>=', date('Y-m-d')]])
                ->get();
        }
    } else {
        if ($filter == 'yyes') {
            return $sessions = DB::table($table)
                ->selectRaw('training_sessions.*')
                ->groupBy($table . '.session_id')
                ->leftJoin('training_sessions', 'training_sessions.id', '=', $table . '.session_id')
                ->where('training_sessions.module_id', $data)
                ->get();
        } else {
            return $sessions = DB::table('training_sessions')
                ->selectRaw('*')
                ->where('module_id', $data)
                ->get();
        }
    }
}

function ip_address()
{
    $ipaddress = '';
    if ($_SERVER['REMOTE_ADDR']) {
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    } else {
        $ipaddress = 'UNKNOWN';
    }

    return $ipaddress;
}

function ip_address_by_api()
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.ipify.org/?format=json');
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
    $returnValue = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($returnValue);
    return @$result->ip;
    // $response = \Illuminate\Support\Facades\Http::get('https://api.ipify.org/?format=json');
    // return @$response['ip'];
}

function getcmtattach($data)
{
    $attachhtml = '';
    foreach ($data as $key => $attach) {
        $attachhtml .= '<a class="btn btn-sm btn-info" title="PDF" target="_blank" href="' . route('training.course.course-management-team.attachment', $attach->id) . '"><i class="fa fa-paperclip"></i></a> ';
    }
    return $attachhtml;
}

function get_days_in_month($month, $year)
{
    return date('t', mktime(0, 0, 0, $month, 1, $year));
}

function getPollisomajDetails($village_id)
{
    $details = PollisomajSetup::where('village_id', $village_id)->get();

    return $details;
}

function getPollisomaj($upazila_id = null, $union_id = null, $pollisomaj_no = null)
{
    $arr         = array($upazila_id, $union_id);
    $pollisomajs = PollisomajSetup::when($arr, function ($query, $arr) {
        if ($arr[1] != null) {
            $query->where('union_id', $arr[1]);
        } else {
            $query->where('upazila_id', $arr[0]);
        }
    })
        ->orderBy('id', 'ASC')
        ->get();
    $html = '<option value="">Select Pollisomaj</option>';
    foreach ($pollisomajs as $pollisomaj) {
        if ($pollisomaj->pollisomaj_no == $pollisomaj_no) {
            $select = 'selected';
        } else {
            $select = '';
        }
        $html .= '<option value="' . $pollisomaj->pollisomaj_no . '" ' . $select . '>' . $pollisomaj->pollisomaj_no . '</option>';
    }

    return $html;
}

function formatIncidentId($id)
{
    if ($id < 10) {
        return '00' . $id;
    }

    if ($id < 100) {
        return '0' . $id;
    }

    return $id;
}

function getCaseStatusForIncidentSingleView($caseType, $caseId)
{
    if ($caseType == 1) {
        return Civilcase::where('status', 1)->find($caseId);
    }

    if ($caseType == 2) {
        return Policecase::where('status', 1)->find($caseId);
    }

    if ($caseType == 3) {
        return Pititioncase::where('status', 1)->find($caseId);
    }
}

function caseJudjementStatusTotalCount($empDisOrUpa, $caseId, $caseStatus, $caseType, $reportType)
{
    $total = \App\Model\SelpIncidentModel::join('survivor_court_cases', 'survivor_court_cases.selp_incident_ref', '=', 'selp_incident_informations.selp_incident_ref')
        ->select(
            'survivor_court_cases.*'
        )
        ->when($reportType, function ($query, $reportType) use ($empDisOrUpa) {
            if ($reportType == 2) {
                $query->orWhere('selp_incident_informations.employee_upazila_id', $empDisOrUpa);
            }

            if ($reportType == 1) {
                $query->where('selp_incident_informations.employee_district_id', $empDisOrUpa);
            }
        })

        ->where('survivor_court_cases.case_type', $caseType)
        ->where('survivor_court_cases.court_case_id', $caseId)
        ->where('survivor_court_cases.judjementstatus_id', $caseStatus)->count();

    return $total;
}
