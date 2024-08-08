<?php

namespace App\Http\Controllers\Backend\Mastersetup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Setup\CampaignEvent;

class CampaignEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $campaign_event=CampaignEvent::all();
        $request->session()->flash('title', 'Campaign Event');
        return view('backend.mastersetup.campaign-event.list',compact('campaign_event'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->session()->flash('title', 'Campaign Event');
        return view('backend.mastersetup.campaign-event.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $meeting_event           =   new CampaignEvent;
        $meeting_event->name     =   $request->input('name');
        $meeting_event->status   =   (int)$request->input('status');
        $meeting_event->save();

        $request->session()->flash('success',"Campaign Event information Added");

        return redirect('campaign-event');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {   
        $editData = CampaignEvent::find($id);
        $editData->delete();
        $request->session()->flash('error',"Campaign Event information deleted");

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
        $editData = CampaignEvent::find($id);
        return view('backend.mastersetup.campaign-event.edit',compact('editData'));
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
        $updateData         =   CampaignEvent::find($id);
        $updateData->name   =   $request->input('name');
        $updateData->status =   $request->input('status');
        $updateData->save();
        $request->session()->flash('success',"Campaign Event information updated");

        return redirect('campaign-event');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $editData = CampaignEvent::find($id);
        $editData->delete();
        $request->session()->flash('error',"Campaign Event information deleted");

        return response()->json('deleted');
    }
}
