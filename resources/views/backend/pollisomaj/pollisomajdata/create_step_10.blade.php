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

    .extra_region_area_info > .region_area_info{
        padding:10px 0px;
        margin-bottom: 10px;
    }
    .card-bg{
        background: #ede5e5;
    }
    .card_body_style{
        background: black;
        color:white;
        margin-bottom:10px;
    }
    .section-container{
        box-shadow: 0px 0px 3px 0px;
        margin-bottom: 15px;
        padding: 7px;
    }
    .margin-bottom{
        margin: 10px 0px;
    }
    .w-100{
        width:100%
    }
    
</style>

<form action="{{route('data.pollisomaj.add_step_10',['step'=>1])}}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="pollisomaj_ref_id" value="{{   $pollisomajData[0]->pollisomaj_data_ref }}">
<div class="card custom-card-style">
    <div class="card-header">
        15. No.of Production workshop
    </div>
    <div class="card-body">
        <div class="row">
            <div class="form-group col-md-2">
                <label class="control-label">Production workshop (SPA)</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->production_workshop_spa : ''}}" type="number" class="form-control form-control-sm" name="production_workshop_spa" id="">
            </div>
            <div class="form-group col-md-2">
                <label class="control-label">Production workshop (Cost recovery)</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->production_workshop_cost_recovery : ''}}" type="number" class="form-control form-control-sm" name="production_workshop_cost_recovery" id="">
            </div>
            <div class="form-group col-md-2">
                <label class="control-label">Production workshop (Project)</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->production_workshop_project : ''}}" type="number" class="form-control form-control-sm" name="production_workshop_project" id="">
            </div>
            <div class="form-group col-md-2">
                <label class="control-label">Production workshop (Special)</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->production_workshop_special : ''}}" type="number" class="form-control form-control-sm" name="production_workshop_special" id="">
            </div>
            <div class="form-group col-md-2">
                <label class="control-label">Production workshop (Others)</label>
                <input value="{{count($pollisomajData)>0 ? $pollisomajData[0]->production_workshop_other : ''}}" type="number" class="form-control form-control-sm" name="production_workshop_other" id="">
            </div>
        </div>
    </div>
</div>        

@include('backend.pollisomaj.pollisomajdata.theatre')      


 
<div  class="text-right">
   <a href="{{route('data.pollisomaj.add',['step'=>9,'pollisomaj_ref_id' => $pollisomajData[0]->pollisomaj_data_ref])}}" class="btn btn-success" >Back</a>
   {{-- <a href="#" class="btn  btn-warning" >Save & Draft</a> --}}
   <input type="submit"  name="save_destroy" class="btn btn-primary"  value="{{isset( $auth_user->user_role[0]['role_id']) && ($auth_user->user_role[0]['role_id']==4) ? "Approve" : "Submit" }}">
   <a href="{{route('incident.pollisomaj.viewpollisomajlist')}}" class="btn  btn-danger" >Cancel</a>
</div>
</form>
<script>
    $( function() {
      $( ".date_picker" ).datepicker({
        dateFormat:"d-M-yy",
       });
    } );
</script>

<script>
    function add(item) 
      {
          
          var extra_region_area_info = item.closest('.region_area_info').clone();
        console.log(extra_region_area_info);
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