
<form action="{{route('data.pollisomaj.add_step_3',['step'=>4])}}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="pollisomaj_ref_id" value="{{   $pollisomajData[0]->pollisomaj_data_ref }}">
<div class="card custom-card-style">
    <div class="card-header">
        5. Involvement with Local power structure
    </div>
    <div class="card-body">
        <div class="row">
            <div class="form-group col-md-6">
                <label class="control-label" style="width:100%;background: #667380;padding: 9px;color: white;margin-top: 21px;">No. of PS members contests in Local Government Election (Persons):</label>
                {{-- <input  type="number" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->ps_mem_gov_elec : ''}}" class="form-control form-control-sm" name="ps_mem_gov_elec" id=""> --}}
                <div class="row">
                    <div class="form-group col-md-3" style="margin-top:10px">
                        <label class="control-label">Men:</label>
                        <input  type="number" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->ps_mem_gov_elec_men : ''}}" class="form-control form-control-sm" name="ps_mem_gov_elec_men" id="">
                    </div>
                    <div class="form-group col-md-3" style="margin-top:10px">
                        <label class="control-label">Womens:</label>
                        <input  type="number" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->ps_mem_gov_elec_women : ''}}" class="form-control form-control-sm" name="ps_mem_gov_elec_women" id="">
                    </div>
                    <div class="form-group col-md-3" style="margin-top:10px">
                        <label class="control-label">Other Gender:</label>
                        <input  type="number" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->ps_mem_gov_elec_transgender : ''}}" class="form-control form-control-sm" name="ps_mem_gov_elec_transgender" id="">
                    </div>
                    <div class="form-group col-md-3" style="margin-top:10px">
                        <label class="control-label">PWD:</label>
                        <input  type="number" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->ps_mem_gov_elec_pwd : ''}}" class="form-control form-control-sm" name="ps_mem_gov_elec_pwd" id="">
                    </div>
                </div>
            </div>
            
            
            <div class="form-group col-md-6">
                <label class="control-label" style="width:100%;background: #667380;padding: 9px;color: white;margin-top: 21px;">No.of PS members elected in Local Government Election (Persons):</label>
                {{-- <input  type="number" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->ps_mem_gov_elec_elected : ''}}" class="form-control form-control-sm" name="ps_mem_gov_elec_elected" id=""> --}}
                <div class="row">
                    <div class="form-group col-md-3" style="margin-top:10px">
                        <label class="control-label">Men:</label>
                        <input  type="number" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->ps_mem_gov_elec_men_elected : ''}}" class="form-control form-control-sm" name="ps_mem_gov_elec_men_elected" id="">
                    </div>
                    <div class="form-group col-md-3" style="margin-top:10px">
                        <label class="control-label">Womens:</label>
                        <input  type="number" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->ps_mem_gov_elec_women_elected : ''}}" class="form-control form-control-sm" name="ps_mem_gov_elec_women_elected" id="">
                    </div>
                    <div class="form-group col-md-3" style="margin-top:10px">
                        <label class="control-label">Other Gender:</label>
                        <input  type="number" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->ps_mem_gov_elec_transgender_elected : ''}}" class="form-control form-control-sm" name="ps_mem_gov_elec_transgender_elected" id="">
                    </div>
                    <div class="form-group col-md-3" style="margin-top:10px">
                        <label class="control-label">PWD:</label>
                        <input  type="number" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->ps_mem_gov_elec_pwd_elected : ''}}" class="form-control form-control-sm" name="ps_mem_gov_elec_pwd_elected" id="">
                    </div>
                </div>
            </div>
            
            <div class="form-group col-md-6">
                <label class="control-label" style="width:100%;background: #667380;padding: 9px;color: white;margin-top: 21px;">No.of PS members in Joyeeta Contested:</label>
                {{-- <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->ps_mem_joyeets_con : ''}}" type="number" class="form-control form-control-sm" name="ps_mem_joyeets_con" id=""> --}}
                <div class="row">
                    <div class="form-group col-md-6" >
                        <label class="control-label">Contested as Joyeeta:</label>
                        <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->contested_as_joyeeta : ''}}" type="number" class="form-control form-control-sm" name="contested_as_joyeeta" id="">
                    </div>
                    <div class="form-group col-md-3">
                        <label class="control-label">Womens:</label>
                        <input  type="number" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->joyeeta_contested_women : ''}}" class="form-control form-control-sm" name="joyeeta_contested_women" id="">
                    </div>
                    <div class="form-group col-md-3">
                        <label class="control-label">PWD:</label>
                        <input  type="number" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->joyeeta_contested_pwd : ''}}" class="form-control form-control-sm" name="joyeeta_contested_pwd" id="">
                    </div>
                </div>
            </div>
            
            
            <div class="form-group col-md-6">
                <label class="control-label" style="width:100%;background: #667380;padding: 9px;color: white;margin-top: 21px;">No.of PS members in Joyeeta selected:</label>
                {{-- <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->ps_mem_joyeeta_selected : ''}}" type="number" class="form-control form-control-sm" name="ps_mem_joyeeta_selected" id=""> --}}
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="control-label">Selected at the upazila level :</label>
                        <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->joyeeta_dis_selected : ''}}" type="number" class="form-control form-control-sm" name="joyeeta_dis_selected" id="">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label">Selected at the district level :</label>
                        <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->joyeeta_div_selected : ''}}" type="number" class="form-control form-control-sm" name="joyeeta_div_selected" id="">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label">Selected at the national level :</label>
                        <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->joyeeta_national_selected : ''}}" type="number" class="form-control form-control-sm" name="joyeeta_national_selected" id="">
                    </div>
                </div>
            </div>
            
            <div class="form-group col-md-12">
                <label class="control-label" style="width:100%;background: #667380;padding: 9px;color: white;margin-top: 21px;">No.of PS members selected/elected in different committees :</label>
                {{-- <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->ps_in_different_committee : ''}}" type="number" class="form-control form-control-sm" name="ps_in_different_committee" id=""> --}}
                <div class="row">
                    {{-- School/Madrasah committee --}}
                    <div class="form-group col-md-12">
                        <label class="control-label" style="background: #667380;padding: 4px;color: white;margin-top:10px; border-radius: 4px; font-size: 15px;">School/Madrasah committee: </label> <input type="checkbox" class="form-grorp" id="school_madrasah" {{$pollisomajData[0]->school_committee_boys!=null ? "checked" : ""}}>
                        <div class="row school_madrasah" style="{{$pollisomajData[0]->school_committee_boys==null ? "display:none" : ""}}">
                            <div class="form-group col-md-2">
                                <label class="control-label">Boys</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->school_committee_boys : ''}}" name="school_committee_boys" id="school_committee_boys">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Girls</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->school_committee_girls : ''}}" name="school_committee_girls" id="school_committee_girls">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Male</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->school_committee_male : ''}}" name="school_committee_male" id="school_committee_male">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Female</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->school_committee_female : ''}}" name="school_committee_female" id="school_committee_female">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Other Gender</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->school_committee_transgender : ''}}" name="school_committee_transgender" id="school_committee_transgender">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Total</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->school_committee_total : ''}}" name="school_committee_total" id="school_committee_total" readonly>
                            </div>
                            <div class="form-group col-md-12" style="margin-bottom: 0px;">
                                <p>Person with disabilities (PWD)</p>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Boys</label>
                                <input type="numbechild marriager" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->school_committee_pwd_boys : ''}}" name="school_committee_pwd_boys" id="school_committee_pwd_boys">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Girls</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->school_committee_pwd_girls : ''}}" name="school_committee_pwd_girls" id="school_committee_pwd_girls">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Male</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->school_committee_pwd_male : ''}}" name="school_committee_pwd_male" id="school_committee_pwd_male">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Female</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->school_committee_pwd_female : ''}}" name="school_committee_pwd_female" id="school_committee_pwd_female">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Other Gender</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->school_committee_pwd_transgender : ''}}" name="school_committee_pwd_transgender" id="school_committee_pwd_transgender">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Total</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->school_committee_pwd_total : ''}}" name="school_committee_pwd_total" id="school_committee_pwd_total" readonly>
                            </div>
                        </div>
                    </div>

                    {{-- Hat-Bazar committee --}}
                    <div class="form-group col-md-12">
                        <label class="control-label" style="background: #667380;padding: 4px;color: white;margin-top:10px; border-radius: 4px; font-size: 15px;">Hat-Bazar committee: </label> <input type="checkbox" class="form-grorp" id="hat_bazar" {{$pollisomajData[0]->hatbazar_committee_boys!=null ? "checked" : ""}}>
                        <div class="row hat_bazar" style="{{$pollisomajData[0]->hatbazar_committee_boys==null ? "display:none" : ""}}">
                            <div class="form-group col-md-2">
                                <label class="control-label">Boys</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->hatbazar_committee_boys : ''}}" name="hatbazar_committee_boys" id="hatbazar_committee_boys">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Girls</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->hatbazar_committee_girls : ''}}" name="hatbazar_committee_girls" id="hatbazar_committee_girls">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Male</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->hatbazar_committee_male : ''}}" name="hatbazar_committee_male" id="hatbazar_committee_male">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Female</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->hatbazar_committee_female : ''}}" name="hatbazar_committee_female" id="hatbazar_committee_female">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Other Gender</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->hatbazar_committee_transgender : ''}}" name="hatbazar_committee_transgender" id="hatbazar_committee_transgender">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Total</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->hatbazar_committee_total : ''}}" name="hatbazar_committee_total" id="hatbazar_committee_total" readonly>
                            </div>
                            <div class="form-group col-md-12" style="margin-bottom: 0px;">
                                <p>Person with disabilities (PWD)</p>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Boys</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->hatbazar_committee_pwd_boys : ''}}" name="hatbazar_committee_pwd_boys" id="hatbazar_committee_pwd_boys">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Girls</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->hatbazar_committee_pwd_girls : ''}}" name="hatbazar_committee_pwd_girls" id="hatbazar_committee_pwd_girls">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Male</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->hatbazar_committee_pwd_male : ''}}" name="hatbazar_committee_pwd_male" id="hatbazar_committee_pwd_male">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Female</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->hatbazar_committee_pwd_female : ''}}" name="hatbazar_committee_pwd_female" id="hatbazar_committee_pwd_female">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Other Gender</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->hatbazar_committee_pwd_transgender : ''}}" name="hatbazar_committee_pwd_transgender" id="hatbazar_committee_pwd_transgender">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Total</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->hatbazar_committee_pwd_total : ''}}" name="hatbazar_committee_pwd_total" id="hatbazar_committee_pwd_total" readonly>
                            </div>
                        </div>
                    </div>

                    {{-- UP Standing committee --}}
                    <div class="form-group col-md-12">
                        <label class="control-label" style="background: #667380;padding: 4px;color: white;margin-top:10px; border-radius: 4px; font-size: 15px;">UP Standing committee: </label> <input type="checkbox" class="form-grorp" id="standing_committee" {{$pollisomajData[0]->stading_committee_boys!=null ? "checked" : ""}}>
                        <div class="row standing_committee"  style="{{$pollisomajData[0]->stading_committee_boys==null ? "display:none" : ""}}">
                            <div class="form-group col-md-2">
                                <label class="control-label">Boys</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->stading_committee_boys : ''}}" name="stading_committee_boys" id="stading_committee_boys">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Girls</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->stading_committee_girls : ''}}" name="stading_committee_girls" id="stading_committee_girls">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Male</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->stading_committee_male : ''}}" name="stading_committee_male" id="stading_committee_male">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Female</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->stading_committee_female : ''}}" name="stading_committee_female" id="stading_committee_female">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Other Gender</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->stading_committee_transgender : ''}}" name="stading_committee_transgender" id="stading_committee_transgender">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Total</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->stading_committee_total : ''}}" name="stading_committee_total" id="stading_committee_total" readonly>
                            </div>
                            <div class="form-group col-md-12" style="margin-bottom: 0px;">
                                <p>Person with disabilities (PWD)</p>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Boys</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->stading_committee_pwd_boys : ''}}" name="stading_committee_pwd_boys" id="stading_committee_pwd_boys">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Girls</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->stading_committee_pwd_girls : ''}}" name="stading_committee_pwd_girls" id="stading_committee_pwd_girls">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Male</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->stading_committee_pwd_male : ''}}" name="stading_committee_pwd_male" id="stading_committee_pwd_male">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Female</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->stading_committee_pwd_female : ''}}" name="stading_committee_pwd_female" id="stading_committee_pwd_female">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Other Gender</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->stading_committee_pwd_transgender : ''}}" name="stading_committee_pwd_transgender" id="stading_committee_pwd_transgender">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Total</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->stading_committee_pwd_total : ''}}" name="stading_committee_pwd_total" id="stading_committee_pwd_total" readonly>
                            </div>
                        </div>
                    </div>

                    {{-- Community clinic committee --}}
                    <div class="form-group col-md-12">
                        <label class="control-label" style="background: #667380;padding: 4px;color: white;margin-top:10px; border-radius: 4px; font-size: 15px;">Community clinic committee: </label> <input type="checkbox" class="form-grorp" id="community_clinic" {{$pollisomajData[0]->clinic_committee_boys!=null ? "checked" : ""}}>
                        <div class="row community_clinic" style="{{$pollisomajData[0]->clinic_committee_boys==null ? "display:none" : ""}}">
                            <div class="form-group col-md-2">
                                <label class="control-label">Boys</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->clinic_committee_boys : ''}}" name="clinic_committee_boys" id="clinic_committee_boys">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Girls</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->clinic_committee_girls : ''}}" name="clinic_committee_girls" id="clinic_committee_girls">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Male</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->clinic_committee_male : ''}}" name="clinic_committee_male" id="clinic_committee_male">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Female</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->clinic_committee_female : ''}}" name="clinic_committee_female" id="clinic_committee_female">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Other Gender</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->clinic_committee_transgender : ''}}" name="clinic_committee_transgender" id="clinic_committee_transgender">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Total</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->clinic_committee_total : ''}}" name="clinic_committee_total" id="clinic_committee_total" readonly>
                            </div>
                            <div class="form-group col-md-12" style="margin-bottom: 0px;">
                                <p>Person with disabilities (PWD)</p>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Boys</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->clinic_committee_pwd_boys : ''}}" name="clinic_committee_pwd_boys" id="clinic_committee_pwd_boys">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Girls</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->clinic_committee_pwd_girls : ''}}" name="clinic_committee_pwd_girls" id="clinic_committee_pwd_girls">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Male</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->clinic_committee_pwd_male : ''}}" name="clinic_committee_pwd_male" id="clinic_committee_pwd_male">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Female</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->clinic_committee_pwd_female : ''}}" name="clinic_committee_pwd_female" id="clinic_committee_pwd_female">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Other Gender</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->clinic_committee_pwd_transgender : ''}}" name="clinic_committee_pwd_transgender" id="clinic_committee_pwd_transgender">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Total</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->clinic_committee_pwd_total : ''}}" name="clinic_committee_pwd_total" id="clinic_committee_pwd_total" readonly>
                            </div>
                        </div>
                    </div>

                    {{-- Religion institution committee --}}
                    <div class="form-group col-md-12">
                        <label class="control-label" style="background: #667380;padding: 4px;color: white;margin-top:10px; border-radius: 4px; font-size: 15px;">Religion institution committee: </label> <input type="checkbox" class="form-grorp" id="religion_institution" {{$pollisomajData[0]->institution_committee_boys!=null ? "checked" : ""}}>
                        <div class="row religion_institution" style="{{$pollisomajData[0]->institution_committee_boys==null ? "display:none" : ""}}">
                            <div class="form-group col-md-2">
                                <label class="control-label">Boys</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->institution_committee_boys : ''}}" name="institution_committee_boys" id="institution_committee_boys">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Girls</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->institution_committee_girls : ''}}" name="institution_committee_girls" id="institution_committee_girls">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Male</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->institution_committee_male : ''}}" name="institution_committee_male" id="institution_committee_male">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Female</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->institution_committee_female : ''}}" name="institution_committee_female" id="institution_committee_female">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Other Gender</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->institution_committee_transgender : ''}}" name="institution_committee_transgender" id="institution_committee_transgender">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Total</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->institution_committee_total : ''}}" name="institution_committee_total" id="institution_committee_total" readonly>
                            </div>
                            <div class="form-group col-md-12" style="margin-bottom: 0px;">
                                <p>Person with disabilities (PWD)</p>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Boys</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->institution_committee_pwd_boys : ''}}" name="institution_committee_pwd_boys" id="institution_committee_pwd_boys">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Girls</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->institution_committee_pwd_girls : ''}}" name="institution_committee_pwd_girls" id="institution_committee_pwd_girls">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Male</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->institution_committee_pwd_male : ''}}" name="institution_committee_pwd_male" id="institution_committee_pwd_male">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Female</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->institution_committee_pwd_female : ''}}" name="institution_committee_pwd_female" id="institution_committee_pwd_female">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Other Gender</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->institution_committee_pwd_transgender : ''}}" name="institution_committee_pwd_transgender" id="institution_committee_pwd_transgender">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Total</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->institution_committee_pwd_total : ''}}" name="institution_committee_pwd_total" id="institution_committee_pwd_total" readonly>
                            </div>
                        </div>
                    </div>

                    {{-- Village Social Solidarity Committee (VSSC) --}}
                    <div class="form-group col-md-12">
                        <label class="control-label" style="background: #667380;padding: 4px;color: white;margin-top:10px; border-radius: 4px; font-size: 15px;">Village Social Solidarity Committee (VSSC): </label> <input type="checkbox" class="form-grorp" id="village_social" {{$pollisomajData[0]->solidarity_committee_boys!=null ? "checked" : ""}}>
                        <div class="row village_social" style="{{$pollisomajData[0]->solidarity_committee_boys==null ? "display:none" : ""}}">
                            <div class="form-group col-md-2">
                                <label class="control-label">Boys</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->solidarity_committee_boys : ''}}" name="solidarity_committee_boys" id="solidarity_committee_boys">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Girls</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->solidarity_committee_girls : ''}}" name="solidarity_committee_girls" id="solidarity_committee_girls">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Male</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->solidarity_committee_male : ''}}" name="solidarity_committee_male" id="solidarity_committee_male">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Female</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->solidarity_committee_female : ''}}" name="solidarity_committee_female" id="solidarity_committee_female">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Other Gender</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->solidarity_committee_transgender : ''}}" name="solidarity_committee_transgender" id="solidarity_committee_transgender">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Total</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->solidarity_committee_total : ''}}" name="solidarity_committee_total" id="solidarity_committee_total" readonly>
                            </div>
                            <div class="form-group col-md-12" style="margin-bottom: 0px;">
                                <p>Person with disabilities (PWD)</p>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Boys</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->solidarity_committee_pwd_boys : ''}}" name="solidarity_committee_pwd_boys" id="solidarity_committee_pwd_boys">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Girls</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->solidarity_committee_pwd_girls : ''}}" name="solidarity_committee_pwd_girls" id="solidarity_committee_pwd_girls">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Male</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->solidarity_committee_pwd_male : ''}}" name="solidarity_committee_pwd_male" id="solidarity_committee_pwd_male">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Female</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->solidarity_committee_pwd_female : ''}}" name="solidarity_committee_pwd_female" id="solidarity_committee_pwd_female">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Other Gender</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->solidarity_committee_pwd_transgender : ''}}" name="solidarity_committee_pwd_transgender" id="solidarity_committee_pwd_transgender">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Total</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->solidarity_committee_pwd_total : ''}}" name="solidarity_committee_pwd_total" id="solidarity_committee_pwd_total" readonly>
                            </div>
                        </div>
                    </div>

                    {{-- NGO/Club/Social welfare committee --}}
                    <div class="form-group col-md-12">
                        <label class="control-label" style="background: #667380;padding: 4px;color: white;margin-top:10px; border-radius: 4px; font-size: 15px;">NGO/Club/Social welfare committee: </label> <input type="checkbox" class="form-grorp" id="welfare_committee" {{$pollisomajData[0]->welfare_committee_boys!=null ? "checked" : ""}}>
                        <div class="row welfare_committee" style="{{$pollisomajData[0]->welfare_committee_boys==null ? "display:none" : ""}}">
                            <div class="form-group col-md-2">
                                <label class="control-label">Boys</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->welfare_committee_boys : ''}}" name="welfare_committee_boys" id="welfare_committee_boys">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Girls</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->welfare_committee_girls : ''}}" name="welfare_committee_girls" id="welfare_committee_girls">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Male</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->welfare_committee_male : ''}}" name="welfare_committee_male" id="welfare_committee_male">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Female</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->welfare_committee_female : ''}}" name="welfare_committee_female" id="welfare_committee_female">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Other Gender</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->welfare_committee_transgender : ''}}" name="welfare_committee_transgender" id="welfare_committee_transgender">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Total</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->welfare_committee_total : ''}}" name="welfare_committee_total" id="welfare_committee_total" readonly>
                            </div>
                            <div class="form-group col-md-12" style="margin-bottom: 0px;">
                                <p>Person with disabilities (PWD)</p>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Boys</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->welfare_committee_pwd_boys : ''}}" name="welfare_committee_pwd_boys" id="welfare_committee_pwd_boys">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Girls</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->welfare_committee_pwd_girls : ''}}" name="welfare_committee_pwd_girls" id="welfare_committee_pwd_girls">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Male</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->welfare_committee_pwd_male : ''}}" name="welfare_committee_pwd_male" id="welfare_committee_pwd_male">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Female</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->welfare_committee_pwd_female : ''}}" name="welfare_committee_pwd_female" id="welfare_committee_pwd_female">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Other Gender</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->welfare_committee_pwd_transgender : ''}}" name="welfare_committee_pwd_transgender" id="welfare_committee_pwd_transgender">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Total</label>
                                <input type="number" class="form-control form-control-sm" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->welfare_committee_pwd_total : ''}}" name="welfare_committee_pwd_total" id="welfare_committee_pwd_total" readonly>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            
        </div>
    </div>
</div>


<div class="text-right">
    <a href="{{route('data.pollisomaj.add',['step'=>2,'pollisomaj_ref_id' => $pollisomajData[0]->pollisomaj_data_ref])}}" class="btn btn-success" >Back</a>
    {{-- <a href="{{route('data.pollisomaj.add',['step'=>4])}}" class="btn  btn-primary" >Save & Next</a> --}}
    <input type="submit" value="Save & Next" class="btn btn-success"/>
    <input type="submit" style='{{isset( $auth_user->user_role[0]['role_id']) && ($auth_user->user_role[0]['role_id']==4 || $auth_user->user_role[0]['role_id']==1) ? "display:none" : "" }}' name="save_destroy" class="btn btn-primary"  value="Save & Draft">
    <a href="{{route('incident.pollisomaj.viewpollisomajlist')}}" class="btn  btn-danger" >Cancel</a>
</div>

</form>

<script>
    $(document).ready(function(){
        $("input").keyup(function(){
            var school_committee_boys        = +$("#school_committee_boys").val();
            var school_committee_girls       = +$("#school_committee_girls").val();
            var school_committee_male        = +$("#school_committee_male").val();
            var school_committee_female      = +$("#school_committee_female").val();
            var school_committee_transgender = +$("#school_committee_transgender").val();
            var total                        = school_committee_boys+school_committee_girls+school_committee_male+school_committee_female+school_committee_transgender;
            $("#school_committee_total").val(total);

            var school_committee_pwd_boys        = +$("#school_committee_pwd_boys").val();
            var school_committee_pwd_girls       = +$("#school_committee_pwd_girls").val();
            var school_committee_pwd_male        = +$("#school_committee_pwd_male").val();
            var school_committee_pwd_female      = +$("#school_committee_pwd_female").val();
            var school_committee_pwd_transgender = +$("#school_committee_pwd_transgender").val();
            var total_pwd                        = school_committee_pwd_boys+school_committee_pwd_girls+school_committee_pwd_male+school_committee_pwd_female+school_committee_pwd_transgender;
            $("#school_committee_pwd_total").val(total_pwd);
        });
    });
</script>

<script>
    $(document).ready(function(){
        $("input").keyup(function(){
            var hatbazar_committee_boys         = +$("#hatbazar_committee_boys").val();
            var hatbazar_committee_girls        = +$("#hatbazar_committee_girls").val();
            var hatbazar_committee_male         = +$("#hatbazar_committee_male").val();
            var hatbazar_committee_female       = +$("#hatbazar_committee_female").val();
            var hatbazar_committee_transgender  = +$("#hatbazar_committee_transgender").val();
            var total                           = hatbazar_committee_boys+hatbazar_committee_girls+hatbazar_committee_male+hatbazar_committee_female+hatbazar_committee_transgender;
            $("#hatbazar_committee_total").val(total);

            var hatbazar_committee_pwd_boys        = +$("#hatbazar_committee_pwd_boys").val();
            var hatbazar_committee_pwd_girls       = +$("#hatbazar_committee_pwd_girls").val();
            var hatbazar_committee_pwd_male        = +$("#hatbazar_committee_pwd_male").val();
            var hatbazar_committee_pwd_female      = +$("#hatbazar_committee_pwd_female").val();
            var hatbazar_committee_pwd_transgender = +$("#hatbazar_committee_pwd_transgender").val();
            var total_pwd                          = hatbazar_committee_pwd_boys+hatbazar_committee_pwd_girls+hatbazar_committee_pwd_male+hatbazar_committee_pwd_female+hatbazar_committee_pwd_transgender;
            $("#hatbazar_committee_pwd_total").val(total_pwd);
        });
    });
</script>

<script>
    $(document).ready(function(){
        $("input").keyup(function(){
            var stading_committee_boys          = +$("#stading_committee_boys").val();
            var stading_committee_girls         = +$("#stading_committee_girls").val();
            var stading_committee_male          = +$("#stading_committee_male").val();
            var stading_committee_female        = +$("#stading_committee_female").val();
            var stading_committee_transgender   = +$("#stading_committee_transgender").val();
            var total                           = stading_committee_boys+stading_committee_girls+stading_committee_male+stading_committee_female+stading_committee_transgender;
            $("#stading_committee_total").val(total);

            var stading_committee_pwd_boys        = +$("#stading_committee_pwd_boys").val();
            var stading_committee_pwd_girls       = +$("#stading_committee_pwd_girls").val();
            var stading_committee_pwd_male        = +$("#stading_committee_pwd_male").val();
            var stading_committee_pwd_female      = +$("#stading_committee_pwd_female").val();
            var stading_committee_pwd_transgender = +$("#stading_committee_pwd_transgender").val();
            var total_pwd                         = stading_committee_pwd_boys+stading_committee_pwd_girls+stading_committee_pwd_male+stading_committee_pwd_female+stading_committee_pwd_transgender;
            $("#stading_committee_pwd_total").val(total_pwd);
        });
    });
</script>

<script>
    $(document).ready(function(){
        $("input").keyup(function(){
            var clinic_committee_boys          = +$("#clinic_committee_boys").val();
            var clinic_committee_girls         = +$("#clinic_committee_girls").val();
            var clinic_committee_male          = +$("#clinic_committee_male").val();
            var clinic_committee_female        = +$("#clinic_committee_female").val();
            var clinic_committee_transgender   = +$("#clinic_committee_transgender").val();
            var total                          = clinic_committee_boys+clinic_committee_girls+clinic_committee_male+clinic_committee_female+clinic_committee_transgender;
            $("#clinic_committee_total").val(total);

            var clinic_committee_pwd_boys        = +$("#clinic_committee_pwd_boys").val();
            var clinic_committee_pwd_girls       = +$("#clinic_committee_pwd_girls").val();
            var clinic_committee_pwd_male        = +$("#clinic_committee_pwd_male").val();
            var clinic_committee_pwd_female      = +$("#clinic_committee_pwd_female").val();
            var clinic_committee_pwd_transgender = +$("#clinic_committee_pwd_transgender").val();
            var total_pwd                        = clinic_committee_pwd_boys+clinic_committee_pwd_girls+clinic_committee_pwd_male+clinic_committee_pwd_female+clinic_committee_pwd_transgender;
            $("#clinic_committee_pwd_total").val(total_pwd);
        });
    });
</script>

<script>
    $(document).ready(function(){
        $("input").keyup(function(){
            var institution_committee_boys          = +$("#institution_committee_boys").val();
            var institution_committee_girls         = +$("#institution_committee_girls").val();
            var institution_committee_male          = +$("#institution_committee_male").val();
            var institution_committee_female        = +$("#institution_committee_female").val();
            var institution_committee_transgender   = +$("#institution_committee_transgender").val();
            var total                               = institution_committee_boys+institution_committee_girls+institution_committee_male+institution_committee_female+institution_committee_transgender;
            $("#institution_committee_total").val(total);

            var institution_committee_pwd_boys        = +$("#institution_committee_pwd_boys").val();
            var institution_committee_pwd_girls       = +$("#institution_committee_pwd_girls").val();
            var institution_committee_pwd_male        = +$("#institution_committee_pwd_male").val();
            var institution_committee_pwd_female      = +$("#institution_committee_pwd_female").val();
            var institution_committee_pwd_transgender = +$("#institution_committee_pwd_transgender").val();
            var total_pwd                             = institution_committee_pwd_boys+institution_committee_pwd_girls+institution_committee_pwd_male+institution_committee_pwd_female+institution_committee_pwd_transgender;
            $("#institution_committee_pwd_total").val(total_pwd);
        });
    });
</script>

<script>
    $(document).ready(function(){
        $("input").keyup(function(){
            var solidarity_committee_boys          = +$("#solidarity_committee_boys").val();
            var solidarity_committee_girls         = +$("#solidarity_committee_girls").val();
            var solidarity_committee_male          = +$("#solidarity_committee_male").val();
            var solidarity_committee_female        = +$("#solidarity_committee_female").val();
            var solidarity_committee_transgender   = +$("#solidarity_committee_transgender").val();
            var total                              = solidarity_committee_boys+solidarity_committee_girls+solidarity_committee_male+solidarity_committee_female+solidarity_committee_transgender;
            $("#solidarity_committee_total").val(total);

            var solidarity_committee_pwd_boys        = +$("#solidarity_committee_pwd_boys").val();
            var solidarity_committee_pwd_girls       = +$("#solidarity_committee_pwd_girls").val();
            var solidarity_committee_pwd_male        = +$("#solidarity_committee_pwd_male").val();
            var solidarity_committee_pwd_female      = +$("#solidarity_committee_pwd_female").val();
            var solidarity_committee_pwd_transgender = +$("#solidarity_committee_pwd_transgender").val();
            var total_pwd                            = solidarity_committee_pwd_boys+solidarity_committee_pwd_girls+solidarity_committee_pwd_male+solidarity_committee_pwd_female+solidarity_committee_pwd_transgender;
            $("#solidarity_committee_pwd_total").val(total_pwd);
        });
    });
</script>

<script>
    $(document).ready(function(){
        $("input").keyup(function(){
            var welfare_committee_boys          = +$("#welfare_committee_boys").val();
            var welfare_committee_girls         = +$("#welfare_committee_girls").val();
            var welfare_committee_male          = +$("#welfare_committee_male").val();
            var welfare_committee_female        = +$("#welfare_committee_female").val();
            var welfare_committee_transgender   = +$("#welfare_committee_transgender").val();
            var total                           = welfare_committee_boys+welfare_committee_girls+welfare_committee_male+welfare_committee_female+welfare_committee_transgender;
            $("#welfare_committee_total").val(total);

            var welfare_committee_pwd_boys        = +$("#welfare_committee_pwd_boys").val();
            var welfare_committee_pwd_girls       = +$("#welfare_committee_pwd_girls").val();
            var welfare_committee_pwd_male        = +$("#welfare_committee_pwd_male").val();
            var welfare_committee_pwd_female      = +$("#welfare_committee_pwd_female").val();
            var welfare_committee_pwd_transgender = +$("#welfare_committee_pwd_transgender").val();
            var total_pwd                         = welfare_committee_pwd_boys+welfare_committee_pwd_girls+welfare_committee_pwd_male+welfare_committee_pwd_female+welfare_committee_pwd_transgender;
            $("#welfare_committee_pwd_total").val(total_pwd);
        });
    });
</script>

<script>
    $(document).ready(function() {
        $("#school_madrasah").click(function() {
            var school_madrasah = $("#school_madrasah");
            if (school_madrasah[0].checked) {
                $(".school_madrasah").fadeIn(700).show();
            } else {
                $(".school_madrasah").hide();

                $("#school_committee_boys").prop('disabled', true);
                $("#school_committee_girls").prop('disabled', true);
                $("#school_committee_male").prop('disabled', true);
                $("#school_committee_female").prop('disabled', true);
                $("#school_committee_transgender").prop('disabled', true);
                $("#school_committee_total").prop('disabled', true);
                $("#school_committee_pwd_boys").prop('disabled', true);
                $("#school_committee_pwd_girls").prop('disabled', true);
                $("#school_committee_pwd_male").prop('disabled', true);
                $("#school_committee_pwd_female").prop('disabled', true);
                $("#school_committee_pwd_transgender").prop('disabled', true);
                $("#school_committee_pwd_total").prop('disabled', true);
            }
        });

        $("#hat_bazar").click(function() {
            var hat_bazar = $("#hat_bazar");
            if (hat_bazar[0].checked) {
                $(".hat_bazar").fadeIn(700).show();
            } else {
                $(".hat_bazar").hide();
                $("#hatbazar_committee_boys").prop('disabled', true);
                $("#hatbazar_committee_girls").prop('disabled', true);
                $("#hatbazar_committee_male").prop('disabled', true);
                $("#hatbazar_committee_female").prop('disabled', true);
                $("#hatbazar_committee_transgender").prop('disabled', true);
                $("#hatbazar_committee_total").prop('disabled', true);
                $("#hatbazar_committee_pwd_boys").prop('disabled', true);
                $("#hatbazar_committee_pwd_girls").prop('disabled', true);
                $("#hatbazar_committee_pwd_male").prop('disabled', true);
                $("#hatbazar_committee_pwd_female").prop('disabled', true);
                $("#hatbazar_committee_pwd_transgender").prop('disabled', true);
                $("#hatbazar_committee_pwd_total").prop('disabled', true);
            }
        });

        $("#standing_committee").click(function() {
            var standing_committee = $("#standing_committee");
            if (standing_committee[0].checked) {
                $(".standing_committee").fadeIn(700).show();
            } else {
                $(".standing_committee").hide();
                $("#stading_committee_boys").prop('disabled', true);
                $("#stading_committee_girls").prop('disabled', true);
                $("#stading_committee_male").prop('disabled', true);
                $("#stading_committee_female").prop('disabled', true);
                $("#stading_committee_transgender").prop('disabled', true);
                $("#stading_committee_total").prop('disabled', true);
                $("#stading_committee_pwd_boys").prop('disabled', true);
                $("#stading_committee_pwd_girls").prop('disabled', true);
                $("#stading_committee_pwd_male").prop('disabled', true);
                $("#stading_committee_pwd_female").prop('disabled', true);
                $("#stading_committee_pwd_transgender").prop('disabled', true);
                $("#stading_committee_pwd_total").prop('disabled', true);
            }
        });

        $("#community_clinic").click(function() {
            var community_clinic = $("#community_clinic");
            if (community_clinic[0].checked) {
                $(".community_clinic").fadeIn(700).show();
            } else {
                $(".community_clinic").hide();

                $("#clinic_committee_boys").prop('disabled', true);
                $("#clinic_committee_girls").prop('disabled', true);
                $("#clinic_committee_male").prop('disabled', true);
                $("#clinic_committee_female").prop('disabled', true);
                $("#clinic_committee_transgender").prop('disabled', true);
                $("#clinic_committee_total").prop('disabled', true);
                $("#clinic_committee_pwd_boys").prop('disabled', true);
                $("#clinic_committee_pwd_girls").prop('disabled', true);
                $("#clinic_committee_pwd_male").prop('disabled', true);
                $("#clinic_committee_pwd_female").prop('disabled', true);
                $("#clinic_committee_pwd_transgender").prop('disabled', true);
                $("#clinic_committee_pwd_total").prop('disabled', true);
            }
        });

        $("#religion_institution").click(function() {
            var religion_institution = $("#religion_institution");
            if (religion_institution[0].checked) {
                $(".religion_institution").fadeIn(700).show();
            } else {
                $(".religion_institution").hide();

                $("#institution_committee_boys").prop('disabled', true);
                $("#institution_committee_girls").prop('disabled', true);
                $("#institution_committee_male").prop('disabled', true);
                $("#institution_committee_female").prop('disabled', true);
                $("#institution_committee_transgender").prop('disabled', true);
                $("#institution_committee_total").prop('disabled', true);
                $("#institution_committee_pwd_boys").prop('disabled', true);
                $("#institution_committee_pwd_girls").prop('disabled', true);
                $("#institution_committee_pwd_male").prop('disabled', true);
                $("#institution_committee_pwd_female").prop('disabled', true);
                $("#institution_committee_pwd_transgender").prop('disabled', true);
                $("#institution_committee_pwd_total").prop('disabled', true);
            }
        });

        $("#village_social").click(function() {
            var village_social = $("#village_social");
            if (village_social[0].checked) {
                $(".village_social").fadeIn(700).show();
            } else {
                $(".village_social").hide();

                $("#solidarity_committee_boys").prop('disabled', true);
                $("#solidarity_committee_girls").prop('disabled', true);
                $("#solidarity_committee_male").prop('disabled', true);
                $("#solidarity_committee_female").prop('disabled', true);
                $("#solidarity_committee_transgender").prop('disabled', true);
                $("#solidarity_committee_total").prop('disabled', true);
                $("#solidarity_committee_pwd_boys").prop('disabled', true);
                $("#solidarity_committee_pwd_girls").prop('disabled', true);
                $("#solidarity_committee_pwd_male").prop('disabled', true);
                $("#solidarity_committee_pwd_female").prop('disabled', true);
                $("#solidarity_committee_pwd_transgender").prop('disabled', true);
                $("#solidarity_committee_pwd_total").prop('disabled', true);
            }
        });

        $("#welfare_committee").click(function() {
            var welfare_committee = $("#welfare_committee");
            if (welfare_committee[0].checked) {
                $(".welfare_committee").fadeIn(700).show();
            } else {
                $(".welfare_committee").hide();

                $("#welfare_committee_boys").prop('disabled', true);
                $("#welfare_committee_girls").prop('disabled', true);
                $("#welfare_committee_male").prop('disabled', true);
                $("#welfare_committee_female").prop('disabled', true);
                $("#welfare_committee_transgender").prop('disabled', true);
                $("#welfare_committee_total").prop('disabled', true);
                $("#welfare_committee_pwd_boys").prop('disabled', true);
                $("#welfare_committee_pwd_girls").prop('disabled', true);
                $("#welfare_committee_pwd_male").prop('disabled', true);
                $("#welfare_committee_pwd_female").prop('disabled', true);
                $("#welfare_committee_pwd_transgender").prop('disabled', true);
                $("#welfare_committee_pwd_total").prop('disabled', true);
            }
        });
    });
</script>
