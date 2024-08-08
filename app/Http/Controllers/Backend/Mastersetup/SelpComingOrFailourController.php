<?php

namespace App\Http\Controllers\Backend\Mastersetup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\SelpComingOrFailour;
class SelpComingOrFailourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $selpcomings=SelpComingOrFailour::all();
        $request->session()->flash('title', 'Selp Coming or Failour');
        return view('backend.mastersetup.causeofselpfailours.list',compact('selpcomings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->session()->flash('title', 'Selp Coming or Failour');
        return view('backend.mastersetup.causeofselpfailours.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item=new SelpComingOrFailour;
        $item->title=$request->input('name');
        $item->status=(int)$request->input('status');
        $item->save();

        $request->session()->flash('success',"Selp Coming or Failour information added");

        return redirect('selpcomings');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        SelpComingOrFailour::where('id', $id)->delete();
        return response()->json('deleted');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $editData = SelpComingOrFailour::find($id);
        return view('backend.mastersetup.causeofselpfailours.edit',compact('editData'));
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
        $updateData = SelpComingOrFailour::find($id);
        $updateData->title=$request->input('name');
        $updateData->status=$request->input('status');
        $updateData->save();
        $request->session()->flash('success',"Selp Coming or Failour information updated");

        return redirect('selpcomings');
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
