@extends('backend.layouts.app')
@section('content')

<!-- /.content-header -->
<div style="display:none" class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Pollishomaj Wise Member Add	</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Pollishomaj Wise Member<li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section style="margin-top:70px" class="content">
    <div class="container-fluid">
        <div class="card card-success card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-plus"></i>
                  Pollishomaj Edit Form 
                  <a href="{{route('view.pollisomaj')}}" class="btn btn-primary btn-sm btn-flat float-right"><i class="fas fa-list"></i> View Pollishomaj Wise Member</a>
				</h3>
            </div>
            <div class="card-body show_module_more_event region_area_info">
                <form action="{{route('edit.pollisomaj',['id'=>$item->id])}}" method="POST">
					@csrf
					<div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="name">Pollishomaj No.</label>
                            <input type="text" name="pollisomaj_no" class="form-control form-control-sm {{$errors->has('pollisomaj_no')? 'is-invalid' : ''}}" id="pollisomaj_no" placeholder="Pollishomaj No." value="{{$item->pollisomaj_no}}"  required>
                            <div class="invalid-feedback">
                                {{ $errors->first('pollisomaj_no') }}
                            </div>
						</div>
						<div class="form-group col-md-2">
                            <label for="name">Pollishomaj Name</label>
                            <input type="text" name="name" class="form-control form-control-sm {{$errors->has('name')? 'is-invalid' : ''}}" id="name" placeholder="Pollishomaj Name" value="{{$item->pollisomaj_name}}"  required>
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
						</div>
                        <div class="form-group col-md-2">
                            <label for="role">Zone <span class="text-danger">*</span></label>
                            <select name="zone_id" class="form-control form-control-sm region_id" required="" onchange="getRegionalDivision(this.options[this.selectedIndex].value, $(this));">
                                <option value="">Select Zone</option>
                                @foreach($regions as $region)
                                <option {{$region->id==$item->zone_id ? "selected" : ''}} value="{{ $region->id }}">{{ $region->region_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label">Division <span class="text-danger">*</span></label>
                            <select required="" name="division_id" class="form-control form-control-sm division_id" onchange="getRegionalDivisionDistrict(this.options[this.selectedIndex].value, $(this));">
                                {{-- <option value="">Select Division</option> --}}
                                {!! getRegionalDivision($item->zone_id,$item->division_id) !!}
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label">District <span class="text-danger">*</span></label>
                            <select required="" name="district_id" id="district_id" class="form-control form-control-sm district_id" onchange="getDistrictUpazila(this.options[this.selectedIndex].value, $(this));">
                                {!! getRegionalDivisionDistrict($item->zone_id,$item->division_id,$item->district_id) !!}
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label">Upazila</label>
                            <select required="" name="upazila_id" class="form-control form-control-sm upazila_id" onchange="getUpazilaUnion(this.options[this.selectedIndex].value, $(this));">
                                {!! getupazila($item->district_id,$item->upazila_id) !!}
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label">Union</label>
                            <select name="union_id" class="form-control form-control-sm union_id" onchange="getUnionVillage(this.options[this.selectedIndex].value, $(this));">
                                {!! getunion($item->upazila_id,$item->union_id) !!}
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label">Village</label>
                            <input type="text" class="form-control form-control-sm" value="{{$item->village_name}}" name="village_name" id="">
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label">Formation Date</label>
                            <input type="date" class="form-control form-control-sm" name="date_from" value="{{$item->date_from}}" id="">
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label">Closing Date</label>
                            <input type="date" class="form-control form-control-sm" value="{{$item->date_to}}" name="date_to" id="">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label"> President Name </label>
                            <input required="" type="text" class="form-control form-control-sm" value="{{$item->name_1}}" name="name_1" id="">
                        </div>

                        <div class="form-group col-md-6">
                            <label class="control-label"> Mobile No </label>
                            <input required="" type="text" class="form-control form-control-sm InputPhone" maxlength="11" name="mob_1" value="{{$item->mob_1}}" id="">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label"> Secretary Name </label>
                            <input type="text" class="form-control form-control-sm" value="{{$item->name_2}}" name="name_2" id="">
                        </div>

                        <div class="form-group col-md-6">
                            <label class="control-label"> Mobile No </label>
                            <input type="text" class="form-control form-control-sm InputPhone" maxlength="11" value="{{$item->mob_2}}" name="mob_2" id="">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label"> Cashier Name </label>
                            <input type="text" class="form-control form-control-sm" value="{{$item->name_3}}" name="name_3" id="">
                        </div>

                        <div class="form-group col-md-6">
                            <label class="control-label"> Mobile No </label>
                            <input type="text" class="form-control form-control-sm InputPhone" maxlength="11" value="{{$item->mob_3}}" name="mob_3" id="">
                        </div>
                        
                        {{-- Member Information --}}
                        <div class="col-md-12">
                            <h6>Member Details</h6>
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label">Girls:</label>
                            <input  type="number"  value="{{ @$item->member_girls }}" class="form-control form-control-sm" name="member_girls" id="member_girls" onkeypress="return isNumberKey(event)">
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label">Boys:</label>
                            <input  type="number"  value="{{ @$item->member_boys }}" class="form-control form-control-sm" name="member_boys" id="member_boys" onkeypress="return isNumberKey(event)">
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label">Female:</label>
                            <input  type="number"  value="{{ @$item->member_female }}" class="form-control form-control-sm" name="member_female" id="member_female" onkeypress="return isNumberKey(event)">
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label">Male:</label>
                            <input  type="number"  value="{{ @$item->member_male }}" class="form-control form-control-sm" name="member_male" id="member_male" onkeypress="return isNumberKey(event)">
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label">Other Gender:</label>
                            <input  type="number"  value="{{ @$item->member_transgender }}" class="form-control form-control-sm" name="member_transgender" id="member_transgender" onkeypress="return isNumberKey(event)">
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label">Total:</label>
                            <input  type="number"  value="{{ @$item->general_member_total }}" class="form-control form-control-sm" name="general_member_total" id="general_member_total" readonly="">
                        </div>

                        <div class="col-md-12">
                            <h6>Person with disabilities (PWD)</h6>
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label">Girls:</label>
                            <input  type="number"  value="{{ @$item->member_girls_pwd }}" class="form-control form-control-sm" name="member_girls_pwd" id="member_girls_pwd" onkeypress="return isNumberKey(event)">
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label">Boys:</label>
                            <input  type="number"  value="{{ @$item->member_boys_pwd }}" class="form-control form-control-sm" name="member_boys_pwd" id="member_boys_pwd" onkeypress="return isNumberKey(event)">
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label">Female:</label>
                            <input  type="number"  value="{{ @$item->member_female_pwd }}" class="form-control form-control-sm" name="member_female_pwd" id="member_female_pwd" onkeypress="return isNumberKey(event)">
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label">Male:</label>
                            <input  type="number"  value="{{ @$item->member_male_pwd }}" class="form-control form-control-sm" name="member_male_pwd" id="member_male_pwd" onkeypress="return isNumberKey(event)">
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label">Other Gender:</label>
                            <input  type="number"  value="{{ @$item->member_transgender_pwd }}" class="form-control form-control-sm" name="member_transgender_pwd" id="member_transgender_pwd" onkeypress="return isNumberKey(event)">
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label">Total:</label>
                            <input  type="number"  value="{{ @$item->general_member_pwd_total }}" class="form-control form-control-sm" name="general_member_pwd_total" id="general_member_pwd_total" readonly="">
                        </div>
					</div>
					<button type="submit" class="btn btn-success btn-flat"> <i class="fas fa-save"></i> Store </button>
				</form>
            </div>
            <!-- /.card -->
        </div>
    </div>
    <!--/. container-fluid -->
</section>
<script>
    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
        return true;
    }
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
    $(document).on("input", ".InputPhone", function() {
        this.value = this.value.replace(/\D/g,'');
    });

    $(document).ready(function(){
    	$('#myForm').validate({
    		errorClass:'text-danger',
	      	validClass:'text-success',
	        rules : {
	            'employee_name' : {
	                required : true,
	            },
	            'employee_pin' : {
	                required : true,
	            },
	        },
	        messages : {

	        }
	    });
    });

    function add(item)
    {
        var extra_region_area_info = item.closest('.region_area_info').clone();

        extra_region_area_info.find('.btn-remove').removeClass('d-none');
        extra_region_area_info.find('input, select').each(function() {
            $(this).val('');
        });

        item.closest('.region_area').find('.extra_region_area_info').append(extra_region_area_info);
    }

    function remove(item)
    {
        item.closest('.region_area_info').remove();
    }

    function getUser(employee_pin, item)
    {
    	var url  = "{{ route('setup.getUser') }}";
      	var data = {
    		employee_pin: employee_pin
    	}

      	$.get(url, data, function(response) {
            var role_name = '';
            $.each(response.user_role, function(index, value) {
			  	role_name += value.role_details.name+', ';
			});

            item.closest('.show_module_more_event').find('.user_id').val(response.id);
            item.closest('.show_module_more_event').find('.employee_name').val(response.name);
			item.closest('.show_module_more_event').find('.role_name').val(role_name);
        });
    }

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

    function getUpazilaUnion(upazila_id, item)
    {
    	var url  = "{{ route('setup.getUpazilaUnion') }}";
      	var data = {
    		upazila_id: upazila_id
    	}

      	$.get(url, data, function(response) {
            // console.log(response);
            item.closest('.region_area_info').find('.union_id').html(response);
        });
    }

    function getUnionVillage(union_id,item){
        var url  = "{{ route('setup.getUnionVillage') }}";
      	var data = {
    		union_id: union_id
    	}

      	$.get(url, data, function(response) {
            // console.log(response);
            item.closest('.region_area_info').find('.village_id').html(response);
        });
    }
</script>

<script>
    function add(item)
    {
        var extra_region_area_info = item.closest('.region_area_info').clone();

        extra_region_area_info.find('.btn-remove').removeClass('d-none');
        extra_region_area_info.find('input, select').each(function() {
            $(this).val('');
        });

        item.closest('.region_area').find('.extra_region_area_info').append(extra_region_area_info);
    }

    function remove(item)
    {
        item.closest('.region_area_info').remove();
    }
</script>



<script>
	$(document).ready(function(){
		addEventListener('change',(e)=>{
			if(e.target.hasAttribute('el_type')){
				$.ajax({
					url : "{{route('setup.pollisomaj.checkactivevillage')}}",
					type : "GET",
					data : {village_id:e.target.value},
					success:function(data){
						if(data.status==200){
							Swal.fire({
								icon: 'error',
								title: 'This village is already in use',
								showConfirmButton: true,
								
								html:'<a href="'+data.url+'" target="_blank">Click</a> ' +
									'to inactive this village',
								
							})
							//if(e.target.parentNode.parentNode.parentNode.getAttribute("class")=="extra_region_area_info"){
								//console.log(e.target.parentNode.parentNode.getAttribute("class"))
								e.target.value='';
							//}
							
						}
					}
				});
			}
		})
	})
</script>
@endsection
