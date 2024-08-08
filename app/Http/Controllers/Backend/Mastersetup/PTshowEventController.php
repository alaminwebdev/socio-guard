<?php

namespace App\Http\Controllers\Backend\Mastersetup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Setup\PTshowEvent;

class PTshowEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pt_show_event=PTshowEvent::all();
        $request->session()->flash('title', 'PT Show Event');
        return view('backend.mastersetup.pt-show-event.list',compact('pt_show_event'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->session()->flash('title', 'PT Show Event');
        return view('backend.mastersetup.pt-show-event.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pt_show_event           =   new PTshowEvent;
        $pt_show_event->name     =   $request->input('name');
        $pt_show_event->status   =   (int)$request->input('status');
        $pt_show_event->save();

        $request->session()->flash('success',"PT Show Event information Added");

        return redirect('pt-show-event');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {   
        $editData = PTshowEvent::find($id);
        $editData->delete();
        $request->session()->flash('error',"PT Show Event information deleted");

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
        $editData = PTshowEvent::find($id);
        return view('backend.mastersetup.pt-show-event.edit',compact('editData'));
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
        $updateData         =   PTshowEvent::find($id);
        $updateData->name   =   $request->input('name');
        $updateData->status =   $request->input('status');
        $updateData->save();
        $request->session()->flash('success',"PT Show Event information updated");

        return redirect('pt-show-event');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $editData = PTshowEvent::find($id);
        $editData->delete();
        $request->session()->flash('error',"PT Show Event information deleted");

        return response()->json('deleted');
    }
}
