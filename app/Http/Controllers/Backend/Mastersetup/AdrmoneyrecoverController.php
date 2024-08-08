<?php

namespace App\Http\Controllers\Backend\Mastersetup;;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Adrmoneyrecover;
class AdrmoneyrecoverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $adrmoneyrecover=Adrmoneyrecover::all();
        $request->session()->flash('title', 'Money recovered through ADR');
        return view('backend.mastersetup.adrmoneyrecover.list',compact('adrmoneyrecover'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->session()->flash('title', 'Money recovered through ADR');
        return view('backend.mastersetup.adrmoneyrecover.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $adr=new Adrmoneyrecover();
        $adr->title=$request->input('name');
        $adr->status=(int)$request->input('status');
        $adr->save();

        $request->session()->flash('success',"Money recovered through ADR information added");

        return redirect('adrmoneyrecover');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $editData = Adrmoneyrecover::find($id);
        $editData->delete();
        $request->session()->flash('error',"Money recovered through ADR information deleted");

        return redirect('adrmoneyrecover');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $editData = Adrmoneyrecover::find($id);
        return view('backend.mastersetup.adrmoneyrecover.edit',compact('editData'));
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
        $updateData = Adrmoneyrecover::find($id);
        $updateData->title=$request->input('name');
        $updateData->status=$request->input('status');
        $updateData->save();
        $request->session()->flash('success',"Money recovered through ADR information updated");

        return redirect('adrmoneyrecover');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $editData = Adrmoneyrecover::find($id);
        $editData->delete();
        $request->session()->flash('error',"Money recovered through ADR information deleted");

        return redirect('adrmoneyrecover');
    }
}
