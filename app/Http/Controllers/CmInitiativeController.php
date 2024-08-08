<?php

namespace App\Http\Controllers;

use App\CmInitiative;
use Illuminate\Http\Request;
use App\SwapnosarothiProfile;
use App\SwapnosarothiCmPrevention;
use App\SwapnosarothiMarriageInfo;
use Illuminate\Support\Facades\DB;
use App\Model\Admin\Setup\Division;
use App\SwapnosarothiCmGirlEducation;
use App\SwapnosarothiCmMarriagePlace;
use App\SwapnosarothiCmMarriagReason;
use App\SwapnosarothiCmPreventionType;
use App\SwapnosarothiCmMarriageRegister;
use App\SwapnosarothiCmGirlInstituteonType;
use App\SwapnosarothiCmWhoInitiatedMarriag;
use App\Model\Admin\Setup\CEP_Region\Region;
use App\Model\Admin\Setup\Occupation;
use App\Model\Education;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Profiler\Profile;

class CmInitiativeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['profile'] = SwapnosarothiProfile::with(['groupName', 'cmInitiatives' => function($q){
            $q->orderBy('id', 'asc');
        }])->find($request->profile_id);

        $data['cm_prevention_types'] = SwapnosarothiCmPreventionType::all();
        $data['cm_preventions'] = SwapnosarothiCmPrevention::where('status', 1)->get();
        $data['cm_marriage_registers'] = SwapnosarothiCmMarriageRegister::where('status', 1)->get();
        $data['cm_marriage_places'] = SwapnosarothiCmMarriagePlace::where('status', 1)->get();
        $data['cm_marriag_reasons'] = SwapnosarothiCmMarriagReason::where('status', 1)->get();
        $data['cm_who_initiated_marriags'] = SwapnosarothiCmWhoInitiatedMarriag::where('status', 1)->get();
        $data['cm_girl_instituteon_types'] = SwapnosarothiCmGirlInstituteonType::where('status', 1)->get();
        $data['cmlastInitiative'] = $data['profile']->cmInitiatives->pluck('initiative')->last();
        $data['zones'] = Region::all();
        $data['divisions'] = Division::where('status', 1)->get();
        $data['occupations'] = Occupation::where('status', 1)->get();
        $data['educations'] = Education::where('status', 1)->get();

        return view('swapnosarothi.cm_initiative.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->prevention_type == 1){
            $request->validate([
                'initiative' => 'required',
                'prevention_type' => 'required',
                'prevention_by' => 'required',
                'date' => 'required',
            ]);
        }else{
            
            $request->validate([
                'initiative' => 'required',
                'date' => 'required',
                'prevention_type' => 'required',
                'prevention_by' => 'required',
                'marriage_date' => 'required',
                'registration_completed' => 'required',
            ]);
        }
        

        try {
            DB::beginTransaction();
            $initiative = "";
            if($request->initiative == 1){
                $initiative = $request->initiative . 'st';
            }elseif($request->initiative == 2){
                $initiative = $request->initiative . 'nd';
                
            }elseif($request->initiative == 3){
                $initiative = $request->initiative . 'rd';
            }else{
                $initiative = $request->initiative . 'th';
            }
           $cmInitiative =  CmInitiative::create([
                'swapnosarothi_profile_id' => $request->swapnosarothi_profile_id,
                'initiative' => $initiative,
                'prevention_type' => $request->prevention_type,
                'prevention_by' => $request->prevention_by,
                'age' => $request->age,
                'date' => $request->date,
                'created_by' => Auth::id(),
            ]);

            if($request->prevention_type == 2 || $request->prevention_type == 3){
                $marriageInfo = SwapnosarothiMarriageInfo::create([
                    "swapnosarothi_profile_id" => $request->swapnosarothi_profile_id,
                    "cm_initiative_id" => $cmInitiative->id,
                    "marriage_date" => $request->marriage_date,
                    "registration_completed" => $request->registration_completed,
                    "who_registered"=> $request->who_registered,
                    "marriage_place" => $request->marriage_place,
                    "marriage_reason" => $request->marriage_reason,
                    "asked_by_groom" => $request->asked_by_groom,
                    "dower_amount" => $request->dower_amount,
                    "marriag_initiated_person" => $request->marriag_initiated_person,
                    "girl_educational" => $request->girl_educational,
                    "studentship_status" => $request->studentship_status,
                    "educatinal_institution" => $request->educatinal_institution,
                    "groom_age" => $request->groom_age,
                    "girl_age" => $request->girl_age,
                    "groom_profession" => $request->groom_profession,
                    "groom_education" => $request->groom_education,
                ]);

                SwapnosarothiProfile::where('id', $request->swapnosarothi_profile_id)->update([
                    'group_status' => 'married',
                ]);
            }

        
            DB::commit();
            $request->session()->flash("success", "Data Successfully Inserted!");
            return back();
        
        } catch (\Exception $e) {
            DB::rollback();
        
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CmInitiative  $cmInitiative
     * @return \Illuminate\Http\Response
     */
    public function show(CmInitiative $cminitiative)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CmInitiative  $cmInitiative
     * @return \Illuminate\Http\Response
     */
    public function edit(CmInitiative $cminitiative)
    {
        // return count($cminitiative->profile->marriageInfo);
        $data['cminitiative'] = $cminitiative;
        $data['cm_prevention_types'] = SwapnosarothiCmPreventionType::all();

        $data['cm_preventions'] = SwapnosarothiCmPrevention::where('prevention_type_id', $cminitiative->prevention_type)->get();
        
        $data['cm_marriage_registers'] = SwapnosarothiCmMarriageRegister::where('status', 1)->get();
        $data['cm_marriage_places'] = SwapnosarothiCmMarriagePlace::where('status', 1)->get();
        $data['cm_marriag_reasons'] = SwapnosarothiCmMarriagReason::where('status', 1)->get();
        $data['cm_who_initiated_marriags'] = SwapnosarothiCmWhoInitiatedMarriag::where('status', 1)->get();
        $data['cm_girl_instituteon_types'] = SwapnosarothiCmGirlInstituteonType::where('status', 1)->get();
        $data['occupations'] = Occupation::where('status', 1)->get();
        $data['educations'] = Education::where('status', 1)->get();
        return view('swapnosarothi.cm_initiative.edit', $data);
    }

    public function typeWisePrevention(Request $request){
        $cm_preventions = SwapnosarothiCmPrevention::where('prevention_type_id', $request->prevention_type)->get();
        
        $preventionOptions = ['<option value="">Select Prevention</option>'];
        foreach($cm_preventions as $cm_prevention){
            $preventionOptions[] = '<option value="'.$cm_prevention->id.'">'.$cm_prevention->name.'</option>';
        }
        return $preventionOptions;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CmInitiative  $cmInitiative
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CmInitiative $cminitiative)
    {
       
        if($request->prevention_type ==1){
            $request->validate([
                'initiative' => 'required',
                'prevention_type' => 'required',
                'prevention_by' => 'required',
                'date' => 'required',
            ]);
        }else{
            
            $request->validate([
                'initiative' => 'required',
                'date' => 'required',
                'prevention_type' => 'required',
                'prevention_by' => 'required',
                'marriage_date' => 'required',
                'registration_completed' => 'required',
            ]);
        }
        

        try {
            DB::beginTransaction();
           
           $cminitiative->update([
                'prevention_type' => $request->prevention_type,
                'prevention_by' => $request->prevention_by,
                'age' => $request->age,
                'date' => $request->date,
                'updated_by' => Auth::id(),
            ]);

            if($request->prevention_type == 2 || $request->prevention_type == 3){
                $cminitiative->profile->marriageInfo->update([
                    "marriage_date" => $request->marriage_date,
                    "registration_completed" => $request->registration_completed,
                    "who_registered"=> $request->who_registered,
                    "marriage_place" => $request->marriage_place,
                    "marriage_reason" => $request->marriage_reason,
                    "asked_by_groom" => $request->asked_by_groom,
                    "dower_amount" => $request->dower_amount,
                    "marriag_initiated_person" => $request->marriag_initiated_person,
                    "girl_educational" => $request->girl_educational,
                    "studentship_status" => $request->studentship_status,
                    "educatinal_institution" => $request->educatinal_institution,
                    "groom_age" => $request->groom_age,
                    "girl_age" => $request->girl_age,
                    "groom_profession" => $request->groom_profession,
                    "groom_education" => $request->groom_education,
                ]);
            }

        
            DB::commit();
            $request->session()->flash("success", "Data Successfully Updated!");
            return back();
        
        } catch (\Exception $e) {
            DB::rollback();
        
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CmInitiative  $cmInitiative
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, CmInitiative $cminitiative)
    {
        
        try {
            DB::beginTransaction();

            SwapnosarothiProfile::where('id', $cminitiative->swapnosarothi_profile_id)->update([
                'group_status' => 'ongoing',
            ]);

            $cminitiative->profile->marriageInfo->delete();

            $cminitiative->delete();

            $request->session()->flash("success", "Data Successfully Deleted!");
            return back();
        } catch (\Exception $e) {
            DB::rollback();
        
            throw $e;
        }
    }
}
