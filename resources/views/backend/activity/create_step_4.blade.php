<style>
    .label-p{
        display: block;
    width: 100%;
    background: #4980b5;
    color: white;
    padding: 7px 5px 7px 10px;
    margin-left: 1%;
    margin-right: 1%;
        
    }
    .section-container{
        box-shadow: 0px 0px 3px 0px;
        margin-bottom: 15px;
        padding: 7px;
    }
    .margin-bottom{
        margin-bottom: 10px;
    }
    .w-100{
        width:100%
    }
    .performers {
        max-width: 13.8%!important;
        flex: 20%;
        padding: 2px;
    }

    .bg-color{
        background: #e9ecef;
    }

    .m-bottom{
        margin-bottom: 10px;
    }

    .v-hidden{
        visibility: hidden;
    }

    .m-top{
        margin-top:10px;
    }

    .p-top{
        padding-top:10px;
    }

    .p-left{
        padding-top:10px;
    }
</style>

<meta name="meetings" content="{{ json_encode($activityDataObj->community_activity) }}">

<form action="{{route('activity.add_step_4',['step'=>5])}}" method="post">
    {{ csrf_field() }}
    <input type="hidden" value="{{ $activityData[0]->selp_activity_ref }}" name="selp_activity_ref">
<div class="card custom-card-style">
    <div class="card-header">
        Community Level Awareness
    </div>
    <div id="meeting_container">
        @if (count($activityData) > 0 && count(@$activityData[0]->community_activity) == 0)
            <div id="meeting_container_1" class="m-bottom card-body">
                <div  class="m-top row">
                    <div class="p-top p-left bg-color col-md-10">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="control-label"> Event name </label>
                                <select is_event_type="true" name="event_id[]" offset="0" onchange="checkChange(this)" id="evt_id_1" class=" form-control form-control-sm select2">
                                        <option value="">Select event</option>
                                    @foreach ($community_event as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="control-label"> No. of Events </label>
                                <input value="" type="number" class="margin-bottom form-control form-control-sm" name="no_of_event[]" id="panel_staff_workshop">
                            </div>
                            <div class="col-md-3">
                                <label class="control-label"> Starting Date </label>
                                @if (loginUserRole()->user_role[0]->role_id == 1 )
                                    <input  autocomplete="off" value="" type="date" placeholder="dd-mm-yy"  class="margin-bottom form-control form-control-sm" name="starting_date[]">
                                @else
                                    <input  autocomplete="off" value="" type="text" placeholder="dd-mm-yy" id="start_date_picker" class="margin-bottom form-control form-control-sm" name="starting_date[]" id="panel_staff_date">
                                @endif
                            </div>
                            <div class="col-md-3">
                                <label class="control-label">Ending Date</label>
                                @if (loginUserRole()->user_role[0]->role_id == 1 )
                                    <input autocomplete="off" value="" type="date" placeholder="dd-mm-yy" class="margin-bottom form-control form-control-sm" name="ending_date[]">
                                @else
                                    <input autocomplete="off" value="" type="text" placeholder="dd-mm-yy" id="end_date_picker" class="margin-bottom form-control form-control-sm" name="ending_date[]" id="panel_staff_date">
                                @endif
                            </div>
                            
                            {{-- Participents number container --}}
                            <br>
                            <div style="margin-left:10px" class="row">
                                <div class="form-group col-md-3" style="background: #667380;padding: 8px;color: white; margin-top:23px;margin-bottom: 30px; border-radius: 4px; font-size: 13px; text-align:center">
                                    Participants
                                </div>
                                <div class="form-group col-md-1 community_awareness">
                                    <label class="control-label">Boys</label>
                                    <input is_participent="true" offset="0" value="" type="number" class="form-control form-control-sm" name="participant_boys[]" id="p_b_0">
                                </div>
                                <div class="form-group col-md-1 community_awareness">
                                    <label class="control-label">Girls</label>
                                    <input is_participent="true" offset="0" value="" type="number" class="form-control form-control-sm" name="participant_girls[]" id="p_g_0">
                                </div>
                                <div class="form-group col-md-1 community_awareness">
                                    <label class="control-label">Men</label>
                                    <input is_participent="true" offset="0" value="" type="number" class="form-control form-control-sm" name="participant_men[]" id="p_m_0">
                                </div>
                                <div class="form-group col-md-1 community_awareness">
                                    <label class="control-label">Women</label>
                                    <input is_participent="true" offset="0" value="" type="number" class="form-control form-control-sm" name="participant_women[]" id="p_w_0">
                                </div>
                                <div class="form-group col-md-2 community_awareness">
                                    <label class="control-label">Other Gender</label>
                                    <input is_participent="true" offset="0" value="" type="number" class="form-control form-control-sm" name="participant_other_gender[]" id="p_i_0">
                                </div>
                                <div class="form-group col-md-2 community_awareness">
                                    <label class="control-label">Total</label>
                                    <input value="" type="number" class="form-control form-control-sm" name="participant_total[]" id="p_t_0" readonly>
                                </div>
                                
                            </div>
                            
                            <div style="margin-left:10px" class="row">
                                <div class="form-group col-md-3" style="background: #667380;padding: 8px;color: white; margin-top:23px;margin-bottom: 30px; border-radius: 4px; font-size: 13px; text-align:center">
                                    Persons With Disabilities (PWD)
                                </div>
                                <div class="form-group col-md-1 community_awareness">
                                    <label class="control-label">Boys</label>
                                    <input is_pwd_participent="true" offset="0" value="" type="number" class="form-control form-control-sm" name="participant_pwd_boys[]" id="pwd_p_b_0">
                                </div>
                                <div class="form-group col-md-1 community_awareness">
                                    <label class="control-label">Girls</label>
                                    <input is_pwd_participent="true" offset="0" value="" type="number" class="form-control form-control-sm" name="participant_pwd_girls[]" id="pwd_p_g_0">
                                </div>
                                <div class="form-group col-md-1 community_awareness">
                                    <label class="control-label">Men</label>
                                    <input is_pwd_participent="true" offset="0" value="" type="number" class="form-control form-control-sm" name="participant_pwd_men[]" id="pwd_p_m_0">
                                </div>
                                <div class="form-group col-md-1 community_awareness">
                                    <label class="control-label">Women</label>
                                    <input is_pwd_participent="true" offset="0" value="" type="number" class="form-control form-control-sm" name="participant_pwd_women[]" id="pwd_p_w_0">
                                </div>
                                <div class="form-group col-md-2 community_awareness">
                                    <label class="control-label">Other Gender</label>
                                    <input is_pwd_participent="true" offset="0" value="" type="number" class="form-control form-control-sm" name="participant_pwd_other_gender[]" id="pwd_p_i_0">
                                </div>
                                <div class="form-group col-md-2 community_awareness">
                                    <label class="control-label">Total</label>
                                    <input is_pwd_participent="true" offset="0" value="" type="number" class="form-control form-control-sm" name="participant_pwd_total[]" id="pwd_p_t_0" readonly>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="col-md-2">
                        <a href="#"  el_type="add_new_meeting" class="fa fa-plus btn btn-lg btn-info"></a>
                    </div>
                    
                </div>
            </div>
        @endif
        @foreach($activityData[0]->community_activity as $key => $value)
            @if ($key+1 < 2)
                <div id="meeting_container_1" class="m-bottom card-body">
                    <div  class="m-top row">
                        <div class="p-top p-left bg-color col-md-10">
                            <div class="row">
                                <input type="hidden" class="form-control form-control-sm" name="id[]" value="{{ $value->id }}">
                                <div class="col-md-3">
                                    <label class="control-label"> Event name </label>
                                    <select is_event_type="true" name="event_id[]" offset="0" onchange="checkChange(this)" id="evt_id_1" class=" form-control form-control-sm select2">
                                            <option value="">Select event</option>
                                        @foreach ($community_event as $item)
                                            <option {{ $value->event_id == $item->id ? "selected": "" }} value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label"> No. of Events </label>
                                    <input value="{{ $value->no_of_event }}" type="number" class="margin-bottom form-control form-control-sm" name="no_of_event[]" id="panel_staff_workshop">
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label"> Starting Date </label>
                                    @if (loginUserRole()->user_role[0]->role_id == 1)
                                    <input  autocomplete="off" value="{{ $value->starting_date }}" type="date" placeholder="dd-mm-yy" class="margin-bottom form-control form-control-sm" name="starting_date[]">
                                    @else
                                    <input  autocomplete="off" value="{{ $value->starting_date }}" type="text" placeholder="dd-mm-yy" id="start_date_picker" class="margin-bottom form-control form-control-sm" name="starting_date[]" id="panel_staff_date">
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label">Ending Date</label>
                                    @if (loginUserRole()->user_role[0]->role_id == 1)
                                    <input autocomplete="off" value="{{ $value->ending_date }}" type="date" placeholder="dd-mm-yy" class="margin-bottom form-control form-control-sm" name="ending_date[]">
                                    @else
                                    <input autocomplete="off" value="{{ $value->ending_date }}" type="text" placeholder="dd-mm-yy" id="end_date_picker" class="margin-bottom form-control form-control-sm" name="ending_date[]" id="panel_staff_date">
                                    @endif
                                </div>
                                
                                {{-- Participents number container --}}
                                <br>
                                <div style="margin-left:10px" class="row">
                                    <div class="form-group col-md-3" style="background: #667380;padding: 8px;color: white; margin-top:23px;margin-bottom: 30px; border-radius: 4px; font-size: 13px; text-align:center">
                                        Participants
                                    </div>
                                    <div class="form-group col-md-1 community_awareness">
                                        <label class="control-label">Boys</label>
                                        <input is_participent="true" offset="0" value="{{ $value->participant_boys }}" type="number" class="form-control form-control-sm" name="participant_boys[]" id="p_b_0">
                                    </div>
                                    <div class="form-group col-md-1 community_awareness">
                                        <label class="control-label">Girls</label>
                                        <input is_participent="true" offset="0" value="{{ $value->participant_girls }}" type="number" class="form-control form-control-sm" name="participant_girls[]" id="p_g_0">
                                    </div>
                                    <div class="form-group col-md-1 community_awareness">
                                        <label class="control-label">Men</label>
                                        <input is_participent="true" offset="0" value="{{ $value->participant_men }}" type="number" class="form-control form-control-sm" name="participant_men[]" id="p_m_0">
                                    </div>
                                    <div class="form-group col-md-1 community_awareness">
                                        <label class="control-label">Women</label>
                                        <input is_participent="true" offset="0" value="{{ $value->participant_women }}" type="number" class="form-control form-control-sm" name="participant_women[]" id="p_w_0">
                                    </div>
                                    <div class="form-group col-md-2 community_awareness">
                                        <label class="control-label">Other Gender</label>
                                        <input is_participent="true" offset="0" value="{{ $value->participant_other_gender }}" type="number" class="form-control form-control-sm" name="participant_other_gender[]" id="p_i_0">
                                    </div>
                                    <div class="form-group col-md-2 community_awareness">
                                        <label class="control-label">Total</label>
                                        <input value="{{ $value->participant_total }}" type="number" class="form-control form-control-sm" name="participant_total[]" id="p_t_0" readonly>
                                    </div>
                                    
                                </div>
                                
                                <div style="margin-left:10px" class="row">
                                    <div class="form-group col-md-3" style="background: #667380;padding: 8px;color: white; margin-top:23px;margin-bottom: 30px; border-radius: 4px; font-size: 13px; text-align:center">
                                        Persons With Disabilities (PWD)
                                    </div>
                                    <div class="form-group col-md-1 community_awareness">
                                        <label class="control-label">Boys</label>
                                        <input is_pwd_participent="true" offset="0" value="{{ $value->participant_pwd_boys }}" type="number" class="form-control form-control-sm" name="participant_pwd_boys[]" id="pwd_p_b_0">
                                    </div>
                                    <div class="form-group col-md-1 community_awareness">
                                        <label class="control-label">Girls</label>
                                        <input is_pwd_participent="true" offset="0" value="{{ $value->participant_pwd_girls }}" type="number" class="form-control form-control-sm" name="participant_pwd_girls[]" id="pwd_p_g_0">
                                    </div>
                                    <div class="form-group col-md-1 community_awareness">
                                        <label class="control-label">Men</label>
                                        <input is_pwd_participent="true" offset="0" value="{{ $value->participant_pwd_men }}" type="number" class="form-control form-control-sm" name="participant_pwd_men[]" id="pwd_p_m_0">
                                    </div>
                                    <div class="form-group col-md-1 community_awareness">
                                        <label class="control-label">Women</label>
                                        <input is_pwd_participent="true" offset="0" value="{{ $value->participant_pwd_women }}" type="number" class="form-control form-control-sm" name="participant_pwd_women[]" id="pwd_p_w_0">
                                    </div>
                                    <div class="form-group col-md-2 community_awareness">
                                        <label class="control-label">Other Gender</label>
                                        <input is_pwd_participent="true" offset="0" value="{{ $value->participant_pwd_other_gender }}" type="number" class="form-control form-control-sm" name="participant_pwd_other_gender[]" id="pwd_p_i_0">
                                    </div>
                                    <div class="form-group col-md-2 community_awareness">
                                        <label class="control-label">Total</label>
                                        <input is_pwd_participent="true" offset="0" value="{{ $value->participant_pwd_total }}" type="number" class="form-control form-control-sm" name="participant_pwd_total[]" id="pwd_p_t_0" readonly>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        
                        <div class="col-md-2">
                            <a href="#"  el_type="add_new_meeting" class="fa fa-plus btn btn-lg btn-info"></a>
                        </div>
                        
                    </div>


                

                    

                    
                </div>
            @else
            <div id="meeting_container_{{ $key+1 }}" class="m-bottom card-body">
                <div  class="m-top row">
                    <div class="p-top p-left bg-color col-md-10">
                        <div class="row">
                            <input type="hidden" class="form-control form-control-sm" name="id[]" value="{{ $value->id }}">
                            <div class="col-md-3">
                                <label class="control-label"> Event name </label>
                                <select is_event_type="true" name="event_id[]" offset="0" onchange="checkChange(this)" id="evt_id_1" class=" form-control form-control-sm select2">
                                        <option value="">Select event</option>
                                    @foreach ($community_event as $item)
                                        <option {{ $value->event_id == $item->id ? "selected": "" }} value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="control-label"> No. of Events </label>
                                <input value="{{ $value->no_of_event }}" type="number" class="margin-bottom form-control form-control-sm" name="no_of_event[]" id="panel_staff_workshop">
                            </div>
                            <div class="col-md-3">
                                <label class="control-label"> Starting Date </label>
                                @if (loginUserRole()->user_role[0]->role_id == 1)
                                    <input  autocomplete="off" value="{{ $value->starting_date }}" type="date" placeholder="dd-mm-yy"class="margin-bottom form-control form-control-sm" name="starting_date[]">
                                @else
                                    <input  autocomplete="off" value="{{ $value->starting_date }}" type="text" placeholder="dd-mm-yy" id="start_date_picker" class="margin-bottom form-control form-control-sm" name="starting_date[]" id="panel_staff_date">
                                @endif
                            </div>
                            <div class="col-md-3">
                                <label class="control-label">Ending Date</label>
                                @if (loginUserRole()->user_role[0]->role_id == 1)
                                    <input value="{{ $value->ending_date }}" type="date" placeholder="dd-mm-yy" class="margin-bottom form-control form-control-sm" name="ending_date[]">
                                @else
                                    <input autocomplete="off" value="{{ $value->ending_date }}" type="text" placeholder="dd-mm-yy" id="end_date_picker" class="margin-bottom form-control form-control-sm" name="ending_date[]" id="panel_staff_date">
                                @endif
                            </div>
                            
                            {{-- Participents number container --}}
                            <br>
                            <div style="margin-left:10px" class="row">
                                <div class="form-group col-md-3" style="background: #667380;padding: 8px;color: white; margin-top:23px;margin-bottom: 30px; border-radius: 4px; font-size: 13px; text-align:center">
                                    Participants
                                </div>
                                <div class="form-group col-md-1 community_awareness">
                                    <label class="control-label">Boys</label>
                                    <input is_participent="true" offset="{{ $key }}" value="{{ $value->participant_boys }}" type="number" class="form-control form-control-sm" name="participant_boys[]" id="p_b_{{$key}}">
                                </div>
                                <div class="form-group col-md-1 community_awareness">
                                    <label class="control-label">Girls</label>
                                    <input is_participent="true" offset="{{ $key }}" value="{{ $value->participant_girls }}" type="number" class="form-control form-control-sm" name="participant_girls[]" id="p_g_{{$key}}">
                                </div>
                                <div class="form-group col-md-1 community_awareness">
                                    <label class="control-label">Men</label>
                                    <input is_participent="true" offset="{{ $key }}" value="{{ $value->participant_men }}" type="number" class="form-control form-control-sm" name="participant_men[]" id="p_m_{{$key}}">
                                </div>
                                <div class="form-group col-md-1 community_awareness">
                                    <label class="control-label">Women</label>
                                    <input is_participent="true" offset="{{ $key }}" value="{{ $value->participant_women }}" type="number" class="form-control form-control-sm" name="participant_women[]" id="p_w_{{$key}}">
                                </div>
                                <div class="form-group col-md-2 community_awareness">
                                    <label class="control-label">Other Gender</label>
                                    <input is_participent="true" offset="{{ $key }}" value="{{ $value->participant_other_gender }}" type="number" class="form-control form-control-sm" name="participant_other_gender[]" id="p_i_{{$key}}">
                                </div>
                                <div class="form-group col-md-2 community_awareness">
                                    <label class="control-label">Total</label>
                                    <input value="{{ $value->participant_total }}" type="number" class="form-control form-control-sm" name="participant_total[]" id="p_t_{{$key}}" readonly>
                                </div>
                                
                            </div>
                            
                            <div style="margin-left:10px" class="row">
                                <div class="form-group col-md-3" style="background: #667380;padding: 8px;color: white; margin-top:23px;margin-bottom: 30px; border-radius: 4px; font-size: 13px; text-align:center">
                                    Persons With Disabilities (PWD)
                                </div>
                                <div class="form-group col-md-1 community_awareness">
                                    <label class="control-label">Boys</label>
                                    <input is_pwd_participent="true" offset="{{ $key }}" value="{{ $value->participant_pwd_boys }}" type="number" class="form-control form-control-sm" name="participant_pwd_boys[]" id="pwd_p_b_{{$key}}">
                                </div>
                                <div class="form-group col-md-1 community_awareness">
                                    <label class="control-label">Girls</label>
                                    <input is_pwd_participent="true" offset="{{ $key }}" value="{{ $value->participant_pwd_girls }}" type="number" class="form-control form-control-sm" name="participant_pwd_girls[]" id="pwd_p_g_{{$key}}">
                                </div>
                                <div class="form-group col-md-1 community_awareness">
                                    <label class="control-label">Men</label>
                                    <input is_pwd_participent="true" offset="{{ $key }}" value="{{ $value->participant_pwd_men }}" type="number" class="form-control form-control-sm" name="participant_pwd_men[]" id="pwd_p_m_{{$key}}">
                                </div>
                                <div class="form-group col-md-1 community_awareness">
                                    <label class="control-label">Women</label>
                                    <input is_pwd_participent="true" offset="{{ $key }}" value="{{ $value->participant_pwd_women }}" type="number" class="form-control form-control-sm" name="participant_pwd_women[]" id="pwd_p_w_{{$key}}">
                                </div>
                                <div class="form-group col-md-2 community_awareness">
                                    <label class="control-label">Other Gender</label>
                                    <input is_pwd_participent="true" offset="{{ $key }}" value="{{ $value->participant_pwd_other_gender }}" type="number" class="form-control form-control-sm" name="participant_pwd_other_gender[]" id="pwd_p_i_{{$key}}">
                                </div>
                                <div class="form-group col-md-2 community_awareness">
                                    <label class="control-label">Total</label>
                                    <input is_pwd_participent="true" offset="{{ $key }}" value="{{ $value->participant_pwd_total }}" type="number" class="form-control form-control-sm" name="participant_pwd_total[]" id="pwd_p_t_{{$key}}" readonly>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="col-md-2">
                        <a href="#"  el_type="add_new_meeting" class="fa fa-plus btn btn-lg btn-info"></a>
                        <a href="#" offset="{{ $key+1 }}" rm_meeting_el="meeting_container_{{ $key+1 }}"  style="display:inline-block"  class="fa fa-minus btn btn-lg btn-danger"></a>
                    </div>
                    
                </div>


            

                

                
            </div>
            @endif
            
        @endforeach
    </div>


    
</div>        

     



 
<div class="text-right">
    <a href="{{route('activity.add',['step'=>3, 'selp_activity_ref' => $activityData[0]->selp_activity_ref])}}" class="btn btn-success" >Back</a>
    {{-- <a href="{{route('data.pollisomaj.add',['step'=>10])}}" class="btn  btn-primary" >Save & Next</a> --}}
    {{-- <a href="{{route('activity.add',['step'=>5])}}" class="btn  btn-success" >Save & Next</a> --}}
    <input type="submit" value="Save & Next" class="btn btn-success" onClick="this.form.submit(); this.disabled=true; this.value='Sending…';">
    <input type="submit" style='{{isset( $auth_user->user_role[0]['role_id']) && ($auth_user->user_role[0]['role_id']==4 || $auth_user->user_role[0]['role_id']==1) ? "display:none" : "" }}' name="save_destroy" class="btn btn-primary"  value="Draft & Close">
    <a href="{{route('activity.draft.list')}}" class="btn  btn-danger" >Cancel</a>
</div>
</form>



@include('backend.activity.activity_script',['events'=>$community_event])
<script>
    $( function() {
      $( ".date_picker" ).datepicker({
        "dateFormat": "dd-M-yy",
        "minDate": -7,
        "maxDate": new Date()
       
      });
    } );
</script>

<script>
    $(document).ready(function(){
        $("input").keyup(function(){
            var external_network_dlac_meeting_male      = +$("#external_network_dlac_meeting_male").val();
            var external_network_dlac_meeting_female    = +$("#external_network_dlac_meeting_female").val();
            var total                                   = external_network_dlac_meeting_male+external_network_dlac_meeting_female;
            $("#external_network_dlac_meeting_total").val(total);
        });
    });
</script>

<script>
    $(document).ready(function(){
        $("input").keyup(function(){
            var pt_group_performer_boy          = +$("#pt_group_performer_boy").val();
            var pt_group_performer_girl         = +$("#pt_group_performer_girl").val();
            var pt_group_performer_men          = +$("#pt_group_performer_men").val();
            var pt_group_performer_women        = +$("#pt_group_performer_women").val();
            var pt_group_performer_transgender  = +$("#pt_group_performer_transgender").val();
            var total                           = pt_group_performer_boy+pt_group_performer_girl+pt_group_performer_men+pt_group_performer_women+pt_group_performer_transgender;
            $("#pt_group_performer_total").val(total);

            var pt_group_performer_boy_pwd        = +$("#pt_group_performer_boy_pwd").val();
            var pt_group_performer_girl_pwd       = +$("#pt_group_performer_girl_pwd").val();
            var pt_group_performer_men_pwd        = +$("#pt_group_performer_men_pwd").val();
            var pt_group_performer_women_pwd      = +$("#pt_group_performer_women_pwd").val();
            var pt_group_performer_transgender_pwd= +$("#pt_group_performer_transgender_pwd").val();
            var total_pwd                         = pt_group_performer_boy_pwd+pt_group_performer_girl_pwd+pt_group_performer_men_pwd+pt_group_performer_women_pwd+pt_group_performer_transgender_pwd;
            console.log(total_pwd);
            $("#pt_group_performer_transgender_pwd_total").val(total_pwd);
        });
    });
</script>