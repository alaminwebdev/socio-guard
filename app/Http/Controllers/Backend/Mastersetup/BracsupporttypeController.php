<?php

namespace App\Http\Controllers\Backend\Mastersetup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Bracsupporttypes;
use App\Model\SelpIncidentModel;
class BracsupporttypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $bracsupports=Bracsupporttypes::all();
        $request->session()->flash('title', 'Bracsupporttypes');
        return view('backend.mastersetup.bracsupport.list',compact('bracsupports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->session()->flash('title', 'Brac Support Type');
        return view('backend.mastersetup.bracsupport.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bracsupporttype=new Bracsupporttypes;
        $bracsupporttype->title=$request->input('name');
        $bracsupporttype->status=(int)$request->input('status');
        $bracsupporttype->save();

        $request->session()->flash('success',"Bracsupporttypes information added");

        return redirect('bracsupports');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        // $editData = Bracsupporttypes::find($id);
        // $editData->delete();
        // $request->session()->flash('error',"Bracsupporttypes information deleted");

        // return redirect('bracsupports');

        $exist_data =   SelpIncidentModel::where('brac_supporttype_id', $id)->count();

        if ($exist_data > 0) {
            return response()->json('notdeleted');
        } else {
            Bracsupporttypes::where('id', $id)->delete();
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
        $editData = Bracsupporttypes::find($id);
        return view('backend.mastersetup.bracsupport.edit',compact('editData'));
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
        $updateData = Bracsupporttypes::find($id);
        $updateData->title=$request->input('name');
        $updateData->status=$request->input('status');
        $updateData->save();
        $request->session()->flash('success',"Bracsupporttypes information updated");

        return redirect('bracsupports');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $editData = Bracsupporttypes::find($id);
        $editData->delete();
        $request->session()->flash('error',"Bracsupporttypes information deleted");

        return redirect('bracsupport');
    }
}
