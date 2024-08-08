<?php

namespace App\Http\Controllers;

use App\ChildMarriageAssistanceTaken;
use App\ChildMarriageInformation;
use App\ChildMarriageInitiative;
use App\Exports\MisReportExport;
use App\Http\Controllers\Controller;
use App\Model\Admin\Setup\Division;
use App\Model\Admin\Setup\Gender;
use App\Model\Admin\Setup\SurvivorAutisticInformation;
use App\Model\Admin\Setup\ViolenceCategory;
use App\Model\AuditLog;
use App\Model\SelpIncidentModel;
use App\User;
use Auth;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class ChildMarriageInformationController extends Controller
{
    private function formatIncidentId($id)
    {
        if ($id < 10) {
            return '00' . $id;
        }

        if ($id < 100) {
            return '0' . $id;
        }

        return $id;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['divisions'] = Division::all();
        $data['regions']   = getRegionByUserType();
        $data['auth_user'] = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        return view('backend/childmarriageinformation/index', $data);
    }

    public function ChildMarriageInformationDatatable(Request $request)
    {
        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date   = date("Y-m-d", strtotime($request->to_date));

        $auth_user = User::with(['setup_user_area'])->where('id', Auth::id())->first();

        $incidents = ChildMarriageInformation::select('id', 'reporting_date', 'child_name', 'child_age', 'child_gender_id', 'created_at')->where('status', 1);

        $incidents = searchCriteria($query = $incidents, $data = ['region_id' => $request->region_id, 'division_id' => $request->division_id, 'district_id' => $request->district_id, 'upazila_id' => $request->upazila_id, 'from_reporting_date' => $request->from_date, 'to_reporting_date' => $request->to_date]);
        $incidents->orderBy('id', 'DESC');

        return DataTables::of($incidents)
            ->addIndexColumn()
            ->editColumn('created_at', function ($incidents) {
                return date('d-m-Y', strtotime($incidents->created_at));
            })
            ->editColumn('reporting_date', function ($incidents) {
                return $incidents->reporting_date != null ? date("d-m-Y", strtotime($incidents->reporting_date)) : null;
            })
            ->addColumn('action_column', function (ChildMarriageInformation $incident) use ($auth_user) {
                $links = '';
                if ($auth_user->user_role[0]['role_id'] == 5 || $auth_user->user_role[0]['role_id'] == 4 || $auth_user->user_role[0]['role_id'] == 1) {
                    $links = '<a href="' . route('childmarriageinformation.edit', $incident->id) . '" class="btn btn-sm btn-info" title="Edit"><i class="fa fa-edit"> </i></a> ';
                }
                $links .= ' <a href="' . route('childmarriageinformation.show', $incident->id) . '" target="__blank" class="btn btn-sm btn-danger mr-1" title="PDF">
                        <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                    </a>';

                $links .= '<a href="' . route('child.marriage.information.excel', $incident->id) . '" target="__blank" class="btn btn-sm btn-success mr-1" title="Excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>';

                if ($auth_user->user_role[0]['role_id'] == 1) {
                    $links .= '<a href="#" class="btn btn-sm btn-youtube" title="Delete" onclick="confirmDelete(' . $incident->id . ')"><i class="fa fa-trash" aria-hidden="true"></i></a>';
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
    public function approved()
    {
        $data['divisions'] = Division::all();
        $data['regions']   = getRegionByUserType();
        $data['auth_user'] = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        return view('backend/childmarriageinformation/approve', $data);
    }
    public function ChildMarriageInformationApproved(Request $request)
    {
        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date   = date("Y-m-d", strtotime($request->to_date));

        $auth_user = User::with(['setup_user_area'])->where('id', Auth::id())->first();

        $incidents = ChildMarriageInformation::select('id', 'reporting_date', 'child_name', 'child_age', 'child_gender_id', 'created_at')->where('status', 2);

        $incidents = searchCriteria($query = $incidents, $data = ['region_id' => $request->region_id, 'division_id' => $request->division_id, 'district_id' => $request->district_id, 'upazila_id' => $request->upazila_id, 'from_reporting_date' => $request->from_date, 'to_reporting_date' => $request->to_date]);
        $incidents->orderBy('id', 'DESC');

        return DataTables::of($incidents)
            ->addIndexColumn()
            ->editColumn('created_at', function ($incidents) {
                return date('d-m-Y', strtotime($incidents->created_at));
            })
            ->editColumn('reporting_date', function ($incidents) {
                return $incidents->reporting_date != null ? date("d-m-Y", strtotime($incidents->reporting_date)) : null;
            })
            ->addColumn('action_column', function (ChildMarriageInformation $incident) use ($auth_user) {
                $links = '';
                if ($auth_user->user_role[0]['role_id'] == 1) {
                    $links = '<a href="' . route('childmarriageinformation.edit', $incident->id) . '" class="btn btn-sm btn-info" title="Edit"><i class="fa fa-edit"></i></a> ';
                }
                $links .= ' <a href="' . route('childmarriageinformation.show', $incident->id) . '" target="__blank" class="btn btn-sm btn-danger mr-1" title="PDF">
                    <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                </a>';

                $links .= '<a href="' . route('child.marriage.information.excel', $incident->id) . '" target="__blank" class="btn btn-sm btn-success mr-1" title="Excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>';

                if ($auth_user->user_role[0]['role_id'] == 1) {
                    $links .= '<a href="#" class="btn btn-sm btn-youtube" title="Delete" onclick="confirmDelete(' . $incident->id . ')"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                }

                return $links;
            })

            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $data['divisions'] = Division::all();

        $data['regions'] = getRegionByUserType();

        $data['violence_categories']             = ViolenceCategory::where('status', '1')->get();
        $data['user_info']                       = Auth::user();
        $data['selpIncident']                    = SelpIncidentModel::where('id', $request->id)->get();
        $data['child_marriage_initiative']       = ChildMarriageInitiative::get();
        $data['child_marriage_assistance_taken'] = ChildMarriageAssistanceTaken::get();
        $data['survivor_autistic_information']   = SurvivorAutisticInformation::get();
        $data['child_gender']                    = Gender::get();
        $data['childmarriageinformation']        = ChildMarriageInformation::latest()->first();

        return view('backend/childmarriageinformation/create', $data);
    }

    public function getChieldComplainInformationDatatable(Request $request)
    {
        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date   = date("Y-m-d", strtotime($request->to_date));

        $auth_user = User::with(['setup_user_area'])->where('id', Auth::id())->first();

        $incidents = SelpIncidentModel::select('id', 'posting_date', 'selp_incident_ref', 'survivor_name', 'survivor_gender_id', 'survivor_age', 'status', 'created_at');
        $incidents = searchCriteria($query = $incidents, $data = ['region_id' => $request->region_id, 'division_id' => $request->division_id, 'district_id' => $request->district_id, 'upazila_id' => $request->upazila_id, 'from_posting_date' => $request->from_date, 'to_posting_date' => $request->to_date]);
        $incidents->where('status', 2);
        $incidents->where('survivor_age', '<', 18);
        $incidents->orderBy('id', 'DESC');

        return DataTables::of($incidents)
            ->addIndexColumn()
            ->editColumn('created_at', function ($incidents) {
                return date('d-m-Y', strtotime($incidents->created_at));
            })
            ->editColumn('posting_date', function ($incidents) {
                return $incidents->posting_date != null ? date("d-m-Y", strtotime($incidents->posting_date)) : null;
            })
            ->editColumn('selp_incident_ref', function ($incidents) {
                $incident_ref      = explode('.', $incidents->selp_incident_ref);
                $selp_incident_ref = $this->formatIncidentId($incidents->id); //$incident_ref[1];
                return $selp_incident_ref;
            })
            ->addColumn('action_column', function (SelpIncidentModel $incident) use ($auth_user) {

                if (($auth_user->user_role[0]['role_id'] == 5 || $auth_user->user_role[0]['role_id'] == 1) && $incident->status == 2) {
                    $links = '<a href="' . route('child.marriage.information.complain.id', $incident->id) . '" class="btn btn-sm btn-info">Add Child Marriage Info</a> ';
                }
                return $links;
            })
            ->editColumn('status', function ($list) {
                $actionBtn = '';
                if ($list->status == 0 || $list->status == null) {
                    $actionBtn = '<span class="badge badge-warning">Draft</span>';
                } elseif ($list->status == 2) {
                    $actionBtn = '<span class="badge badge-success">Approved</span>';
                } else {
                    $actionBtn = '<span class="badge badge-primary">Pending for Approval</span>';
                }
                return $actionBtn;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function complainIdBycreate(Request $request)
    {
        $data['divisions'] = Division::all();

        $data['regions'] = getRegionByUserType();

        $data['violence_categories']             = ViolenceCategory::where('status', '1')->get();
        $data['user_info']                       = Auth::user();
        $data['selpIncident']                    = SelpIncidentModel::where('id', $request->id)->get();
        $data['child_marriage_initiative']       = ChildMarriageInitiative::get();
        $data['child_marriage_assistance_taken'] = ChildMarriageAssistanceTaken::get();
        $data['survivor_autistic_information']   = SurvivorAutisticInformation::get();
        $data['child_gender']                    = Gender::get();
        $data['childmarriageinformation']        = ChildMarriageInformation::latest()->first();

        return view('backend/childmarriageinformation/complainbycreate', $data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([

            "reporting_date"                  => 'required',
            "employee_name"                   => 'required',
            "employee_mobile_number"          => 'required',
            "employee_designation"            => 'required',
            "employee_pin"                    => 'required',
            "employee_zone_id"                => 'required',
            "employee_division_id"            => 'required',
            "employee_district_id"            => 'required',
            "employee_upazila_id"             => 'required',
            "child_marriage_initiative"       => 'required',
            "child_name"                      => 'required',
            "child_marriage_assistance_taken" => 'required',
            "child_age"                       => 'required',
            "child_mobile_number"             => 'required',
            "child_gender"                    => 'required',
            "survivor_division"               => 'required',
            "survivor_district"               => 'required',
            "survivor_upazila"                => 'required',
            "survivor_union"                  => 'required',
            "survivor_village_name"           => 'required',

        ]);

        $information = ChildMarriageInformation::create([
            "complain_id"                      => $request->complain_id,
            "reporting_date"                   => date("Y-m-d", strtotime($request->reporting_date)),
            "employee_name"                    => $request->employee_name,
            "employee_mobile_number"           => $request->employee_mobile_number,
            "employee_designation"             => $request->employee_designation,
            "employee_pin"                     => $request->employee_pin,
            "employee_zone_id"                 => $request->employee_zone_id,
            "employee_division_id"             => $request->employee_division_id,
            "employee_district_id"             => $request->employee_district_id,
            "employee_upazila_id"              => $request->employee_upazila_id,
            "child_marriage_initiative_id"     => $request->child_marriage_initiative,
            "survivor_autistic_information_id" => $request->survivor_disability_status,
            "child_name"                       => $request->child_name,
            "child_age"                        => $request->child_age,
            "child_father_name"                => $request->child_father_name,
            "child_mother_name"                => $request->child_mother_name,
            "child_mobile_number"              => $request->child_mobile_number,
            "child_gender_id"                  => $request->child_gender,
            "child_division_id"                => $request->survivor_division,
            "child_district_id"                => $request->survivor_district,
            "child_upazila_id"                 => $request->survivor_upazila,
            "child_union_id"                   => $request->survivor_union,
            "child_village_name"               => $request->survivor_village_name,
            "update_by"                        => auth()->user()->id,
            "person_name"                      => $request->person_name,
            "person_mobile_number"             => $request->person_mobile_number,
            "person_division_id"               => $request->person_division_id,
            "person_district_id"               => $request->person_district_id,
            "person_upazila_id"                => $request->person_upazila_id,
            "person_union_id"                  => $request->person_union_id,
            "person_village_name"              => $request->person_village_name,
            "status"                           => 1,
            "submited_at"                      => Carbon::now(),
        ]);
        $information->assistanceTakens()->attach($request->child_marriage_assistance_taken);

        return redirect()->route('childmarriageinformation.index')->with('success', 'Data Insert Successfull!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ChildMarriageInformation  $childMarriageInformation
     * @return \Illuminate\Http\Response
     */
    public function show(ChildMarriageInformation $childmarriageinformation)
    {

        $data['childmarriageinformation'] = $childmarriageinformation->load('assistanceTakens');

        $pdf = PDF::loadView('backend.childmarriageinformation.childmarriageviewpdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        $fileName = 'Complain_id' . '_' . $childmarriageinformation->id . '.' . 'pdf';
        return $pdf->stream($fileName);
    }

    public function ChildMarriageInformationExcel(ChildMarriageInformation $childmarriageinformation)
    {

        $data['childmarriageinformation'] = $childmarriageinformation->load('assistanceTakens');

        $view_link = 'backend.childmarriageinformation.childmarriageview_excel';
        return Excel::download(new MisReportExport($data, $view_link), 'childmarriageview_excel.xlsx');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ChildMarriageInformation  $childMarriageInformation
     * @return \Illuminate\Http\Response
     */
    public function edit(ChildMarriageInformation $childmarriageinformation)
    {
        $data['divisions'] = Division::all();

        $data['regions'] = getRegionByUserType();

        $data['child_marriage_initiative']       = ChildMarriageInitiative::get();
        $data['child_marriage_assistance_taken'] = ChildMarriageAssistanceTaken::get();
        $data['survivor_autistic_information']   = SurvivorAutisticInformation::get();
        $data['child_gender']                    = Gender::get();
        $data['childmarriageinformation']        = $childmarriageinformation->load('assistanceTakens');
        $data['user_info']                       = Auth::user();

        return view('backend/childmarriageinformation/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ChildMarriageInformation  $childMarriageInformation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChildMarriageInformation $childmarriageinformation)
    {
        $request->validate([

            "reporting_date"                  => 'required',
            "employee_name"                   => 'required',
            "employee_mobile_number"          => 'required',
            "employee_designation"            => 'required',
            "employee_pin"                    => 'required',
            "employee_zone_id"                => 'required',
            "employee_division_id"            => 'required',
            "employee_district_id"            => 'required',
            "employee_upazila_id"             => 'required',
            "child_marriage_initiative"       => 'required',
            "child_name"                      => 'required',
            "child_marriage_assistance_taken" => 'required',
            "child_age"                       => 'required',
            "child_mobile_number"             => 'required',
            "child_gender"                    => 'required',
            "survivor_division"               => 'required',
            "survivor_district"               => 'required',
            "survivor_upazila"                => 'required',
            "survivor_union"                  => 'required',
            "survivor_village_name"           => 'required',

        ]);

        $childmarriageinformation->update([
            "reporting_date"                   => date("Y-m-d", strtotime($request->reporting_date)),
            "employee_name"                    => $request->employee_name,
            "employee_mobile_number"           => $request->employee_mobile_number,
            "employee_designation"             => $request->employee_designation,
            "employee_pin"                     => $request->employee_pin,
            "employee_zone_id"                 => $request->employee_zone_id,
            "employee_division_id"             => $request->employee_division_id,
            "employee_district_id"             => $request->employee_district_id,
            "employee_upazila_id"              => $request->employee_upazila_id,
            "child_marriage_initiative_id"     => $request->child_marriage_initiative,
            "survivor_autistic_information_id" => $request->survivor_disability_status,
            "child_name"                       => $request->child_name,
            "child_age"                        => $request->child_age,
            "child_father_name"                => $request->child_father_name,
            "child_mother_name"                => $request->child_mother_name,
            "child_mobile_number"              => $request->child_mobile_number,
            "child_gender_id"                  => $request->child_gender,
            "child_division_id"                => $request->survivor_division,
            "child_district_id"                => $request->survivor_district,
            "child_upazila_id"                 => $request->survivor_upazila,
            "child_union_id"                   => $request->survivor_union,
            "child_village_name"               => $request->survivor_village_name,
            "update_by"                        => auth()->user()->id,
            "person_name"                      => $request->person_name,
            "person_mobile_number"             => $request->person_mobile_number,
            "person_division_id"               => $request->person_division_id,
            "person_district_id"               => $request->person_district_id,
            "person_upazila_id"                => $request->person_upazila_id,
            "person_union_id"                  => $request->person_union_id,
            "person_village_name"              => $request->person_village_name,
        ]);

        $childmarriageinformation->assistanceTakens()->sync($request->child_marriage_assistance_taken);

        if ($request->dm_approved == 2) {
            $childmarriageinformation->status = 2;
            if ($childmarriageinformation->approved_at == null) {
                $childmarriageinformation->approved_at = Carbon::now();
                $childmarriageinformation->approved_by = auth()->user()->id;
            }
        } else {
            $childmarriageinformation->status = 1;
        }
        $childmarriageinformation->save();

        return redirect()->route('childmarriageinformation.index')->with('success', 'Data Update Successfull!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ChildMarriageInformation  $childMarriageInformation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $childMarriageInformation = ChildMarriageInformation::findOrFail($id);

        if ($childMarriageInformation->delete()) {
            $login_audit                  = new AuditLog();
            $login_audit->employee_id     = auth()->user()->id;
            $login_audit->employee_pin    = auth()->user()->pin;
            $login_audit->employee_name   = auth()->user()->name;
            $login_audit->ip_address      = request()->ip();

            $login_audit->complain_id     = $id;
            $login_audit->description     = "Child Marriage Prevention Data deleted";
            $login_audit->table_name      = "child_marriage_informations";
            $login_audit->action_type     = 3;
            $login_audit->save();

            return redirect()->back()->with('success', 'Data deleted successfully!');
        }
    }
}
