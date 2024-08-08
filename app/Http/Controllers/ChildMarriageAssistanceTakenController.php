<?php

namespace App\Http\Controllers;

use App\ChildMarriageAssistanceTaken;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChildMarriageAssistanceTakenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = ChildMarriageAssistanceTaken::get();
        return view('backend.mastersetup.child-marriage-assistance.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.mastersetup.child-marriage-assistance.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:child_marriage_assistance_takens,name',
        ]);
        ChildMarriageAssistanceTaken::create([
            'name' => $request->name,
        ]);
        return redirect()->route('childmarriageassistancetaken.index')->with('success', "Data Successfully Inserted!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ChildMarriageAssistanceTaken  $childmarriageassistancetaken
     * @return \Illuminate\Http\Response
     */
    public function show(ChildMarriageAssistanceTaken $childmarriageassistancetaken)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ChildMarriageAssistanceTaken  $childMarriageAssistanceTaken
     * @return \Illuminate\Http\Response
     */
    public function edit(ChildMarriageAssistanceTaken $childmarriageassistancetaken)
    {
        $editData = $childmarriageassistancetaken;
        return view('backend.mastersetup.child-marriage-assistance.form', compact('editData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ChildMarriageAssistanceTaken  $childMarriageAssistanceTaken
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChildMarriageAssistanceTaken $childmarriageassistancetaken)
    {
        $request->validate([
            'name' => 'required|unique:child_marriage_assistance_takens,name,' .$childmarriageassistancetaken->id,
        ]);
        $childmarriageassistancetaken->update([
            'name' => $request->name,
        ]);
        return redirect()->route('childmarriageassistancetaken.index')->with('success', "Data Successfully Update!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ChildMarriageAssistanceTaken  $childMarriageAssistanceTaken
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChildMarriageAssistanceTaken $childmarriageassistancetaken)
    {
        $childmarriageassistancetaken->delete();
        return redirect()->route('childmarriageassistancetaken.index')->with('success', "Data Successfully Deleted!");
    }
}
