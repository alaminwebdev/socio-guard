<?php

namespace App\Http\Controllers\Backend\Mastersetup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Followup;
use App\Model\SelpIncidentModel;

class FollowupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $followups=Followup::all();
        $request->session()->flash('title', 'Followup');
        return view('backend.mastersetup.followup.list',compact('followups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->session()->flash('title', 'Followup');
        return view('backend.mastersetup.followup.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $followup=new Followup;
        $followup->title=$request->input('name');
        $followup->status=(int)$request->input('status');
        $followup->save();

        $request->session()->flash('success',"Followup information added");

        return redirect('followups');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {   
        $exist_data =   SelpIncidentModel::where('followup_id', $id)->count();

        if ($exist_data > 0) {
            return response()->json('notdeleted');
        } else {
            Followup::where('id', $id)->delete();
            return response()->json('deleted');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $editData = Followup::find($id);
        return view('backend.mastersetup.followup.edit',compact('editData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $updateData = Followup::find($id);
        $updateData->title=$request->input('name');
        $updateData->status=$request->input('status');
        $updateData->save();
        $request->session()->flash('success',"Followup information updated");

        return redirect('followups');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $editData = Followup::find($id);
        $editData->delete();
        $request->session()->flash('error',"Followup information deleted");

        return redirect('followups');
    }
}
