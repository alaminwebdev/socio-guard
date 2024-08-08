<?php

namespace App\Http\Controllers\Backend\Mastersetup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Setup\CommunityEvent;

class CommunityEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $community_event=CommunityEvent::all();
        $request->session()->flash('title', 'Community Event');
        return view('backend.mastersetup.community-event.list',compact('community_event'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->session()->flash('title', 'Community Event');
        return view('backend.mastersetup.community-event.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $Community_event           =   new CommunityEvent;
        $Community_event->name     =   $request->input('name');
        $Community_event->status   =   (int)$request->input('status');
        $Community_event->save();

        $request->session()->flash('success',"Community Event information Added");

        return redirect('community-event');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {   
        $editData = CommunityEvent::find($id);
        $editData->delete();
        $request->session()->flash('error',"Community Event information deleted");

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
        $editData = CommunityEvent::find($id);
        return view('backend.mastersetup.community-event.edit',compact('editData'));
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
        $updateData         =   CommunityEvent::find($id);
        $updateData->name   =   $request->input('name');
        $updateData->status =   $request->input('status');
        $updateData->save();
        $request->session()->flash('success',"Community Event information updated");

        return redirect('community-event');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $editData = CommunityEvent::find($id);
        $editData->delete();
        $request->session()->flash('error',"Community Event information deleted");

        return response()->json('deleted');
    }
}
