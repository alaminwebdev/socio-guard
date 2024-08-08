@extends('backend.layouts.app')
@section('content')
<!-- color picker -->
<style>
.custom-size .colorpicker-saturation {
	width: 250px;
	height: 250px;
}

.custom-size .colorpicker-hue,
.custom-size .colorpicker-alpha {
	width: 40px;
	height: 250px;
}

.custom-size .colorpicker-color,
.custom-size .colorpicker-color div {
	height: 40px;
}
</style>
      
<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">ড্যাশবোর্ড জন্য রঙ পরিচালনা করুন</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">হোম </li> 
			<li class="breadcrumb-item active">ড্যাশবোর্ড জন্য রঙ যোগ করুন</li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div>
<div class="container fullbody">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5>ড্যাশবোর্ড জন্য রঙ যোগ করুন<a class="btn btn-sm btn-success float-right" href="{{route('setup.color.view')}}"><i class="fa fa-list"></i> ড্যাশবোর্ড জন্য রঙ তালিকা</a></h5>
			</div>
			<!-- Form Start-->
			<form method="post" action="{{!empty($editData->id) ? route('setup.color.update',$editData->id) : route('setup.color.store')}}" id="myForm">
				{{csrf_field()}}
				<div class="card-body">
					<div class="show_module_more_event">
						<div class="form-row">
							<div class="form-group col-md-12">
								<label class="control-label">ড্যাশবোর্ড প্রকার</label>
								<select id="usertype" name="usertype" class="form-control form-control-sm">
									<option value="">ড্যাশবোর্ড নির্বাচন করুন</option>
									<option value="admin" {{(@$editData->usertype == 'admin')?('selected'):''}}>অ্যাডমিন ড্যাশবোর্ড</option>
									<option value="guestspeaker" {{(@$editData->usertype == 'guestspeaker')?('selected'):''}}>Guest Speaker Dashboard</option>
									<option value="participant" {{(@$editData->usertype == 'participant')?('selected'):''}}>Participant Dashboard</option>
								</select>
							</div>

							<div class="form-group col-md-6">
								<label class="control-label">নাভবার পটভূমি রঙ</label>
								<div class="input-group input-group-sm colorpicker-component">
									<input type="text" name="navbarbgcode" id="navbarbgcode" class="form-control form-control-sm code" value="{{!empty($editData->navbarbgcode) ? ($editData->navbarbgcode) : ''}}" placeholder="রঙের কোড লিখুন" readonly="">
									<div class="input-group-append">
										<span class="input-group-text" style="padding-bottom: 0px">
											<span class="input-group-addon"><i  style="padding-left:40px !important"></i></span>
										</span>
									</div>
								</div>
							</div>
    

							<div class="form-group col-md-6">
								<label class="control-label">নাভবার লেখার রঙ</label>
								
								<div class="input-group input-group-sm colorpicker-component">
									<input type="text" name="navbartxtcode" id="navbartxtcode" class="form-control form-control-sm code" value="{{!empty($editData->navbartxtcode) ? ($editData->navbartxtcode) : ''}}" placeholder="রঙের কোড লিখুন" readonly="">
									<div class="input-group-append">
										<span class="input-group-text" style="padding-bottom: 0px">
											<span class="input-group-addon"><i  style="padding-left:40px !important"></i></span>
										</span>
									</div>
								</div>
							</div>
							<div class="form-group col-md-6">
								<label class="control-label">শিশু নাভবার  পটভূমি রঙ</label>
								
								<div class="input-group input-group-sm colorpicker-component">
									<input type="text" name="childnavbarbgcode" id="childnavbarbgcode" class="form-control form-control-sm code" value="{{!empty($editData->childnavbarbgcode) ? ($editData->childnavbarbgcode) : ''}}" placeholder="রঙের কোড লিখুন" readonly="">
									<div class="input-group-append">
										<span class="input-group-text" style="padding-bottom: 0px">
											<span class="input-group-addon"><i  style="padding-left:40px !important"></i></span>
										</span>
									</div>
								</div>
							</div>
							<div class="form-group col-md-6">
								<label class="control-label">শিশু নাভবার  পটভূমি রঙ</label>
								
								<div class="input-group input-group-sm colorpicker-component">
									<input type="text" name="childnavbartxtcode" id="childnavbartxtcode" class="form-control form-control-sm code" value="{{!empty($editData->childnavbartxtcode) ? ($editData->childnavbartxtcode) : ''}}" placeholder="রঙের কোড লিখুন" readonly="">
									<div class="input-group-append">
										<span class="input-group-text" style="padding-bottom: 0px">
											<span class="input-group-addon"><i  style="padding-left:40px !important"></i></span>
										</span>
									</div>
								</div>
							</div>
							<div class="form-group col-md-6">
								<label class="control-label">টেবিল পটভূমি রঙ</label>
								
								<div class="input-group input-group-sm colorpicker-component">
									<input type="text" name="tablebgcode" id="tablebgcode" class="form-control form-control-sm code" value="{{!empty($editData->tablebgcode) ? ($editData->tablebgcode) : ''}}" placeholder="রঙের কোড লিখুন" readonly="">
									<div class="input-group-append">
										<span class="input-group-text" style="padding-bottom: 0px">
											<span class="input-group-addon"><i  style="padding-left:40px !important"></i></span>
										</span>
									</div>
								</div>
							</div>
							<div class="form-group col-md-6">
								<label class="control-label">টেবিল টেক্সট রঙ</label>
								
								<div class="input-group input-group-sm colorpicker-component">
									<input type="text" name="tabletxtcode" id="tabletxtcode" class="form-control form-control-sm code" value="{{!empty($editData->tabletxtcode) ? ($editData->tabletxtcode) : ''}}" placeholder="রঙের কোড লিখুন" readonly="">
									<div class="input-group-append">
										<span class="input-group-text" style="padding-bottom: 0px">
											<span class="input-group-addon"><i  style="padding-left:40px !important"></i></span>
										</span>
									</div>
								</div>
							</div>

						</div>
					</div>
						
					<button type="submit" class="btn btn-success btn-sm">{{(@$editData) ? 'Update' : 'জমা দিন'}}</button>
					<button type="reset" class="btn btn-danger btn-sm">রিসেট</button>
				</div>
			</form>
			<!--Form End-->
		</div>
	</div>
</div>
<!-- extra html -->

<script>
	$(function () {
		$('.colorpicker-component').colorpicker({
              customClass: 'custom-size',
              sliders: {
                  saturation: {
                      maxLeft: 250,
                      maxTop: 250
                  },
                  hue: {
                      maxTop: 250
                  },
                  alpha: {
                      maxTop: 250
                  }
              }
          });
	});
</script>
<script>


	$(document).on('change','.code',function(){
		var codenavbarbgcode 		= $('#navbarbgcode').val();
		var codenavbartxtcode 		= $('#navbartxtcode').val();
		var codechildnavbarbgcode 	= $('#childnavbarbgcode').val();
		var codechildnavbartxtcode 	= $('#childnavbartxtcode').val();
		var codetablebgcode 		= $('#tablebgcode').val();
		var codetabletxtcode 		= $('#tabletxtcode').val();
		$(".navbarbgcode").css("background-color", codenavbarbgcode);
		$(".navbartxtcode").css("color", codenavbartxtcode);
		$(".pnavbar").css("background-color", codenavbarbgcode);
		$(".cnavbar").css("background-color", codechildnavbarbgcode);
		// $(".childnavbartxtcode").css("color", codechildnavbartxtcode);
		$("table thead").css("background-color", codetablebgcode);
		$("table thead tr th").css("color", codetabletxtcode);
	});




	// $(document).on('change','#colorcode',function(){
	// 	var colorcode = $(this).val();
	// 	$(this).parents('.input-group').find('.code').val(colorcode);
	// });

    $(document).ready(function(){
    	$('#myForm').validate({
    		errorClass:'text-danger',
	      	validClass:'text-success',
	        rules : {
	            'usertype' : {
	                required : true
	            },
	            'navbarbgcode' : {
	                required : true
	            },
	            'navbartxtcode' : {
	                required : true
	            },
	            'childnavbarbgcode' : {
	                required : true
	            },
	            'childnavbartxtcode' : {
	                required : true
	            },
	            'tablebgcode' : {
	                required : true
	            },
	            'tabletxtcode' : {
	                required : true
	            },
	        },
	        messages : {
	            'usertype' : 'অনুগ্রহ করে ড্যাশবোর্ড দরণ নির্বাচন করুন',
	            'navbarbgcode' : 'নাভবার পটভূমি রঙ দয়া করে লিখুন ',
	            'navbartxtcode' : 'নাভবার  টেক্সট রঙ দয়া করে লিখুন ',
	            'childnavbarbgcode' : 'চাইল্ড নাভবার পটভূমি রঙ দয়া করে লিখুন',
	            'childnavbartxtcode' : 'চাইল্ড নাভবার  লেখার রঙ দয়া করে লিখুন ',
	            'tablebgcode' : 'টেবিল পটভূমি রঙ দয়া করে লিখুন ',
	            'tabletxtcode' : 'টেবিল লেখার রঙ দয়া করে লিখুন ',
	        }
	    });
    });
</script> 

@endsection