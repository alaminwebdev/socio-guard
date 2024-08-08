<?php

namespace App\Http\Controllers\Backend\Mastersetup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Pititioncase;
class PititioncaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pititioncases=Pititioncase::all();
        $request->session()->flash('title', 'Pititioncase');
        return view('backend.mastersetup.pititioncase.list',compact('pititioncases'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->session()->flash('title', 'Pititioncase');
        return view('backend.mastersetup.pititioncase.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $case=new Pititioncase;
        $case->title=$request->input('name');
        $case->status=(int)$request->input('status');
        $case->save();

        $request->session()->flash('success',"Pititioncase information added");

        return redirect('pititioncases');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        Pititioncase::where('id', $id)->delete();
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
        $editData = Pititioncase::find($id);
        return view('backend.mastersetup.pititioncase.edit',compact('editData'));
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
        $updateData = Pititioncase::find($id);
        $updateData->title=$request->input('name');
        $updateData->status=$request->input('status');
        $updateData->save();
        $request->session()->flash('success',"Pititioncase information updated");

        return redirect('pititioncases');
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
