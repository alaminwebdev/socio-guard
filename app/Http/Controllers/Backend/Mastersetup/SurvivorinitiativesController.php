<?php

namespace App\Http\Controllers\Backend\Mastersetup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Survivorinitiative;

class SurvivorinitiativesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $survivorinitiatives=Survivorinitiative::all();
        $request->session()->flash('title', 'Survivor Initiative');
        return view('backend.mastersetup.survivorinitiative.list',compact('survivorinitiatives'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->session()->flash('title', 'Survivor Initiative');
        return view('backend.mastersetup.survivorinitiative.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $initiative=new Survivorinitiative;
        $initiative->title=$request->input('name');
        $initiative->status=(int)$request->input('status');
        $initiative->save();

        $request->session()->flash('success',"Survivor Initiative");

        return redirect('survivorinitiatives');
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $editData = Survivorinitiative::find($id);
        $editData->delete();
        $request->session()->flash('error',"Survivor Initiative information deleted");

        return redirect('survivorinitiatives');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $editData = Survivorinitiative::find($id);
        return view('backend.mastersetup.survivorinitiative.edit',compact('editData'));
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
        $updateData = Survivorinitiative::find($id);
        $updateData->title=$request->input('name');
        $updateData->status=$request->input('status');
        $updateData->save();
        $request->session()->flash('success',"Survivor Initiative information updated");

        return redirect('survivorinitiatives');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $editData = Survivorinitiative::find($id);
        $editData->delete();
        $request->session()->flash('error',"Survivor Initiative information deleted");

        return redirect('survivorinitiatives');
    }
}
