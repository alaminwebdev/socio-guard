<?php

namespace App\Http\Controllers\Backend\Menu;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Role;

class RoleController extends Controller
{
    public function index()
    {
        $data['roles'] = Role::with(['parent_role'])->get();
        //dd($data['roles']->toArray());
    	return view('backend.user.view-user-role', $data);
    }

    public function add()
    {
        $data['roles'] = Role::all();
        return view('backend.user.add_user_role', $data);
    }

    public function store(Request $request)
    {
        // dd($request->toArray());

        $this->validate($request, [
            'name' => 'required'
        ]);    
      
        $roleData              = new Role;
        $roleData->name        = $request->name;
        $roleData->role_id     = $request->role_id;
        $roleData->description = $request->description;
        $roleData->save();

        $request->session()->flash('success', 'Role Name Save Successfully');
        return redirect()->route('user.role');
    }

    public function edit($id)
    {
        $data['roles']    = Role::all();
        $data['editData'] = Role::find($id);
        // dd($data['editData']->toArray());

        return view('backend.user.edit_user_role', $data);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $roleData              = Role::find($id);
        $roleData->name        = $request->name;
        $roleData->role_id     = $request->role_id;
        $roleData->description = $request->description;
        $roleData->save();

        $request->session()->flash('success','Role Name Updated Successfully');
        return redirect()->route('user.role');
    }

    public function delete($id)
    {
        Role::find($id)->delete();
        $request->session()->flash('success','Role Name Updated Successfully');
        return redirect()->route('user.role');
    }
}
