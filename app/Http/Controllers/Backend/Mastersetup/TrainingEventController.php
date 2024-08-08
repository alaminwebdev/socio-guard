<?php

namespace App\Http\Controllers\Backend\Mastersetup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Setup\TrainingEvent;

class TrainingEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $training_event=TrainingEvent::all();
        $request->session()->flash('title', 'Training Event');
        return view('backend.mastersetup.training-event.list',compact('training_event'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->session()->flash('title', 'Training Event');
        return view('backend.mastersetup.training-event.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $training_event           =   new TrainingEvent;
        $training_event->name     =   $request->input('name');
        $training_event->status   =   (int)$request->input('status');
        $training_event->save();

        $request->session()->flash('success',"Training Event information Added");

        return redirect('training-event');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {   
        $editData = TrainingEvent::find($id);
        $editData->delete();
        $request->session()->flash('error',"Training Event information deleted");

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
        $editData = TrainingEvent::find($id);
        return view('backend.mastersetup.training-event.edit',compact('editData'));
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
        $updateData         =   TrainingEvent::find($id);
        $updateData->name   =   $request->input('name');
        $updateData->status =   $request->input('status');
        $updateData->save();
        $request->session()->flash('success',"Training Event information updated");

        return redirect('training-event');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $editData = TrainingEvent::find($id);
        $editData->delete();
        $request->session()->flash('error',"Training Event information deleted");

        return response()->json('deleted');
    }
}
