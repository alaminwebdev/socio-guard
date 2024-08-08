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

    .people_received {
        max-width: 13.8%!important;
        flex: 20%;
        padding: 3px;
    }

    
</style>

<form action="{{route('data.pollisomaj.add_step_4',['step'=>6])}}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="pollisomaj_ref_id" value="{{   $pollisomajData[0]->pollisomaj_data_ref }}">
<div class="card custom-card-style">
    <div class="card-header">
        6. Skill Development 
    </div>
    <div class="card-body">

        <div class="card custom-card-style">
            <div class="card-header custom_card_header">
                6.1. Number of people received/assisted with IGA training
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-2" style="text-align: right;">
                        <label class="control-label" style="background: #667380;padding: 6px;color: white;margin-top:26px; border-radius: 4px; font-size: 13px;"> PS Members </label>
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Boys</label>
                        <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_financial_ps_mem_boys : ''}}" type="number" class="form-control form-control-sm" name="iga_training_financial_ps_mem_boys" id="iga_training_financial_ps_mem_boys">
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Girls</label>
                        <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_financial_ps_mem_girls : ''}}" type="number" class="form-control form-control-sm" name="iga_training_financial_ps_mem_girls" id="iga_training_financial_ps_mem_girls">
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Men</label>
                        <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_financial_ps_mem_men : ''}}" type="number" class="form-control form-control-sm" name="iga_training_financial_ps_mem_men" id="iga_training_financial_ps_mem_men">
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Womens</label>
                        <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_financial_ps_mem_women : ''}}" type="number" class="form-control form-control-sm" name="iga_training_financial_ps_mem_women" id="iga_training_financial_ps_mem_women">
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Other Gender</label>
                        <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_financial_ps_mem_transgender : ''}}" type="number" class="form-control form-control-sm" name="iga_training_financial_ps_mem_transgender" id="iga_training_financial_ps_mem_transgender">
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Total</label>
                        <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_financial_ps_mem_total : ''}}" type="number" class="form-control form-control-sm" name="iga_training_financial_ps_mem_total" id="iga_training_financial_ps_mem_total" readonly>
                    </div>
                    <div class="form-group col-md-2" style="margin-bottom: 0px; padding-top: 32px;text-align: right;">
                        <p> PWD </p>
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Boys</label>
                        <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_financial_ps_mem_pwd_boys : ''}}" type="number" class="form-control form-control-sm" name="iga_training_financial_ps_mem_pwd_boys" id="iga_training_financial_ps_mem_pwd_boys">
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Girls</label>
                        <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_financial_ps_mem_pwd_girls : ''}}" type="number" class="form-control form-control-sm" name="iga_training_financial_ps_mem_pwd_girls" id="iga_training_financial_ps_mem_pwd_girls">
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Men</label>
                        <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_financial_ps_mem_pwd_male : ''}}" type="number" class="form-control form-control-sm" name="iga_training_financial_ps_mem_pwd_male" id="iga_training_financial_ps_mem_pwd_male">
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Womens</label>
                        <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_financial_ps_mem_pwd_women : ''}}" type="number" class="form-control form-control-sm" name="iga_training_financial_ps_mem_pwd_women" id="iga_training_financial_ps_mem_pwd_women">
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Other Gender</label>
                        <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_financial_ps_mem_pwd_transgender : ''}}" type="number" class="form-control form-control-sm" name="iga_training_financial_ps_mem_pwd_transgender" id="iga_training_financial_ps_mem_pwd_transgender">
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Total</label>
                        <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_financial_ps_mem_pwd_total : ''}}" type="number" class="form-control form-control-sm" name="iga_training_financial_ps_mem_pwd_total" id="iga_training_financial_ps_mem_pwd_total" readonly>
                    </div>


                    {{-- Out of PS --}}
                    <div class="form-group col-md-2" style="text-align: right;">
                        <label class="control-label" style="background: #667380;padding: 6px;color: white;margin-top:26px; border-radius: 4px; font-size: 13px;"> Out of PS </label>
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Boys</label>
                        <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_financial_without_ps_mem_boys : ''}}" type="number" class="form-control form-control-sm" name="iga_training_financial_without_ps_mem_boys" id="iga_training_financial_without_ps_mem_boys">
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Girls</label>
                        <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_financial_without_ps_mem_girls : ''}}" type="number" class="form-control form-control-sm" name="iga_training_financial_without_ps_mem_girls" id="iga_training_financial_without_ps_mem_girls">
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Men</label>
                        <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_financial_without_ps_mem_men : ''}}" type="number" class="form-control form-control-sm" name="iga_training_financial_without_ps_mem_men" id="iga_training_financial_without_ps_mem_men">
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Womens</label>
                        <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_financial_without_ps_mem_women : ''}}" type="number" class="form-control form-control-sm" name="iga_training_financial_without_ps_mem_women" id="iga_training_financial_without_ps_mem_women">
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Other Gender</label>
                        <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_financial_without_ps_mem_transgender : ''}}" type="number" class="form-control form-control-sm" name="iga_training_financial_without_ps_mem_transgender" id="iga_training_financial_without_ps_mem_transgender">
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Total</label>
                        <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_financial_without_ps_mem_total : ''}}" type="number" class="form-control form-control-sm" name="iga_training_financial_without_ps_mem_total" id="iga_training_financial_without_ps_mem_total" readonly>
                    </div>
                    <div class="form-group col-md-2" style="margin-bottom: 0px; padding-top: 32px;text-align: right;">
                        <p> PWD </p>
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Boys</label>
                        <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_financial_without_ps_mem_pwd_boys : ''}}" type="number" class="form-control form-control-sm" name="iga_training_financial_without_ps_mem_pwd_boys" id="iga_training_financial_without_ps_mem_pwd_boys">
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Girls</label>
                        <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_financial_without_ps_mem_pwd_girls : ''}}" type="number" class="form-control form-control-sm" name="iga_training_financial_without_ps_mem_pwd_girls" id="iga_training_financial_without_ps_mem_pwd_girls">
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Men</label>
                        <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_financial_without_ps_mem_pwd_male : ''}}" type="number" class="form-control form-control-sm" name="iga_training_financial_without_ps_mem_pwd_male" id="iga_training_financial_without_ps_mem_pwd_male">
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Womens</label>
                        <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_financial_without_ps_mem_pwd_women : ''}}" type="number" class="form-control form-control-sm" name="iga_training_financial_without_ps_mem_pwd_women" id="iga_training_financial_without_ps_mem_pwd_women">
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Other Gender</label>
                        <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_financial_without_ps_mem_pwd_transgender : ''}}" type="number" class="form-control form-control-sm" name="iga_training_financial_without_ps_mem_pwd_transgender" id="iga_training_financial_without_ps_mem_pwd_transgender">
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Total</label>
                        <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_financial_without_ps_mem_pwd_total : ''}}" type="number" class="form-control form-control-sm" name="iga_training_financial_without_ps_mem_pwd_total" id="iga_training_financial_without_ps_mem_pwd_total" readonly>
                    </div>
                </div>
            </div>
        </div>
        <div class="card custom-card-style">
            <div class="card-header custom_card_header">
                6.2. Persons involved in financial activities after receiving IGA Training
            </div>
            <div class="card-body">
                <div class="row">

                    {{-- PS Member --}}
                    <div class="form-group col-md-2" style="text-align: right;">
                        <label class="control-label" style="background: #667380;padding: 6px;color: white;margin-top:26px; border-radius: 4px; font-size: 13px;"> PS Members </label>
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Boys</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_ps_mem_boys : ''}}" type="number" class="form-control form-control-sm" name="iga_training_ps_mem_boys" id="iga_training_ps_mem_boys">
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Girls</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_ps_mem_girls : ''}}" type="number" class="form-control form-control-sm" name="iga_training_ps_mem_girls" id="iga_training_ps_mem_girls">
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Men</label>
                        <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_ps_mem_men : ''}}" type="number" class="form-control form-control-sm" name="iga_training_ps_mem_men" id="iga_training_ps_mem_men">
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Womens</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_ps_mem_women : ''}}" type="number" class="form-control form-control-sm" name="iga_training_ps_mem_women" id="iga_training_ps_mem_women">
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Other Gender</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_ps_mem_transgender : ''}}" type="number" class="form-control form-control-sm" name="iga_training_ps_mem_transgender" id="iga_training_ps_mem_transgender">
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Total</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_ps_mem_total : ''}}" type="number" class="form-control form-control-sm" name="iga_training_ps_mem_total" id="iga_training_ps_mem_total" readonly>
                    </div>
                    <div class="form-group col-md-2" style="margin-bottom: 0px; padding-top: 32px;text-align: right;">
                        <p> PWD </p>
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Boys</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_ps_mem_pwd_boys : ''}}" type="number" class="form-control form-control-sm" name="iga_training_ps_mem_pwd_boys" id="iga_training_ps_mem_pwd_boys">
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Girls</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_ps_mem_pwd_girls : ''}}" type="number" class="form-control form-control-sm" name="iga_training_ps_mem_pwd_girls" id="iga_training_ps_mem_pwd_girls">
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Men</label>
                        <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_ps_mem_pwd_men : ''}}" type="number" class="form-control form-control-sm" name="iga_training_ps_mem_pwd_men" id="iga_training_ps_mem_pwd_men">
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Womens</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_ps_mem_pwd_women : ''}}" type="number" class="form-control form-control-sm" name="iga_training_ps_mem_pwd_women" id="iga_training_ps_mem_pwd_women">
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Other Gender</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_ps_mem_pwd_transgender : ''}}" type="number" class="form-control form-control-sm" name="iga_training_ps_mem_pwd_transgender" id="iga_training_ps_mem_pwd_transgender">
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Total</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_ps_mem_pwd_total : ''}}" type="number" class="form-control form-control-sm" name="iga_training_ps_mem_pwd_total" id="iga_training_ps_mem_pwd_total" readonly>
                    </div>


                    {{-- Out of PS --}}
                    <div class="form-group col-md-2" style="text-align: right;">
                        <label class="control-label" style="background: #667380;padding: 6px;color: white;margin-top:26px; border-radius: 4px; font-size: 13px;"> Out of PS </label>
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Boys</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_without_ps_mem_boys : ''}}" type="number" class="form-control form-control-sm" name="iga_training_without_ps_mem_boys" id="iga_training_without_ps_mem_boys">
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Girls</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_without_ps_mem_girls : ''}}" type="number" class="form-control form-control-sm" name="iga_training_without_ps_mem_girls" id="iga_training_without_ps_mem_girls">
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Men</label>
                        <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_without_ps_mem_men : ''}}" type="number" class="form-control form-control-sm" name="iga_training_without_ps_mem_men" id="iga_training_without_ps_mem_men">
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Womens</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_without_ps_mem_women : ''}}" type="number" class="form-control form-control-sm" name="iga_training_without_ps_mem_women" id="iga_training_without_ps_mem_women">
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Other Gender</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_without_ps_mem_transgender : ''}}" type="number" class="form-control form-control-sm" name="iga_training_without_ps_mem_transgender" id="iga_training_without_ps_mem_transgender">
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Total</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_without_ps_mem_total : ''}}" type="number" class="form-control form-control-sm" name="iga_training_without_ps_mem_total" id="iga_training_without_ps_mem_total" readonly>
                    </div>
                    <div class="form-group col-md-2" style="margin-bottom: 0px; padding-top: 32px;text-align: right;">
                        <p> PWD </p>
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Boys</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_without_ps_mem_pwd_boys : ''}}" type="number" class="form-control form-control-sm" name="iga_training_without_ps_mem_pwd_boys" id="iga_training_without_ps_mem_pwd_boys">
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Girls</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_without_ps_mem_pwd_girls : ''}}" type="number" class="form-control form-control-sm" name="iga_training_without_ps_mem_pwd_girls" id="iga_training_without_ps_mem_pwd_girls">
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Men</label>
                        <input  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_without_ps_mem_pwd_men : ''}}" type="number" class="form-control form-control-sm" name="iga_training_without_ps_mem_pwd_men" id="iga_training_without_ps_mem_pwd_men">
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Womens</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_without_ps_mem_pwd_women : ''}}" type="number" class="form-control form-control-sm" name="iga_training_without_ps_mem_pwd_women" id="iga_training_without_ps_mem_pwd_women">
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Other Gender</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_without_ps_mem_pwd_transgender : ''}}" type="number" class="form-control form-control-sm" name="iga_training_without_ps_mem_pwd_transgender" id="iga_training_without_ps_mem_pwd_transgender">
                    </div>
                    <div class="form-group col-md-2 people_received">
                        <label class="control-label">Total</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->iga_training_without_ps_mem_pwd_total : ''}}" type="number" class="form-control form-control-sm" name="iga_training_without_ps_mem_pwd_total" id="iga_training_without_ps_mem_pwd_total" readonly>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
    <div class="text-right">
        <a href="{{route('data.pollisomaj.add',['step'=>3,'pollisomaj_ref_id' => $pollisomajData[0]->pollisomaj_data_ref])}}" class="btn btn-success" >Back</a>
        {{-- <a href="{{route('data.pollisomaj.add',['step'=>5])}}" class="btn  btn-primary" >Save & Next</a> --}}
        <input type="submit" class="btn btn-success" value="Save & Next" />
        <input type="submit" style='{{isset( $auth_user->user_role[0]['role_id']) && ($auth_user->user_role[0]['role_id']==4 || $auth_user->user_role[0]['role_id']==1) ? "display:none" : "" }}' name="save_destroy" class="btn btn-primary"  value="Save & Draft">
        <a href="{{route('incident.pollisomaj.viewpollisomajlist')}}" class="btn  btn-danger" >Cancel</a>
    </div>
</form>


<script>
    $(document).ready(function(){
        $("input").keyup(function(){
            var iga_training_financial_ps_mem_boys          = +$("#iga_training_financial_ps_mem_boys").val();
            var iga_training_financial_ps_mem_girls         = +$("#iga_training_financial_ps_mem_girls").val();
            var iga_training_financial_ps_mem_men           = +$("#iga_training_financial_ps_mem_men").val();
            var iga_training_financial_ps_mem_women         = +$("#iga_training_financial_ps_mem_women").val();
            var iga_training_financial_ps_mem_transgender   = +$("#iga_training_financial_ps_mem_transgender").val();
            var total           = iga_training_financial_ps_mem_boys+iga_training_financial_ps_mem_girls+iga_training_financial_ps_mem_men+iga_training_financial_ps_mem_women+iga_training_financial_ps_mem_transgender;
            $("#iga_training_financial_ps_mem_total").val(total);

            var iga_training_financial_ps_mem_pwd_boys        = +$("#iga_training_financial_ps_mem_pwd_boys").val();
            var iga_training_financial_ps_mem_pwd_girls       = +$("#iga_training_financial_ps_mem_pwd_girls").val();
            var iga_training_financial_ps_mem_pwd_male        = +$("#iga_training_financial_ps_mem_pwd_male").val();
            var iga_training_financial_ps_mem_pwd_women       = +$("#iga_training_financial_ps_mem_pwd_women").val();
            var iga_training_financial_ps_mem_pwd_transgender = +$("#iga_training_financial_ps_mem_pwd_transgender").val();
            var total_pwd             = iga_training_financial_ps_mem_pwd_boys+iga_training_financial_ps_mem_pwd_girls+iga_training_financial_ps_mem_pwd_male+iga_training_financial_ps_mem_pwd_women+iga_training_financial_ps_mem_pwd_transgender;
            $("#iga_training_financial_ps_mem_pwd_total").val(total_pwd);
        });
    });
</script>

<script>
    $(document).ready(function(){
        $("input").keyup(function(){
            var iga_training_financial_without_ps_mem_boys          = +$("#iga_training_financial_without_ps_mem_boys").val();
            var iga_training_financial_without_ps_mem_girls         = +$("#iga_training_financial_without_ps_mem_girls").val();
            var iga_training_financial_without_ps_mem_men           = +$("#iga_training_financial_without_ps_mem_men").val();
            var iga_training_financial_without_ps_mem_women         = +$("#iga_training_financial_without_ps_mem_women").val();
            var iga_training_financial_without_ps_mem_transgender   = +$("#iga_training_financial_without_ps_mem_transgender").val();
            var total           = iga_training_financial_without_ps_mem_boys+iga_training_financial_without_ps_mem_girls+iga_training_financial_without_ps_mem_men+iga_training_financial_without_ps_mem_women+iga_training_financial_without_ps_mem_transgender;
            $("#iga_training_financial_without_ps_mem_total").val(total);

            var iga_training_financial_without_ps_mem_pwd_boys        = +$("#iga_training_financial_without_ps_mem_pwd_boys").val();
            var iga_training_financial_without_ps_mem_pwd_girls       = +$("#iga_training_financial_without_ps_mem_pwd_girls").val();
            var iga_training_financial_without_ps_mem_pwd_male        = +$("#iga_training_financial_without_ps_mem_pwd_male").val();
            var iga_training_financial_without_ps_mem_pwd_women       = +$("#iga_training_financial_without_ps_mem_pwd_women").val();
            var iga_training_financial_without_ps_mem_pwd_transgender = +$("#iga_training_financial_without_ps_mem_pwd_transgender").val();
            var total_pwd             = iga_training_financial_without_ps_mem_pwd_boys+iga_training_financial_without_ps_mem_pwd_girls+iga_training_financial_without_ps_mem_pwd_male+iga_training_financial_without_ps_mem_pwd_women+iga_training_financial_without_ps_mem_pwd_transgender;
            $("#iga_training_financial_without_ps_mem_pwd_total").val(total_pwd);
        });
    });
</script>

<script>
    $(document).ready(function(){
        $("input").keyup(function(){
            var iga_training_ps_mem_boys          = +$("#iga_training_ps_mem_boys").val();
            var iga_training_ps_mem_girls         = +$("#iga_training_ps_mem_girls").val();
            var iga_training_ps_mem_men           = +$("#iga_training_ps_mem_men").val();
            var iga_training_ps_mem_women         = +$("#iga_training_ps_mem_women").val();
            var iga_training_ps_mem_transgender   = +$("#iga_training_ps_mem_transgender").val();
            var total           = iga_training_ps_mem_boys+iga_training_ps_mem_girls+iga_training_ps_mem_men+iga_training_ps_mem_women+iga_training_ps_mem_transgender;
            $("#iga_training_ps_mem_total").val(total);

            var iga_training_ps_mem_pwd_boys        = +$("#iga_training_ps_mem_pwd_boys").val();
            var iga_training_ps_mem_pwd_girls       = +$("#iga_training_ps_mem_pwd_girls").val();
            var iga_training_ps_mem_pwd_men        = +$("#iga_training_ps_mem_pwd_men").val();
            var iga_training_ps_mem_pwd_women       = +$("#iga_training_ps_mem_pwd_women").val();
            var iga_training_ps_mem_pwd_transgender = +$("#iga_training_ps_mem_pwd_transgender").val();
            var total_pwd             = iga_training_ps_mem_pwd_boys+iga_training_ps_mem_pwd_girls+iga_training_ps_mem_pwd_men+iga_training_ps_mem_pwd_women+iga_training_ps_mem_pwd_transgender;
            $("#iga_training_ps_mem_pwd_total").val(total_pwd);
        });
    });
</script>

<script>
    $(document).ready(function(){
        $("input").keyup(function(){
            var iga_training_without_ps_mem_boys          = +$("#iga_training_without_ps_mem_boys").val();
            var iga_training_without_ps_mem_girls         = +$("#iga_training_without_ps_mem_girls").val();
            var iga_training_without_ps_mem_men           = +$("#iga_training_without_ps_mem_men").val();
            var iga_training_without_ps_mem_women         = +$("#iga_training_without_ps_mem_women").val();
            var iga_training_without_ps_mem_transgender   = +$("#iga_training_without_ps_mem_transgender").val();
            var total           = iga_training_without_ps_mem_boys+iga_training_without_ps_mem_girls+iga_training_without_ps_mem_men+iga_training_without_ps_mem_women+iga_training_without_ps_mem_transgender;
            $("#iga_training_without_ps_mem_total").val(total);

            var iga_training_without_ps_mem_pwd_boys        = +$("#iga_training_without_ps_mem_pwd_boys").val();
            var iga_training_without_ps_mem_pwd_girls       = +$("#iga_training_without_ps_mem_pwd_girls").val();
            var iga_training_without_ps_mem_pwd_men        = +$("#iga_training_without_ps_mem_pwd_men").val();
            var iga_training_without_ps_mem_pwd_women       = +$("#iga_training_without_ps_mem_pwd_women").val();
            var iga_training_without_ps_mem_pwd_transgender = +$("#iga_training_without_ps_mem_pwd_transgender").val();
            var total_pwd             = iga_training_without_ps_mem_pwd_boys+iga_training_without_ps_mem_pwd_girls+iga_training_without_ps_mem_pwd_men+iga_training_without_ps_mem_pwd_women+iga_training_without_ps_mem_pwd_transgender;
            $("#iga_training_without_ps_mem_pwd_total").val(total_pwd);
        });
    });
</script>