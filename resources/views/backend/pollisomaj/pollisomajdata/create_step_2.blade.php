
<style>
    .people_received {
        max-width: 24.8%!important;
        flex: 20%;
        padding: 2px;
    }
</style>
<form action="{{route('data.pollisomaj.add_step_2',['step'=>3])}}" method="post">
    {{ csrf_field() }}

    <input type="hidden" name="pollisomaj_ref_id" value="{{$pollisomajData[0]->pollisomaj_data_ref }}">

    <div class="card custom-card-style">
        <div class="card-header">
            4. Taken preventive initiative 
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-3"">
                    <label class="control-label" style="background: #667380;padding: 8px;color: white;border-radius: 4px; font-size: 13px;"> Number of Child Marriage Reported </label>
                </div>
                <div class="form-group col-md-3">
                    <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->number_of_child_marriage : ''}}" type="number" class="form-control form-control-sm" name="number_of_child_marriage" id="number_of_child_marriage">
                </div>
            </div>
            <div class="card custom-card-style">
                <div class="card-header">
                    4.1. Initiatives taken to prevent child marriage </h6>
                </div>
                <div class="card-body">
                        {{-- Contacted UP --}}
                        <div class="row">
                            <div class="form-group col-md-4" style="text-align: right;">
                                <label class="control-label" style="background: #667380;padding: 6px;color: white;margin-top:26px; border-radius: 4px; font-size: 13px;"> Contacted UP </label> <input type="checkbox" class="form-grorp" id="contacted_up" {{$pollisomajData[0]->contacted_up_within_ps_member!=null ? "checked" : ""}}>
                            </div>
                            <div class="form-group col-md-3 people_received">
                                <label class="control-label">Within PS members</label>
                                <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->contacted_up_within_ps_member : ''}}" type="number" class="form-control form-control-sm" name="contacted_up_within_ps_member" id="contacted_up_within_ps_member" {{$pollisomajData[0]->contacted_up_within_ps_member==null ? "disabled" : ""}}>
                            </div>
                            <div class="form-group col-md-3 people_received">
                                <label class="control-label">Beyond PS members</label>
                                <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->contacted_up_beyond_ps_member : ''}}" type="number" class="form-control form-control-sm" name="contacted_up_beyond_ps_member" id="contacted_up_beyond_ps_member" {{$pollisomajData[0]->contacted_up_beyond_ps_member==null ? "disabled" : ""}}>
                            </div>
                        </div>

                        {{-- Contacted Local PS --}}
                        <div class="row">
                            <div class="form-group col-md-4" style="text-align: right;">
                                <label class="control-label" style="background: #667380;padding: 6px;color: white;margin-top:26px; border-radius: 4px; font-size: 13px;"> Contacted Local Thana </label> <input type="checkbox" class="form-grorp" id="contacted_local" {{$pollisomajData[0]->contacted_local_within_ps_member!=null ? "checked" : ""}}>
                            </div>
                            <div class="form-group col-md-3 people_received">
                                <label class="control-label">Within PS members</label>
                                <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->contacted_local_within_ps_member : ''}}" type="number" class="form-control form-control-sm" name="contacted_local_within_ps_member" id="contacted_local_within_ps_member" {{$pollisomajData[0]->contacted_local_within_ps_member==null ? "disabled" : ""}}>
                            </div>
                            <div class="form-group col-md-3 people_received">
                                <label class="control-label">Beyond PS members</label>
                                <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->contacted_local_beyond_ps_member : ''}}" type="number" class="form-control form-control-sm" name="contacted_local_beyond_ps_member" id="contacted_local_beyond_ps_member" {{$pollisomajData[0]->contacted_local_beyond_ps_member==null ? "disabled" : ""}}>
                            </div>
                        </div>

                        {{-- Family consultation --}}
                        <div class="row">
                            <div class="form-group col-md-4" style="text-align: right;">
                                <label class="control-label" style="background: #667380;padding: 6px;color: white;margin-top:26px; border-radius: 4px; font-size: 13px;"> Family Consultation </label> <input type="checkbox" class="form-grorp" id="family_consultation" {{$pollisomajData[0]->family_consultation_within_ps_member!=null ? "checked" : ""}}>
                            </div>
                            <div class="form-group col-md-3 people_received">
                                <label class="control-label">Within PS members</label>
                                <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->family_consultation_within_ps_member : ''}}" type="number" class="form-control form-control-sm" name="family_consultation_within_ps_member" id="family_consultation_within_ps_member" {{$pollisomajData[0]->family_consultation_within_ps_member==null ? "disabled" : ""}}>
                            </div>
                            <div class="form-group col-md-3 people_received">
                                <label class="control-label">Beyond PS members</label>
                                <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->family_consultation_beyond_ps_member : ''}}" type="number" class="form-control form-control-sm" name="family_consultation_beyond_ps_member" id="family_consultation_beyond_ps_member" {{$pollisomajData[0]->family_consultation_beyond_ps_member==null ? "disabled" : ""}}>
                            </div>
                        </div>

                        {{-- Contacted Upazila administration --}}
                        <div class="row">
                            <div class="form-group col-md-4" style="text-align: right;">
                                <label class="control-label" style="background: #667380;padding: 6px;color: white;margin-top:26px; border-radius: 4px; font-size: 13px;"> Contacted Upazila administration </label> <input type="checkbox" class="form-grorp" id="contacted_upazila" {{$pollisomajData[0]->contacted_upazila_within_ps_member!=null ? "checked" : ""}}>
                            </div>
                            <div class="form-group col-md-3 people_received">
                                <label class="control-label">Within PS members</label>
                                <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->contacted_upazila_within_ps_member : ''}}" type="number" class="form-control form-control-sm" name="contacted_upazila_within_ps_member" id="contacted_upazila_within_ps_member" {{$pollisomajData[0]->contacted_upazila_within_ps_member==null ? "disabled" : ""}}>
                            </div>
                            <div class="form-group col-md-3 people_received">
                                <label class="control-label">Beyond PS members</label>
                                <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->contacted_upazila_beyond_ps_member : ''}}" type="number" class="form-control form-control-sm" name="contacted_upazila_beyond_ps_member" id="contacted_upazila_beyond_ps_member" {{$pollisomajData[0]->contacted_upazila_beyond_ps_member==null ? "disabled" : ""}}>
                            </div>
                        </div>

                        {{-- Dialed on Hotline numbers --}}
                        <div class="row">
                            <div class="form-group col-md-4" style="text-align: right;">
                                <label class="control-label" style="background: #667380;padding: 6px;color: white;margin-top:26px; border-radius: 4px; font-size: 13px;"> Dialed on Hotline numbers </label> <input type="checkbox" class="form-grorp" id="hotline_number" {{$pollisomajData[0]->hotline_number_within_ps_member!=null ? "checked" : ""}}>
                            </div>
                            <div class="form-group col-md-3 people_received">
                                <label class="control-label">Within PS members</label>
                                <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->hotline_number_within_ps_member : ''}}" type="number" class="form-control form-control-sm" name="hotline_number_within_ps_member" id="hotline_number_within_ps_member" {{$pollisomajData[0]->hotline_number_within_ps_member==null ? "disabled" : ""}}>
                            </div>
                            <div class="form-group col-md-3 people_received">
                                <label class="control-label">Beyond PS members</label>
                                <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->hotline_number_beyond_ps_member : ''}}" type="number" class="form-control form-control-sm" name="hotline_number_beyond_ps_member" id="hotline_number_beyond_ps_member" {{$pollisomajData[0]->hotline_number_beyond_ps_member==null ? "disabled" : ""}}>
                            </div>
                        </div>

                        {{-- <div class="form-group col-md-6">
                            <label class="control-label">Type of initiative taken:</label>
                            <select name="ps_members_initiative" id="" class="form-control form-control-sm">
                                <option value="">--Select--</option>
                                <option {{count($pollisomajData)>0 ? ($pollisomajData[0]->ps_members_initiative==1 ? "selected" : "") : ''}} value="1">Contacted UP</option>
                                <option {{count($pollisomajData)>0 ? ($pollisomajData[0]->ps_members_initiative==2 ? "selected" : "") : ''}} value="2">Contacted Local PS</option>
                                <option {{count($pollisomajData)>0 ? ($pollisomajData[0]->ps_members_initiative==3 ? "selected" : "") : ''}} value="3">Family consultation</option>
                                <option {{count($pollisomajData)>0 ? ($pollisomajData[0]->ps_members_initiative==4 ? "selected" : "") : ''}} value="4">Contacted Upazila administration</option>
                                <option {{count($pollisomajData)>0 ? ($pollisomajData[0]->ps_members_initiative==5 ? "selected" : "") : ''}} value="5">Dialed on Hotline numbers</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Within PS members:</label>
                            <input  type="text" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->ps_members : ''}}" class="form-control form-control-sm" name="ps_members" id="">
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Beyond PS members:</label>
                            <input  type="text" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->beyond_ps_members : ''}}" class="form-control form-control-sm" name="beyond_ps_members" id="">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Type of initiative taken:</label>
                            <select name="beyond_ps_members_initiative" id="" class="form-control form-control-sm">
                                <option value="">--Select--</option>
                                <option {{count($pollisomajData)>0 ? ($pollisomajData[0]->beyond_ps_members_initiative==1 ? "selected" : "") : ''}} value="1">Contacted UP</option>
                                <option {{count($pollisomajData)>0 ? ($pollisomajData[0]->beyond_ps_members_initiative==2 ? "selected" : "") : ''}} value="2">Contacted Local PS</option>
                                <option {{count($pollisomajData)>0 ? ($pollisomajData[0]->beyond_ps_members_initiative==3 ? "selected" : "") : ''}} value="3">Family consultation</option>
                                <option {{count($pollisomajData)>0 ? ($pollisomajData[0]->beyond_ps_members_initiative==4 ? "selected" : "") : ''}} value="4">Contacted Upazila administration</option>
                                <option {{count($pollisomajData)>0 ? ($pollisomajData[0]->beyond_ps_members_initiative==5 ? "selected" : "") : ''}} value="5">Dialed on Hotline numbers</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Within PS members:</label>
                            <input  type="text" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->ps_members : ''}}" class="form-control form-control-sm" name="ps_members" id="">
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Beyond PS members:</label>
                            <input  type="text" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->beyond_ps_members : ''}}" class="form-control form-control-sm" name="beyond_ps_members" id="">
                        </div> --}}
                    </div>
                </div>
            </div>
            
            <div class="card custom-card-style">
                <div class="card-header">
                    4.2. Girls at a risk of Child marriage mapping
                </div>
                <div class="card-body">
                    <div class="row">
                        {{-- 1 --}}
                        <div class="form-group col-md-6">
                            <label style="width:100%;background: #667380;padding: 9px;color: white;margin-top: 21px;" class="control-label">Number of girls identified as at risk of child marriage:</label>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="control-label">Girls:</label>
                                    <input  type="text" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->girls_risk_of_child_marriage : ''}}" class="form-control form-control-sm" name="girls_risk_of_child_marriage" id="">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label">PWD:</label>
                                    <input  type="text" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->girls_risk_of_child_marriage_pwd : ''}}" class="form-control form-control-sm" name="girls_risk_of_child_marriage_pwd" id="">
                                </div>
                            </div>
                        </div>

                        {{-- 2 --}}
                        <div class="form-group col-md-6">
                            <label style="width:100%;background: #667380;padding: 9px;color: white;margin-top: 21px;" class="control-label">Card provided among girls/families:</label>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="control-label">Girls:</label>
                                    <input  type="text" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->card_provided_among_girls : ''}}" class="form-control form-control-sm" name="card_provided_among_girls" id="">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label">PWD:</label>
                                    <input  type="text" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->card_provided_among_pwd : ''}}" class="form-control form-control-sm" name="card_provided_among_pwd" id="">
                                </div>
                            </div>
                        </div>

                        {{-- 3 --}}
                        <div class="form-group col-md-6">
                            <label style="width:100%;background: #667380;padding: 9px;color: white;margin-top: 21px;" class="control-label">Number of identified girls/ families are  referred/connected to service :</label>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="control-label">Girls:</label>
                                    <input  type="text" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->girls_connected_to_service : ''}}" class="form-control form-control-sm" name="girls_connected_to_service" id="">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label">PWD:</label>
                                    <input  type="text" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->girls_connected_to_service_pwd : ''}}" class="form-control form-control-sm" name="girls_connected_to_service_pwd" id="">
                                </div>
                            </div>
                        </div>
                        
                        {{-- 4 --}}
                        <div class="form-group col-md-6">
                            <label style="width:100%;background: #667380;padding: 9px;color: white;margin-top: 21px;" class="control-label">Number of identified girls got married finally</label>
                            <div class="row">
                                <div class="form-group col-md-4 people_received">
                                    <label class="control-label">Girls:</label>
                                    <input  type="text" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->girls_got_married_finally : ''}}" class="form-control form-control-sm" name="girls_got_married_finally" id="">
                                </div>
                                <div class="form-group col-md-4 people_received">
                                    <label class="control-label">PWD:</label>
                                    <input  type="text" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->girls_got_married_finally_pwd : ''}}" class="form-control form-control-sm" name="girls_got_married_finally_pwd" id="">
                                </div>
                                <div class="form-group col-md-4 people_received">
                                    <label class="control-label">Married at 18+:</label>
                                    <input  type="text" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->girls_got_married_at_18_finally : ''}}" class="form-control form-control-sm @error('girls_got_married_at_18_finally') is-invalid @enderror" name="girls_got_married_at_18_finally" id="">
                                    @error('girls_got_married_at_18_finally')
                                    <p style="color:red; margin-top:5px;">This field is required</p>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4 people_received">
                                    <label class="control-label">Married under 18:</label>
                                    <input  type="text" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->girls_got_married_under_18_finally_pwd : ''}}" class="form-control form-control-sm @error('girls_got_married_under_18_finally_pwd') is-invalid @enderror" name="girls_got_married_under_18_finally_pwd" id="">
                                    @error('girls_got_married_under_18_finally_pwd')
                                    <p style="color:red; margin-top:5px;">This field is required</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>    
                </div>
            </div>
            
            <div class="card custom-card-style">
                <div class="card-header">
                    4.3. VAWC Preventive initiative
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label class="control-label" style="margin-bottom: -8px;">Illegal divorce: <input type="checkbox" class="form-group" id="checkbox1" {{$pollisomajData[0]->illegal_divorce!=null ? "checked" : ""}} value="1"> </label>
                            <input  placeholder="No of initiatives" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->illegal_divorce : ''}}" type="number" class="form-control form-control-sm" name="illegal_divorce" id="illegal_divorce" {{$pollisomajData[0]->illegal_divorce==null ? "disabled" : ""}}>
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label" style="margin-bottom: -8px;" >Illegal polygamy: <input type="checkbox" class="form-group" id="checkbox2" {{$pollisomajData[0]->illegal_polygamy!=null ? "checked" : ""}} > </label>
                            <input  placeholder="No of initiatives" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->illegal_polygamy : ''}}" type="number" class="form-control form-control-sm" name="illegal_polygamy" id="illegal_polygamy" {{$pollisomajData[0]->illegal_polygamy==null ? "disabled" : ""}}>
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label" style="margin-bottom: -8px;" >Family Conflict: <input type="checkbox" class="form-group" id="checkbox3" {{$pollisomajData[0]->family_conflict!=null ? "checked" : ""}} > </label>
                            <input  placeholder="No of initiatives" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->family_conflict : ''}}" type="number" class="form-control form-control-sm" name="family_conflict" id="family_conflict" {{$pollisomajData[0]->family_conflict==null ? "disabled" : ""}}>
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label" style="margin-bottom: -8px;" >Hilla marriage: <input type="checkbox" class="form-group" id="checkbox4" {{$pollisomajData[0]->hilla_marriage!=null ? "checked" : ""}} > </label>
                            <input placeholder="No of initiatives" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->hilla_marriage : ''}}" type="number" class="form-control form-control-sm" name="hilla_marriage" id="hilla_marriage" {{$pollisomajData[0]->hilla_marriage==null ? "disabled" : ""}}>
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label" style="margin-bottom: -8px;" >Illegal arbitration: <input type="checkbox" class="form-group" id="checkbox5" {{$pollisomajData[0]->illegal_arbitration!=null ? "checked" : ""}} > </label>
                            <input placeholder="No of initiatives" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->illegal_arbitration : ''}}" type="number" class="form-control form-control-sm" name="illegal_arbitration" id="illegal_arbitration" {{$pollisomajData[0]->illegal_arbitration==null ? "disabled" : ""}}>
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label" style="margin-bottom: -8px;" >Illegal fatwa: <input type="checkbox" class="form-group" id="checkbox6" {{$pollisomajData[0]->illegal_fatwah!=null ? "checked" : ""}} > </label>
                            <input placeholder="No of initiatives" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->illegal_fatwah : ''}}" type="number" class="form-control form-control-sm" name="illegal_fatwah" id="illegal_fatwah" {{$pollisomajData[0]->illegal_fatwah==null ? "disabled" : ""}}>
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label" style="margin-bottom: -8px;" >Physical torture: <input type="checkbox" class="form-group" id="checkbox7" {{$pollisomajData[0]->physical_torture!=null ? "checked" : ""}} > </label>
                            <input placeholder="No of initiatives" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->physical_torture : ''}}" type="number" class="form-control form-control-sm" name="physical_torture" id="physical_torture" {{$pollisomajData[0]->physical_torture==null ? "disabled" : ""}}>
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label" style="margin-bottom: -8px;" >Sexual harassment: <input type="checkbox" class="form-group" id="checkbox8" {{$pollisomajData[0]->sexual_harassment!=null ? "checked" : ""}} > </label>
                            <input placeholder="No of initiatives" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->sexual_harassment : ''}}" type="number" class="form-control form-control-sm" name="sexual_harassment" id="sexual_harassment" {{$pollisomajData[0]->sexual_harassment==null ? "disabled" : ""}}>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-right">
        <a href="{{route('data.pollisomaj.add',['step'=>1, 'pollisomaj_ref_id' => $pollisomajData[0]->pollisomaj_data_ref])}}" class="btn btn-success" >Back</a>
        <input type="submit" class="btn btn-success" value="Save & Next" />
        {{-- <a href="{{route('data.pollisomaj.add',['step'=>3])}}" class="btn  btn-primary" >Save & Next</a> --}}
        <input type="submit" style='{{isset( $auth_user->user_role[0]['role_id']) && ($auth_user->user_role[0]['role_id']==4 || $auth_user->user_role[0]['role_id']==1) ? "display:none" : "" }}' name="save_destroy" class="btn btn-primary"  value="Save & Draft">
        <a href="{{route('incident.pollisomaj.viewpollisomajlist')}}" class="btn  btn-danger" >Cancel</a>
    </div>
</form>

<script>
    $(document).ready(function() {
        $("#checkbox1").click(function() {
            var checkbox1 = $("#checkbox1");
            if (checkbox1[0].checked) {
                $("#illegal_divorce").prop('disabled', false);
            } else {
                $("#illegal_divorce").prop('disabled', true);
            }
        });

        $("#checkbox2").click(function() {
            var checkbox2 = $("#checkbox2");
            if (checkbox2[0].checked) {
                $("#illegal_polygamy").prop('disabled', false);
            } else {
                $("#illegal_polygamy").prop('disabled', true);
            }
        });

        $("#checkbox3").click(function() {
            var checkbox3 = $("#checkbox3");
            if (checkbox3[0].checked) {
                $("#family_conflict").prop('disabled', false);
            } else {
                $("#family_conflict").prop('disabled', true);
            }
        });

        $("#checkbox4").click(function() {
            var checkbox4 = $("#checkbox4");
            if (checkbox4[0].checked) {
                $("#hilla_marriage").prop('disabled', false);
            } else {
                $("#hilla_marriage").prop('disabled', true);
            }
        });

        $("#checkbox5").click(function() {
            var checkbox5 = $("#checkbox5");
            if (checkbox5[0].checked) {
                $("#illegal_arbitration").prop('disabled', false);
            } else {
                $("#illegal_arbitration").prop('disabled', true);
            }
        });

        $("#checkbox6").click(function() {
            var checkbox6 = $("#checkbox6");
            if (checkbox6[0].checked) {
                $("#illegal_fatwah").prop('disabled', false);
            } else {
                $("#illegal_fatwah").prop('disabled', true);
            }
        });

        $("#checkbox7").click(function() {
            var checkbox7 = $("#checkbox7");
            if (checkbox7[0].checked) {
                $("#physical_torture").prop('disabled', false);
            } else {
                $("#physical_torture").prop('disabled', true);
            }
        });

        $("#checkbox8").click(function() {
            var checkbox8 = $("#checkbox8");
            if (checkbox8[0].checked) {
                $("#sexual_harassment").prop('disabled', false);
            } else {
                $("#sexual_harassment").prop('disabled', true);
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $("#contacted_up").click(function() {
            var contacted_up = $("#contacted_up");
            if (contacted_up[0].checked) {
                $("#contacted_up_within_ps_member").prop('disabled', false);
                $("#contacted_up_beyond_ps_member").prop('disabled', false);
            } else {
                $("#contacted_up_within_ps_member").prop('disabled', true);
                $("#contacted_up_beyond_ps_member").prop('disabled', true);
            }
        });

        $("#contacted_local").click(function() {
            var contacted_local = $("#contacted_local");
            if (contacted_local[0].checked) {
                $("#contacted_local_within_ps_member").prop('disabled', false);
                $("#contacted_local_beyond_ps_member").prop('disabled', false);
            } else {
                $("#contacted_local_within_ps_member").prop('disabled', true);
                $("#contacted_local_beyond_ps_member").prop('disabled', true);
            }
        });

        $("#family_consultation").click(function() {
            var family_consultation = $("#family_consultation");
            if (family_consultation[0].checked) {
                $("#family_consultation_within_ps_member").prop('disabled', false);
                $("#family_consultation_beyond_ps_member").prop('disabled', false);
            } else {
                $("#family_consultation_within_ps_member").prop('disabled', true);
                $("#family_consultation_beyond_ps_member").prop('disabled', true);
            }
        });

        $("#contacted_upazila").click(function() {
            var contacted_upazila = $("#contacted_upazila");
            if (contacted_upazila[0].checked) {
                $("#contacted_upazila_within_ps_member").prop('disabled', false);
                $("#contacted_upazila_beyond_ps_member").prop('disabled', false);
            } else {
                $("#contacted_upazila_within_ps_member").prop('disabled', true);
                $("#contacted_upazila_beyond_ps_member").prop('disabled', true);
            }
        });

        $("#hotline_number").click(function() {
            var hotline_number = $("#hotline_number");
            if (hotline_number[0].checked) {
                $("#hotline_number_within_ps_member").prop('disabled', false);
                $("#hotline_number_beyond_ps_member").prop('disabled', false);
            } else {
                $("#hotline_number_within_ps_member").prop('disabled', true);
                $("#hotline_number_beyond_ps_member").prop('disabled', true);
            }
        });
    });
</script>

