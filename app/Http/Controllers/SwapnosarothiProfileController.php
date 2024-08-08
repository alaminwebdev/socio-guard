<?php

namespace App\Http\Controllers;

use App\Exports\MisReportExport;
use App\Imports\SwapnosarothiProfileImport;
use App\Model\Admin\Setup\CEP_Region\Region;
use App\Model\Admin\Setup\CEP_Region\RegionAreaDetail;
use App\Model\Admin\Setup\CEP_Region\SetupUserArea;
use App\Model\Admin\Setup\District;
use App\Model\Admin\Setup\Division;
use App\Model\Admin\Setup\Occupation;
use App\Model\Admin\Setup\SurvivorAutisticInformation;
use App\Model\Admin\Setup\Upazila;
use App\Model\Setup\DropoutReason;
use App\Model\Setup\MigratedReason;
use App\SwapnosarothiProfile;
use App\SwapnosarothiProfileMoneySupport;
use App\SwapnosarothiSetupGroup;
use App\SwapnosarothiSkill;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Yajra\DataTables\Facades\DataTables;

class SwapnosarothiProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $auth_user = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        $region_ids   = SetupUserArea::where('user_id', $auth_user->id)->groupBy('region_id')->pluck('region_id')->toArray();
        $division_ids = SetupUserArea::where('user_id', $auth_user->id)->groupBy('division_id')->pluck('division_id')->toArray();
        $district_ids = SetupUserArea::where('user_id', $auth_user->id)->groupBy('district_id')->pluck('district_id')->toArray();
        $upazila_ids  = SetupUserArea::where('user_id', $auth_user->id)->groupBy('upazila_id')->pluck('upazila_id')->toArray();
        $regions = Region::when($region_ids, function ($query) use ($region_ids) {
            if (count($region_ids) > 0) {
                $query->whereIn('id', $region_ids);
            }
        })->where('status', '1')->get();

        $divisions = Division::when($division_ids, function ($query) use ($division_ids) {
            if (count($division_ids) > 0) {
                $query->whereIn('id', $division_ids);
            }
        })->where('status', '1')->get();

        $districts = District::when($district_ids, function ($query) use ($district_ids) {
            if (count($district_ids) > 0) {
                $query->whereIn('id', $district_ids);
            }
        })->where('status', '1')->get();

        $upazilas = Upazila::when($upazila_ids, function ($query) use ($upazila_ids) {
            if (count($upazila_ids) > 0) {
                $query->whereIn('id', $upazila_ids);
            }
        })->where('status', '1')->get();

        $groups = SwapnosarothiSetupGroup::when($region_ids, function ($query) use ($region_ids) {
            if (count($region_ids) > 0) {
                $query->whereIn('zone_id', $region_ids);
            }
        })->when($division_ids, function ($query) use ($division_ids) {
            if (count($division_ids) > 0) {
                $query->whereIn('division_id', $division_ids);
            }
        })->when($district_ids, function ($query) use ($district_ids) {
            if (count($district_ids) > 0) {
                $query->whereIn('district_id', $district_ids);
            }
        })->when($upazila_ids, function ($query) use ($upazila_ids) {
            if (count($upazila_ids) > 0) {
                $query->whereIn('upazila_id', $upazila_ids);
            }
        })->where('status', 1)->get();

        return view('swapnosarothi.profile.drift', compact('regions', 'divisions', 'districts', 'upazilas', 'groups', 'auth_user'));
    }

    //drift list
    public function getProfileListDataTable(Request $request)
    {
        $profileDatas = SwapnosarothiProfile::query()->orderByRaw("CASE WHEN group_status = 'ongoing' THEN 1 ELSE 2 END, group_status ASC")->orderBy('id', 'DESC')->where('status', 0);
        $auth_user    = User::with(['setup_user_area'])->where('id', Auth::id())->first();

        $profileDatas = searchCriteriaSwapnosarothiProfile($query = $profileDatas, $data = ['region_id' => $request->region_id, 'division_id' => $request->division_id, 'district_id' => $request->district_id, 'upazila_id' => $request->upazila_id, 'from_start_date' => $request->start_date, 'to_start_date' => $request->end_date, 'group_id' => $request->group_id, 'group_status' => $request->group_status, 'profile_union' => $request->union, 'profile_village' => $request->village, 'status' => 0]);

        return DataTables::of($profileDatas)

            ->addColumn('group', function ($profileDatas) {
                return '(' . @$profileDatas->groupName->id . ') ' . @$profileDatas->groupName->group_name;
            })
            ->editColumn('employee_zone_id', function ($profileDatas) {
                return @$profileDatas->employee_zone->region_name;
            })
            ->editColumn('start_date', function ($profileDatas) {
                return date('d-M-Y', strtotime(@$profileDatas->created_at));
            })
            ->editColumn('group_status', function ($profileDatas) {
                $statusBg = $profileDatas->group_status == 'ongoing' ? 'success' : ($profileDatas->group_status == 'married' ? 'info' : ($profileDatas->group_status == 'droupout' ? 'warning' : 'primary'));
                return '<span class="badge badge-' . $statusBg . '">' . $profileDatas->group_status . '</span>';
            })
            ->editColumn('date_of_birth', function ($profileDatas) {
                return date('d-M-Y', strtotime($profileDatas->date_of_birth));
            })
            ->editColumn('age_completion_date', function ($profileDatas) {
                return date('d-M-Y', strtotime(@$profileDatas->created_at));
            })
            ->editColumn('created_at', function ($profileDatas) {
                return date('d-M-Y', strtotime($profileDatas->created_at));
            })
            ->addColumn('action_column', function ($profileDatas) use ($auth_user) {
                $links = '';
                // $links = $profileDatas->group_status == 'ongoing' ? '<a href="' . route('cminitiative.create', ['profile_id' => $profileDatas->id]) . '" target="_blank" class="btn btn-sm btn-success mr-2" title="CM initiative">Add Initiative</a>' : '<a href="' . route('cminitiative.create', ['profile_id' => $profileDatas->id]) . '" target="_blank" class="btn btn-sm btn-success mr-2" title="CM initiative"><i class="fa fa-eye"></i></a>';
                // $links .=  $profileDatas->group_status != 'ongoing' ? '' : '';

                $links .= '<a href="' . route('swapnosarothi.profile.pdf.view', $profileDatas->id) . '" target="_blank" class="btn btn-sm btn-danger"><i class="fa fa-file-pdf-o"></i></a> <a href="' . route('swapnosarothi.profile.excel.view', $profileDatas->id) . '" target="_blank" class="btn btn-sm btn-success mr-1"><i class="fa fa-file-excel-o"></i></a>';

                if ($auth_user->user_role[0]['role_id'] == 5 || $auth_user->user_role[0]['role_id'] == 3) {
                    $links .= '<a href="' . route('swapnosarothiprofile.edit', $profileDatas->id) . '" class="btn btn-sm btn-info" title="Edit"><i class="fa fa-edit"></i></a> ';
                }

                if ($auth_user->user_role[0]['role_id'] == 1 || $auth_user->user_role[0]['role_id'] == 3) {
                    $links .= '<form action="' . route('swapnosarothiprofile.destroy', $profileDatas->id) . '" method="POST"  class=" d-inline swapnosarothiprofileDelete" title="Delete"> ' . csrf_field() . method_field("DELETE") . ' <button type="button" class="btn btn-sm btn-danger" style="min-width:auto"><i class="fa fa-trash"></i></button></form>';
                }

                return $links;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profilePendingList()
    {

        $auth_user = User::with(['setup_user_area'])->where('id', Auth::id())->first();

        $region_ids   = SetupUserArea::where('user_id', $auth_user->id)->groupBy('region_id')->pluck('region_id')->toArray();
        $division_ids = SetupUserArea::where('user_id', $auth_user->id)->groupBy('division_id')->pluck('division_id')->toArray();
        $district_ids = SetupUserArea::where('user_id', $auth_user->id)->groupBy('district_id')->pluck('district_id')->toArray();
        $upazila_ids  = SetupUserArea::where('user_id', $auth_user->id)->groupBy('upazila_id')->pluck('upazila_id')->toArray();

        $regions = Region::when($region_ids, function ($query) use ($region_ids) {
            if (count($region_ids) > 0) {
                $query->whereIn('id', $region_ids);
            }
        })->where('status', '1')->get();

        $divisions = Division::when($division_ids, function ($query) use ($division_ids) {
            if (count($division_ids) > 0) {
                $query->whereIn('id', $division_ids);
            }
        })->where('status', '1')->get();

        $districts = District::when($district_ids, function ($query) use ($district_ids) {
            if (count($district_ids) > 0) {
                $query->whereIn('id', $district_ids);
            }
        })->where('status', '1')->get();

        $upazilas = Upazila::when($upazila_ids, function ($query) use ($upazila_ids) {
            if (count($upazila_ids) > 0) {
                $query->whereIn('id', $upazila_ids);
            }
        })->where('status', '1')->get();

        $groups = SwapnosarothiSetupGroup::when($region_ids, function ($query) use ($region_ids) {
            if (count($region_ids) > 0) {
                $query->whereIn('zone_id', $region_ids);
            }
        })->when($division_ids, function ($query) use ($division_ids) {
            if (count($division_ids) > 0) {
                $query->whereIn('division_id', $division_ids);
            }
        })->when($district_ids, function ($query) use ($district_ids) {
            if (count($district_ids) > 0) {
                $query->whereIn('district_id', $district_ids);
            }
        })->when($upazila_ids, function ($query) use ($upazila_ids) {
            if (count($upazila_ids) > 0) {
                $query->whereIn('upazila_id', $upazila_ids);
            }
        })->where('status', 1)->get();

        return view('swapnosarothi.profile.pending', compact('regions', 'divisions', 'districts', 'upazilas', 'groups', 'auth_user'));
    }

    public function pendingProfileListDataTable(Request $request)
    {
        $profileDatas = SwapnosarothiProfile::query()->orderByRaw("CASE WHEN group_status = 'ongoing' THEN 1 ELSE 2 END, group_status ASC")->orderBy('id', 'DESC')->where('status', 1);
        $auth_user    = User::with(['setup_user_area'])->where('id', Auth::id())->first();

        $profileDatas = searchCriteriaSwapnosarothiProfile($query = $profileDatas, $data = ['region_id' => $request->region_id, 'division_id' => $request->division_id, 'district_id' => $request->district_id, 'upazila_id' => $request->upazila_id, 'from_start_date' => $request->start_date, 'to_start_date' => $request->end_date, 'group_id' => $request->group_id, 'group_status' => $request->group_status, 'profile_union' => $request->union, 'profile_village' => $request->village, 'status' => 1]);

        return DataTables::of($profileDatas)

            ->addColumn('group', function ($profileDatas) {
                return '(' . @$profileDatas->groupName->id . ') ' . @$profileDatas->groupName->group_name;
            })
            ->editColumn('employee_zone_id', function ($profileDatas) {
                return @$profileDatas->employee_zone->region_name;
            })
            ->editColumn('start_date', function ($profileDatas) {
                return date('d-M-Y', strtotime(@$profileDatas->created_at));
            })
            ->editColumn('group_status', function ($profileDatas) {
                $statusBg = $profileDatas->group_status == 'ongoing' ? 'success' : ($profileDatas->group_status == 'married' ? 'info' : ($profileDatas->group_status == 'droupout' ? 'warning' : 'primary'));
                return '<span class="badge badge-' . $statusBg . '">' . $profileDatas->group_status . '</span>';
            })
            ->editColumn('date_of_birth', function ($profileDatas) {
                return date('d-M-Y', strtotime($profileDatas->date_of_birth));
            })
            ->editColumn('age_completion_date', function ($profileDatas) {
                return date('d-M-Y', strtotime(@$profileDatas->created_at));
            })
            ->editColumn('created_at', function ($profileDatas) {
                return date('d-M-Y', strtotime($profileDatas->created_at));
            })
            ->addColumn('action_column', function ($profileDatas) use ($auth_user) {
                $links = '';
                // $links = $profileDatas->group_status == 'ongoing' ? '<a href="' . route('cminitiative.create', ['profile_id' => $profileDatas->id]) . '" target="_blank" class="btn btn-sm btn-success mr-2" title="CM initiative">Add Initiative</a>' : '<a href="' . route('cminitiative.create', ['profile_id' => $profileDatas->id]) . '" target="_blank" class="btn btn-sm btn-success mr-2" title="CM initiative"><i class="fa fa-eye"></i></a>';
                // $links .=  $profileDatas->group_status != 'ongoing' ? '' : '';

                $links .= '<a href="' . route('swapnosarothi.profile.pdf.view', $profileDatas->id) . '" target="_blank" class="btn btn-sm btn-danger"><i class="fa fa-file-pdf-o"></i></a> <a href="' . route('swapnosarothi.profile.excel.view', $profileDatas->id) . '" target="_blank" class="btn btn-sm btn-success mr-1"><i class="fa fa-file-excel-o"></i></a>';
                if ($auth_user->user_role[0]['role_id'] == 4 || $auth_user->user_role[0]['role_id'] == 3) {
                    $links .= '<a href="' . route('swapnosarothiprofile.edit', $profileDatas->id) . '" class="btn btn-sm btn-info" title="Edit"><i class="fa fa-edit"></i></a> ';
                }
                if ($auth_user->user_role[0]['role_id'] == 1 || $auth_user->user_role[0]['role_id'] == 3) {
                    $links .= '<form action="' . route('swapnosarothiprofile.destroy', $profileDatas->id) . '" method="POST"  class=" d-inline swapnosarothiprofileDelete" title="Delete"> ' . csrf_field() . method_field("DELETE") . ' <button type="button" class="btn btn-sm btn-danger" style="min-width:auto"><i class="fa fa-trash"></i></button></form>';
                }

                return $links;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profileApproveList()
    {

        $auth_user = User::with(['setup_user_area'])->where('id', Auth::id())->first();

        $region_ids   = SetupUserArea::where('user_id', $auth_user->id)->groupBy('region_id')->pluck('region_id')->toArray();
        $division_ids = SetupUserArea::where('user_id', $auth_user->id)->groupBy('division_id')->pluck('division_id')->toArray();
        $district_ids = SetupUserArea::where('user_id', $auth_user->id)->groupBy('district_id')->pluck('district_id')->toArray();
        $upazila_ids  = SetupUserArea::where('user_id', $auth_user->id)->groupBy('upazila_id')->pluck('upazila_id')->toArray();

        $regions = Region::when($region_ids, function ($query) use ($region_ids) {
            if (count($region_ids) > 0) {
                $query->whereIn('id', $region_ids);
            }
        })->where('status', '1')->get();

        $divisions = Division::when($division_ids, function ($query) use ($division_ids) {
            if (count($division_ids) > 0) {
                $query->whereIn('id', $division_ids);
            }
        })->where('status', '1')->get();

        $districts = District::when($district_ids, function ($query) use ($district_ids) {
            if (count($district_ids) > 0) {
                $query->whereIn('id', $district_ids);
            }
        })->where('status', '1')->get();

        $upazilas = Upazila::when($upazila_ids, function ($query) use ($upazila_ids) {
            if (count($upazila_ids) > 0) {
                $query->whereIn('id', $upazila_ids);
            }
        })->where('status', '1')->get();

        $groups = SwapnosarothiSetupGroup::when($region_ids, function ($query) use ($region_ids) {
            if (count($region_ids) > 0) {
                $query->whereIn('zone_id', $region_ids);
            }
        })->when($division_ids, function ($query) use ($division_ids) {
            if (count($division_ids) > 0) {
                $query->whereIn('division_id', $division_ids);
            }
        })->when($district_ids, function ($query) use ($district_ids) {
            if (count($district_ids) > 0) {
                $query->whereIn('district_id', $district_ids);
            }
        })->when($upazila_ids, function ($query) use ($upazila_ids) {
            if (count($upazila_ids) > 0) {
                $query->whereIn('upazila_id', $upazila_ids);
            }
        })->where('status', 1)->get();

        $dropout_reasons     = DropoutReason::where('status', 1)->get();
        $migrated_reasons    = MigratedReason::where('status', 1)->get();

        return view('swapnosarothi.profile.approve', compact('regions', 'divisions', 'districts', 'upazilas', 'groups', 'auth_user', 'dropout_reasons', 'migrated_reasons'));
    }

    public function approveProfileListDataTable(Request $request)
    {
        $auth_user = User::with(['setup_user_area'])->where('id', Auth::id())->first();

        if ($request->data_source == 'current_zone') {
            $profileDatas = SwapnosarothiProfile::query()->orderBy('id', 'DESC')->where('status', 2);
            $profileDatas = searchCriteriaSwapnosarothiProfile($query = $profileDatas, $data = ['region_id' => $request->region_id, 'division_id' => $request->division_id, 'district_id' => $request->district_id, 'upazila_id' => $request->upazila_id, 'from_start_date' => $request->start_date, 'to_start_date' => $request->end_date, 'group_id' => $request->group_id, 'group_status' => $request->group_status, 'profile_union' => $request->union, 'profile_village' => $request->village, 'status' => 2]);
        }else{
            $previousZoneInfo = getPreviousZoneIdsFromDivision($request->division_id);
            if (!empty($previousZoneInfo)) {
                $profileDatas = SwapnosarothiProfile::query()->orderBy('id', 'DESC');
                $profileDatas = searchCriteriaPreviousSwapnosarothiProfile($query = $profileDatas, $data = ['previous_zone_info' => $previousZoneInfo, 'division_id' => $request->division_id, 'district_id' => $request->district_id, 'upazila_id' => $request->upazila_id,  'group_id' => $request->group_id, 'group_status' => $request->group_status, 'profile_union' => $request->union, 'profile_village' => $request->village, 'status' => 2]);
            } else {
                $profileDatas = collect();
            }
        }

        return DataTables::of($profileDatas)

            ->addColumn('group', function ($profileDatas) {
                return '(' . @$profileDatas->groupName->id . ') ' . @$profileDatas->groupName->group_name;
            })
            ->editColumn('employee_zone_id', function ($profileDatas) {
                return @$profileDatas->employee_zone->region_name;
            })
            ->editColumn('start_date', function ($profileDatas) {
                return date('d-M-Y', strtotime(@$profileDatas->created_at));
            })
            ->editColumn('group_status', function ($profileDatas) {
                $statusBg = $profileDatas->group_status == 'ongoing' ? 'success' : ($profileDatas->group_status == 'married' ? 'info' : ($profileDatas->group_status == 'droupout' ? 'warning' : 'primary'));
                return '<span class="badge badge-' . $statusBg . '">' . $profileDatas->group_status . '</span>';
            })
            ->editColumn('date_of_birth', function ($profileDatas) {
                return date('d-M-Y', strtotime($profileDatas->date_of_birth));
            })
            ->editColumn('age_completion_date', function ($profileDatas) {
                return date('d-M-Y', strtotime(@$profileDatas->created_at));
            })
            ->editColumn('created_at', function ($profileDatas) {
                return date('d-M-Y', strtotime($profileDatas->created_at));
            })
            ->addColumn('action_column', function ($profileDatas) use ($auth_user) {
                $links = '';
                $links = $profileDatas->group_status == 'ongoing' ? '<a href="' . route('cminitiative.create', ['profile_id' => $profileDatas->id]) . '" target="_blank" class="btn btn-sm btn-success mr-1" title="CM initiative">Add Initiative</a>' : '<a href="' . route('cminitiative.create', ['profile_id' => $profileDatas->id]) . '" target="_blank" class="btn btn-sm btn-success mr-2" title="CM initiative"><i class="fa fa-eye"></i></a>';
                // $links .=  $profileDatas->group_status != 'ongoing' ? '' : '';

                $links .= '<a href="' . route('swapnosarothi.profile.pdf.view', $profileDatas->id) . '" target="_blank" class="btn btn-sm btn-danger"><i class="fa fa-file-pdf-o"></i></a> <a href="' . route('swapnosarothi.profile.excel.view', $profileDatas->id) . '" target="_blank" class="btn btn-sm btn-success mr-1"><i class="fa fa-file-excel-o"></i></a>';

                if ($auth_user->user_role[0]['role_id'] == 1 || $auth_user->user_role[0]['role_id'] == 12) {
                    $links .= '<a href="' . route('swapnosarothiprofile.edit', $profileDatas->id) . '" class="btn btn-sm btn-info" title="Edit"><i class="fa fa-edit"></i></a> ';
                    $links .= '<form action="' . route('swapnosarothiprofile.destroy', $profileDatas->id) . '" method="POST"  class=" d-inline swapnosarothiprofileDelete" title="Delete"> ' . csrf_field() . method_field("DELETE") . ' <button type="button" class="btn btn-sm btn-danger" style="min-width:auto"><i class="fa fa-trash"></i></button></form>';
                }

                if ($auth_user->user_role[0]['role_id'] == 5 && $profileDatas->group_status == 'ongoing') {
                    $links .= '
                    <a class="btn btn-sm btn-info text-white changeProfileStatus " data-id="' . $profileDatas->id . '" title="Change Profile Status" style="cursor: pointer">
                        Change Profile Status
                    </a>';
                }
                // $links .= '<a href="' . route('swapnosarothi.profile.money.support', $profileDatas->id) . '" class="btn btn-sm btn-primary ml-1" title="Add Money Support"><i class="fa fa-usd mr-1" aria-hidden="true"></i>Add Money Support</a>';

                return $links;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    public function getProfilePdfVIew($id)
    {
        $data['pofileData'] = SwapnosarothiProfile::with(
            'marriageInfo',
            'cmInitiatives',
            'groupName',
            'profile_skills.skill',
            'profile_division',
            'profile_district',
            'profile_upazila',
            'profile_union',
            'profile_village',
            'employee_zone',
            'employee_division',
            'employee_district',
            'employee_upazila',
            'employee_union',
            'employee'
        )->where('id', $id)
            ->first();
        // return  $data['pofileData'];
        $pdf = PDF::loadView('swapnosarothi.profile.pdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        $fileName = 'Profile_id' . '_' . $data['pofileData']->id . '.' . 'pdf';
        return $pdf->stream($fileName);
    }

    public function getProfileExcelView($id)
    {
        $data['profileData'] = SwapnosarothiProfile::with(
            'marriageInfo',
            'cmInitiatives',
            'groupName',
            'profile_skills.skill',
            'profile_division',
            'profile_district',
            'profile_upazila',
            'profile_union',
            'profile_village',
            'employee_zone',
            'employee_division',
            'employee_district',
            'employee_upazila',
            'employee_union',
            'employee'
        )->where('id', $id)->first();

        $data['skills'] = SwapnosarothiSkill::where('status', 1)->orderBy('order', 'asc')->get();

        //return view('swapnosarothi.profile.excel', $data);
        $view_link = 'swapnosarothi.profile.excel';
        $fileName  = 'Profile_id' . '_' . $data['profileData']->id . '.' . 'xlsx';
        return Excel::download(new MisReportExport($data, $view_link), $fileName);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return redirect()->back();

        $data['zones']        = Region::all();
        $data['divisions']    = Division::where('status', 1)->get();
        $data['disabilities'] = SurvivorAutisticInformation::where('status', 1)->get();
        $data['occupations']  = Occupation::where('status', 1)->get();

        $data['auth_user']    = User::with(['user_role'])->where('id', Auth::id())->first();
        // return User::with('setup_user_area')->where('id', Auth::id())->first();

        return view('swapnosarothi.profile.create', $data);
    }

    public function getRegionUpazilaGroup(Request $request)
    {
        $groups = SwapnosarothiSetupGroup::where('zone_id', $request->emp_region_id)
            ->where('division_id', $request->emp_division_id)
            ->where('district_id', $request->emp_district_id)
            ->where('upazila_id', $request->emp_upazila_id)
            ->where('status', 1)
            ->get();
        return response()->json($groups);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $auth_user = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        // return $request;
        $request->validate([
            "profile_id"           => 'required',
            "employee_zone_id"     => 'required',
            "employee_division_id" => 'required',
            "employee_district_id" => 'required',
            "employee_upazila_id"  => 'required',
            "group_id"             => 'required',
            "start_date"           => 'required',
            "name"                 => 'required',
            "date_of_birth"        => 'required',
            "division_id"          => 'required',
            "district_id"          => 'required',
            "upazila_id"           => 'required',
            "union_id"             => 'required',
            "profile_photo"        => 'nullable|mimes:jpeg,png,jpg|max:512|dimensions:max_width=200,max_height=200',
        ]);
        $profile_photo = $request->file('profile_photo');
        $fileName      = '';
        if ($profile_photo) {
            $fileName = time() . '.' . $profile_photo->extension();
            $profile_photo->move(public_path('swapnosarothi_profile'), $fileName);
        }

        $requestData                    = $request->all();
        $requestData['profile_image']   = $fileName;
        $requestData['profile_id']      = $this->getProfileId($isNotJson = true);

        if ($auth_user->user_role[0]['role_id'] == 5) {
            if (!$request->craeted_by) {
                $requestData['craeted_by'] = Auth::id();
            }
            $requestData['status'] = 1;
        }

        SwapnosarothiProfile::create($requestData);

        $request->session()->flash("success", "Profile successfully Created!");
        return redirect()->route('swapnosarothiprofile.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SwapnosarothiProfile  $swapnosarothiProfile
     * @return \Illuminate\Http\Response
     */
    public function show(SwapnosarothiProfile $swapnosarothiProfile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SwapnosarothiProfile  $swapnosarothiProfile
     * @return \Illuminate\Http\Response
     */
    public function edit(SwapnosarothiProfile $swapnosarothiprofile)
    {
        $data['editData']    = $swapnosarothiprofile;

        $previousZoneIds = RegionAreaDetail::withPreviousZone($swapnosarothiprofile->employee_division_id)
            ->pluck('region_id')
            ->unique()
            ->toArray();

        // $data['group_names'] = SwapnosarothiSetupGroup::where('zone_id', $swapnosarothiprofile->employee_zone_id)
        //     ->where('division_id', $swapnosarothiprofile->employee_division_id)
        //     ->where('district_id', $swapnosarothiprofile->employee_district_id)
        //     ->where('upazila_id', $swapnosarothiprofile->employee_upazila_id)
        //     ->get();


        // $data['group_names'] = SwapnosarothiSetupGroup::where(function ($query) use ($swapnosarothiprofile, $previousZoneIds) {
        //     $query->where('zone_id', $swapnosarothiprofile->employee_zone_id)
        //         ->where('division_id', $swapnosarothiprofile->employee_division_id)
        //         ->where('district_id', $swapnosarothiprofile->employee_district_id)
        //         ->where('upazila_id', $swapnosarothiprofile->employee_upazila_id)
        //         ->orWhere(function ($query) use ($previousZoneIds) {
        //             $query->whereIn('zone_id', $previousZoneIds)
        //                 ->whereIn('division_id', session()->get('userareaaccess.sdivisions'))
        //                 ->whereIn('district_id', session()->get('userareaaccess.sdistricts'))
        //                 ->whereIn('upazila_id', session()->get('userareaaccess.supazilas'))
        //                 ->orWhere(function ($query) {
        //                     $query->whereIn('zone_id', session()->get('userareaaccess.sregions'))
        //                         ->whereIn('division_id', session()->get('userareaaccess.sdivisions'))
        //                         ->whereIn('district_id', session()->get('userareaaccess.sdistricts'))
        //                         ->whereIn('upazila_id', session()->get('userareaaccess.supazilas'));
        //                 });
        //         });
        // })
        // ->get();

        $data['group_names'] = SwapnosarothiSetupGroup::where('division_id', $swapnosarothiprofile->employee_division_id)
            ->where('district_id', $swapnosarothiprofile->employee_district_id)
            ->where('upazila_id', $swapnosarothiprofile->employee_upazila_id)
            ->get();


        // dd($query->toSql(), $query->getBindings());
        // dd($data['group_names']);

        $data['zones']        = Region::all();
        $data['divisions']    = Division::where('status', 1)->get();
        $data['disabilities'] = SurvivorAutisticInformation::where('status', 1)->get();
        $data['occupations']  = Occupation::where('status', 1)->get();

        $data['dropout_reasons']     = DropoutReason::where('status', 1)->get();
        $data['migrated_reasons']    = MigratedReason::where('status', 1)->get();

        $data['auth_user']    = User::with(['user_role'])->where('id', Auth::id())->first();

        return view('swapnosarothi.profile.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SwapnosarothiProfile  $swapnosarothiProfile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SwapnosarothiProfile $swapnosarothiprofile)
    {
        $auth_user = User::with(['setup_user_area'])->where('id', Auth::id())->first();

        $request->validate([
            "profile_id"           => 'required',
            "employee_zone_id"     => 'required',
            "employee_division_id" => 'required',
            "employee_district_id" => 'required',
            "employee_upazila_id"  => 'required',
            "group_id"             => 'required',
            "start_date"           => 'required',
            "name"                 => 'required',
            "date_of_birth"        => 'required',
            "division_id"          => 'required',
            "district_id"          => 'required',
            "upazila_id"           => 'required',
            "union_id"             => 'required',
            "profile_photo"        => 'nullable|mimes:jpeg,png,jpg|max:512|dimensions:max_width=200,max_height=200',
            "group_status"         => 'required',
            "status_date"          => 'required_if:group_status,migrated,droupout,graduated',
            "reason_id"            => 'required_if:group_status,migrated,droupout', 
        ]);

        $profile_photo = $request->file('profile_photo');

        if ($profile_photo) {
            $fileName = time() . '.' . $profile_photo->extension();
            $profile_photo->move(public_path('swapnosarothi_profile'), $fileName);
        } else {
            $fileName = $swapnosarothiprofile->profile_image;
        }

        $requestData                  = $request->all();
        $requestData['profile_image'] = $fileName;

        if ($request->submit_action == 'update') {
            if ($auth_user->user_role[0]['role_id'] == 5) {
                if (!$request->craeted_by) {
                    $requestData['craeted_by'] = Auth::id();
                }
                $requestData['status'] = 1;
            }
            if ($auth_user->user_role[0]['role_id'] == 4) {
                $requestData['status'] = 2;
            }
        }


        $swapnosarothiprofile->update($requestData);
        $request->session()->flash("success", "Profile successfully Updated!");

        if ($auth_user->user_role[0]['role_id'] == 5) {
            if ($request->submit_action == 'update') {
                return redirect()->route('swapnosarothi.profile.pending.list');
            } else {
                return redirect()->route('swapnosarothiprofile.index');
            }
        }

        if ($auth_user->user_role[0]['role_id'] == 4) {
            if ($request->submit_action == 'update') {
                return redirect()->route('swapnosarothi.profile.approve.list');
            } else {
                return redirect()->route('swapnosarothi.profile.pending.list');
            }
        }

        return redirect()->route('swapnosarothiprofile.index');

        // Previous Code 
        // if ($auth_user->user_role[0]['role_id'] == 5) {
        //     if (!$request->craeted_by) {
        //         $requestData['craeted_by'] = Auth::id();
        //     }
        //     $requestData['status'] = 1;
        // }
        // if ($auth_user->user_role[0]['role_id'] == 4) {
        //     $requestData['status'] = 2;
        // }

        // $swapnosarothiprofile->update($requestData);

        // $request->session()->flash("success", "Profile successfully Updated!");

        // if ($auth_user->user_role[0]['role_id'] == 5) {
        //     return redirect()->route('swapnosarothi.profile.pending.list');
        // }
        // if ($auth_user->user_role[0]['role_id'] == 4) {
        //     return redirect()->route('swapnosarothi.profile.approve.list');
        // }
        // return redirect()->route('swapnosarothiprofile.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SwapnosarothiProfile  $swapnosarothiProfile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, SwapnosarothiProfile $swapnosarothiprofile)
    {
        $swapnosarothiprofile->delete();
        $request->session()->flash("success", "Profile successfully Deleted!");
        return redirect()->route('swapnosarothiprofile.index');
    }

    /**
     * get profile id
     * use this create profile page
     */
    public function getProfileId($isNotJson = false)
    {
        $latestProfile = SwapnosarothiProfile::orderBy('id', 'desc')->first();
        $id            = $latestProfile ? $latestProfile->profile_id + 1 : 1;

        if ($isNotJson) {
            return $id;
        }
        return response()->json($id);
    }

    //dumy data inport

    public function uploadSwapnosarothiData()
    {
        return view('swapnosarothi.profile.upload-form');
    }
    public function profileDataUpload(Request $request)
    {
        //dd($request->file('profile_upload'));
        ini_set('memory_limit', -1);
        $data = Excel::import(new SwapnosarothiProfileImport, request()->file('profile_upload'));
        return back();
    }

    public function swapnosarothiProfileStatusChange(Request $request)
    {
        $profile = SwapnosarothiProfile::find($request->id);

        // Define validation rules based on group_status
        $validationRules = [
            'group_status'  => 'required',
            'status_date'   => 'required',
        ];

        // Add additional validation rules based on the selected group_status
        if ($request->group_status === 'migrated') {
            $validationRules['migrated_reason'] = 'required';
        } elseif ($request->group_status === 'droupout') {
            $validationRules['dropout_reason'] = 'required';
        }

        // Validate the request
        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
        }

        $profile->group_status  = $request->group_status;
        $profile->status_date   = $request->status_date;

        if ($request->group_status === 'migrated') {
            $profile->reason_id   = $request->migrated_reason;
        } elseif ($request->group_status === 'droupout') {
            $profile->reason_id   = $request->dropout_reason;
        }

        $profile->save();

        return response()->json(['status' => 'success']);
    }
    public function swapnosarothiProfileListGenerate(Request $request)
    {
        ini_set('memory_limit', -1);
        

        $profiles = SwapnosarothiProfile::orderBy('id', 'DESC')->where('status', 2);

        if ($request->data_source == 'current_zone') {
            $profiles = searchCriteriaSwapnosarothiProfile(
                $query = $profiles, 
                $data = [
                    'region_id'         => $request->region_id, 
                    'division_id'       => $request->division_id, 
                    'district_id'       => $request->district_id, 
                    'upazila_id'        => $request->upazila_id,
                    'profile_union'     => $request->union_id, 
                    'profile_village'   => $request->village_id, 
                    'group_id'          => $request->group, 
                    'group_status'      => $request->group_status,  
                    'status'            => 2
                ]
            );

            $profiles = $profiles->get();
            
        }else{
            $previousZoneInfo = getPreviousZoneIdsFromDivision($request->division_id);
            if (!empty($previousZoneInfo)) {
                $profiles = searchCriteriaPreviousSwapnosarothiProfile(
                    $query = $profiles, 
                    $data = [
                        'previous_zone_info'    => $previousZoneInfo, 
                        'division_id'           => $request->division_id, 
                        'district_id'           => $request->district_id, 
                        'upazila_id'            => $request->upazila_id,  
                        'group_id'              => $request->group, 
                        'group_status'          => $request->group_status, 
                        'profile_union'         => $request->union_id, 
                        'profile_village'       => $request->village_id, 
                        'status'                => 2
                    ]);
                $profiles = $profiles->get();            
            } else {
                $profiles = collect();
            }
        }

        $profiles = searchCriteriaSwapnosarothiProfile(
            $query = $profiles, 
            $data = [
                'region_id'         => $request->region_id, 
                'division_id'       => $request->division_id, 
                'district_id'       => $request->district_id, 
                'upazila_id'        => $request->upazila_id,
                'profile_union'     => $request->union_id, 
                'profile_village'   => $request->village_id, 
                'group_id'          => $request->group, 
                'group_status'      => $request->group_status,  
                'status'            => 2
            ]
        );
        
        $profile_data['profiles']   = $profiles;
        $profile_data['skills']     = SwapnosarothiSkill::where('status', 1)->orderBy('order', 'asc')->get();

        // return view('swapnosarothi.profile.girls-list-in-excel', $profile_data);
        $view_link = 'swapnosarothi.profile.girls-list-in-excel';
        $fileName  = 'swapnosarothi profile girls list' . '.' . 'xlsx';
        return Excel::download(new MisReportExport($profile_data, $view_link), $fileName);
    }

    public function addSwapnosarothiProfileMoneySupport(Request $request, $id)
    {

        $data['swapnosarothi_profile'] =  SwapnosarothiProfile::select('id', 'group_id', 'name', 'fathers_name', 'mothers_name', 'group_status', 'status', 'created_at')->where('id', $id)->first();

        if ($request->isMethod('post')) {

            $request->validate([
                'amount_of_money_received.*'    => 'required|numeric|min:0',
                'money_receive_date.*'          => 'required|date',
            ], [],[
                'amount_of_money_received.*'    => 'Amount Of Money Received',
                'money_receive_date.*'          => 'Money Receive Date'
            ]);

            $moneySupportIds    = $request->swapnosarothi_profile_money_support_id;
            $amounts            = $request->amount_of_money_received;
            $dates              = $request->money_receive_date;

            foreach ($amounts as $index => $amount) {
                if ($moneySupportIds[$index]) {
                    // Update existing entry
                    $moneySupport                           = SwapnosarothiProfileMoneySupport::find($moneySupportIds[$index]);
                    $moneySupport->amount_of_money_received = $amount;
                    $moneySupport->money_receive_date       = $dates[$index];
                    $moneySupport->updated_by               = Auth::id();
                    $moneySupport->save();
                } else {
                    // Create new entry
                    $moneySupport                               = new SwapnosarothiProfileMoneySupport();
                    $moneySupport->swapnosarothi_profile_id     = $id;
                    $moneySupport->amount_of_money_received     = $amount;
                    $moneySupport->money_receive_date           = $dates[$index];
                    $moneySupport->created_by                   = Auth::id();
                    $moneySupport->save();
                }
            }
            return redirect()->route('swapnosarothi.profile.approve.list')->with('success', 'Money support updated successfully.');
        }

        return view('swapnosarothi.profile.money-support', $data);
    }
}
