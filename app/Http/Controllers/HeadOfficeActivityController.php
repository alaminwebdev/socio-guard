<?php

namespace App\Http\Controllers;

use App\HeadOfficeActivity;
use App\Model\Setup\HeadOfficeActivityEvent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class HeadOfficeActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::flash('title', 'Head Office Actitvity');
        $data['ho_events']  = HeadOfficeActivityEvent::where('status', 1)->get();
        return view('head-office-activity.list', $data);
    }

    public function headOfficeActivityListDataTable(Request $request)
    {
        $ho_activity = HeadOfficeActivity::when($request->ho_event_id, function ($query) use ($request) {
            $query->where('ho_event_id', $request->ho_event_id);
        })
            ->when($request->start_date, function ($query) use ($request) {
                $query->where('created_at', '>=', date('Y-m-d', strtotime($request->start_date)) . ' 00:00:00');
            })
            ->when($request->end_date, function ($query) use ($request) {
                $query->where('created_at', '<=', date('Y-m-d', strtotime($request->end_date)) . ' 23:59:59');
            })
            ->latest()
            ->get();

        return DataTables::of($ho_activity)
            ->editColumn('ho_event', function ($ho_activity) {
                return @$ho_activity->ho_event->name;
            })
            ->editColumn('ending_date', function ($ho_activity) {
                return date('d-M-Y', strtotime(@$ho_activity->ending_date));
            })
            ->addColumn('action_column', function ($ho_activity) {
                $links = '<div class="d-flex"> ';
                $links .= '<a class="btn btn-sm btn-success mr-1" title="Edit" href=" ' . route('head.office.activity.edit', $ho_activity->id) . ' "><i class="fa fa-edit"></i></a>';

                $links .= '<form method="POST" class="d-inline" action="' . route('head.office.activity.delete', $ho_activity->id) . '">';
                $links .= csrf_field();
                $links .= method_field("DELETE");
                $links .= '<button type="submit" class="btn btn-sm btn-danger" title="Delete" style="min-width:auto"><i class="fa fa-trash"></i></button>';
                $links .= '</form>';
                $links .= '</div>';

                return $links;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    public function add(Request $request)
    {
        Session::flash('title', 'Head Office Actitvity Add');
        $data['user_info']          = Auth::user();
        $data['ho_events']          = HeadOfficeActivityEvent::where('status', 1)->get();
        $data['ho_activity_ref']    = 'HO_ACTIVITY_ID_' . substr(uniqid(), -8);

        return view('head-office-activity.add')->with($data);
    }

    public function store(Request $request)
    {
        // Validation rules
        $rules = [
            'ho_event_id'           => 'required|numeric',
            'no_of_event'           => 'required|numeric',
            'start_date'            => 'required|date_format:d-m-Y',
            'end_date'              => 'required|date_format:d-m-Y',
            'participant_total'     => 'required|numeric',
            'participant_pwd_total' => 'required|numeric',
        ];

        // Validation messages
        $messages = [
            'required'      => 'The :attribute field is required.',
            'numeric'       => 'The :attribute field must be numeric.',
            'date_format'   => 'The :attribute field must be in the format dd-mm-yyyy.',
        ];

        // Custom attribute names
        $attributes = [
            'ho_event_id'           => 'Event ID',
            'no_of_event'           => 'Number of Events',
            'start_date'            => 'Start Date',
            'end_date'              => 'End Date',
            'participant_total'     => 'Total Participants',
            'participant_pwd_total' => 'Total Participants with Disabilities',
        ];

        // Validate the request
        $request->validate($rules, $messages, $attributes);

        // Get ho_activity_ref
        $ho_activity_ref = $request->ho_activity_ref;

        // Check if ho_activity_ref is unique
        $is_unique = HeadOfficeActivity::where('ho_activity_ref', $ho_activity_ref)->exists();

        // If not unique, generate a new one until unique
        while ($is_unique) {
            $ho_activity_ref = 'HO_ACTIVITY_ID_' . substr(uniqid(), -8);
            $is_unique = HeadOfficeActivity::where('ho_activity_ref', $ho_activity_ref)->exists();
        }

        // Create new HeadOfficeActivity instance
        $ho_activity                                = new HeadOfficeActivity();
        $ho_activity->ho_activity_ref               = $ho_activity_ref;
        $ho_activity->ho_event_id                   = $request->ho_event_id;
        $ho_activity->no_of_event                   = $request->no_of_event;
        $ho_activity->starting_date                 = Carbon::createFromFormat('d-m-Y', $request->start_date);
        $ho_activity->ending_date                   = Carbon::createFromFormat('d-m-Y', $request->end_date);
        $ho_activity->participant_boys              = $request->participant_boys;
        $ho_activity->participant_girls             = $request->participant_girls;
        $ho_activity->participant_men               = $request->participant_men;
        $ho_activity->participant_women             = $request->participant_women;
        $ho_activity->participant_other_gender      = $request->participant_other_gender;
        $ho_activity->participant_total             = $request->participant_total;
        $ho_activity->participant_pwd_boys          = $request->participant_pwd_boys;
        $ho_activity->participant_pwd_girls         = $request->participant_pwd_girls;
        $ho_activity->participant_pwd_men           = $request->participant_pwd_men;
        $ho_activity->participant_pwd_women         = $request->participant_pwd_women;
        $ho_activity->participant_pwd_other_gender  = $request->participant_pwd_other_gender;
        $ho_activity->participant_pwd_total         = $request->participant_pwd_total;

        // Save the record
        $ho_activity->save();

        // Redirect or return response
        return redirect()->route('head.office.activity.index');
    }

    public function edit($id)
    {
        Session::flash('title', 'Head Office Actitvity Edit');
        $data["editData"]   = HeadOfficeActivity::find($id);
        $data['ho_events']  = HeadOfficeActivityEvent::where('status', 1)->get();
        return view('head-office-activity.add', $data);
    }

    public function update(Request $request, $id)
    {
        // Validation rules
        $rules = [
            'ho_event_id'           => 'required|numeric',
            'no_of_event'           => 'required|numeric',
            'start_date'            => 'required|date_format:d-m-Y',
            'end_date'              => 'required|date_format:d-m-Y',
            'participant_total'     => 'required|numeric',
            'participant_pwd_total' => 'required|numeric',
        ];

        // Validation messages
        $messages = [
            'required'      => 'The :attribute field is required.',
            'numeric'       => 'The :attribute field must be numeric.',
            'date_format'   => 'The :attribute field must be in the format dd-mm-yyyy.',
        ];

        // Custom attribute names
        $attributes = [
            'ho_event_id'           => 'Event ID',
            'no_of_event'           => 'Number of Events',
            'start_date'            => 'Start Date',
            'end_date'              => 'End Date',
            'participant_total'     => 'Total Participants',
            'participant_pwd_total' => 'Total Participants with Disabilities',
        ];

        // Validate the request
        $request->validate($rules, $messages, $attributes);


        $ho_activity           =   HeadOfficeActivity::find($id);

        // Assign values to properties
        $ho_activity->ho_event_id                   = $request->ho_event_id;
        $ho_activity->no_of_event                   = $request->no_of_event;
        $ho_activity->starting_date                 = Carbon::createFromFormat('d-m-Y', $request->start_date);
        $ho_activity->ending_date                   = Carbon::createFromFormat('d-m-Y', $request->end_date);
        $ho_activity->participant_boys              = $request->participant_boys;
        $ho_activity->participant_girls             = $request->participant_girls;
        $ho_activity->participant_men               = $request->participant_men;
        $ho_activity->participant_women             = $request->participant_women;
        $ho_activity->participant_other_gender      = $request->participant_other_gender;
        $ho_activity->participant_total             = $request->participant_total;
        $ho_activity->participant_pwd_boys          = $request->participant_pwd_boys;
        $ho_activity->participant_pwd_girls         = $request->participant_pwd_girls;
        $ho_activity->participant_pwd_men           = $request->participant_pwd_men;
        $ho_activity->participant_pwd_women         = $request->participant_pwd_women;
        $ho_activity->participant_pwd_other_gender  = $request->participant_pwd_other_gender;
        $ho_activity->participant_pwd_total         = $request->participant_pwd_total;

        // Save the record
        $ho_activity->save();

        Session::flash('success', 'Head Office Actitvity Event Updated');
        return redirect()->route('head.office.activity.index');
    }


    public function destroy(Request $request, $id)
    {
        $ho_activity = HeadOfficeActivity::findOrFail($id);
        $ho_activity->delete();
        Session::flash('success', 'Head Office Actitvity Event Deleted');
        return redirect()->route('head.office.activity.index');
    }
}
