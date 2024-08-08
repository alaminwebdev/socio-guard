<?php

namespace App\Http\Controllers\Backend;

use App\Exports\MisReportExport;
use App\Http\Controllers\Controller;
use App\User;
use App\Model\AuditLog;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Session;

class AuditLogController extends Controller
{
    public function view()
    {
        $data['auth_user']      = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        return view('backend.admin.audit_log.audit_log', $data);
    }

    public function getAuditLogDatatable(Request $request)
    {
        // dd($request->all());
        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date = date("Y-m-d", strtotime($request->to_date));
        
        $auditlogs = AuditLog::with(['employee_info'])->select('id', 'employee_id', 'employee_pin', 'employee_name', 'login_time', 'logout_time','complain_id','pollisomaj_data_id','description','action_type', 'created_at', 'ip_address');
        if ($request->from_date != null || $request->to_date != null) {
            $auditlogs->whereBetween('created_at', [$from_date.' 00:00:00',$to_date.' 23:59:59']);
        }
        $auditlogs->orderBy('id', 'DESC');
        // dd($auditlogs->get());


        return DataTables::of($auditlogs)
        ->addIndexColumn()
        ->addColumn('employee_name', function($auditlogs){
            return $auditlogs['employee_info']['name'];
        })
        ->addColumn('employee_pin', function($auditlogs){
            return $auditlogs['employee_info']['pin'];
        })
        ->editColumn('created_at', function ($auditlogs){
            return date('d-m-Y H:i:s', strtotime($auditlogs->created_at));
        })
        ->editColumn('action_type', function ($list) {
            $actionBtn = '';
            if($list->action_type == 1){
                $actionBtn = '<span class="badge badge-success">Inserted</span>';
            } elseif($list->action_type == 2) {
                $actionBtn = '<span class="badge badge-warning">Updated</span>';
            } elseif($list->action_type == 3) {
                $actionBtn = '<span class="badge badge-danger">Deleted</span>';
            } elseif($list->action_type == 4) {
                $actionBtn = '<span class="badge badge-success">Report Generate</span>';
            } elseif($list->action_type == 5) {
                $actionBtn = '<span class="badge badge-success">Login-Logout</span>';
            } else{
                $actionBtn = '<span class="badge badge-primary">No Status</span>';
            }
            return $actionBtn;
        })
        ->addIndexColumn()
        ->escapeColumns([])
        ->make(true);

    }

    public function deleteAuditLog(Request $request, $from_date, $to_date)
    {
        $from_date  = date('Y-m-d', strtotime($request->from_date));
        $to_date    = date('Y-m-d', strtotime($request->to_date));
        AuditLog::whereBetween('created_at', [$from_date.' 00:00:00',$to_date.' 23:59:59'])->delete();
        return response()->json('deleted');
    }
}
