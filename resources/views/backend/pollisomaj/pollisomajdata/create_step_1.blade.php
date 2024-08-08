<form action="{{route('data.pollisomaj.add_step_1',['step'=>2])}}" method="post">
    {{ csrf_field() }}
    @if (count($pollisomajData) >0)
        <input type="hidden" name="pollisomaj_ref_id" value="{{ $pollisomajData[0]->pollisomaj_data_ref }}">
    @endif
    <input type="hidden" name="employee_id" value="{{count($pollisomajData)>0  ? $pollisomajData[0]->employee_id : @$user_info->id}}" id="employee_id" class="form-control form-control-sm">
    <input type="hidden" name="employee_pin" value="{{count($pollisomajData)>0  ? $pollisomajData[0]->employee_pin : @$user_info->pin}}" id="employee_pin" class="form-control form-control-sm">
    <div class="card custom-card-style">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6" style="margin-top: 7px;">
                    1. Data Entry for month: {{date('d-M-Y')}}
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6" style="text-align:right;margin-top: 7px;">
                            <label>Reporting Date: </label>
                        </div>
                        @php
                            if ((Session::has('p_edit_mode') && Session::get('p_edit_mode')) && (count($pollisomajData)>0 && $pollisomajData[0]->reporting_date != null)){
                                $today			=	date('Y-m-d');
                                $posting_today 	= 	$pollisomajData[0]->reporting_date;
                                $date 	= 	date_diff(date_create($today), date_create($posting_today));
                                $days	=	$date->format('%a');
                            }
                        @endphp
                        <div class="col-md-6">
                            
                            {{-- <p style="font-size: 15px;margin-top: 10px;">{{count($pollisomajData)>0 && $pollisomajData[0]->reporting_date != null ? date("d-m-Y", strtotime($pollisomajData[0]->reporting_date)) : date("d-m-Y")}}</p> --}}

                            @if ($user_info['user_role'][0]['role_id'] == 1 && count($pollisomajData) > 0)
                                <input type="date" id="reporting_date"
                                    value="{{ $pollisomajData[0]->reporting_date != null ? date('Y-m-d', strtotime($pollisomajData[0]->reporting_date)) : '' }}"
                                    class="form-control form-control-sm " name="reporting_date" {{ request()->has('step') ? 'disabled' : '' }}>
                            @else
                                <input type="text" class="form-control form-control-sm {{ count($pollisomajData)>0 && $pollisomajData[0]->reporting_date != null && date("Y-m-d", strtotime($pollisomajData[0]->reporting_date)) < now()->subDays(7) ? '': 'postingdatepicker' }}" value="{{count($pollisomajData)>0 && $pollisomajData[0]->reporting_date != null ? date("d-m-Y", strtotime($pollisomajData[0]->reporting_date)) : ''}}" name="reporting_date" id="reporting_date" readonly>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row pollisomaj_data_entry">
                <div class="form-group col-md-2">
                    <label class="control-label">Zone</label>
                    {{-- <select name="zone_id" id="zone_id" class="zone_id form-control form-control-sm">
                      <option value="">Select Zone</option> --}}
                      {{-- {{ dd(session()->get('userareaaccess.sregions')) }} --}}
                      @if(count(session()->get('userareaaccess.sregions'))>0)
                                <select name="zone_id" id="region_id" class="region_id form-control form-control-sm select2" required="">
                          
                          
                          <option value="">Select zone</option>
                          @foreach($regions as $key=>$region)
                            
                            @if(in_array($region->id,session()->get('userareaaccess.sregions')) )
                              <option value="{{$region->id}}" {{(count($pollisomajData)>0 && $pollisomajData[0]->zone_id == $region->id) ? "selected" : ""}}>{{$region->region_name}}</option>
                            @endif
                          @endforeach
                        </select>
                            @else
                                <select name="zone_id" id="region_id" class="region_id form-control form-control-sm select2" required="">
                          <option value="">Select Zone</option>
                            @foreach($regions as $region)
                                    {{-- @if(count(session()->get('userareaaccess.sregions')) ==1)
                                        <option value="{{$region->id}}" {{(session()->get('userareaaccess.sregions')[0] == $region->id)?('selected'):''}}>{{$region->region_name}}</option>
                                    @else --}}
                        
                                        <option value="{{$region->id}}" {{(count($pollisomajData)>0 && $pollisomajData[0]->zone_id == $region->id) ? "selected" : ""}} {{checkCurrentRegion($region->id,$pollisomajData)}}>{{$region->region_name}}</option>
                                    {{-- @endif --}}
                              @endforeach
                                </select>  
                      @endif
                                    
                    {{-- </select> --}}
                  </div>
                  <div class="form-group col-md-2">
                    <label class="control-label">Division</label>
                    <select name="division_id" id="division_id" class="division_id form-control form-control-sm" required>
                      @if (count($pollisomajData)>0)
                        @if(count(session()->get('userareaaccess.sregions')) ==1)
                          {!! getUserDivisions(session()->get('userareaaccess.sregions')[0]) !!}
                        @else
                          {!! getRegionalDivision($pollisomajData[0]->zone_id,$pollisomajData[0]->division_id) !!};
                        @endif
                      @else
                        @if(count(session()->get('userareaaccess.sregions')) ==1)
                          {!! getUserDivisions(session()->get('userareaaccess.sregions')[0]) !!}
                        @else
                          <option value="">Select Division</option>
                        @endif
                      @endif
                      
                    </select>
                  </div>
                  <div class="form-group col-md-2">
                    <label class="control-label">District</label>
                    <select name="district_id" id="district_id" class="district_id form-control form-control-sm" required>
                      @if (count($pollisomajData)>0)
                        {!! getRegionalDivisionDistrict($pollisomajData[0]->zone_id,$pollisomajData[0]->division_id,$pollisomajData[0]->district_id) !!};
                      @else
                       <option value="">Select District</option>
                        
                      @endif
                    </select>
                  </div>
                  <div class="form-group col-md-2">
                    <label class="control-label">Upazila</label>
                    <select name="upazilla_id" id="upazila_id" class="upazila_id pollisomaj_list form-control form-control-sm" required>
                      @if (count($pollisomajData)>0)
                      {!! getupazila($pollisomajData[0]->district_id,$pollisomajData[0]->upazilla_id) !!}
                    @else
                      <option value="">Select Upazila</option>
                    @endif
                    </select>
                  </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Union</label>
                    {{-- <select name="union_id" id="union_id" class="pollisomaj_list form-control form-control-sm union_id" onchange="getUnionVillage(this.options[this.selectedIndex].value, $(this));"> --}}
                    <select name="union_id" id="union_id" class="pollisomaj_list form-control form-control-sm union_id" required>
                      @if (count($pollisomajData)>0)
                        {!! getunion($pollisomajData[0]->upazilla_id,$pollisomajData[0]->union_id) !!};
                      @else
                      <option value="">Select Union</option>
                      @endif
                       
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Village</label>
                    <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->village_name : ''}}" type="text" class="form-control form-control-sm village_name" name="village_name" id="village_name" readonly>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Ward No:</label>
                    <input required="" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->ward_no : ''}}" type="text" class="form-control form-control-sm" name="ward_no" id="ward_no" required>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Pollisomaj No</label>
                    {{-- <input type="text" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->pollisomaj_no : ''}}" class="form-control form-control-sm" name="pollisomaj_no" id="pollisomaj_no" onfocusout="getPollisomajInfo($(this))"> --}}
                    <select name="pollisomaj_no" id="pollisomaj_no" class="form-control form-control-sm pollisomaj_no" onchange="getPollisomajInfo($(this))" required>
                        @if (count($pollisomajData)>0)
                            {!! getPollisomaj($pollisomajData[0]->upazilla_id,$pollisomajData[0]->union_id,$pollisomajData[0]->pollisomaj_no) !!};
                        @else
                            <option value="">Select Pollisomaj</option>
                        @endif
                        {{-- <option value="">Select Pollisomaj</option> --}}
                        {{-- @endif --}}
                         
                      </select>
                </div>
                {{-- <div class="form-group col-md-3">
                    <label class="control-label">Pollisomaj ID</label>
                    <input readonly="" type="text" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->pollisomaj_id : ''}}" class="form-control form-control-sm" name="pollisomaj_id" id="pollisomaj_id">
                </div> --}}
                <div class="form-group col-md-3">
                    <label class="control-label">Pollisomaj Name</label>
                    <input readonly="" type="text" value="{{count($pollisomajData)>0 ? @$pollisomajData[0]['pollisomaj_info']['pollisomaj_name'] : ''}}" class="form-control form-control-sm pollisomaj_info" name="pollisomaj_name" id="pollisomaj_name">
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Date of pollisomaj Reformation:</label>
                    <input readonly="" type="text"  value="{{count($pollisomajData)>0 && $pollisomajData[0]->ps_reform_date != null ? date("d-m-Y", strtotime($pollisomajData[0]->ps_reform_date)) : ''}}" class="form-control form-control-sm"  placeholder="dd-mm-yy" name="ps_reform_date" id="ps_reform_date">
                </div>
            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-header">
            2. Member Details
        </div>
        <div class="card-body">
            
            <div class="row">
                
                <div class="form-group col-md-2">
                    <label class="control-label">Girls:</label>
                    <input  type="number"  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->member_girls : ''}}" class="form-control form-control-sm" name="member_girls" id="member_girls" onkeypress="return isNumberKey(event)" readonly="">
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Boys:</label>
                    <input  type="number"  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->member_boys : ''}}" class="form-control form-control-sm" name="member_boys" id="member_boys" onkeypress="return isNumberKey(event)" readonly="">
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Female:</label>
                    <input  type="number"  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->member_female : ''}}" class="form-control form-control-sm" name="member_female" id="member_female" onkeypress="return isNumberKey(event)" readonly="">
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Male:</label>
                    <input  type="number"  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->member_male : ''}}" class="form-control form-control-sm" name="member_male" id="member_male" onkeypress="return isNumberKey(event)" readonly="">
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Other Gender:</label>
                    <input  type="number"  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->member_transgender : ''}}" class="form-control form-control-sm" name="member_transgender" id="member_transgender" onkeypress="return isNumberKey(event)" readonly="">
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Total:</label>
                    <input  type="number"  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->general_member_total : ''}}" class="form-control form-control-sm" name="general_member_total" id="general_member_total" readonly="">
                </div>
                {{-- <div class="form-group col-md-2">
                    <label class="control-label">Total:</label>
                    <input  readonly="" type="number" class="form-control form-control-sm" name="m_total" id="">
                </div> --}}
                <div class="col-md-12">
                    <h6>Person with disabilities (PWD)</h6>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Girls:</label>
                    <input  type="number"  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->member_girls_pwd : ''}}" class="form-control form-control-sm" name="member_girls_pwd" id="member_girls_pwd" onkeypress="return isNumberKey(event)" readonly="">
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Boys:</label>
                    <input  type="number"  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->member_boys_pwd : ''}}" class="form-control form-control-sm" name="member_boys_pwd" id="member_boys_pwd" onkeypress="return isNumberKey(event)" readonly="">
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Female:</label>
                    <input  type="number"  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->member_female_pwd : ''}}" class="form-control form-control-sm" name="member_female_pwd" id="member_female_pwd" onkeypress="return isNumberKey(event)" readonly="">
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Male:</label>
                    <input  type="number"  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->member_male_pwd : ''}}" class="form-control form-control-sm" name="member_male_pwd" id="member_male_pwd" onkeypress="return isNumberKey(event)" readonly="">
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Other Gender:</label>
                    <input  type="number"  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->member_transgender_pwd : ''}}" class="form-control form-control-sm" name="member_transgender_pwd" id="member_transgender_pwd" onkeypress="return isNumberKey(event)" readonly="">
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Total:</label>
                    <input  type="number"  value="{{count($pollisomajData)>0 ? $pollisomajData[0]->general_member_pwd_total : ''}}" class="form-control form-control-sm" name="general_member_pwd_total" id="general_member_pwd_total" readonly="">
                </div>
            </div> 
        </div>

    </div>
    <div class="card custom-card-style">
        <div class="card-header">
            3. The contact number of key 3 persons
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-4">
                    <label class="control-label">President Contact Number:</label>
                    <input  type="text" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->p_number : ''}}" readonly="" class="form-control form-control-sm pollisomaj_info" name="p_number" id="p_number">
                </div>
                <div class="form-group col-md-4">
                    <label class="control-label">Secretary Contact Number:</label>
                    <input  type="text" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->s_number : ''}}" readonly="" class="form-control form-control-sm pollisomaj_info" name="s_number" id="s_number">
                </div>
                <div class="form-group col-md-4">
                    <label class="control-label">Cashier Contact Number:</label>
                    <input  type="text" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->c_number : ''}}" readonly="" class="form-control form-control-sm pollisomaj_info" name="c_number" id="c_number">
                </div>
                {{-- <div class="form-group col-md-3">
                    <label class="control-label">Female group leader:</label>
                    <input  type="text" value="{{count($pollisomajData)>0 ? $pollisomajData[0]->f_number : ''}}" readonly="" class="form-control form-control-sm pollisomaj_info" name="f_number" id="f_number">
                </div> --}}
            </div>
        </div>
    </div>


    <div class="text-right">
        <input type="submit" class="btn btn-success" value="Save & Next" />
        {{-- <a href="{{route('data.pollisomaj.add',['step'=>2])}}" class="btn  btn-success" ></a> --}}
        <input type="submit" style='{{isset( $auth_user->user_role[0]['role_id']) && ($auth_user->user_role[0]['role_id']==4 || $auth_user->user_role[0]['role_id']==1) ? "display:none" : "" }}' name="save_destroy" class="btn btn-primary"  value="Save & Draft">
        <a href="{{route('incident.pollisomaj.viewpollisomajlist')}}" class="btn  btn-danger" >Cancel</a>
    </div>
</form>


<!-- Start JS for Date time Picker -->
<script type="text/javascript">


    

    // $(function() {
    //     $('.postingdatepicker').daterangepicker({
    //         singleDatePicker: true,
    //         showDropdowns: true,
    //         @if (!(Session::has('p_edit_mode') && Session::get('p_edit_mode')) && (count($pollisomajData)>0 && $pollisomajData[0]->reporting_date != null))
    //             autoUpdateInput: false,
    //         @endif
            
    //         // drops: "up",
    //         autoApply:true,
    //         locale: {
    //             format: 'DD-MM-YYYY',
    //             daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
    //             firstDay: 0
    //         },
    //         minDate: '01/01/2021',
    //         maxDate: new Date(),
    //     },
    //     function(start) {
    //         this.element.val(start.format('DD-MM-YYYY'));
    //         this.element.parent().parent().removeClass('has-error');
    //     },
    //     function(chosen_date) {
    //         this.element.val(chosen_date.format('DD-MM-YYYY'));
    //     });

    //     $('.singledatepicker').on('apply.daterangepicker', function(ev, picker) {
    //         $(this).val(picker.startDate.format('DD-MM-YYYY'));
    //     });
    // });
    $(function() {

        // loader
        var submitBtn = $('input[type="submit"]');
        submitBtn.on('click', function(){
            var zone = $(this).parents('form').find('#region_id').val();
            var division = $(this).parents('form').find('#division_id').val();
            var district = $(this).parents('form').find('#district_id').val();
            var upazila_id = $(this).parents('form').find('#upazila_id').val();
            var union_id = $(this).parents('form').find('#union_id').val();
            var ward_no = $(this).parents('form').find('#ward_no').val();
            var pollisomaj_no = $(this).parents('form').find('#pollisomaj_no').val();
        

            if(zone != "" && division != "" && district != "" && upazila_id != "" && union_id != "" && ward_no != "" && pollisomaj_no != ""){

            $('.from_loader').css({"display": 'block'}); 
            }
        });

        
		var date = new Date();
		@if ((Session::has('p_edit_mode') && Session::get('p_edit_mode')) && (count($pollisomajData)>0 && $pollisomajData[0]->reporting_date != null))
		var editDate = Math.floor(Math.abs((new Date())-(new Date("{{$pollisomajData[0]->reporting_date}}")))/ (1000 * 60 * 60 * 24));
		var rrr = new Date("{{$pollisomajData[0]->reporting_date}}");
		// alert(new Date(rrr.setDate((rrr.getDate()+editDate))));
		var result = new Date("{{$pollisomajData[0]->reporting_date}}") + editDate;
		@endif
        $('.postingdatepicker').daterangepicker({
			
			// console.log(date);
            singleDatePicker: true,
            showDropdowns: true,
            @if (!(Session::has('p_edit_mode') && Session::get('p_edit_mode')) && (count($pollisomajData)>0 && $pollisomajData[0]->reporting_date != null))
                autoUpdateInput: false,
			@else
				minDate: new Date(date.setDate(date.getDate() - 6)),
				@if((Session::has('p_edit_mode') && Session::get('p_edit_mode')) && (count($pollisomajData)>0 && $pollisomajData[0]->reporting_date != null))
					// let diffTime = Math.abs(date2 - date1);
					// let diffDays = (diffTime / (1000 * 60 * 60 * 24));
					maxDate :  new Date(rrr.setDate((rrr.getDate()+editDate))),
					// maxDate :  new Date("{{$pollisomajData[0]->reporting_date}}"),
				@else
					maxDate: new Date(),
				@endif
            @endif
            
            // drops: "up",
            autoApply:true,
            locale: {
                format: 'DD-MM-YYYY',
                daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
                firstDay: 0
            },
            // minDate: new Date(date.setDate(date.getDate() - 30)),
            // maxDate: new Date(),
        },
        function(start) {
            this.element.val(start.format('DD-MM-YYYY'));
            this.element.parent().parent().removeClass('has-error');
        },
        function(chosen_date) {
            this.element.val(chosen_date.format('DD-MM-YYYY'));
        });

        $('.singledatepicker').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD-MM-YYYY'));
        });
    });
</script>


<script>
    $(document).ready(function(){
        $("input").keyup(function(){
            var member_girls          = +$("#member_girls").val();
            var member_boys           = +$("#member_boys").val();
            var member_female        = +$("#member_female").val();
            var member_male          = +$("#member_male").val();
            var member_transgender   = +$("#member_transgender").val();
            var total           = member_girls+member_boys+member_female+member_male+member_transgender;
            $("#general_member_total").val(total);

            var member_girls_pwd          = +$("#member_girls_pwd").val();
            var member_boys_pwd           = +$("#member_boys_pwd").val();
            var member_female_pwd        = +$("#member_female_pwd").val();
            var member_male_pwd          = +$("#member_male_pwd").val();
            var member_transgender_pwd   = +$("#member_transgender_pwd").val();
            var total_pwd             = member_girls_pwd+member_boys_pwd+member_female_pwd+member_male_pwd+member_transgender_pwd;
            $("#general_member_pwd_total").val(total_pwd);
        });
    });
</script>


<script>
    function getPollisomajInfo(item) {
		var pollisomaj_no = item.val();
		// var employee_pin = $('#pin').val();
		var url  = "{{ route('setup.getPollisomajInfo') }}";
      	var data = {
    		pollisomaj_no: pollisomaj_no
    	}

      	$.get(url, data, function(response) {
      		console.log(response);
            var moment_date = moment(response.date_from).format("DD-MM-YYYY");
            // let moment_date = services[i].followup_date;
            console.log(moment_date);

            if(response){
                document.getElementById("pollisomaj_name").value=response.pollisomaj_name;
                document.getElementById("ps_reform_date").value=moment_date;
                document.getElementById("p_number").value=response.mob_1;
                document.getElementById("s_number").value=response.mob_2;
                document.getElementById("c_number").value=response.mob_3;
                document.getElementById("village_name").value=response.village_name;
                document.getElementById("member_girls").value=response.member_girls;
                document.getElementById("member_boys").value=response.member_boys;
                document.getElementById("member_female").value=response.member_female;
                document.getElementById("member_male").value=response.member_male;
                document.getElementById("member_transgender").value=response.member_transgender;
                document.getElementById("general_member_total").value=response.general_member_total;
                document.getElementById("member_girls_pwd").value=response.member_girls_pwd;
                document.getElementById("member_boys_pwd").value=response.member_boys_pwd;
                document.getElementById("member_female_pwd").value=response.member_female_pwd;
                document.getElementById("member_male_pwd").value=response.member_male_pwd;
                document.getElementById("member_transgender_pwd").value=response.member_transgender_pwd;
                document.getElementById("general_member_pwd_total").value=response.general_member_pwd_total;
            }else{
                alert("In this Pollisomaj No. has no Pollisomaj Information");
                document.getElementById("pollisomaj_name").value="";
                document.getElementById("ps_reform_date").value="";
                document.getElementById("p_number").value="";
                document.getElementById("s_number").value="";
                document.getElementById("c_number").value="";
                document.getElementById("village_name").value="";
                document.getElementById("member_girls").value="";
                document.getElementById("member_boys").value="";
                document.getElementById("member_female").value="";
                document.getElementById("member_male").value="";
                document.getElementById("member_transgender").value="";
                document.getElementById("general_member_total").value="";
                document.getElementById("member_girls_pwd").value="";
                document.getElementById("member_boys_pwd").value="";
                document.getElementById("member_female_pwd").value="";
                document.getElementById("member_male_pwd").value="";
                document.getElementById("member_transgender_pwd").value="";
                document.getElementById("general_member_pwd_total").value="";
            }
      		// item.closest('.pollisomaj_data_entry').find('#pollisomaj_name').val(response.pollisomaj_name);
            // document.getElementById("pollisomaj_name").value=response.pollisomaj_name;
            // document.getElementById("p_number").value=response.mob_1;
            // document.getElementById("s_number").value=response.mob_2;
            // document.getElementById("c_number").value=response.mob_3;
            // document.getElementById("f_number").value=response.mob_4;
        });
	}
</script>



<script>
    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
        return true;
    }
</script>

<script>
    
    function getRegionalDivision(region_id, item)
    {
    	var url  = "{{ route('setup.getRegionalDivision') }}";
      	var data = {
    		region_id: region_id
    	}

      	$.get(url, data, function(response) {
            // console.log(response);
            item.closest('.show_module_more_event').find('.division_id').html(response);
        });
    }

    function getRegionalDivisionDistrict(division_id, item)
    {
    	var region_id = $('.region_id').val();
    	var url  = "{{ route('setup.getRegionalDivisionDistrict') }}";
      	var data = {
    		region_id: region_id,
    		division_id: division_id
    	}

      	$.get(url, data, function(response) {
      		console.log(item);
              item.closest('.region_area_info').find('.district_id').html(response);
        });
    }

    function getDistrictUpazila(district_id, item)
    {
    	var url  = "{{ route('setup.getDistrictUpazila') }}";
      	var data = {
    		district_id: district_id
    	}

      	$.get(url, data, function(response) {
            // console.log(response);
            item.closest('.region_area_info').find('.upazila_id').html(response);
        });
    }

    // function getUpazilaUnion(upazila_id, item)
    // {
    // 	var url  = "{{ route('setup.getUpazilaUnion') }}";
    //   	var data = {
    // 		upazila_id: upazila_id
    // 	}

    //   	$.get(url, data, function(response) {
    //         // console.log(response);
    //         item.closest('.region_area_info').find('.union_id').html(response);
    //     });
    // }

    function getUpazilaPollisomaj(upazila_id, union_id)
    {
    	var url  = "{{ route('setup.getUpazilaPollisomaj') }}";
      	var data = {
    		upazila_id: upazila_id,
    		union_id: union_id
    	}

      	$.get(url, data, function(response) {
            // console.log(response);
            $('#pollisomaj_no').html(response);
        });
    }

    

    // function getUnionVillage(union_id,item){
    //     var url  = "{{ route('setup.getUnionVillage') }}";
    //   	var data = {
    // 		union_id: union_id
    // 	}

    //   	$.get(url, data, function(response) {
    //         // console.log(response);
    //         item.closest('.region_area_info').find('.village_id').html(response);
    //     });
    // }
</script>



<script>
    $( function() {
      $( "#ps_reform_date" ).datepicker({
        dateFormat:"d-M-yy"
      });
    } );
</script>



<script type="text/javascript">
	$(function(){
		$(document).on('change','#region_id',function(){
			var region_id = $(this).val();
			$.ajax({
				url : "{{route('default.get-division')}}",
				type : "GET",
				data : {region_id:region_id},
				success:function(data){
					var html = '<option value="">Select Division</option>';
					$.each(data,function(key,v){
						html +='<option value="'+v.division_id+'">'+v.regional_division.name+'</option>';
					});
					$('#division_id').html(html);
				}
			});
		});
	});
</script>
<script type="text/javascript">
	$(function(){
		$(document).on('change','#division_id',function(){
			var region_id = $('#region_id').val();
			var division_id = $(this).val();
			$.ajax({
				url : "{{route('default.get-region-district')}}",
				type : "GET",
				data : {region_id:region_id,division_id:division_id},
				success:function(data){
					var html = '<option value="">Select District</option>';
					$.each(data,function(key,v){
						html +='<option value="'+v.district_id+'">'+v.regional_district.name+'</option>';
					});
					$('#district_id').html(html);
				}
			});
		});
	});
</script>
<script type="text/javascript">
	$(function(){
		$(document).on('change','#district_id',function(){
			var district_id = $(this).val();
			$.ajax({
				url : "{{route('default.get-region-upazila')}}",
				type : "GET",
				data : {district_id:district_id},
				success:function(data){
          console.log(data);
					var html = '<option value="">Select Upazila</option>';
					$.each(data,function(key,v){
            if (v.setup_user_upazila == undefined) {
              html +='<option value="'+v.id+'">'+v.name+'</option>';
            } else {
              html +='<option value="'+v.setup_user_upazila.id+'">'+v.setup_user_upazila.name+'</option>';
            }
					});
					$('#upazila_id').html(html);
				}
			});
		});
	});
</script>

<script type="text/javascript">
	$(function(){
		$(document).on('change','#upazila_id',function(){
			var upazila_id = $(this).val();
			$.ajax({
				url : "{{route('default.get-union')}}",
				type : "GET",
				data : {upazila_id:upazila_id},
				success:function(data){
					var html = '<option value="">Select Union</option>';
					$.each(data,function(key,v){
						html +='<option value="'+v.id+'">'+v.name+'</option>';
					});
					$('#union_id').html(html);
				}
			});
		});
	});
</script>

<script type="text/javascript">
    $(function(){
        $(document).on('change','.pollisomaj_list',function(){
            setTimeout(() => {
                getUpazilaPollisomaj($('#upazila_id').val(),$('#union_id').val())
            }, 500);
           
        });
    });
</script>

<script type="text/javascript">

        $(document).on('change','.pollisomaj_list',function(){
            $('.pollisomaj_info').val('');
           
        });
    // addEventListener('change', ()=>{
    // })
</script>

@if (!(Session::has('p_edit_mode') && Session::get('p_edit_mode')))
<script type="text/javascript">
	$(function(){
		$('#region_id').trigger('change');
	});
</script>
@endif


{{-- <script type="text/javascript">
	$(function(){
		$(document).on('change','#village_id',function(){
			var village_id = $(this).val();
			$.ajax({
				url : "{{route('get-details.pollisomaj')}}",
				type : "GET",
				data : {village_id:village_id},
				success:function(data){
					let info=JSON.parse(data);
                    if(info.length > 0){
                        console.log(info);
                        document.getElementById("p1_cell").value=info[0]['mob_1']
                        document.getElementById("p2_cell").value=info[0]['mob_2']
                        document.getElementById("p3_cell").value=info[0]['mob_3']
                        document.getElementById("p4_cell").value=info[0]['mob_4']
                        document.getElementById("pollisomaj_id").value=info[0]['id']
                        document.getElementById("pollisomaj_name").value=info[0]['pollisomaj_name']
                    }else{
                        document.getElementById("p1_cell").value=""
                        document.getElementById("p2_cell").value=""
                        document.getElementById("p3_cell").value=""
                        document.getElementById("p4_cell").value=""
                        document.getElementById("pollisomaj_id").value=""
                        document.getElementById("pollisomaj_name").value=""
                    }
				}
			});
		});
	});
</script> --}}


{{-- <script type="text/javascript">
	$(function(){
        
		$("#village_id").ready(function(){
			var village_id = $("#village_id").val();
            console.log(village_id);
            //alert("Hellow")
			$.ajax({
				url : "{{route('get-details.pollisomaj')}}",
				type : "GET",
				data : {village_id:village_id},
				success:function(data){
					let info=JSON.parse(data);
                    if(info.length > 0){
                        console.log(info);
                        document.getElementById("p1_cell").value=info[0]['mob_1']
                        document.getElementById("p2_cell").value=info[0]['mob_2']
                        document.getElementById("p3_cell").value=info[0]['mob_3']
                        document.getElementById("pollisomaj_id").value=info[0]['id']
                        document.getElementById("pollisomaj_name").value=info[0]['pollisomaj_name']
                    }else{
                        document.getElementById("p1_cell").value=""
                        document.getElementById("p2_cell").value=""
                        document.getElementById("p3_cell").value=""
                        document.getElementById("pollisomaj_id").value=""
                        document.getElementById("pollisomaj_name").value=""
                    }
				}
			});
		});
	});
</script> --}}