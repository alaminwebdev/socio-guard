<?php

namespace App\Http\Controllers\Backend\Mastersetup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Setup\SecondaryRefferal;

class SecondaryRefferalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $refferal=SecondaryRefferal::all();
        $request->session()->flash('title', 'Secondary Refferal');
        return view('backend.mastersetup.secondary-refferal.list',compact('refferal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->session()->flash('title', 'Secondary Refferal');
        return view('backend.mastersetup.secondary-refferal.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $refferal           =   new SecondaryRefferal;
        $refferal->name     =   $request->input('name');
        $refferal->status   =   (int)$request->input('status');
        $refferal->save();

        $request->session()->flash('success',"Secondary Refferal information Added");

        return redirect('secondary-refferal');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {   
        SecondaryRefferal::find($id)->delete();
        // $request->session()->flash('error',"Secondary Refferal information deleted");

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
        $editData = SecondaryRefferal::find($id);
        return view('backend.mastersetup.secondary-refferal.edit',compact('editData'));
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
        $updateData         =   SecondaryRefferal::find($id);
        $updateData->name   =   $request->input('name');
        $updateData->status =   $request->input('status');
        $updateData->save();
        $request->session()->flash('success',"Secondary Refferal information updated");

        return redirect('secondary-refferal');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        SecondaryRefferal::find($id)->delete();
        $request->session()->flash('error',"Secondary Refferal information deleted");

        return response()->json('deleted');
    }
}
