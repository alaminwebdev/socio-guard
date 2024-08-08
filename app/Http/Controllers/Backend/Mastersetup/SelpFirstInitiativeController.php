<?php

namespace App\Http\Controllers\Backend\Mastersetup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\SelpFirstInitiative;

class SelpFirstInitiativeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $selpfirstinitiatives=SelpFirstInitiative::all();
        $request->session()->flash('title', 'Selp initiatives');
        return view('backend.mastersetup.selpfirstinitiative.list',compact('selpfirstinitiatives'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->session()->flash('title', 'Selp initiatives');
        return view('backend.mastersetup.selpfirstinitiative.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $selpdata=new SelpFirstInitiative;
        $selpdata->title=$request->input('name');
        $selpdata->status=(int)$request->input('status');
        $selpdata->save();

        $request->session()->flash('success',"Selp First Initiative information added");

        return redirect('selpfirstinitiatives');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $editData = SelpFirstInitiative::find($id);
        $editData->delete();
        $request->session()->flash('error',"Selp First Initiative information deleted");

        return redirect('selpfirstinitiatives');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $editData = SelpFirstInitiative::find($id);
        return view('backend.mastersetup.selpfirstinitiative.edit',compact('editData'));
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
        $updateData = SelpFirstInitiative::find($id);
        $updateData->title=$request->input('name');
        $updateData->status=$request->input('status');
        $updateData->save();
        $request->session()->flash('success',"Selp First Initiative information added");

        return redirect('selpfirstinitiatives');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
