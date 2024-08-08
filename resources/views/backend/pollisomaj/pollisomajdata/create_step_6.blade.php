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

    .sessions_with_ps {
        max-width: 10.7%!important;
        flex: 20%;
    }

    .sessions_with_adolescent {
        max-width: 15%!important;
        flex: 20%;
    }

    .community_mobilization {
        max-width: 13.8%!important;
        flex: 20%;
    }
</style>

<form action="{{route('data.pollisomaj.add_step_6',['step'=>7])}}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="pollisomaj_ref_id" value="{{   $pollisomajData[0]->pollisomaj_data_ref }}">
<div class="card custom-card-style">
    <div class="card-header">
        7. Awareness sessions/meetings of Polli Shomaj
    </div>
    <div class="card-body">
        <div class="row">
            <div class="form-group col-md-3" style="background: #667380;padding: 8px;color: white;margin-bottom:26px; border-radius: 4px; font-size: 13px; text-align:center">
                Number of Session with Men
            </div>
            <div class="form-group col-md-3">
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->no_of_session_with_men : ''}}" type="number" class="margin-bottom form-control form-control-sm" placeholder="No. of Session" name="no_of_session_with_men" id="no_of_session_with_men" >
            </div>
            <div class="form-group col-md-3">
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->session_with_men_total : ''}}" type="number" class="margin-bottom form-control form-control-sm" placeholder="Total Participant" name="session_with_men_total" id="session_with_men_total">
            </div>
            <div class="form-group col-md-3">
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->session_with_men_pwd_total : ''}}" type="number" class="margin-bottom form-control form-control-sm" placeholder="PWD" name="session_with_men_pwd_total" id="session_with_men_pwd_total">
            </div>


            <div class="form-group col-md-3" style="background: #667380;padding: 8px;color: white;margin-bottom:26px; border-radius: 4px; font-size: 13px; text-align:center">
                Number of Session with Women
            </div>
            <div class="form-group col-md-3">
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->no_of_session_with_women : ''}}" type="number" class="margin-bottom form-control form-control-sm" placeholder="No. of Session" name="no_of_session_with_women" id="no_of_session_with_women" >
            </div>
            <div class="form-group col-md-3">
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->session_with_women_total : ''}}" type="number" class="margin-bottom form-control form-control-sm" placeholder="Total Participant" name="session_with_women_total" id="session_with_women_total">
            </div>
            <div class="form-group col-md-3">
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->session_with_women_pwd_total : ''}}" type="number" class="margin-bottom form-control form-control-sm" placeholder="PWD" name="session_with_women_pwd_total" id="session_with_women_pwd_total">
            </div>


            <div class="form-group col-md-3" style="background: #667380;padding: 8px;color: white;margin-bottom:26px; border-radius: 4px; font-size: 13px; text-align:center">
                Number of Session with Adolescents
            </div>
            <div class="form-group col-md-2 sessions_with_adolescent">
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->no_of_session_with_adolescent : ''}}" type="number" class="margin-bottom form-control form-control-sm" placeholder="No. of Session" name="no_of_session_with_adolescent" id="no_of_session_with_adolescent" >
            </div>
            <div class="form-group col-md-2 sessions_with_adolescent">
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->session_with_adolescent_boys : ''}}" type="number" class="margin-bottom form-control form-control-sm" placeholder="Boys" name="session_with_adolescent_boys" id="session_with_adolescent_boys" >
            </div>
            <div class="form-group col-md-2 sessions_with_adolescent">
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->session_with_adolescent_girls : ''}}" type="number" class="margin-bottom form-control form-control-sm" placeholder="Girls" name="session_with_adolescent_girls" id="session_with_adolescent_girls" >
            </div>
            <div class="form-group col-md-2 sessions_with_adolescent">
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->session_with_adolescent_total : ''}}" type="number" class="margin-bottom form-control form-control-sm" placeholder="Total Participant" name="session_with_adolescent_total" id="session_with_adolescent_total" readonly>
            </div>
            <div class="form-group col-md-2 sessions_with_adolescent">
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->session_with_adolescent_pwd_total : ''}}" type="number" class="margin-bottom form-control form-control-sm" placeholder="PWD" name="session_with_adolescent_pwd_total" id="session_with_adolescent_pwd_total">
            </div>


            <div class="form-group col-md-3" style="background: #667380;padding: 8px;color: white;margin-bottom:26px; border-radius: 4px; font-size: 13px; text-align:center">
                Number of sessions with PS
            </div>
            <div class="form-group col-md-2 sessions_with_adolescent">
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->no_of_session_with_ps : ''}}" type="number" class="margin-bottom form-control form-control-sm" placeholder="No. of Session" name="no_of_session_with_ps" id="no_of_session_with_ps" >
            </div>
            <div class="form-group col-md-2 sessions_with_adolescent">
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->session_with_ps_boys : ''}}" type="number" class="margin-bottom form-control form-control-sm" placeholder="Boys" name="session_with_ps_boys" id="session_with_ps_boys" >
            </div>
            <div class="form-group col-md-2 sessions_with_adolescent">
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->session_with_ps_girls : ''}}" type="number" class="margin-bottom form-control form-control-sm" placeholder="Girls" name="session_with_ps_girls" id="session_with_ps_girls" >
            </div>
            <div class="form-group col-md-2 sessions_with_adolescent">
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->session_with_ps_men : ''}}" type="number" class="margin-bottom form-control form-control-sm" placeholder="Men" name="session_with_ps_men" id="session_with_ps_men" >
            </div>
            <div class="form-group col-md-2 sessions_with_adolescent">
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->session_with_ps_women : ''}}" type="number" class="margin-bottom form-control form-control-sm" placeholder="Women" name="session_with_ps_women" id="session_with_ps_women" >
            </div>
            <div class="form-group col-md-2">    
            </div>
            <div class="form-group col-md-1">    
            </div>
            <div class="form-group col-md-2 sessions_with_adolescent">
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->session_with_ps_transgender : ''}}" type="number" class="margin-bottom form-control form-control-sm" placeholder="Other Gender" name="session_with_ps_transgender" id="session_with_ps_transgender">
            </div>
            <div class="form-group col-md-2 sessions_with_adolescent">
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->session_with_ps_pwd : ''}}" type="number" class="margin-bottom form-control form-control-sm" placeholder="PWD" name="session_with_ps_pwd" id="session_with_ps_pwd">
            </div>
            <div class="form-group col-md-2 sessions_with_adolescent">
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->session_with_ps_total : ''}}" type="number" class="margin-bottom form-control form-control-sm" placeholder="Total" name="session_with_ps_total" id="session_with_ps_total" readonly>
            </div>
        </div>
    </div>
</div>


<div class="card custom-card-style">
    <div class="card-header">
        8. PS leaders received orientation/ capacity building training by SELP
    </div>
    <div class="card-body">
        <div class="row">
            <div class="form-group col-md-2" style="background: #667380;padding: 8px;color: white;margin-top:20px; border-radius: 4px; font-size: 13px; text-align:center">
                No. of Participants
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Boys</label>
                <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->capacity_building_training_by_selp_boy : ''}}" type="number" class="form-control form-control-sm" name="capacity_building_training_by_selp_boy" id="capacity_building_training_by_selp_boy">
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Girls</label>
                <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->capacity_building_training_by_selp_girls : ''}}" type="number" class="form-control form-control-sm" name="capacity_building_training_by_selp_girls" id="capacity_building_training_by_selp_girls">
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Men</label>
                <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->capacity_building_training_by_selp_men : ''}}" type="number" class="form-control form-control-sm" name="capacity_building_training_by_selp_men" id="capacity_building_training_by_selp_men">
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Women</label>
                <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->capacity_building_training_by_selp_women : ''}}" type="number" class="form-control form-control-sm" name="capacity_building_training_by_selp_women" id="capacity_building_training_by_selp_women">
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Other Gender</label>
                <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->capacity_building_training_by_selp_transgender : ''}}" type="number" class="form-control form-control-sm" name="capacity_building_training_by_selp_transgender" id="capacity_building_training_by_selp_transgender">
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Total</label>
                <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->capacity_building_training_by_selp_total : ''}}" type="number" class="form-control form-control-sm" name="capacity_building_training_by_selp_total" id="capacity_building_training_by_selp_total" readonly>
            </div>

            <div class="form-group col-md-2" style="background: #667380;padding: 9px;color: white;margin-top:20px; border-radius: 4px; font-size: 13px; text-align:center">
                PWD
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Boys</label>
                <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->capacity_building_training_by_selp_boy_pwd : ''}}" type="number" class="form-control form-control-sm" name="capacity_building_training_by_selp_boy_pwd" id="capacity_building_training_by_selp_boy_pwd">
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Girls</label>
                <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->capacity_building_training_by_selp_girls_pwd : ''}}" type="number" class="form-control form-control-sm" name="capacity_building_training_by_selp_girls_pwd" id="capacity_building_training_by_selp_girls_pwd">
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Men</label>
                <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->capacity_building_training_by_selp_men_pwd : ''}}" type="number" class="form-control form-control-sm" name="capacity_building_training_by_selp_men_pwd" id="capacity_building_training_by_selp_men_pwd">
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Women</label>
                <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->capacity_building_training_by_selp_women_pwd : ''}}" type="number" class="form-control form-control-sm" name="capacity_building_training_by_selp_women_pwd" id="capacity_building_training_by_selp_women_pwd">
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Other Gender</label>
                <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->capacity_building_training_by_selp_girls_transgender : ''}}" type="number" class="form-control form-control-sm" name="capacity_building_training_by_selp_girls_transgender" id="capacity_building_training_by_selp_girls_transgender">
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Total</label>
                <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->capacity_building_training_by_selp_pwd_total : ''}}" type="number" class="form-control form-control-sm" name="capacity_building_training_by_selp_pwd_total" id="capacity_building_training_by_selp_pwd_total" readonly>
            </div>
        </div>
    </div>
</div>
<!-- <div class="text-right">
    <a href="{{route('data.pollisomaj.add',['step'=>4])}}" class="btn btn-success" >Back</a>
    {{-- <a href="{{route('data.pollisomaj.add',['step'=>7])}}" class="btn  btn-primary" >Save & Next</a> --}}
    <input type="submit" value="Save & Next" class="btn btn-success"/>
    <input type="submit" style='{{isset( $auth_user->user_role[0]['role_id']) && ($auth_user->user_role[0]['role_id']==4) ? "display:none" : "" }}' name="save_destroy" class="btn btn-primary"  value="Save & Draft">
    <a href="{{route('incident.pollisomaj.viewpollisomajlist')}}" class="btn  btn-danger" >Cancel</a>
</div> -->
<div  class="text-right">
   <a href="{{route('data.pollisomaj.add',['step'=>4,'pollisomaj_ref_id' => $pollisomajData[0]->pollisomaj_data_ref])}}" class="btn btn-success" >Back</a>
   {{-- <a href="#" class="btn  btn-warning" >Save & Draft</a> --}}
   <input type="submit"  name="save_destroy" class="btn btn-primary"  value="{{isset( $auth_user->user_role[0]['role_id']) && ($auth_user->user_role[0]['role_id']==4 || $auth_user->user_role[0]['role_id']==1) ? "Approve" : "Submit" }}">
   <a href="{{route('incident.pollisomaj.viewpollisomajlist')}}" class="btn  btn-danger" >Cancel</a>
</div>
</form>

<script>
    $(document).ready(function(){
        $("input").keyup(function(){
            var session_with_adolescent_boys  = +$("#session_with_adolescent_boys").val();
            var session_with_adolescent_girls = +$("#session_with_adolescent_girls").val();
            var total                         = session_with_adolescent_boys+session_with_adolescent_girls;
            $("#session_with_adolescent_total").val(total);
        });
    });
</script>

<script>
    $(document).ready(function(){
        $("input").keyup(function(){
            var session_with_ps_boys        = +$("#session_with_ps_boys").val();
            var session_with_ps_girls       = +$("#session_with_ps_girls").val();
            var session_with_ps_men         = +$("#session_with_ps_men").val();
            var session_with_ps_women       = +$("#session_with_ps_women").val();
            var session_with_ps_transgender = +$("#session_with_ps_transgender").val();
            var session_with_ps_pwd         = +$("#session_with_ps_pwd").val();
            var total                       = session_with_ps_boys+session_with_ps_girls+session_with_ps_men+session_with_ps_women+session_with_ps_transgender;
            $("#session_with_ps_total").val(total);
        });
    });
</script>

<script>
    $(document).ready(function(){
        $("input").keyup(function(){
            var capacity_building_training_by_selp_boy         = +$("#capacity_building_training_by_selp_boy").val();
            var capacity_building_training_by_selp_girls       = +$("#capacity_building_training_by_selp_girls").val();
            var capacity_building_training_by_selp_men         = +$("#capacity_building_training_by_selp_men").val();
            var capacity_building_training_by_selp_women       = +$("#capacity_building_training_by_selp_women").val();
            var capacity_building_training_by_selp_transgender = +$("#capacity_building_training_by_selp_transgender").val();
            var total                       = capacity_building_training_by_selp_boy+capacity_building_training_by_selp_girls+capacity_building_training_by_selp_men+capacity_building_training_by_selp_women+capacity_building_training_by_selp_transgender;
            $("#capacity_building_training_by_selp_total").val(total);

            var capacity_building_training_by_selp_boy_pwd          = +$("#capacity_building_training_by_selp_boy_pwd").val();
            var capacity_building_training_by_selp_girls_pwd        = +$("#capacity_building_training_by_selp_girls_pwd").val();
            var capacity_building_training_by_selp_men_pwd          = +$("#capacity_building_training_by_selp_men_pwd").val();
            var capacity_building_training_by_selp_women_pwd        = +$("#capacity_building_training_by_selp_women_pwd").val();
            var capacity_building_training_by_selp_girls_transgender= +$("#capacity_building_training_by_selp_girls_transgender").val();
            var total_pwd             = capacity_building_training_by_selp_boy_pwd+capacity_building_training_by_selp_girls_pwd+capacity_building_training_by_selp_men_pwd+capacity_building_training_by_selp_women_pwd+capacity_building_training_by_selp_girls_transgender;
            $("#capacity_building_training_by_selp_pwd_total").val(total_pwd);
        });
    });
</script>