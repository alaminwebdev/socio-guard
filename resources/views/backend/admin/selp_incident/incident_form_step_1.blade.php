<form action="{{route('incident.selp.step-1')}}" method="post" style="padding-bottom: 20px;">
  @csrf

   <input type="hidden" name="selp_incident_ref" value="{{request()->selp_incident_ref }}">
  <input type="hidden" name="tab" value="1">
  <input type="hidden" name="step" value="2">
  <input type="hidden" name="posting_date" id="test" value="{{count($selpIncident)>0  ? $selpIncident[0]->posting_date : ''}}">
<div class="form-row">
  <div class="form-group col-sm-3">
    <label class="control-label">Name</label>
    <input type="text" name="employee_name" value="{{count($selpIncident)>0  ? $selpIncident[0]->employee_name : @$user_info->name}}" id="employee_name" class="form-control form-control-sm" readonly="">
  </div>
  <div class="form-group col-sm-3">
    <label class="control-label">Cell</label>
    <input type="text" name="employee_mobile_number" value="{{count($selpIncident)>0  ? $selpIncident[0]->employee_mobile_number : @$user_info->mobile}}" id="employee_mobile_number" class="form-control form-control-sm" readonly="">
  </div>
  <div class="form-group col-sm-3">
    <label class="control-label">Designation</label>
    <input type="text" name="employee_designation" value="{{count($selpIncident)>0  ? $selpIncident[0]->employee_designation : @$user_info->designation}}" id="employee_designation" class="form-control form-control-sm" readonly="">
  </div>
  <div class="form-group col-sm-3">
    <label class="control-label">Pin</label>
    <input type="text" name="employee_pin" value="{{count($selpIncident)>0  ? $selpIncident[0]->employee_pin : @$user_info->pin}}" id="employee_pin" class="form-control form-control-sm" readonly="">
  </div>
</div>
<div class="form-row" style="margin-top: -12px;margin-bottom: -12px;">
  <div class="form-group col-md-12">
  <p><strong><u>Address:</u></strong></p>
  </div>
  <div class="form-group col-md-3">
    
    <label class="control-label">Zone <span class="text-danger">*</span></label>
    {{-- <select name="employee_zone_id" id="zone_id" class="zone_id form-control form-control-sm">
      <option value="">Select Zone</option> --}}
      {{-- {{ dd(session()->get('userareaaccess.sregions')) }} --}}
      @if(count(session()->get('userareaaccess.sregions'))>0)
				<select name="employee_zone_id" id="region_id" class="region_id form-control form-control-sm select2" required="">
          
          
          <option value="">Select zone</option>
          @foreach($regions as $key=>$region)
            
            @if(in_array($region->id,session()->get('userareaaccess.sregions')) )
              <option value="{{$region->id}}" {{(count($selpIncident)>0 && $selpIncident[0]->employee_zone_id == $region->id) ? "selected" : ""}}>{{$region->region_name}}</option>
            @endif
          @endforeach
        </select>
			@else
				<select name="employee_zone_id" id="region_id" class="region_id form-control form-control-sm select2" required="">
          <option value="">Select Zone</option>
					@foreach($regions as $region)
								<option value="{{$region->id}}" {{checkCurrentRegion($region->id,$selpIncident)}}>{{$region->region_name}}</option>
							
			  @endforeach
				</select>  
      @endif
					
    {{-- </select> --}}
    @error('employee_zone_id')
    <p style="color:red; margin-top:5px;">This field is required</p>
    @enderror
  </div>
  <div class="form-group col-md-3">
    <label class="control-label">Division <span class="text-danger">*</span></label>
    <select name="employee_division_id" id="division_id" class="division_id form-control form-control-sm" required="">
      @if (count($selpIncident)>0)
        @if(count(session()->get('userareaaccess.sregions')) ==1)
          {!! getUserDivisions(session()->get('userareaaccess.sregions')[0]) !!}
        @else
          {!! getRegionalDivision($selpIncident[0]->employee_zone_id,$selpIncident[0]->employee_division_id) !!};
        @endif
      @else
        @if(count(session()->get('userareaaccess.sregions')) ==1)
          {!! getUserDivisions(session()->get('userareaaccess.sregions')[0]) !!}
        @else
          <option value="">Select Division</option>
        @endif
      @endif
      
    </select>
    @error('employee_division_id')
    <p style="color:red; margin-top:5px;">This field is required</p>
    @enderror
  </div>
  <div class="form-group col-md-3">
    <label class="control-label">District <span class="text-danger">*</span></label>
    <select name="employee_district_id" id="district_id" class="district_id form-control form-control-sm" required>
      @if (count($selpIncident)>0)
        {!! getRegionalDivisionDistrict($selpIncident[0]->employee_zone_id,$selpIncident[0]->employee_division_id,$selpIncident[0]->employee_district_id) !!};
      @else
       <option value="">Select District</option>
        
      @endif
    </select>
    @error('employee_district_id')
    <p style="color:red; margin-top:5px;">This field is required</p>
    @enderror
  </div>
  <div class="form-group col-md-3">
    <label class="control-label">Upazila <span class="text-danger">*</span></label>
    <select name="employee_upazila_id" id="upazila_id" class="upazila_id form-control form-control-sm" required>
      @if (count($selpIncident)>0)
      {!! getupazila($selpIncident[0]->employee_district_id,$selpIncident[0]->employee_upazila_id) !!};
    @else
      <option value="">Select Upazila</option>
    @endif
    </select>
    @error('employee_upazila_id')
    <p style="color:red; margin-top:5px;">This field is required</p>
    @enderror
  </div>
</div>
<div class="form-row">
  <div class="form-group col-md-12">
    <p><strong><u>Referred by : </u></strong></p>
  </div>
  <div class="form-group col-sm-3">
    <label class="control-label">Information Provider <span class="text-danger">*</span></label>
    <select name="employee_information_provider" id="information_provider" class="information_provider form-control form-control-sm @error('employee_information_provider') is-invalid @enderror" required="">
      <option value="">-- Select --</option>
      @foreach($informationProvider as $provide)
      <option {{count($selpIncident)>0 && $selpIncident[0]->information_provider_source_id==$provide->id ? "selected" : ''}} value="{{ $provide->id }}">{{ $provide->name }}</option>
      @endforeach
    </select>
    @error('employee_information_provider')
      <p style="color:red; margin-top:5px;">This field is required</p>
    @enderror
  </div>
  <div class="form-group col-sm-3">
    <label class="control-label">Name of BRAC Programme <span class="text-danger">*</span></label>
    <select name="brac_program_name" id="information_provider_brac" class="information_provider form-control form-control-sm @error('brac_program_name') is-invalid @enderror" required="">
      <option value="">-- Select --</option>
      @foreach($bracProgram as $program)
      <option {{count($selpIncident)>0 && $selpIncident[0]->brac_programe_name_id==$program->id ? "selected" : ''}} value="{{ $program->id }}">{{ $program->title }}</option>
      @endforeach
    </select>
    @error('brac_program_name')
      <p style="color:red; margin-top:5px;">This field is required</p>
    @enderror
  </div>
  <div class="form-group col-sm-3">
    <label class="control-label">Informer name</label>
    <input type="text" name="referral_name" value="{{count($selpIncident)>0  ? $selpIncident[0]->referral_name : ''}}" id="referral_name" class="form-control form-control-sm">
  </div>
  <div class="form-group col-sm-3">
    <label class="control-label">Informer Contact Number</label>
    <input type="text" name="informer_mobile_number" value="{{count($selpIncident)>0  ? $selpIncident[0]->informer_mobile_number : ''}}" id="informer_mobile_number" class="form-control form-control-sm InputPhone" maxlength="11">
  </div>
  {{-- <div class="form-group col-sm-3">
    <label class="control-label">Relation between Survivor’s</label>
    <select name="referral_reletionship_id" id="" class="form-control form-control-sm">
      <option value="">-- Select --</option>
      @foreach($perpetratorRelation as $item)
      <option {{count($selpIncident)>0 && $selpIncident[0]->referral_reletionship_id==$item->id ? "selected" : ''}} value="{{ $item->id }}">{{ $item->name }}</option>
      @endforeach
    </select>
  </div> --}}
  <div class="form-group col-sm-3">
    <label class="control-label">Gender <span class="text-danger">*</span></label>
    <select name="gender_id" id="gen_id" class="form-control form-control-sm @error('gender_id') is-invalid @enderror" required="">
      <option value="">Select Gender</option>
      @foreach($genders as $gender)
      <option {{(count($selpIncident)>0 && $selpIncident[0]->gender_id==$gender->id) || old('gender_id')==$gender->id ? "selected" : ''}} value="{{ $gender->id }}">{{ $gender->name }}</option>
      @endforeach
    </select>
    @error('gender_id')
      <p style="color:red; margin-top:5px;">This field is required</p>
    @enderror
  </div>
  <div class="form-group col-sm-3">
    <label class="control-label">Occupation</label>
    <select name="occupation_id" id="" class="form-control form-control-sm">
      <option value="">Select Occupation</option>
      @foreach($occupations as $occupation)
      <option {{count($selpIncident)>0 && $selpIncident[0]->occupation_id==$occupation->id ? "selected" : ''}} value="{{ $occupation->id }}">{{ $occupation->name }}</option>
      @endforeach
    </select>
  </div>
  {{-- <div class="form-group col-md-12">
    <p><strong><u>Types fo disputes : </u></strong></p>
  </div> --}}
  <div class="form-group col-sm-3">
    <label class="control-label">Reported Incident Type <span class="text-danger">*</span></label>
    <select name="violence_reason_id" id="dispute" class="form-control form-control-sm @error('violence_reason_id') is-invalid @enderror" required="">
      <option value=""> -- Select -- </option>
      @foreach($ViolenceCategory as $reason)
      <option {{(count($selpIncident)>0 && $selpIncident[0]->violence_reason_id==$reason->id) || old('violence_reason_id')==$reason->id ? "selected" : ''}} value="{{ $reason->id }}">{{ $reason->name }}</option>
      @endforeach
    </select>
    @error('violence_reason_id')
      <p style="color:red; margin-top:5px;">This field is required</p>
    @enderror
  </div>
  <div class="form-group col-sm-3">
    <label class="control-label">Date of disputes <span class="text-danger">*</span></label>
    <input type="text" name="date_of_dispute" value="{{(count($selpIncident)>0 && $selpIncident[0]->date_of_dispute != null) ? date("d-m-Y", strtotime($selpIncident[0]->date_of_dispute)) : old('date_of_dispute')}}" id="date_of_dispute" class="form-control form-control-sm datepicker @error('date_of_dispute') is-invalid @enderror" required="" readonly>
    @error('date_of_dispute')
      <p style="color:red; margin-top:5px;">This field is required</p>
    @enderror
  </div>
</div>

<br>
<div class="form-row" style="float: right">
  {{-- <button type="submit" class="btn btn-success submit text-white mr-1">Back</button> --}}
  <a href="{{route('incident.pending.list')}}" class="btn  btn-danger" >Cancel</a> &nbsp;
  <button type="submit" class="btn btn-info submit text-white mr-1" onClick="this.form.submit(); this.disabled=true; this.innerHTML='Sending…';">Save & Next</button>
  @if($user_info['user_role'][0]['role_id'] == 4)
    <button type="submit" name="save_destroy" class="btn btn-primary submit text-white mr-1">Close</button>
  @else
    <button type="submit" name="save_destroy" class="btn btn-primary submit text-white mr-1" onClick="this.form.submit(); this.disabled=true; this.innerHTML='Sending…';">Draft & Close</button>
  @endif
  <button type="submit" name="save_destroy" class="btn btn-warning final text-white mr-1 d-none" id="final_submit" onClick="this.form.submit(); this.disabled=true; this.innerHTML='Sending…';">Submit</button>
</div>

</form>
<script type="text/javascript">
	$(function(){

		$(document).on('change','#region_id',function(){
			var region_id = $(this).val();
			$.ajax({
				url : "{{route('default.get-division')}}",
				type : "GET",
				data : {region_id:region_id},
				success:function(data){
         // console.log(data);
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


    //loader
    
    var submitBtn = $('button[type="submit"]');
    submitBtn.on('click', function(){
        var zone = $(this).parents('form').find('#region_id').val();
        var division = $(this).parents('form').find('#division_id').val();
        var district = $(this).parents('form').find('#district_id').val();
        var upazila_id = $(this).parents('form').find('#upazila_id').val();
        var information_provider = $(this).parents('form').find('#information_provider').val();
        var information_provider_brac = $(this).parents('form').find('#information_provider_brac').val();
        var gen_id = $(this).parents('form').find('#gen_id').val();
        var dispute = $(this).parents('form').find('#dispute').val();
        // var date_of_dispute = $(this).parents('form').find('#date_of_dispute').val();


        if(zone != "" && division != "" && district != "" && upazila_id != "" && information_provider != "" && information_provider_brac != ""  && gen_id != "" && dispute != ""){

           $('.from_loader').css({"display": 'block'}); 
        }
    });

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
          //console.log(data);
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
@if (!(Session::has('edit_mode') && Session::get('edit_mode')))
<script type="text/javascript">
	$(function(){
		$('#region_id').trigger('change');
	});
</script>
@endif

