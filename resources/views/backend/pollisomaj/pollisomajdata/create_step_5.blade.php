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

    
</style>

<form action="{{route('data.pollisomaj.add_step_5',['step'=>6])}}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="pollisomaj_ref_id" value="{{   $pollisomajData[0]->pollisomaj_data_ref }}">
<div class="card custom-card-style">
    <div class="card-header">
        7. No.of out of PS members (person) assisted to get safety-net support
    </div>
    <div class="card-body">
        <div class="card">
            <div class="card-header custom_card_header">
                7.1.Food for work
            </div>
            <div class="card-body">
                <div class="row">
                     {{-- Use girls field as men both in front and backend --}}
                     <div class="form-group col-md-2">
                        <label class="control-label">Men </label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->one_house_one_firm_girls : ''}}" type="number" class="form-control form-control-sm" name="one_house_one_firm_girls" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Womens </label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->food_for_work_women : ''}}" type="number" class="form-control form-control-sm" name="food_for_work_women" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Other Gender </label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->food_for_work_transgender : ''}}" type="number" class="form-control form-control-sm" name="food_for_work_transgender" id="">
                    </div>
                    {{-- Use girls field as men both in front and backend --}}
                    <div class="form-group col-md-2">
                        <label class="control-label">Men (PWD)</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->one_house_one_firm_girls_pwd : ''}}" type="number" class="form-control form-control-sm" name="one_house_one_firm_girls_pwd" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Womens (PWD)</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->food_for_work_women_pwd : ''}}"  type="number" class="form-control form-control-sm" name="food_for_work_women_pwd" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Other Gender (PWD)</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->food_for_work_transgender_pwd : ''}}"  type="number" class="form-control form-control-sm" name="food_for_work_transgender_pwd" id="">
                    </div>
                </div>
            </div>
        </div>
        
        
        <div class="card custom-card-style">
            <div class="card-header custom_card_header">
                7.2.VGF\VGD
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-2">
                        <label class="control-label">Girls </label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->vgf_vgd_girls : ''}}" type="number" class="form-control form-control-sm" name="vgf_vgd_girls" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Womens </label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->vgf_vgd_women : ''}}" type="number" class="form-control form-control-sm" name="vgf_vgd_women" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Men </label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->vgf_vgd_girls : ''}}" type="number" class="form-control form-control-sm" name="vgf_vgd_girls" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Other Gender </label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->vgf_vgd_transgender : ''}}" type="number" class="form-control form-control-sm" name="vgf_vgd_transgender" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Girls (PWD)</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->vgf_vgd_girls_pwd : ''}}" type="number" class="form-control form-control-sm" name="vgf_vgd_girls_pwd" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Womens (PWD)</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->vgf_vgd_women_pwd : ''}}" type="number" class="form-control form-control-sm" name="vgf_vgd_women_pwd" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Men(PWD) </label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->vgf_vgd_girls : ''}}" type="number" class="form-control form-control-sm" name="vgf_vgd_girls" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Other Gender (PWD)</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->vgf_vgd_transgender_pwd : ''}}" type="number" class="form-control form-control-sm" name="vgf_vgd_transgender_pwd" id="">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card custom-card-style">
            <div class="card-header custom_card_header">
                7.3.Income support programme for the poorest 100/1000 days programme
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-2">
                        <label class="control-label">Girls </label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->programe_for_poorest_girls : ''}}" type="number" class="form-control form-control-sm" name="programe_for_poorest_girls" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Womens </label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->programe_for_poorest_women : ''}}" type="number" class="form-control form-control-sm" name="programe_for_poorest_women" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Other Gender </label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->programe_for_poorest_transgender : ''}}" type="number" class="form-control form-control-sm" name="programe_for_poorest_transgender" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Girls (PWD)</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->programe_for_poorest_girls_pwd : ''}}" type="number" class="form-control form-control-sm" name="programe_for_poorest_girls_pwd" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Womens (PWD)</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->programe_for_poorest_women_pwd : ''}}" type="number" class="form-control form-control-sm" name="programe_for_poorest_women_pwd" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Other Gender (PWD)</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->programe_for_poorest_transgender_pwd : ''}}" type="number" class="form-control form-control-sm" name="programe_for_poorest_transgender_pwd" id="">
                    </div>
                </div>
            </div>
        </div>        
        
    
        <div class="card custom-card-style">
            <div class="card-header custom_card_header">
                7.4.Maternity Allowance Programme for the Poor
            </div> 
            <div class="card-body">
                <div class="row">
                    {{-- <div class="form-group col-md-2">
                        <label class="control-label">Girls </label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->maternity_allowance_girls : ''}}" type="number" class="form-control form-control-sm" name="maternity_allowance_girls" id="">
                    </div> --}}
                    <div class="form-group col-md-2">
                        <label class="control-label">Womens </label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->maternity_allowance_women : ''}}" type="number" class="form-control form-control-sm" name="maternity_allowance_women" id="">
                    </div>
                    {{-- <div class="form-group col-md-2">
                        <label class="control-label">Other Gender </label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->maternity_allowance_transgender : ''}}" type="number" class="form-control form-control-sm" name="maternity_allowance_transgender" id="">
                    </div> --}}
                    {{-- <div class="form-group col-md-2">
                        <label class="control-label">Girls (PWD)</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->maternity_allowance_girls_pwd : ''}}" type="number" class="form-control form-control-sm" name="maternity_allowance_girls_pwd" id="">
                    </div> --}}
                    <div class="form-group col-md-2">
                        <label class="control-label">Womens (PWD)</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->maternity_allowance_women_pwd : ''}}" type="number" class="form-control form-control-sm" name="maternity_allowance_women_pwd" id="">
                    </div>
                    {{-- <div class="form-group col-md-2">
                        <label class="control-label">Other Gender (PWD)</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->maternity_allowance_transgender_pwd : ''}}" type="number" class="form-control form-control-sm" name="maternity_allowance_transgender_pwd" id="">
                    </div> --}}
                </div>
            </div>
        </div>       
        
        {{-- <div class="card custom-card-style">
            <div class="card-header custom_card_header">
                7.5.Honorarium for Freedom Fighters
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-2">
                        <label class="control-label">Girls </label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->freedom_fighters_girls : ''}}" type="number" class="form-control form-control-sm" name="freedom_fighters_girls" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Womens </label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->freedom_fighters_women : ''}}" type="number" class="form-control form-control-sm" name="freedom_fighters_women" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Other Gender </label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->freedom_fighters_transgender : ''}}" type="number" class="form-control form-control-sm" name="freedom_fighters_transgender" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Girls (PWD)</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->freedom_fighters_girls_pwd : ''}}" type="number" class="form-control form-control-sm" name="freedom_fighters_girls_pwd" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Womens (PWD)</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->freedom_fighters_women_pwd : ''}}" type="number" class="form-control form-control-sm" name="freedom_fighters_women_pwd" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Other Gender (PWD)</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->freedom_fighters_transgender_pwd : ''}}" type="number" class="form-control form-control-sm" name="freedom_fighters_transgender_pwd" id="">
                    </div>
                </div>
            </div>
        </div>         --}}
        
        <div class="card custom-card-style">
            <div class="card-header custom_card_header">
                7.5.Block Allocation for Disaster Management
            </div> 
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-2">
                        <label class="control-label">Girls </label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->disaster_allocation_girls : ''}}" type="number" class="form-control form-control-sm" name="disaster_allocation_girls" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Womens </label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->disaster_allocation_women : ''}}" type="number" class="form-control form-control-sm" name="disaster_allocation_women" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Other Gender </label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->disaster_allocation_girls : ''}}" type="number" class="form-control form-control-sm" name="disaster_allocation_transgender" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Girls (PWD)</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->disaster_allocation_transgender_pwd : ''}}" type="number" class="form-control form-control-sm" name="disaster_allocation_girls_pwd" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Womens (PWD)</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->disaster_allocation_women_pwd : ''}}" type="number" class="form-control form-control-sm" name="disaster_allocation_women_pwd" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Other Gender (PWD)</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->disaster_allocation_transgender_pwd : ''}}" type="number" class="form-control form-control-sm" name="disaster_allocation_transgender_pwd" id="">
                    </div>
                </div>
            </div>
        </div>   
        
        <div class="card custom-card-style">
            <div class="card-header custom_card_header">
                7.6.General Relief Activities (Block)
            </div> 
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-2">
                        <label class="control-label">Girls </label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->relief_activities_girls : ''}}" type="number" class="form-control form-control-sm" name="relief_activities_girls" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Womens </label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->relief_activities_women : ''}}" type="number" class="form-control form-control-sm" name="relief_activities_women" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Other Gender </label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->relief_activities_girls : ''}}" type="number" class="form-control form-control-sm" name="relief_activities_transgender" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Girls (PWD)</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->relief_activities_transgender_pwd : ''}}" type="number" class="form-control form-control-sm" name="relief_activities_girls_pwd" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Womens (PWD)</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->relief_activities_women_pwd : ''}}" type="number" class="form-control form-control-sm" name="relief_activities_women_pwd" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Other Gender (PWD)</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->relief_activities_transgender_pwd : ''}}" type="number" class="form-control form-control-sm" name="relief_activities_transgender_pwd" id="">
                    </div>
               
                </div>
            </div>
        </div>    
        
        <div class="card custom-card-style">
            <div class="card-header custom_card_header">
                7.7.Gratuitous Relief (Food)
            </div> 
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-2">
                        <label class="control-label">Girls </label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->relief_gratuitous_girls : ''}}" type="number" class="form-control form-control-sm" name="relief_gratuitous_girls" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Womens </label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->relief_gratuitous_women : ''}}" type="number" class="form-control form-control-sm" name="relief_gratuitous_women" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Other Gender </label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->relief_gratuitous_transgender : ''}}" type="number" class="form-control form-control-sm" name="relief_gratuitous_transgender" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Girls (PWD)</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->relief_gratuitous_girls_pwd : ''}}" type="number" class="form-control form-control-sm" name="relief_gratuitous_girls_pwd" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Womens (PWD)</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->relief_gratuitous_women_pwd : ''}}" type="number" class="form-control form-control-sm" name="relief_gratuitous_women_pwd" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Other Gender (PWD)</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->relief_gratuitous_transgender_pwd : ''}}" type="number" class="form-control form-control-sm" name="relief_gratuitous_transgender_pwd" id="">
                    </div>
                    
                </div>
            </div>
        </div>    
        
        <div class="card custom-card-style">
            <div class="card-header custom_card_header">
                7.8.One House One Farm
            </div> 
            <div class="card-body">
                <div class="row">
                   
                    <div class="form-group col-md-2">
                        <label class="control-label">Girls </label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->one_house_one_firm_girls : ''}}" type="number" class="form-control form-control-sm" name="one_house_one_firm_girls" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Womens </label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->one_house_one_firm_women : ''}}" type="number" class="form-control form-control-sm" name="one_house_one_firm_women" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Other Gender </label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->one_house_one_firm_transgender : ''}}" type="number" class="form-control form-control-sm" name="one_house_one_firm_transgender" id="">
                    </div>
                    
                    <div class="form-group col-md-2">
                        <label class="control-label">Girls (PWD)</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->one_house_one_firm_girls_pwd : ''}}" type="number" class="form-control form-control-sm" name="one_house_one_firm_girls_pwd" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Womens (PWD)</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->one_house_one_firm_women_pwd : ''}}" type="number" class="form-control form-control-sm" name="one_house_one_firm_women_pwd" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Other Gender (PWD)</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->one_house_one_firm_transgender_pwd : ''}}" type="number" class="form-control form-control-sm" name="one_house_one_firm_transgender_pwd" id="">
                    </div>
                </div>
            </div>
        </div>    
        
        
        <div class="card custom-card-style">
            <div class="card-header custom_card_header">
                7.9.Stipend for Disabled Students
            </div> 
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-2">
                        <label class="control-label">Girls </label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->stipned_for_disabilities_girls : ''}}" type="number" class="form-control form-control-sm" name="stipned_for_disabilities_girls" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Womens </label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->stipned_for_disabilities_women : ''}}" type="number" class="form-control form-control-sm" name="stipned_for_disabilities_women" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Other Gender </label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->stipned_for_disabilities_transgender : ''}}" type="number" class="form-control form-control-sm" name="stipned_for_disabilities_transgender" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Girls (PWD)</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->stipned_for_disabilities_girls_pwd : ''}}" type="number" class="form-control form-control-sm" name="stipned_for_disabilities_girls_pwd" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Womens (PWD)</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->stipned_for_disabilities_women_pwd : ''}}" type="number" class="form-control form-control-sm" name="stipned_for_disabilities_women_pwd" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Other Gender (PWD)</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->stipned_for_disabilities_transgender_pwd : ''}}" type="number" class="form-control form-control-sm" name="stipned_for_disabilities_transgender_pwd" id="">
                    </div>
                </div>
            </div>
        </div>        
        
        {{-- <div class="card custom-card-style">
            <div class="card-header custom_card_header">
                7.11.Others
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-2">
                        <label class="control-label">Girls </label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->others_girls : ''}}" type="number" class="form-control form-control-sm" name="others_girls" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Womens </label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->others_women : ''}}" type="number" class="form-control form-control-sm" name="others_women" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Other Gender </label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->others_transgender : ''}}" type="number" class="form-control form-control-sm" name="others_transgender" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Girls (PWD)</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->others_girls_pwd : ''}}" type="number" class="form-control form-control-sm" name="others_girls_pwd" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Womens (PWD)</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->others_women_pwd : ''}}" type="number" class="form-control form-control-sm" name="others_women_pwd" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Other Gender (PWD)</label>
                        <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->others_transgender_pwd : ''}}" type="number" class="form-control form-control-sm" name="others_transgender_pwd" id="">
                    </div>
                </div>
            </div>
        </div>    --}}
    </div>
</div>


       
    
    
    
<div class="text-right">
    <a href="{{route('data.pollisomaj.add',['step'=>4,'pollisomaj_ref_id' => $pollisomajData[0]->pollisomaj_data_ref])}}" class="btn btn-success" >Back</a>
    {{-- <a href="{{route('data.pollisomaj.add',['step'=>6])}}" class="btn  btn-primary" >Save & Next</a> --}}
    <input type="submit" value="Save & Next" class="btn btn-success" />
    <input type="submit" style='{{isset( $auth_user->user_role[0]['role_id']) && ($auth_user->user_role[0]['role_id']==4 || $auth_user->user_role[0]['role_id']==1) ? "display:none" : "" }}' name="save_destroy" class="btn btn-primary"  value="Save & Draft">
    <a href="{{route('incident.pollisomaj.viewpollisomajlist')}}" class="btn  btn-danger" >Cancel</a>
</div>
</form>