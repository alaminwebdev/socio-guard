<?php

namespace App\Http\Controllers\Backend\Mastersetup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ViolenceLocation;
use App\Model\SelpIncidentModel;
class ViolenceLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $violencelocations=ViolenceLocation::all();
        $request->session()->flash('title', 'Violencelocation');
        return view('backend.mastersetup.violencelocations.list',compact('violencelocations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->session()->flash('title', 'Violencelocation');
        return view('backend.mastersetup.violencelocations.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $location=new ViolenceLocation;
        $location->title=$request->input('name');
        $location->status=(int)$request->input('status');
        $location->save();

        $request->session()->flash('success',"Violence Location information added");

        return redirect('violencelocations');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $exist_data     =   SelpIncidentModel::where('violence_location_id', $id)->count();
		// dd($exist_data);
        if ($exist_data > 0) {
            return response()->json('notdeleted');
        } else {
            ViolenceLocation::where('id', $id)->delete();
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
        $editData = ViolenceLocation::find($id);
        return view('backend.mastersetup.violencelocations.edit',compact('editData'));
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
        $updateData = ViolenceLocation::find($id);
        $updateData->title=$request->input('name');
        $updateData->status=$request->input('status');
        $updateData->save();
        $request->session()->flash('success',"Violence location information updated");

        return redirect('violencelocations');
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
