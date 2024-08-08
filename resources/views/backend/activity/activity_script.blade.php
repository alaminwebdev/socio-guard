<script>
    let list = JSON.parse($('meta[name="meetings"]').attr('content'))
    let meetingObj=[];
    let alreadyExistEvent=[];
    if(list.length==0){
        console.log("sff");
        meetingObj=[{
            id:1,
            p_m_boy:0,
            p_m_girl:0,
            p_m_men:0,
            p_m_women:0,
            p_m_intersex:0,
            p_m_total:0,
            pwd_p_m_boy:0,
            pwd_p_m_girl:0,
            pwd_p_m_men:0,
            pwd_p_m_women:0,
            pwd_p_m_intersex:0,
            pwd_p_m_total:0,
            
        }];
    }else{
        console.log("sdfsf");
        for (let i = 0; i < list.length; i++) {
            let temp={
                id:i+1,
                p_m_boy:list[i]['participant_boys']*1,
                p_m_girl:list[i]['participant_girls']*1,
                p_m_men:list[i]['participant_men']*1,
                p_m_women:list[i]['participant_women']*1,
                p_m_intersex:list[i]['participant_other_gender']*1,
                p_m_total:list[i]['participant_total']*1,
                pwd_p_m_boy:list[i]['participant_pwd_boys']*1,
                pwd_p_m_girl:list[i]['participant_pwd_girls']*1,
                pwd_p_m_men:list[i]['participant_pwd_men']*1,
                pwd_p_m_women:list[i]['participant_pwd_women']*1,
                pwd_p_m_intersex:list[i]['participant_pwd_other_gender']*1,
                pwd_p_m_total:list[i]['participant_pwd_total']*1,
            }
            meetingObj.push(temp);
            alreadyExistEvent.push(list[i]['event_id'])
            
        }
    }
    



function approvePush(elId,elval){
    for(let i=0;i<alreadyExistEvent.length;i++){
        if(alreadyExistEvent[i][1]==elId){
            alreadyExistEvent[i][0]=elval
            if(eval==null){
                alreadyExistEvent[i][1]=null;
            }
            return;
        }
    }

    alreadyExistEvent.push([elval,elId])
}


function checkChange(e){
    if(e.hasAttribute('is_event_type')){
        if(alreadyExistEvent.find((val)=>(val[0] == e.value && val[1]!=e.id && val[0]!=null))){
            alert("Already added");
            e.value="";
            $("#"+e.id).select2();
        }else{
            approvePush(e.id,e.value);
            
        }

        
       
       
        
        
    }
}

$( document ).ready(function() {
    // $('#start_date_picker').datepicker({dateFormat: "dd-M-yy"});
    // $('#end_date_picker').datepicker({dateFormat: "dd-M-yy"});

    $(document).ready(function(){
      $("#start_date_picker").datepicker({
        "dateFormat": "dd-M-yy",
        "minDate": -7,
        "maxDate": new Date()
     })
   
      $("#end_date_picker").datepicker({
        "dateFormat": "dd-M-yy",
        "minDate": -7,
        "maxDate": new Date()
     })
    })

    addEventListener('keyup',(e)=>{
        if(e.target.hasAttribute('is_participent') && e.target.getAttribute('is_participent')){
            meetingObj[e.target.getAttribute("offset")]['p_m_boy']=document.getElementById(`p_b_${e.target.getAttribute("offset")}`).value;
            meetingObj[e.target.getAttribute("offset")]['p_m_girl']=document.getElementById(`p_g_${e.target.getAttribute("offset")}`).value;
            meetingObj[e.target.getAttribute("offset")]['p_m_men']=document.getElementById(`p_m_${e.target.getAttribute("offset")}`).value;
            meetingObj[e.target.getAttribute("offset")]['p_m_women']=document.getElementById(`p_w_${e.target.getAttribute("offset")}`).value;
            meetingObj[e.target.getAttribute("offset")]['p_m_intersex']=document.getElementById(`p_i_${e.target.getAttribute("offset")}`).value;


            document.getElementById(`p_t_${e.target.getAttribute("offset")}`).value=(meetingObj[e.target.getAttribute("offset")]['p_m_boy']*1)+(meetingObj[e.target.getAttribute("offset")]['p_m_girl']*1)+(meetingObj[e.target.getAttribute("offset")]['p_m_men']*1)+(meetingObj[e.target.getAttribute("offset")]['p_m_women']*1)+(meetingObj[e.target.getAttribute("offset")]['p_m_intersex']*1)
        }


        if(e.target.hasAttribute('is_pwd_participent') && e.target.getAttribute('is_pwd_participent')){
            meetingObj[e.target.getAttribute("offset")]['pwd_p_m_boy']=document.getElementById(`pwd_p_b_${e.target.getAttribute("offset")}`).value;
            meetingObj[e.target.getAttribute("offset")]['pwd_p_m_girl']=document.getElementById(`pwd_p_g_${e.target.getAttribute("offset")}`).value;
            meetingObj[e.target.getAttribute("offset")]['pwd_p_m_men']=document.getElementById(`pwd_p_m_${e.target.getAttribute("offset")}`).value;
            meetingObj[e.target.getAttribute("offset")]['pwd_p_m_women']=document.getElementById(`pwd_p_w_${e.target.getAttribute("offset")}`).value;
            meetingObj[e.target.getAttribute("offset")]['pwd_p_m_intersex']=document.getElementById(`pwd_p_i_${e.target.getAttribute("offset")}`).value;


            document.getElementById(`pwd_p_t_${e.target.getAttribute("offset")}`).value=(meetingObj[e.target.getAttribute("offset")]['pwd_p_m_boy']*1)+(meetingObj[e.target.getAttribute("offset")]['pwd_p_m_girl']*1)+(meetingObj[e.target.getAttribute("offset")]['pwd_p_m_men']*1)+(meetingObj[e.target.getAttribute("offset")]['pwd_p_m_women']*1)+(meetingObj[e.target.getAttribute("offset")]['pwd_p_m_intersex']*1)
        }
    })
    addEventListener('click',(e)=>{
        
        if(e.target.hasAttribute('rm_meeting_el')){
            e.preventDefault();
            $("#"+e.target.getAttribute('rm_meeting_el')).remove();
            //$("#"+e.target.getAttribute('rm_meeting_el')).remove();
            meetingObj[e.target.getAttribute('offset')-1]=null;
            approvePush(`evt_id_${e.target.getAttribute('offset')}`,null)
        }
       if(e.target.hasAttribute('el_type') && e.target.getAttribute('el_type')=="add_new_meeting"){
            e.preventDefault();
            let elTarget=(meetingObj.length+1)
            meetingObj.push({
                id:elTarget,
                p_m_boy:0,
                p_m_girl:0,
                p_m_men:0,
                p_m_women:0,
                p_m_intersex:0,
                p_m_total:0,
                pwd_p_m_boy:0,
                pwd_p_m_girl:0,
                pwd_p_m_men:0,
                pwd_p_m_women:0,
                pwd_p_m_intersex:0,
                pwd_p_m_total:0,
            });
            
            $("#meeting_container").append(`
            <div id="meeting_container_${elTarget}" class="m-bottom card-body">
                <div  class="m-top row">
                <div class="p-top p-left bg-color col-md-10">
                    <div class="row">
                        <div class=" col-md-3">
                            <label class="control-label"> Event name </label>
                            <select is_event_type="true" name="event_id[]" onchange="checkChange(this)" offset="${elTarget-1}" id="evt_id_${elTarget}" class=" form-control form-control-sm select2">
                                <option value="">Select event</option>
                                @foreach ($events as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="control-label"> No. of Events </label>
                            <input value="" type="number" class="margin-bottom form-control form-control-sm" name="no_of_event[]" id="panel_staff_workshop">
                            
                        </div>
                        <div class=" col-md-3">
                            <label class="control-label"> Starting Date </label>
                            <input autocomplete="off" id="end_date_${elTarget}" value="" type="text" placeholder="dd-mm-yy" class="date_picker margin-bottom form-control form-control-sm" name="starting_date[]" id="panel_staff_date">
                        </div>
                        <div class=" col-md-3">
                            <label class="control-label">Ending Date</label>
                            <input autocomplete="off" id="start_date_${elTarget}" value="" type="text" placeholder="dd-mm-yy" class="date_picker margin-bottom form-control form-control-sm" name="ending_date[]" id="panel_staff_date">
                        </div>
                        
                        {{-- Participents number container --}}
                        <br>
                        <div style="margin-left:10px" class="row">
                            <div class="form-group col-md-3" style="background: #667380;padding: 8px;color: white; margin-top:23px;margin-bottom: 30px; border-radius: 4px; font-size: 13px; text-align:center">
                                Participants
                            </div>
                            <div class="form-group col-md-1 community_awareness">
                                <label class="control-label">Boys</label>
                                <input is_participent="true" offset="${elTarget-1}" value="" type="number" class="form-control form-control-sm" name="participant_boys[]" id="p_b_${elTarget-1}">
                            </div>
                            <div class="form-group col-md-1 community_awareness">
                                <label class="control-label">Girls</label>
                                <input is_participent="true" offset="${elTarget-1}" value="" type="number" class="form-control form-control-sm" name="participant_girls[]" id="p_g_${elTarget-1}">
                            </div>
                            <div class="form-group col-md-1 community_awareness">
                                <label class="control-label">Men</label>
                                <input is_participent="true" offset="${elTarget-1}" value="" type="number" class="form-control form-control-sm" name="participant_men[]" id="p_m_${elTarget-1}">
                            </div>
                            <div class="form-group col-md-1 community_awareness">
                                <label class="control-label">Women</label>
                                <input is_participent="true" offset="${elTarget-1}" value="" type="number" class="form-control form-control-sm" name="participant_women[]" id="p_w_${elTarget-1}">
                            </div>
                            <div class="form-group col-md-2 community_awareness">
                                <label class="control-label">Other Gender</label>
                                <input is_participent="true" offset="${elTarget-1}" value="" type="number" class="form-control form-control-sm" name="participant_other_gender[]" id="p_i_${elTarget-1}">
                            </div>
                            <div class="form-group col-md-2 community_awareness">
                                <label class="control-label">Total</label>
                                <input offset="${elTarget-1}" value="" type="number" class="form-control form-control-sm" name="participant_total[]" id="p_t_${elTarget-1}" readonly>
                            </div>
                            
                        </div>
                        
                        <div style="margin-left:10px" class="row">
                            <div class="form-group col-md-3" style="background: #667380;padding: 8px;color: white; margin-top:23px;margin-bottom: 30px; border-radius: 4px; font-size: 13px; text-align:center">
                                Persons With Disabilities (PWD)
                            </div>
                            <div class="form-group col-md-1 community_awareness">
                                <label class="control-label">Boys</label>
                                <input is_pwd_participent="true" offset="${elTarget-1}" value="" type="number" class="form-control form-control-sm" name="participant_pwd_boys[]" id="pwd_p_b_${elTarget-1}">
                            </div>
                            <div class="form-group col-md-1 community_awareness">
                                <label class="control-label">Girls</label>
                                <input is_pwd_participent="true" offset="${elTarget-1}" value="" type="number" class="form-control form-control-sm" name="participant_pwd_girls[]" id="pwd_p_g_${elTarget-1}">
                            </div>
                            <div class="form-group col-md-1 community_awareness">
                                <label class="control-label">Men</label>
                                <input is_pwd_participent="true" offset="${elTarget-1}" value="" type="number" class="form-control form-control-sm" name="participant_pwd_men[]" id="pwd_p_m_${elTarget-1}">
                            </div>
                            <div class="form-group col-md-1 community_awareness">
                                <label class="control-label">Women</label>
                                <input is_pwd_participent="true" offset="${elTarget-1}" value="" type="number" class="form-control form-control-sm" name="participant_pwd_women[]" id="pwd_p_w_${elTarget-1}">
                            </div>
                            <div class="form-group col-md-2 community_awareness">
                                <label class="control-label">Other Gender</label>
                                <input is_pwd_participent="true" offset="${elTarget-1}" value="" type="number" class="form-control form-control-sm" name="participant_pwd_other_gender[]" id="pwd_p_i_${elTarget-1}">
                            </div>
                            <div class="form-group col-md-2 community_awareness">
                                <label class="control-label">Total</label>
                                <input is_pwd_participent="true" offset="${elTarget-1}" value="" type="number" class="form-control form-control-sm" name="participant_pwd_total[]" id="pwd_p_t_${elTarget-1}" readonly>
                            </div>
                        </div>
                    </div>
                    
                </div>
        
                <div class="col-md-2">
                    <a href="#"  style="display:inline-block" el_type="add_new_meeting" class="fa fa-plus btn btn-lg btn-info"></a>
                    <a href="#" offset="${elTarget}" rm_meeting_el="meeting_container_${elTarget}"  style="display:inline-block"  class="fa fa-minus btn btn-lg btn-danger"></a>
                    
                </div>
        
                </div>
            </div>    
            `);
            // $(`#start_date_${elTarget}`).datepicker({dateFormat: "dd-M-yy"});
            // $(`#end_date_${elTarget}`).datepicker({dateFormat: "dd-M-yy"});
            $(`#evt_id_${elTarget}`).select2();

            $(`#start_date_${elTarget}`).datepicker({
                "dateFormat": "dd-M-yy",
                "minDate": -7,
                "maxDate": new Date()
            });
            $(`#end_date_${elTarget}`).datepicker({
                "dateFormat": "dd-M-yy",
                "minDate": -7,
                "maxDate": new Date()
            });
        }
    })
});
</script>