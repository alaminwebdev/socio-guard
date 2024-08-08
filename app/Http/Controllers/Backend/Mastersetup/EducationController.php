<?php

namespace App\Http\Controllers\Backend\Mastersetup;

use Illuminate\Http\Request;
use  App\Http\Controllers\Controller;
use App\Model\Education;
use App\Model\SelpIncidentModel;

class EducationController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $educations=Education::all();
        $request->session()->flash('title', 'Education');
        return view('backend.mastersetup.education.list',compact('educations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->session()->flash('title', 'Education');
        return view('backend.mastersetup.education.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $education=new Education;
        $education->title=$request->input('name');
        $education->status=(int)$request->input('status');
        $education->save();

        $request->session()->flash('success',"Education information added");

        return redirect('educations');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $exist_data =   SelpIncidentModel::where('survivor_education_id', $id)->count();
		// dd($exist_data);
        if ($exist_data > 0) {
            return response()->json('notdeleted');
        } else {
            Education::where('id', $id)->delete();
            return response()->json('deleted');
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
        $editData = Education::find($id);
        return view('backend.mastersetup.education.edit',compact('editData'));
        
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
        $updateData = Education::find($id);
        $updateData->title=$request->input('name');
        $updateData->status=$request->input('status');
        $updateData->save();
        $request->session()->flash('success',"Education information updated");

        return redirect('educations');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $editData = Education::find($id);
        $editData->delete();
        $request->session()->flash('error',"Education information deleted");

        return redirect('educations');
    }
}
