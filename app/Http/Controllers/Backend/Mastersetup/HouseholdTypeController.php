<?php

namespace App\Http\Controllers\Backend\Mastersetup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Householdtype;


class HouseholdTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $householdtypes=Householdtype::all();
        $request->session()->flash('title', 'Household type');
        return view('backend.mastersetup.householdtype.list',compact('householdtypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->session()->flash('title', 'Household type');
        return view('backend.mastersetup.householdtype.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $householdtype=new Householdtype();
        $householdtype->title=$request->input('name');
        $householdtype->status=(int)$request->input('status');
        $householdtype->save();

        $request->session()->flash('success',"Household type information added");

        return redirect('householdtypes');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $editData = Householdtype::find($id);
        $editData->delete();
        $request->session()->flash('error',"Household type information deleted");

        return redirect('householdtypes');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $editData = Householdtype::find($id);
        return view('backend.mastersetup.householdtype.edit',compact('editData'));
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
        $updateData = Householdtype::find($id);
        $updateData->title=$request->input('name');
        $updateData->status=$request->input('status');
        $updateData->save();
        $request->session()->flash('success',"Household type information updated");

        return redirect('householdtypes');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $editData = Householdtype::find($id);
        $editData->delete();
        $request->session()->flash('error',"Household type information deleted");

        return redirect('householdtypes');
    }
}
