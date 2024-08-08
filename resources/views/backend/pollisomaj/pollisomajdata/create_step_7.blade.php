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

    .community_mobilization {
        max-width: 10.7%!important;
        flex: 20%;
        padding: 2px;
    }
</style>

<form action="{{route('data.pollisomaj.add_step_7',['step'=>8])}}" method="post">
    {{ csrf_field() }}  

    <input type="hidden" name="pollisomaj_ref_id" value="{{   $pollisomajData[0]->pollisomaj_data_ref }}">
<div class="card custom-card-style">
    <div class="card-header">
        9. Campaign and day observation for Community Mobilisation
    </div>
    <div class="card-body">
        {{-- International women’s day celebration --}}
        <div class="row" style="background-color: #d9d5d7;padding: 10px;border-radius: 5px;">
            <div class="form-group col-md-3" style="background: #667380;padding: 8px;color: white; margin-top:23px;margin-bottom: 30px; border-radius: 4px; font-size: 13px; text-align:center">
                International women’s day celebration
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Boys</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->womens_day_celebration_boys : ''}}" type="number" class="margin-bottom form-control form-control-sm" name="womens_day_celebration_boys" id="womens_day_celebration_boys">
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Girls</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->womens_day_celebration_girls : ''}}" type="number" class="margin-bottom form-control form-control-sm" name="womens_day_celebration_girls" id="womens_day_celebration_girls">
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Men</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->womens_day_celebration_men : ''}}" type="number" class="margin-bottom form-control form-control-sm" name="womens_day_celebration_men" id="womens_day_celebration_men">
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Women</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->womens_day_celebration_women : ''}}" type="number" class="margin-bottom form-control form-control-sm" name="womens_day_celebration_women" id="womens_day_celebration_women">
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Other Gender</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->womens_day_celebration_transgender : ''}}" type="number" class="margin-bottom form-control form-control-sm" name="womens_day_celebration_transgender" id="womens_day_celebration_transgender">
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Total</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->womens_day_celebration_total : ''}}" type="number" class="margin-bottom form-control form-control-sm" name="womens_day_celebration_total" id="womens_day_celebration_total" readonly>
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Date</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->womens_day_celebration_date : ''}}" type="date" class="margin-bottom form-control form-control-sm" name="womens_day_celebration_date" id="womens_day_celebration_date">
            </div>
            <div class="form-group col-md-3" style="background: #667380;padding: 8px;color: white;margin-top:23px;margin-bottom: 30px; border-radius: 4px; font-size: 13px; text-align:center">
                PWD
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Boys</label>
                <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->womens_day_celebration_pwd_boys : ''}}" type="number" class="form-control form-control-sm" name="womens_day_celebration_pwd_boys" id="womens_day_celebration_pwd_boys">
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Girls</label>
                <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->womens_day_celebration_pwd_girls : ''}}" type="number" class="form-control form-control-sm" name="womens_day_celebration_pwd_girls" id="womens_day_celebration_pwd_girls">
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Men</label>
                <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->womens_day_celebration_pwd_men : ''}}" type="number" class="form-control form-control-sm" name="womens_day_celebration_pwd_men" id="womens_day_celebration_pwd_men">
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Women</label>
                <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->womens_day_celebration_pwd_women : ''}}" type="number" class="form-control form-control-sm" name="womens_day_celebration_pwd_women" id="womens_day_celebration_pwd_women">
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Other Gender</label>
                <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->womens_day_celebration_pwd_transgender : ''}}" type="number" class="form-control form-control-sm" name="womens_day_celebration_pwd_transgender" id="womens_day_celebration_pwd_transgender">
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Total</label>
                <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->womens_day_celebration_pwd_total : ''}}" type="number" class="form-control form-control-sm" name="womens_day_celebration_pwd_total" id="womens_day_celebration_pwd_total" readonly>
            </div>
        </div>
        <br>

        {{-- Celebrating 16 days campaign --}}
        <div class="row" style="background-color: #e1e5e4;padding: 10px;border-radius: 5px;">
            <div class="form-group col-md-3" style="background: #667380;padding: 8px;color: white; margin-top:23px;margin-bottom: 30px; border-radius: 4px; font-size: 13px; text-align:center">
                Celebrating 16 days campaign
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Boys</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->celebration_days_campaign_boys : ''}}" type="number" class="margin-bottom form-control form-control-sm" name="celebration_days_campaign_boys" id="celebration_days_campaign_boys">
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Girls</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->celebration_days_campaign_girls : ''}}" type="number" class="margin-bottom form-control form-control-sm" name="celebration_days_campaign_girls" id="celebration_days_campaign_girls">
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Men</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->celebration_days_campaign_men : ''}}" type="number" class="margin-bottom form-control form-control-sm" name="celebration_days_campaign_men" id="celebration_days_campaign_men">
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Women</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->celebration_days_campaign_women : ''}}" type="number" class="margin-bottom form-control form-control-sm" name="celebration_days_campaign_women" id="celebration_days_campaign_women">
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Other Gender</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->celebration_days_campaign_transgender : ''}}" type="number" class="margin-bottom form-control form-control-sm" name="celebration_days_campaign_transgender" id="celebration_days_campaign_transgender">
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Total</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->celebration_days_campaign_total : ''}}" type="number" class="margin-bottom form-control form-control-sm" name="celebration_days_campaign_total" id="celebration_days_campaign_total" readonly>
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Date</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->celebration_days_campaign_date : ''}}" type="date" class="margin-bottom form-control form-control-sm" name="celebration_days_campaign_date" id="">
            </div>
            <div class="form-group col-md-3" style="background: #667380;padding: 8px;color: white;margin-top:23px;margin-bottom: 30px; border-radius: 4px; font-size: 13px; text-align:center">
                PWD
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Boys</label>
                <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->celebration_days_campaign_pwd_boys : ''}}" type="number" class="form-control form-control-sm" name="celebration_days_campaign_pwd_boys" id="celebration_days_campaign_pwd_boys">
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Girls</label>
                <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->celebration_days_campaign_pwd_girls : ''}}" type="number" class="form-control form-control-sm" name="celebration_days_campaign_pwd_girls" id="celebration_days_campaign_pwd_girls">
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Men</label>
                <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->celebration_days_campaign_pwd_men : ''}}" type="number" class="form-control form-control-sm" name="celebration_days_campaign_pwd_men" id="celebration_days_campaign_pwd_men">
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Women</label>
                <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->celebration_days_campaign_pwd_women : ''}}" type="number" class="form-control form-control-sm" name="celebration_days_campaign_pwd_women" id="celebration_days_campaign_pwd_women">
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Other Gender</label>
                <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->celebration_days_campaign_pwd_transgender : ''}}" type="number" class="form-control form-control-sm" name="celebration_days_campaign_pwd_transgender" id="celebration_days_campaign_pwd_transgender">
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Total</label>
                <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->celebration_days_campaign_pwd_total : ''}}" type="number" class="form-control form-control-sm" name="celebration_days_campaign_pwd_total" id="celebration_days_campaign_pwd_total" readonly>
            </div>
        </div>
        <br>

        {{-- Celebrating 16 days campaign --}}
        <div class="row" style="background-color: #d2e5e0;padding: 10px;border-radius: 5px;">
            <div class="form-group col-md-3" style="background: #667380;padding: 8px;color: white; margin-top:23px;margin-bottom: 30px; border-radius: 4px; font-size: 13px; text-align:center">
                National Legal Aid Day
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Boys</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->legal_aid_days_boys : ''}}" type="number" class="margin-bottom form-control form-control-sm" name="legal_aid_days_boys" id="legal_aid_days_boys">
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Girls</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->legal_aid_days_girls : ''}}" type="number" class="margin-bottom form-control form-control-sm" name="legal_aid_days_girls" id="legal_aid_days_girls">
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Men</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->legal_aid_days_men : ''}}" type="number" class="margin-bottom form-control form-control-sm" name="legal_aid_days_men" id="legal_aid_days_men">
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Women</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->legal_aid_days_women : ''}}" type="number" class="margin-bottom form-control form-control-sm" name="legal_aid_days_women" id="legal_aid_days_women">
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Other Gender</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->legal_aid_days_transgender : ''}}" type="number" class="margin-bottom form-control form-control-sm" name="legal_aid_days_transgender" id="legal_aid_days_transgender">
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Total</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->legal_aid_days_total : ''}}" type="number" class="margin-bottom form-control form-control-sm" name="legal_aid_days_total" id="legal_aid_days_total" readonly>
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Date</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->legal_aid_days_date : ''}}" type="date" class="margin-bottom form-control form-control-sm" name="legal_aid_days_date" id="">
            </div>
            <div class="form-group col-md-3" style="background: #667380;padding: 8px;color: white;margin-top:23px;margin-bottom: 30px; border-radius: 4px; font-size: 13px; text-align:center">
                PWD
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Boys</label>
                <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->legal_aid_days_pwd_boys : ''}}" type="number" class="form-control form-control-sm" name="legal_aid_days_pwd_boys" id="legal_aid_days_pwd_boys">
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Girls</label>
                <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->legal_aid_days_pwd_girls : ''}}" type="number" class="form-control form-control-sm" name="legal_aid_days_pwd_girls" id="legal_aid_days_pwd_girls">
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Men</label>
                <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->legal_aid_days_pwd_men : ''}}" type="number" class="form-control form-control-sm" name="legal_aid_days_pwd_men" id="legal_aid_days_pwd_men">
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Women</label>
                <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->legal_aid_days_pwd_women : ''}}" type="number" class="form-control form-control-sm" name="legal_aid_days_pwd_women" id="legal_aid_days_pwd_women">
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Other Gender</label>
                <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->legal_aid_days_pwd_transgender : ''}}" type="number" class="form-control form-control-sm" name="legal_aid_days_pwd_transgender" id="legal_aid_days_pwd_transgender">
            </div>
            <div class="form-group col-md-2 community_mobilization">
                <label class="control-label">Total</label>
                <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->legal_aid_days_pwd_total : ''}}" type="number" class="form-control form-control-sm" name="legal_aid_days_pwd_total" id="legal_aid_days_pwd_total" readonly>
            </div>
        </div>
    </div>    
</div>
<div class="text-right">
    <a href="{{route('data.pollisomaj.add',['step'=>6,'pollisomaj_ref_id' => $pollisomajData[0]->pollisomaj_data_ref])}}" class="btn btn-success" >Back</a>
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
            var womens_day_celebration_boys          = +$("#womens_day_celebration_boys").val();
            var womens_day_celebration_girls         = +$("#womens_day_celebration_girls").val();
            var womens_day_celebration_men           = +$("#womens_day_celebration_men").val();
            var womens_day_celebration_women         = +$("#womens_day_celebration_women").val();
            var womens_day_celebration_transgender   = +$("#womens_day_celebration_transgender").val();
            var total           = womens_day_celebration_boys+womens_day_celebration_girls+womens_day_celebration_men+womens_day_celebration_women+womens_day_celebration_transgender;
            $("#womens_day_celebration_total").val(total);

            var womens_day_celebration_pwd_boys          = +$("#womens_day_celebration_pwd_boys").val();
            var womens_day_celebration_pwd_girls           = +$("#womens_day_celebration_pwd_girls").val();
            var womens_day_celebration_pwd_men        = +$("#womens_day_celebration_pwd_men").val();
            var womens_day_celebration_pwd_women          = +$("#womens_day_celebration_pwd_women").val();
            var womens_day_celebration_pwd_transgender   = +$("#womens_day_celebration_pwd_transgender").val();
            var total_pwd             = womens_day_celebration_pwd_boys+womens_day_celebration_pwd_girls+womens_day_celebration_pwd_men+womens_day_celebration_pwd_women+womens_day_celebration_pwd_transgender;
            $("#womens_day_celebration_pwd_total").val(total_pwd);
        });
    });

    $(document).ready(function(){
        $("input").keyup(function(){
            var celebration_days_campaign_boys          = +$("#celebration_days_campaign_boys").val();
            var celebration_days_campaign_girls         = +$("#celebration_days_campaign_girls").val();
            var celebration_days_campaign_men           = +$("#celebration_days_campaign_men").val();
            var celebration_days_campaign_women         = +$("#celebration_days_campaign_women").val();
            var celebration_days_campaign_transgender   = +$("#celebration_days_campaign_transgender").val();
            var total           = celebration_days_campaign_boys+celebration_days_campaign_girls+celebration_days_campaign_men+celebration_days_campaign_women+celebration_days_campaign_transgender;
            $("#celebration_days_campaign_total").val(total);

            var celebration_days_campaign_pwd_boys          = +$("#celebration_days_campaign_pwd_boys").val();
            var celebration_days_campaign_pwd_girls         = +$("#celebration_days_campaign_pwd_girls").val();
            var celebration_days_campaign_pwd_men           = +$("#celebration_days_campaign_pwd_men").val();
            var celebration_days_campaign_pwd_women         = +$("#celebration_days_campaign_pwd_women").val();
            var celebration_days_campaign_pwd_transgender   = +$("#celebration_days_campaign_pwd_transgender").val();
            var total_pwd             = celebration_days_campaign_pwd_boys+celebration_days_campaign_pwd_girls+celebration_days_campaign_pwd_men+celebration_days_campaign_pwd_women+celebration_days_campaign_pwd_transgender;
            $("#celebration_days_campaign_pwd_total").val(total_pwd);
        });
    });

    $(document).ready(function(){
        $("input").keyup(function(){
            var legal_aid_days_boys          = +$("#legal_aid_days_boys").val();
            var legal_aid_days_girls         = +$("#legal_aid_days_girls").val();
            var legal_aid_days_men           = +$("#legal_aid_days_men").val();
            var legal_aid_days_women         = +$("#legal_aid_days_women").val();
            var legal_aid_days_transgender   = +$("#legal_aid_days_transgender").val();
            var total                        = legal_aid_days_boys+legal_aid_days_girls+legal_aid_days_men+legal_aid_days_women+legal_aid_days_transgender;
            $("#legal_aid_days_total").val(total);

            var legal_aid_days_pwd_boys         = +$("#legal_aid_days_pwd_boys").val();
            var legal_aid_days_pwd_girls        = +$("#legal_aid_days_pwd_girls").val();
            var legal_aid_days_pwd_men          = +$("#legal_aid_days_pwd_men").val();
            var legal_aid_days_pwd_women        = +$("#legal_aid_days_pwd_women").val();
            var legal_aid_days_pwd_transgender  = +$("#legal_aid_days_pwd_transgender").val();
            var total_pwd                       = legal_aid_days_pwd_boys+legal_aid_days_pwd_girls+legal_aid_days_pwd_men+legal_aid_days_pwd_women+legal_aid_days_pwd_transgender;
            $("#legal_aid_days_pwd_total").val(total_pwd);
        });
    });
</script>