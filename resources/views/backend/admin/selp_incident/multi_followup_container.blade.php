@extends('backend.layouts.app')
@section('content')
@php
    $arr=array();
    $followUps=\App\Model\FollowUpInfo::where('selp_incident_ref',$incidentRef)->get()->toArray();
    // dd($followUps);
    if(count($followUps)>0){
      for($i=0;$i<count($followUps);$i++){
        array_push($arr,['visibility'=>false,'id'=>$followUps[$i]['id'],'followup_findings'=>$followUps[$i]['followup_findings'],'followup_date'=>$followUps[$i]['followup_date']!=null ? date_format(date_create($followUps[$i]['followup_date']), "d-M-Y") : "",'followup_number'=>$followUps[$i]['followup_number'],'followup_type'=>$followUps[$i]['followup_type']]);
      }
      if(count($followUps)<3){
        array_push($arr,['visibility'=>true,'id'=>"",'followup_findings'=>'','followup_date'=>'','followup_number'=>'','followup_type'=>'']);
      }
    }else{
      array_push($arr,['visibility'=>true,'id'=>"",'followup_findings'=>'','followup_date'=>'','followup_number'=>'','followup_type'=>'']);
    }
@endphp

<meta name="services" content="{{ json_encode($arr) }}">
<div class="container fullbody">
<div class="card">
    <div class="card-header">
        <h5><p><strong><u>Follow up : </u></strong></p></h5>
    </div>
    <div class="card-body">
      <div class="form-row">
        <div class="col-md-1">
    
        </div>
        <div class="col-md-2" style="padding-top:7px;">
        {{-- <p style="font-weight: bold;font-size: 13px;padding-left: 5px;">Complaint ID: {{explode(".",explode("_",Session::get('current_incident_store_session'))[2])[1]}}</p> --}}
        <p style="font-weight: bold;font-size: 13px;padding-left: 5px;">Complaint ID: {{count($selpIncident)>0  ? formatIncidentId($selpIncident[0]->id) : formatIncidentId($tempIncidentId+1)}}</p>
      </div>
        
        <div class="col-md-2" style="padding-left: 45px;">
        <p style="font-weight: bold;font-size: 13px;padding-left: 18px;padding-top: 7px;">Reporting Date:</p>
        </div>
        <div class="col-md-2">
        <input type="text" name="" value="{{count($selpIncident)>0 && $selpIncident[0]->posting_date != null ? date("d-m-Y", strtotime($selpIncident[0]->posting_date)) : ''}}" id="posting_date" value="" class="form-control form-control-sm postingdatepicker" readonly>
        </div>
    
        <div class="col-md-2" style="padding-left: 35px;">
        
        </div>
      </div>
        
        {{-- <form method="post" action="#"> --}}
        <form method="post" action="{{route('incident.selp.addfollowup',$incidentRef)}}" class="followup_submit">
            @csrf
            <input type="hidden" name="tab" value="3">
            <input type="hidden" name="step" value="6">
                         {{-- @include('backend.admin.selp_incident.courtcase') --}}
          
                          <div class="form-row">
                            <div class="form-group col-md-12">
                              {{-- <p><strong><u>6. Followup : </u></strong></p> --}}
                            </div>
                            <div class="row col-md-12" id="follow_up_container">
                              
                            </div>
                            
                          </div>
                          
                         
          
                  <br>
                  <div class="form-row" style="float: right">
                    {{-- <a href="{{route('incident.selp.add', ['tab' => 2, 'step' => 4])}}" class="btn btn-success submit text-white mr-1">Back</a>
                    <button type="submit" class="btn btn-info submit text-white mr-1">Save & Next</button>
                    @if($user_info['user_role'][0]['role_id'] == 4)
                      <button type="submit" name="save_destroy" class="btn btn-primary submit text-white mr-1">Close</button>
                    @else
                      <button type="submit" name="save_destroy" class="btn btn-primary submit text-white mr-1">Draft & Close</button>
                    @endif --}}
                    
                  </div>
                  <hr>
                  <button type="submit" name="save_destroy" class="btn btn-primary final text-white mr-1 followup_submit" id="followup_submit" style="float:right" onClick="this.form.submit(); this.disabled=true; this.innerHTML='Sending…';">Save</button>
          </form>
    </div>


{{-- Follow up script here --}}
</div>

<script type="text/javascript">
	$(function(){
		$(document).on('submit','.followup_submit',function(e){
      // alert("dsf");
      $('.followup_submit').attr('disabled', true);
      // e.preventDefault();
			// var region_id = $('#region_id').val();
			// var case_type = $(this).val();
      // alert("sfsd");
		});
	});
</script>

<script>
  addEventListener('change',(e)=>{
    if(e.target.hasAttribute('element_idx')){
      if(services.find(el=>el.followup_number==e.target.value)){
          alert("Already added");
          e.target.value='';
          return;
      }
      // if(e.target.value > services.length){
      //   alert("You must add previous follow up");
      //   services[e.target.getAttribute('element_idx')]['followup_number']=services.length;
      //   e.target.value=services.length;
      //   //console.log(services.length-e.target.value);
      //   return;
      // }
    }
   
  });


  
  let services=JSON.parse($('meta[name="services"]').attr('content'))
  function renderHtml(services){
        let counter=0;
        let container=document.getElementById('follow_up_container');
        container.innerHTML='';

        for (let i = 0; i < services.length; i++) {
          let template=`
          <input type="hidden" name="id[]" value="${services[i].id}" >
              <div class="form-group col-sm-3">
                  <label class="control-label">No.of follow up made by SELP staff </label>
                  <select element_idx=${i} type="" ${services[i].visibility ? '' : ''} name="no_of_followup_madeby_selp_staff[]" id="division_id" class="division_id form-control form-control-sm">
                      <option value="">-- Select --</option>
                      <option ${services[i].followup_number==1 ? "selected" : '' } value="1"> First Time </option>
                      <option ${services[i].followup_number==2 ? "selected" : '' } value="2"> Second Time </option>
                      <option ${services[i].followup_number==3 ? "selected" : '' } value="3"> Third Time </option>
                  </select>
              </div>
              <div class="form-group col-sm-3">
                  <label class="control-label" style="font-size: 12px;">Type of Follow up </label>
                  <select ${services[i].visibility ? '' : ''} name="program_participent_followup[]" id="division_id" class="division_id form-control form-control-sm">
                      <option value="">-- Select --</option>
                      <option  ${services[i].followup_type==1 ? "selected" : '' } value="1"> Physically/ In-person</option>
                      <option  ${services[i].followup_type==2 ? "selected" : '' } value="2"> Online</option>
                  </select>
              </div>
              <div class="form-group col-sm-3">
                  <label class="control-label">Findings from follow up </label>
                  <select ${services[i].visibility ? '' : ''} name="followup_id[]" id="division_id" class="division_id form-control form-control-sm">
                      <option value="">-- Select --</option>
                      @foreach($findingsFromFollowUp as $FollowUp)
                        <option  ${services[i].followup_findings=="{{ $FollowUp->id }}" ? "selected" : '' } value="{{ $FollowUp->id }}">{{ $FollowUp->title }}</option>
                      @endforeach
                  </select>
              </div>
              <div class="form-group col-sm-3">
                  <label class="control-label">Follow Up Date </label>
                  <input ${services[i].visibility ? '' : ''} type="text" name="followup_date[]" value="${services[i].followup_date}" id="" class="form-control form-control-sm date_picker">
              </div>`

              container.innerHTML+=template  
          
        }

        console.log(container)
        $( ".date_picker" ).datepicker({
        dateFormat:"d-M-yy",
       
      });
       
  }     
  
  renderHtml(services);
</script>
<script>
  $(document).ready(function() {
    $("#section_A").show();
    $("#section_B").show();
  });

  $(document).ready(function() {
    $(".services").change(function() {
        var services = $(".services").val();
        if (services == 3) {
            $(".region_area").show();
        } else if (services == 4) {
          $(".if_direct_support").show();
        } else {
          $(".region_area").hide();
          $(".through_adr").hide();
          $(".if_direct_support").hide();
        }
      });
    });
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



<script type="text/javascript">
	$(function(){
		$(document).on('change','#case_type',function(){
			// var region_id = $('#region_id').val();
			var case_type = $(this).val();
			$.ajax({
				url : "{{route('default.get-case-list')}}",
				type : "GET",
				data : {case_type:case_type},
				success:function(data){
          
					var html = '<option value=""> -- Select -- </option>';
          for(var i=0;i<data.length;i++){
            html +='<option value="'+data[i].id+'">'+data[i].title+'</option>';
         }
					// $.each(data,function(key,v){
          //   console.log(data[key]);
					// 	//html +='<option value="'+v[key].district_id+'">'+v[key].name+'</option>';
					// });
					$('#case_type_list').html(html);
          
				}
			});
		});
	});
</script>
@endsection