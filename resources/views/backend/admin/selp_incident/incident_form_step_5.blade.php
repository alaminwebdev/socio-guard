@php
    $arr=array();
    $followUps=\App\Model\FollowUpInfo::where('selp_incident_ref',request()->selp_incident_ref)->get()->toArray();
    // dd(Session::get('current_incident_store_session'));
    if(count($followUps)>0){
      for($i=0;$i<count($followUps);$i++){
        array_push($arr,['visibility'=>false,'followup_findings'=>$followUps[$i]['followup_findings'],'followup_date'=>$followUps[$i]['followup_date'],'followup_number'=>$followUps[$i]['followup_number'],'followup_type'=>$followUps[$i]['followup_type']]);
      }
      // if(count($followUps)<3){
      //   array_push($arr,['visibility'=>true,'followup_findings'=>'','followup_date'=>'','followup_number'=>'','followup_type'=>'']);
      // }
    }else{
      array_push($arr,['visibility'=>true,'followup_findings'=>'','followup_date'=>'','followup_number'=>'','followup_type'=>'']);
    }

    //dd($followUps);
@endphp

@php
    $refArr=array();
    $referrals=\App\Model\IncidentReferral::where('selp_incident_ref',request()->selp_incident_ref)->get()->toArray();
    if(count($referrals)>0){
      for ($i=0; $i <count($referrals) ; $i++) { 
        array_push($refArr,['visibility'=>false,'id'=>$referrals[$i]['id'],'date'=>$referrals[$i]['referral_date'],'val'=>$referrals[$i]['referral_id']]);
      }
    }else{
        array_push($refArr,['visibility'=>true,'id'=>"",'date'=>'','val'=>'']);
    }
    

@endphp

<meta name="services" content="{{ json_encode($arr) }}">
<meta name="referral" content="{{ json_encode($refArr) }}">
<form method="post" action="{{route('incident.selp.step-5')}}">
  @csrf
  <input type="hidden" name="selp_incident_ref" value="{{request()->selp_incident_ref }}">
  <input type="hidden" name="tab" value="3">
  <input type="hidden" name="step" value="6">
               {{-- @include('backend.admin.selp_incident.courtcase') --}}

                <div class="form-row">
                  <div class="form-group col-md-12">
                    <p><strong><u>6. Followup : </u></strong></p>
                  </div>
                  <div class="row col-md-12" id="follow_up_container">
                    
                  </div>
                  
                </div>
                
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <p><strong><u>7. Referral : </u></strong></p>
                  </div>
                  <div id="referral_container" class="row col-md-12">
                    
                  </div>
                  
                </div>

        <br>
        <div class="form-row" style="float: right">
          <a href="{{route('incident.selp.add', ['tab' => 2, 'step' => 4,'selp_incident_ref' =>request()->selp_incident_ref ])}}" class="btn btn-success submit text-white mr-1">Back</a>
          <button type="submit" class="btn btn-info submit text-white mr-1" onClick="this.form.submit(); this.disabled=true; this.innerHTML='Sending…';">Save & Next</button>
          @if($user_info['user_role'][0]['role_id'] == 4)
            <button type="submit" name="save_destroy" class="btn btn-primary submit text-white mr-1">Close</button>
          @else
            <button type="submit" name="save_destroy" class="btn btn-primary submit text-white mr-1" onClick="this.form.submit(); this.disabled=true; this.innerHTML='Sending…';">Draft & Close</button>
          @endif
          <button type="submit" name="save_destroy" class="btn btn-warning final text-white mr-1 d-none" onClick="this.form.submit(); this.disabled=true; this.innerHTML='Sending…';">Submit</button>
        </div>

</form>

{{-- Follow up script here --}}


<script>
  addEventListener('change',(e)=>{
    if(e.target.hasAttribute('element_idx')){
      if(services.find(el=>el.followup_number==e.target.value)){
          alert("Already added");
          e.target.value='';
          return;
      }

      if(e.target.value > services.length){
        alert("You must add previous follow up");
        services[e.target.getAttribute('element_idx')]['followup_number']=services.length;
        e.target.value=services.length;
        //console.log(services.length-e.target.value);
        return;
      }
    }
   
  });


  
  let services=JSON.parse($('meta[name="services"]').attr('content'))
  function renderHtml(services){
        let counter=0;
        let container=document.getElementById('follow_up_container');
        container.innerHTML='';

        for (let i = 0; i < services.length; i++) {
          let moment_date = moment(services[i].followup_date).format("DD-MM-YYYY");
          // let moment_date = services[i].followup_date;
          console.log(moment_date);
          let template=`
              <div class="form-group col-sm-3">
                  <label class="control-label">No.of follow up made by SELP staff </label>
                  <select element_idx=${i} type="" ${services[i].visibility ? '' : ''} name="no_of_followup_madeby_selp_staff" id="division_id" class="division_id form-control form-control-sm">
                      <option value="">-- Select --</option>
                      <option ${services[i].followup_number==1 ? "selected" : '' } value="1"> First Time </option>
                      <option ${services[i].followup_number==2 ? "selected" : '' } value="2"> Second Time </option>
                      <option ${services[i].followup_number==3 ? "selected" : '' } value="3"> Third Time </option>
                  </select>
              </div>
              <div class="form-group col-sm-3">
                  <label class="control-label" style="font-size: 12px;">Type of Follow up </label>
                  <select ${services[i].visibility ? '' : ''} name="program_participent_followup" id="division_id" class="division_id form-control form-control-sm">
                      <option value="">-- Select --</option>
                      <option  ${services[i].followup_type==1 ? "selected" : '' } value="1"> Physically/ In-person</option>
                      <option  ${services[i].followup_type==2 ? "selected" : '' } value="2"> Online</option>
                  </select>
              </div>
              <div class="form-group col-sm-3">
                  <label class="control-label">Findings from follow up </label>
                  <select ${services[i].visibility ? '' : ''} name="followup_id" id="division_id" class="division_id form-control form-control-sm">
                      <option value="">-- Select --</option>
                      @foreach($findingsFromFollowUp as $FollowUp)
                        <option  ${services[i].followup_findings=="{{ $FollowUp->id }}" ? "selected" : '' } value="{{ $FollowUp->id }}">{{ $FollowUp->title }}</option>
                      @endforeach
                  </select>
              </div>
              <div class="form-group col-sm-3">
                  <label class="control-label">Follow Up Date </label>
                  <input ${services[i].visibility ? '' : ''} type="date" name="followup_date" value="${services[i].followup_date}" id="" class="form-control form-control-sm">
              </div>`

              container.innerHTML+=template  
          
        }

        console.log(container)

       
  }     
  
  renderHtml(services);
</script>

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
                        <input ref_date_idx=${i} type="date" ${referrals[i].visibility ? '' : ''} name="service_raferral_date[]" value="${referrals[i]['date']}" id="" class="form-control form-control-sm">
                      </div>
                      <div class="form-group col-md-2" style="margin-top:21px">
                        <i  btn_type="add_service" class="fa fa-plus btn btn-sm btn-info" onclick="addReferral(this);"></i>
                        <i  idx='${i}' btn_type="rm_service" class="fa fa-minus btn btn-sm btn-danger btn-remove ${i==0 ? 'd-none' : ''}" data-type="delete" onclick="removeReferral(this);"></i>
                      </div>`;


            container.innerHTML+=refTemplate;          
        
      }
      
     }

     renderReferral(referrals)
    //  <i  idx='${i}' btn_type="rm_service" class="fa fa-minus btn btn-sm btn-danger btn-remove ${referrals[i].visibility && i!=0 ? 'd-none' : ''}" data-type="delete" onclick="removeReferral(this);"></i>
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