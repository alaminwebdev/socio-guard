<?php

namespace App\Http\Controllers\Backend\Mastersetup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Setup\PTproductionEvent;

class PTproductionEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pt_production_event=PTproductionEvent::all();
        $request->session()->flash('title', 'PT production Event');
        return view('backend.mastersetup.pt-production-event.list',compact('pt_production_event'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->session()->flash('title', 'PT production Event');
        return view('backend.mastersetup.pt-production-event.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pt_production_event           =   new PTproductionEvent;
        $pt_production_event->name     =   $request->input('name');
        $pt_production_event->status   =   (int)$request->input('status');
        $pt_production_event->save();

        $request->session()->flash('success',"PT production Event information Added");

        return redirect('pt-production-event');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {   
        $editData = PTproductionEvent::find($id);
        $editData->delete();
        $request->session()->flash('error',"PT production Event information deleted");

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
        $editData = PTproductionEvent::find($id);
        return view('backend.mastersetup.pt-production-event.edit',compact('editData'));
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
        $updateData         =   PTproductionEvent::find($id);
        $updateData->name   =   $request->input('name');
        $updateData->status =   $request->input('status');
        $updateData->save();
        $request->session()->flash('success',"PT production Event information updated");

        return redirect('pt-production-event');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $editData = PTproductionEvent::find($id);
        $editData->delete();
        $request->session()->flash('error',"PT production Event information deleted");

        return response()->json('deleted');
    }
}
