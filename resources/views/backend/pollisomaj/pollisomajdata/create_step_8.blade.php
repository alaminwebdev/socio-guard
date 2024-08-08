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

    .community_awareness {
        max-width: 12.5%!important;
        flex: 20%;
        padding: 2px;
    }
</style>

<form action="{{route('data.pollisomaj.add_step_8',['step'=>9])}}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="pollisomaj_ref_id" value="{{   $pollisomajData[0]->pollisomaj_data_ref }}">
<div class="card custom-card-style">
    <div class="card-header">
        10. Community level awareness event on positive gender norms.
    </div>
    <div class="card-body">
        <div class="row">
            <div class="form-group col-md-2 community_awareness">
                <label class="control-label">No. of Events</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->social_cohesion_event : ''}}" type="number" class="margin-bottom form-control form-control-sm" name="social_cohesion_event" id="">
            </div>
            <div class="form-group col-md-2 community_awareness">
                <label class="control-label">Date</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->social_cohesion_event_date : ''}}" type="text" placeholder="dd-mm-yy" class="date_picker form-control form-control-sm" name="social_cohesion_event_date" id="">
            </div>
            <div class="form-group col-md-2 community_awareness">
                <label class="control-label">Girls</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->social_cohesion_event_participent_girl : ''}}" type="number" class="form-control form-control-sm" name="social_cohesion_event_participent_girl" id="social_cohesion_event_participent_girl">
            </div>
            <div class="form-group col-md-2 community_awareness">
                <label class="control-label">Boys</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->social_cohesion_event_participent_boy : ''}}" type="number" class="form-control form-control-sm" name="social_cohesion_event_participent_boy" id="social_cohesion_event_participent_boy">
            </div>
            <div class="form-group col-md-2 community_awareness">
                <label class="control-label">Women</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->social_cohesion_event_participent_women : ''}}" type="number" class="form-control form-control-sm" name="social_cohesion_event_participent_women" id="social_cohesion_event_participent_women">
            </div>
            <div class="form-group col-md-2 community_awareness">
                <label class="control-label">Men</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->social_cohesion_event_participent_men : ''}}" type="number" class="form-control form-control-sm" name="social_cohesion_event_participent_men" id="social_cohesion_event_participent_men">
            </div>
            <div class="form-group col-md-2 community_awareness">
                <label class="control-label">Other Gender</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->social_cohesion_event_participent_transgender : ''}}" type="number" class="form-control form-control-sm" name="social_cohesion_event_participent_transgender" id="social_cohesion_event_participent_transgender">
            </div>
            <div class="form-group col-md-2 community_awareness">
                <label class="control-label">Total</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->social_cohesion_event_participent_total : ''}}" type="number" class="form-control form-control-sm" name="social_cohesion_event_participent_total" id="social_cohesion_event_participent_total" readonly>
            </div>
        </div>
    </div>
</div>        

<div class="card custom-card-style">
    <div class="card-header">
        11. Meeting with Upazila stakeholders/ duty bearer on Child marriage
    </div>
    <div class="card-body">
        <div class="row">
            <div class="form-group col-md-2">
                <label class="control-label">No. of Meeting</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->upazila_stakeholder_meeting : ''}}" type="number" class="margin-bottom form-control form-control-sm" name="upazila_stakeholder_meeting" id="">
            </div>
            <div class="form-group col-md-2">
                <label class="control-label">Date</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->upazila_stakeholder_meeting_date : ''}}" type="text" placeholder="dd-mm-yy" class="date_picker margin-bottom form-control form-control-sm" name="upazila_stakeholder_meeting_date" id="">
            </div>
            <div class="form-group col-md-6">
                <label class="control-label">Participants (GOB Officials)</label>
                <div class="row">
                    <div class="col-md-6">
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->upazila_stakeholder_meeting_participent_men_gob : ''}}" type="number" class="form-control form-control-sm" placeholder="Men" name="upazila_stakeholder_meeting_participent_men_gob" id="">
                    </div>
                    <div class="col-md-6">
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->upazila_stakeholder_meeting_participent_women_gob : ''}}" type="number" class="form-control form-control-sm" placeholder="Women" name="upazila_stakeholder_meeting_participent_women_gob" id="">
                    </div>
                </div>
            </div>
            <div class="form-group col-md-2">
            </div>
    
            {{-- <div class="form-group col-md-3">
                <input  type="text" style="visibility:hidden" class="form-control form-control-sm" name="pwd_female" id="">
                <label class="control-label">3. NGO, CSOs and Community participants</label>
                
            </div> --}}
            <div class="form-group col-md-3" style="background: #667380;padding: 8px;color: white; margin-top:23px;margin-bottom: 30px; border-radius: 4px; font-size: 13px; text-align:center">
                NGO, CSOs and Community participants
            </div>
            <div class="form-group col-md-2 community_awareness">
                <label class="control-label">Boys</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->upazila_stakeholder_meeting_participent_boy : ''}}" type="number" class="form-control form-control-sm" name="upazila_stakeholder_meeting_participent_boy" id="upazila_stakeholder_meeting_participent_boy">
            </div>
            <div class="form-group col-md-2 community_awareness">
                <label class="control-label">Girls</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->upazila_stakeholder_meeting_participent_girl : ''}}" type="number" class="form-control form-control-sm" name="upazila_stakeholder_meeting_participent_girl" id="upazila_stakeholder_meeting_participent_girl">
            </div>
            <div class="form-group col-md-2 community_awareness">
                <label class="control-label">Men</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->upazila_stakeholder_meeting_participent_men : ''}}" type="number" class="form-control form-control-sm" name="upazila_stakeholder_meeting_participent_men" id="upazila_stakeholder_meeting_participent_men">
            </div>
            <div class="form-group col-md-2 community_awareness">
                <label class="control-label">Women</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->upazila_stakeholder_meeting_participent_women : ''}}" type="number" class="form-control form-control-sm" name="upazila_stakeholder_meeting_participent_women" id="upazila_stakeholder_meeting_participent_women">
            </div>
            <div class="form-group col-md-2 community_awareness">
                <label class="control-label">Other Gender</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->upazila_stakeholder_meeting_participent_transgender : ''}}" type="number" class="form-control form-control-sm" name="upazila_stakeholder_meeting_participent_transgender" id="upazila_stakeholder_meeting_participent_transgender">
            </div>
            <div class="form-group col-md-2 community_awareness">
                <label class="control-label">Total</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->upazila_stakeholder_meeting_participent_total : ''}}" type="number" class="form-control form-control-sm" name="upazila_stakeholder_meeting_participent_total" id="upazila_stakeholder_meeting_participent_total" readonly>
            </div>

            <div class="form-group col-md-3" style="background: #667380;padding: 8px;color: white; margin-top:23px;margin-bottom: 30px; border-radius: 4px; font-size: 13px; text-align:center">
                Persons With Disabilities (PWD)
            </div>
            <div class="form-group col-md-2 community_awareness">
                <label class="control-label">Boys</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->upazila_stakeholder_meeting_participent_pwd_boy : ''}}" type="number" class="form-control form-control-sm" name="upazila_stakeholder_meeting_participent_pwd_boy" id="upazila_stakeholder_meeting_participent_pwd_boy">
            </div>
            <div class="form-group col-md-2 community_awareness">
                <label class="control-label">Girls</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->upazila_stakeholder_meeting_participent_pwd_girl : ''}}" type="number" class="form-control form-control-sm" name="upazila_stakeholder_meeting_participent_pwd_girl" id="upazila_stakeholder_meeting_participent_pwd_girl">
            </div>
            <div class="form-group col-md-2 community_awareness">
                <label class="control-label">Men</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->upazila_stakeholder_meeting_participent_pwd_men : ''}}" type="number" class="form-control form-control-sm" name="upazila_stakeholder_meeting_participent_pwd_men" id="upazila_stakeholder_meeting_participent_pwd_men">
            </div>
            <div class="form-group col-md-2 community_awareness">
                <label class="control-label">Women</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->upazila_stakeholder_meeting_participent_pwd_women : ''}}" type="number" class="form-control form-control-sm" name="upazila_stakeholder_meeting_participent_pwd_women" id="upazila_stakeholder_meeting_participent_pwd_women">
            </div>
            <div class="form-group col-md-2 community_awareness">
                <label class="control-label">Other Gender</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->upazila_stakeholder_meeting_participent_pwd_transgender : ''}}" type="number" class="form-control form-control-sm" name="upazila_stakeholder_meeting_participent_pwd_transgender" id="upazila_stakeholder_meeting_participent_pwd_transgender">
            </div>
            <div class="form-group col-md-2 community_awareness">
                <label class="control-label">Total</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->upazila_stakeholder_meeting_participent_pwd_total : ''}}" type="number" class="form-control form-control-sm" name="upazila_stakeholder_meeting_participent_pwd_total" id="upazila_stakeholder_meeting_participent_pwd_total" readonly>
            </div>
        </div>
    </div>
</div>       

<div class="text-right">
    <a href="{{route('data.pollisomaj.add',['step'=>7,'pollisomaj_ref_id' => $pollisomajData[0]->pollisomaj_data_ref])}}" class="btn btn-success" >Back</a>
    
    <input type="submit" value="Save & Next" class="btn btn-success">
    <input type="submit" style='{{isset( $auth_user->user_role[0]['role_id']) && ($auth_user->user_role[0]['role_id']==4) ? "display:none" : "" }}' name="save_destroy" class="btn btn-primary"  value="Save & Draft">
    <a href="{{route('incident.pollisomaj.viewpollisomajlist')}}" class="btn  btn-danger" >Cancel</a>
</div>
</form>
<script>
    $( function() {
      $( ".date_picker" ).datepicker({
        dateFormat:"d-M-yy",
      });

      
    } );
</script>

<script>
    $(document).ready(function(){
        $("input").keyup(function(){
            var social_cohesion_event_participent_girl        = +$("#social_cohesion_event_participent_girl").val();
            var social_cohesion_event_participent_boy         = +$("#social_cohesion_event_participent_boy").val();
            var social_cohesion_event_participent_women       = +$("#social_cohesion_event_participent_women").val();
            var social_cohesion_event_participent_men         = +$("#social_cohesion_event_participent_men").val();
            var social_cohesion_event_participent_transgender = +$("#social_cohesion_event_participent_transgender").val();
            var total           = social_cohesion_event_participent_girl+social_cohesion_event_participent_boy+social_cohesion_event_participent_women+social_cohesion_event_participent_men+social_cohesion_event_participent_transgender;
            $("#social_cohesion_event_participent_total").val(total);
        });
    });
</script>

<script>
    $(document).ready(function(){
        $("input").keyup(function(){
            var upazila_stakeholder_meeting_participent_boy          = +$("#upazila_stakeholder_meeting_participent_boy").val();
            var upazila_stakeholder_meeting_participent_girl         = +$("#upazila_stakeholder_meeting_participent_girl").val();
            var upazila_stakeholder_meeting_participent_men           = +$("#upazila_stakeholder_meeting_participent_men").val();
            var upazila_stakeholder_meeting_participent_women         = +$("#upazila_stakeholder_meeting_participent_women").val();
            var upazila_stakeholder_meeting_participent_transgender   = +$("#upazila_stakeholder_meeting_participent_transgender").val();
            var total           = upazila_stakeholder_meeting_participent_boy+upazila_stakeholder_meeting_participent_girl+upazila_stakeholder_meeting_participent_men+upazila_stakeholder_meeting_participent_women+upazila_stakeholder_meeting_participent_transgender;
            $("#upazila_stakeholder_meeting_participent_total").val(total);

            var upazila_stakeholder_meeting_participent_pwd_boy          = +$("#upazila_stakeholder_meeting_participent_pwd_boy").val();
            var upazila_stakeholder_meeting_participent_pwd_girl           = +$("#upazila_stakeholder_meeting_participent_pwd_girl").val();
            var upazila_stakeholder_meeting_participent_pwd_men        = +$("#upazila_stakeholder_meeting_participent_pwd_men").val();
            var upazila_stakeholder_meeting_participent_pwd_women          = +$("#upazila_stakeholder_meeting_participent_pwd_women").val();
            var upazila_stakeholder_meeting_participent_pwd_transgender   = +$("#upazila_stakeholder_meeting_participent_pwd_transgender").val();
            var total_pwd             = upazila_stakeholder_meeting_participent_pwd_boy+upazila_stakeholder_meeting_participent_pwd_girl+upazila_stakeholder_meeting_participent_pwd_men+upazila_stakeholder_meeting_participent_pwd_women+upazila_stakeholder_meeting_participent_pwd_transgender;
            $("#upazila_stakeholder_meeting_participent_pwd_total").val(total_pwd);
        });
    });
</script>