<?php

namespace App\Http\Controllers;

use App\ChildMarriageInitiative;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChildMarriageInitiativeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = ChildMarriageInitiative::get();
        return view('backend.mastersetup.child-marriage-initiative.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.mastersetup.child-marriage-initiative.form');
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
            'name' => 'required|unique:child_marriage_initiatives,name',
        ]);
        ChildMarriageInitiative::create([
            'name' => $request->name,
        ]);
        return redirect()->route('childmarriageinitiative.index')->with('success', "Data Successfully Inserted!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ChildMarriageInitiative  $childMarriageInitiative
     * @return \Illuminate\Http\Response
     */
    public function show(ChildMarriageInitiative $childMarriageInitiative)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ChildMarriageInitiative  $childMarriageInitiative
     * @return \Illuminate\Http\Response
     */
    public function edit(ChildMarriageInitiative $childmarriageinitiative)
    {
        $editData = $childmarriageinitiative;
        return view('backend.mastersetup.child-marriage-initiative.form', compact('editData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ChildMarriageInitiative  $childMarriageInitiative
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChildMarriageInitiative $childmarriageinitiative)
    {
        $request->validate([
            'name' => 'required|unique:child_marriage_initiatives,name,' .$childmarriageinitiative->id,
        ]);
        $childmarriageinitiative->update([
            'name' => $request->name,
        ]);
        return redirect()->route('childmarriageinitiative.index')->with('success', "Data Successfully Update!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ChildMarriageInitiative  $childMarriageInitiative
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChildMarriageInitiative $childmarriageinitiative)
    {
        $childmarriageinitiative->delete();
        return redirect()->route('childmarriageinitiative.index')->with('success', "Data Successfully Deleted!");
    }
}
