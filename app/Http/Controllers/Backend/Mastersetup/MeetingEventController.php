<?php

namespace App\Http\Controllers\Backend\Mastersetup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Setup\MeetingEvent;

class MeetingEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $meeting_event=MeetingEvent::all();
        $request->session()->flash('title', 'Meeting Event');
        return view('backend.mastersetup.meeting-event.list',compact('meeting_event'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->session()->flash('title', 'Meeting Event');
        return view('backend.mastersetup.meeting-event.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $meeting_event           =   new MeetingEvent;
        $meeting_event->name     =   $request->input('name');
        $meeting_event->status   =   (int)$request->input('status');
        $meeting_event->save();

        $request->session()->flash('success',"Meeting Event information Added");

        return redirect('meeting-event');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {   
        MeetingEvent::find($id)->delete();
        $request->session()->flash('error',"Meeting Event information deleted");

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
        $editData = MeetingEvent::find($id);
        return view('backend.mastersetup.meeting-event.edit',compact('editData'));
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
        $updateData         =   MeetingEvent::find($id);
        $updateData->name   =   $request->input('name');
        $updateData->status =   $request->input('status');
        $updateData->save();
        $request->session()->flash('success',"Meeting Event information updated");

        return redirect('meeting-event');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        MeetingEvent::find($id)->delete();
        $request->session()->flash('error',"Meeting Event information deleted");

        return response()->json('deleted');
    }
}
