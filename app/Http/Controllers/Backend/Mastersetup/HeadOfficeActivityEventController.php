<?php

namespace App\Http\Controllers\Backend\Mastersetup;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Model\Setup\HeadOfficeActivityEvent;

class HeadOfficeActivityEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ho_activity_events = HeadOfficeActivityEvent::all();
        Session::flash('title', 'Head Office Actitvity Events');
        return view('backend.mastersetup.ho-activity-event.list', compact('ho_activity_events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Session::flash('title', 'Head Office Actitvity Events');
        return view('backend.mastersetup.ho-activity-event.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ho_activity_event           =   new HeadOfficeActivityEvent();
        $ho_activity_event->name     =   $request->name;
        $ho_activity_event->status   =   (int)$request->status;
        $ho_activity_event->save();

        Session::flash('success', 'Head Office Actitvity Event Added');
        return redirect()->route('ho-activity-events.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $event = HeadOfficeActivityEvent::find($id);
        if ($event->delete()) {
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'error', 'message' => "Something went wrong. Your event hasn't been deleted!"]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $editData = HeadOfficeActivityEvent::find($id);
        return view('backend.mastersetup.ho-activity-event.edit',compact('editData'));
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
        $ho_activity_event           =   HeadOfficeActivityEvent::find($id);
        $ho_activity_event->name     =   $request->name;
        $ho_activity_event->status   =   (int)$request->status;
        $ho_activity_event->save();

        Session::flash('success', 'Head Office Actitvity Event Updated');
        return redirect()->route('ho-activity-events.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HeadOfficeActivityEvent  $headOfficeActivityEvent
     * @return \Illuminate\Http\Response
     */
    public function destroy(HeadOfficeActivityEvent $headOfficeActivityEvent)
    {
        //
    }
}
