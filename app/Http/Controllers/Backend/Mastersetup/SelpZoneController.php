<?php

namespace App\Http\Controllers\Backend\Mastersetup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Selpzone;
class SelpZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $selpzones=Selpzone::all();
        $request->session()->flash('title', 'Education');
        return view('backend.mastersetup.selpzone.list',compact('selpzones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->session()->flash('title', 'Selpzone');
        return view('backend.mastersetup.selpzone.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $selp=new Selpzone();
        $selp->title=$request->input('name');
        $selp->status=(int)$request->input('status');
        $selp->save();

        $request->session()->flash('success',"Selpzone information added");

        return redirect('selpzones');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $editData = Selpzone::find($id);
        $editData->delete();
        $request->session()->flash('error',"Selpzone information deleted");

        return redirect('selpzones');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $editData = Selpzone::find($id);
        return view('backend.mastersetup.selpzone.edit',compact('editData'));
        
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
        $updateData = Selpzone::find($id);
        $updateData->title=$request->input('name');
        $updateData->status=$request->input('status');
        $updateData->save();
        $request->session()->flash('success',"Selpzone information updated");

        return redirect('selpzones');

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $editData = Selpzone::find($id);
        $editData->delete();
        $request->session()->flash('error',"Selpzone information deleted");

        return redirect('selpzones');
    }
}
