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
</style>



<form action="{{route('data.pollisomaj.add_step_9',['step'=>10])}}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="pollisomaj_ref_id" value="{{   $pollisomajData[0]->pollisomaj_data_ref }}">

<div class="card custom-card-style">
    <div class="card-header">
        12. Dist. coordination meeting with Panel Lawyers and staff
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <label class="control-label"> No. of Workshops </label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->panel_staff_workshop : ''}}" type="number" class="margin-bottom form-control form-control-sm" name="panel_staff_workshop" id="panel_staff_workshop">
            </div>
            <div class="col-md-4">
                <label class="control-label"> Date </label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->panel_staff_date : ''}}" type="text" placeholder="dd-mm-yy" class="date_picker margin-bottom form-control form-control-sm" name="panel_staff_date" id="panel_staff_date">
            </div>
            <div class="col-md-4">
                <label class="control-label"> Panel Lawyers </label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->panel_lawyer : ''}}" type="number" class="margin-bottom form-control form-control-sm" name="panel_lawyer" id="panel_lawyer">
            </div>
            {{-- <div class="col-md-3">
                <label class="control-label"> Date </label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->panel_staff_date : ''}}" type="text" placeholder="dd-mm-yy" class="date_picker margin-bottom form-control form-control-sm" name="panel_lawyer_date" id="panel_lawyer_date">
            </div> --}}
            {{-- <div class="col-md-1">
                Date
            </div>
            <div class="col-md-3">
                <input type="date" class="margin-bottom form-control form-control-sm" name="pwd_girl" id="">
            </div> --}}
            <br>
            
            
        </div>
    </div>
</div>        

<div class="card custom-card-style">
    <div class="card-header">
        13. Meetings with external networks and agencies to improve/integrate services for VAWC survivors
    </div>
    <div class="card-body">
        <div class="row">
            <div class="form-group col-md-2">
                <label class="control-label">No of meetings (DLAC)</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->external_network_dlac_meeting : ''}}" type="number" class="form-control form-control-sm" name="external_network_dlac_meeting" id="">
            </div>
            <div class="form-group col-md-2">
                <label class="control-label">Male</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->external_network_dlac_meeting_male : ''}}" type="number" class="form-control form-control-sm" name="external_network_dlac_meeting_male" id="external_network_dlac_meeting_male">
            </div>
            <div class="form-group col-md-2">
                <label class="control-label">Female</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->external_network_dlac_meeting_female : ''}}" type="number" class="form-control form-control-sm" name="external_network_dlac_meeting_female" id="external_network_dlac_meeting_female">
            </div>
            <div class="form-group col-md-2">
                <label class="control-label">Total</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->external_network_dlac_meeting_total : ''}}" type="number" class="form-control form-control-sm" name="external_network_dlac_meeting_total" id="external_network_dlac_meeting_total" readonly>
            </div>
            <div class="form-group col-md-2">
                <label class="control-label">Date</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->external_network_dlac_meeting_date : ''}}" type="text" placeholder="dd-mm-yy" class="date_picker form-control form-control-sm" name="external_network_dlac_meeting_date" id="">
            </div>
        </div>
    </div>
</div>        

<div class="card custom-card-style">
    <div class="card-header">
        14. PT group information
    </div>
    <div class="card-body">
        <div class="row">
            <div class="form-group col-md-12">
                <div class="form-group col-md-3">
                    <label class="control-label">Number of PT Group</label>
                    <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->pt_group : ''}}" type="text" class="margin-bottom form-control form-control-sm" name="pt_group" id="">
                </div>
            </div>

            <div class="form-group col-md-2" style="background: #667380;padding: 8px;color: white; margin-top:23px;margin-bottom: 30px; border-radius: 4px; font-size: 13px; text-align:center">
                Performers
            </div>
            <div class="form-group col-md-2 performers">
                <label class="control-label">Boys</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->pt_group_performer_boy : ''}}"  type="number" class="form-control form-control-sm" name="pt_group_performer_boy" id="pt_group_performer_boy">
            </div>
            <div class="form-group col-md-2 performers">
                <label class="control-label">Girls</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->pt_group_performer_girl : ''}}"  type="number" class="form-control form-control-sm" name="pt_group_performer_girl" id="pt_group_performer_girl">
            </div>
            <div class="form-group col-md-2 performers">
                <label class="control-label">Men</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->pt_group_performer_men : ''}}"  type="number" class="form-control form-control-sm" name="pt_group_performer_men" id="pt_group_performer_men">
            </div>
            <div class="form-group col-md-2 performers">
                <label class="control-label">Women</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->pt_group_performer_women : ''}}"  type="number" class="form-control form-control-sm" name="pt_group_performer_women" id="pt_group_performer_women">
            </div>
            <div class="form-group col-md-2 performers">
                <label class="control-label">Transgender</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->pt_group_performer_transgender : ''}}"  type="number" class="form-control form-control-sm" name="pt_group_performer_transgender" id="pt_group_performer_transgender">
            </div>
            <div class="form-group col-md-2 performers">
                <label class="control-label">Total</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->pt_group_performer_total : ''}}"  type="number" class="form-control form-control-sm" name="pt_group_performer_total" id="pt_group_performer_total" readonly>
            </div>

            <div class="form-group col-md-2" style="background: #667380;padding: 8px;color: white;margin-top:23px;margin-bottom: 30px; border-radius: 4px; font-size: 13px; text-align:center">
                PWD
            </div>
            <div class="form-group col-md-2 performers">
                <label class="control-label">Boys</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->pt_group_performer_boy_pwd : ''}}" type="number" class="form-control form-control-sm" name="pt_group_performer_boy_pwd" id="pt_group_performer_boy_pwd">
            </div>
            <div class="form-group col-md-2 performers">
                <label class="control-label">Girls</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->pt_group_performer_girl_pwd : ''}}" type="number" class="form-control form-control-sm" name="pt_group_performer_girl_pwd" id="pt_group_performer_girl_pwd">
            </div>
            <div class="form-group col-md-2 performers">
                <label class="control-label">Men</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->pt_group_performer_men_pwd : ''}}" type="number" class="form-control form-control-sm" name="pt_group_performer_men_pwd" id="pt_group_performer_men_pwd">
            </div>
            <div class="form-group col-md-2 performers">
                <label class="control-label">Women</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->pt_group_performer_women_pwd : ''}}" type="number" class="form-control form-control-sm" name="pt_group_performer_women_pwd" id="pt_group_performer_women_pwd">
            </div>
            <div class="form-group col-md-2 performers">
                <label class="control-label">Transgender</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->pt_group_performer_transgender_pwd : ''}}" type="number" class="form-control form-control-sm" name="pt_group_performer_transgender_pwd" id="pt_group_performer_transgender_pwd">
            </div>
            <div class="form-group col-md-2 performers">
                <label class="control-label">Total</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->pt_group_performer_transgender_pwd_total : ''}}" type="number" class="form-control form-control-sm" name="pt_group_performer_transgender_pwd_total" id="pt_group_performer_transgender_pwd_total" readonly>
            </div>
        </div>
    </div>
</div>        


 
<div class="text-right">
    <a href="{{route('data.pollisomaj.add',['step'=>8,'pollisomaj_ref_id' => $pollisomajData[0]->pollisomaj_data_ref])}}" class="btn btn-success" >Back</a>
    {{-- <a href="{{route('data.pollisomaj.add',['step'=>10])}}" class="btn  btn-primary" >Save & Next</a> --}}
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