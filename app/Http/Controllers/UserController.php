<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Model\Role;
use App\Model\UserRole;
use DB;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MisReportExport;

class UserController extends Controller
{
    public function index()
    {
        $data['allData'] = User::with(['user_role'])->get();
        return view('backend.user.view-user', $data);
    }

    public function add()
    {
        $data['roles'] = Role::all();
        return view('backend.user.user-add', $data);
    }

    public function storeUser(Request $request)
    {
        // dd($request->toArray());
        $request->validate([
            'name'      => 'required',
            'pin'       => 'required|unique:users,pin',
            'email'     => 'required|unique:users,email'
        ]);
        $userexistpin = User::where('pin', $request->pin)->first();
        if($userexistpin != null) {
            return redirect()->back()->with('error', 'This User is Already Exist');
        }

        $userexist = User::where('email', $request->email)->first();
        if($userexist != null) {
            return redirect()->back()->with('error', 'This Email is Already Exist');
        }

        $user              = new User();
        $user->name        = $request->name;
        $user->email       = $request->email;
        $user->password    = bcrypt($request->password);
        $user->mobile      = $request->mobile;
        $user->designation = $request->designation;
        $user->pin         = $request->pin;
        $user->created_by  = Auth::id();

        if ($user->save())
        {
            foreach($request->user_role as $role)
            {
                $params['user_id'] = $user->id;
                $params['role_id'] = $role;
                UserRole::create($params);
            }
        }

        return redirect()->route('user')->with('success', 'Successfully Inserted');
    }

    public function editUser($id)
    {
        $data['roles']      = Role::all();
        $data['editData']   = User::find($id);
        $data['role_array'] = UserRole::where('user_id', $id)->get()->toArray();

        return view('backend.user.user-add', $data);
    }

    public function updateUser(Request $request, $id)
    {
        // dd($request->all());
        // $this->validate($request, [
        //     'name'     => 'required',
        //     'email'    => 'required|email',
        //     'password' => 'required|confirmed|min:6',
        //     'role_id'  => 'required'
        // ]);

        $user              = User::find($id);
        $user->name        = $request->name;
        $user->email       = $request->email;
        $user->mobile      = $request->mobile;
        $user->designation = $request->designation;
        $user->pin         = $request->pin;
        if ($request->password != null) {
            $user->password = bcrypt($request->password);
        }
        $user->updated_by  = Auth::id();
        // dd($user);

        if($user->save())
        {
            UserRole::where('user_id', $id)->delete();
            foreach($request->user_role as $role)
            {
                $params['user_id'] = $user->id;
                $params['role_id'] = $role;
                UserRole::create($params);
            }
        }

        return redirect()->route('user')->with('success', 'Successfully Updated');
    }

    public function deleteUser(Request $request)
    {
        User::find($request->id)->delete();
    }

    public function notifications()
    {
        return auth()->user()->unreadNotifications()->limit(25)->get()->toArray();
    }
    public function exportUser()
    {
        $data['users'] = User::with([
            'user_role',
            'setup_user_area' => function ($query) {
                $query->withTrashed();
                $query->with([
                    'setup_user_region',
                    'setup_user_division',
                    'setup_user_district',
                    'setup_user_upazila',
                    'setup_user_union'
                ]);
            }
        ])
        ->get();

        // return view('backend.user.excel', $data);
        return Excel::download(new MisReportExport($data, 'backend.user.excel'), 'user-list.xlsx');
    }
}
