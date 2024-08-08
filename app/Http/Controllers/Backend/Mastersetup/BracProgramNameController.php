<?php

namespace App\Http\Controllers\Backend\Mastersetup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Bracprogramname;
class BracProgramNameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $bracprogramnames=Bracprogramname::all();
        $request->session()->flash('title', 'BRAC Program Name');
        return view('backend.mastersetup.bracprogramname.list',compact('bracprogramnames'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->session()->flash('title', 'BRAC Program Name');
        return view('backend.mastersetup.bracprogramname.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $name=new Bracprogramname();
        $name->title=$request->input('name');
        $name->status=(int)$request->input('status');
        $name->save();

        $request->session()->flash('success',"BRAC Program Name information added");

        return redirect('bracprogramnames');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $editData = Bracprogramname::find($id);
        $editData->delete();
        $request->session()->flash('error',"BRAC Program Name information deleted");

        return redirect('bracprogramnames');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $editData = Bracprogramname::find($id);
        return view('backend.mastersetup.bracprogramname.edit',compact('editData'));
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
        $updateData = Bracprogramname::find($id);
        $updateData->title=$request->input('name');
        $updateData->status=$request->input('status');
        $updateData->save();
        $request->session()->flash('success',"BRAC Program Name information updated");

        return redirect('bracprogramnames');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $editData = Bracprogramname::find($id);
        $editData->delete();
        $request->session()->flash('error',"BRAC Program Name information deleted");

        return redirect('bracprogramnames');
    }
}
