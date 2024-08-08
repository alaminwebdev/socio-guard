@extends('backend.layouts.app')
@section('content')
@php
    $refArr=array();
    $referrals=\App\Model\IncidentReferral::where('selp_incident_ref',$incidentRef)->get()->toArray();
    if(count($referrals)>0){
      for ($i=0; $i <count($referrals) ; $i++) { 
        array_push($refArr,['visibility'=>false,'id'=>$referrals[$i]['id'],'date'=>$referrals[$i]['referral_date']!=null ? date_format(date_create($referrals[$i]['referral_date']), "d-M-Y") : "",'val'=>$referrals[$i]['referral_id']]);
      }
    }else{
        array_push($refArr,['visibility'=>true,'id'=>"",'date'=>'','val'=>'']);
    }
    

@endphp


<meta name="referral" content="{{ json_encode($refArr) }}">
<div class="container fullbody">
<div class="card">
    <div class="card-header">
        <h5><p><strong><u>Referral : </u></strong></p></h5>
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
        <form method="post" action="{{route('incident.selp.addreferral',$incidentRef)}}">
            @csrf
            <input type="hidden" name="tab" value="3">
            <input type="hidden" name="step" value="6">
                         {{-- @include('backend.admin.selp_incident.courtcase') --}}
          
                          <div class="form-row">
                            <div class="form-group col-md-12">
                              {{-- <p><strong><u>6. Followup : </u></strong></p> --}}
                            </div>
                            <div class="row col-md-12" id="referral_container">
                              
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
                  <button type="submit" name="save_destroy" class="btn btn-primary final text-white mr-1 " style="float:right" onClick="this.form.submit(); this.disabled=true; this.innerHTML='Sending…';">Save</button>
          </form>
    </div>



</div>
{{-- Referral script --}}

<script>

    addEventListener('change',(e)=>{
      if(e.target.hasAttribute('ref_element_idx')){
        if(referrals.find(el=>el.val==e.target.value)){
          alert("Already added");
          referrals[e.target.getAttribute('ref_element_idx')]['val']='';
          e.target.value='';
          return;
        }else{
          referrals[e.target.getAttribute('ref_element_idx')]['val']=e.target.value;
          return;
        }
      }
      if(e.target.hasAttribute('ref_date_idx')){
        referrals[e.target.getAttribute('ref_date_idx')]['date']=e.target.value;
        
      }
    })
    function addReferral(item){
        referrals.push({visibility:true,id:'',val:'',date:''})
        renderReferral(referrals);
    }

    function removeReferral(item){
        referrals.splice(item.getAttribute('idx'),1)
        // console.log(item.getAttribute('idx'),item.getAttribute('idx'))
        renderReferral(referrals);
    }

     let referrals=JSON.parse($('meta[name="referral"]').attr('content'))

     function renderReferral(referrals){
      let container=document.getElementById('referral_container');
      container.innerHTML='';
      for (let i = 0; i < referrals.length; i++) {
          let refTemplate=`
          <input type="hidden" name="id[]" value="${referrals[i].id}" >
                      <div class="form-group col-md-4">
                        <label class="control-label">Referral To </label>
                        <select ref_element_idx=${i} ${referrals[i].visibility ? '' : ''} name="service_referral_no[]" id="division_id" class="division_id form-control form-control-sm">
                          <option value="">-- Select --</option>
                          @foreach($secondaryRefferals as $refferal)
                            <option  ${referrals[i].val=="{{ $refferal->id }}" ? "selected" : '' } value="{{ $refferal->id }}">{{ $refferal->name }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group col-md-4"  style="">
                        <label class="control-label">Date </label>
                        <input ref_date_idx=${i} type="text" ${referrals[i].visibility ? '' : ''} name="service_raferral_date[]" value="${referrals[i]['date']}" id="" class="form-control form-control-sm date_picker">
                      </div>
                      <div class="form-group col-md-2" style="margin-top:21px">
                        <i  btn_type="add_service" class="fa fa-plus btn btn-sm btn-info" onclick="addReferral(this);"></i>
                        <i  idx='${i}' btn_type="rm_service" class="fa fa-minus btn btn-sm btn-danger btn-remove ${i==0 ? 'd-none' : ''}" data-type="delete" onclick="removeReferral(this);"></i>
                      </div>`;


            container.innerHTML+=refTemplate;          
        
      }
      $( ".date_picker" ).datepicker({
        dateFormat:"d-M-yy",
       
      });
     }

     renderReferral(referrals)
   

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