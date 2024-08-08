<?php

namespace App\Http\Controllers;

use App\SwapnosarothiSkill;
use Illuminate\Http\Request;

class SwapnosarothiSkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['skills'] = SwapnosarothiSkill::where('status', 1)->get();
        return view('swapnosarothi.skill-setup.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('swapnosarothi.skill-setup.create');
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
            'code' => 'required|unique:swapnosarothi_skills,code',
            'name' => 'required',
            'order' => 'integer',
        ]);

        SwapnosarothiSkill::create($request->all());
        $request->session()->flash("success", "Skill Successfully Added!");
        return back()->with('Skill Successfully Added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SwapnosarothiSkill  $swapnosarothiSkill
     * @return \Illuminate\Http\Response
     */
    public function show(SwapnosarothiSkill $swapnosarothiSkill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SwapnosarothiSkill  $swapnosarothiSkill
     * @return \Illuminate\Http\Response
     */
    public function edit(SwapnosarothiSkill $swapnosarothiskill)
    {
        $editData = $swapnosarothiskill;
        return view('swapnosarothi.skill-setup.edit', compact('editData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SwapnosarothiSkill  $swapnosarothiSkill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SwapnosarothiSkill $swapnosarothiskill)
    {
        $request->validate([
            'code' => 'required|unique:swapnosarothi_skills,code,'.$swapnosarothiskill->id,
            'name' => 'required',
            'order' => 'integer',
        ]);

        $swapnosarothiskill->update($request->all());
        $request->session()->flash("success", "Skill Update Successfull!");
        return redirect()->route('swapnosarothiskill.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SwapnosarothiSkill  $swapnosarothiSkill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, SwapnosarothiSkill $swapnosarothiskill)
    {
        $swapnosarothiskill->delete();
        $request->session()->flash("success", "Skill Delete Successfull!");
        return back()->with('Skill Delete Successfull!');
    }
}
