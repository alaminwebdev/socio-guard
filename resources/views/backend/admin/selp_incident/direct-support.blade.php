@if (count($selpIncident) > 0 && count($selpIncident[0]->survivordirectservice) >0)
    @foreach ($selpIncident[0]->survivordirectservice as $key=>$item)
        <div style="{{count($selpIncident)>0 && $selpIncident[0]->direct_service_type==3 ? "" : 'display: none;'}}" class="col-md-12 adr_support">
            <div class="row adr_support_multi">
            <div class="col-md-3">
                <label class="control-label" style="font-size: 12px;">Alternative Dispute Resolution (ADR) </label>
                <select name="selp_alternative_dispute_resolution[]" id="selp_adr" class="form-control form-control-sm">
                <option value="">-- Select --</option>
                @foreach($adrs as $adr)
                    <option {{count($selpIncident)>0 && $item->alternative_dispute_resolution_id==$adr->id ? "selected" : ''}} value="{{ $adr->id }}">{{ $adr->title }}</option>
                @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="control-label"> Starting Date </label>
                <input type="date" name="selp_support_start_date[]" value="{{$item->starting_date}}" id="" class="form-control form-control-sm">
            </div>
            <div class="col-md-3">
                <label class="control-label"> Closing Date </label>
                <input type="date" name="selp_support_closing_date[]" value="{{$item->closing_date}}" id="" class="form-control form-control-sm">
            </div>
            <div class="form-group col-sm-3">
                <i style="margin-top:23px" class="fa fa-plus btn btn-sm btn-info" onclick="adrAdd($(this));"></i>
                <i style="margin-top:23px" class="fa fa-minus btn btn-sm btn-danger btn-remove {{$key==0 ? "d-none" : ''}}" data-type="delete" onclick="adrRemove($(this));"></i>
            </div>
            </div>
            <div class="extra_adr_support_multi"></div>
        </div>
    @endforeach
@else
    <div class="col-md-12 adr_support" style="{{count($selpIncident)>0 && ( $selpIncident[0]->direct_service_type==3 ||$selpIncident[0]->direct_service_type==4) ? "" : "display:none" }}">
        <div class="row adr_support_multi">
        <div class="col-md-3">
            <label class="control-label" style="font-size: 12px;">Alternative Dispute Resolution (ADR) </label>
            <select name="selp_alternative_dispute_resolution[]" id="selp_adr" class="form-control form-control-sm">
            <option value="">-- Select --</option>
            @foreach($adrs as $adr)
            <option value="{{ $adr->id }}">{{ $adr->title }}</option>
            @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="control-label"> Starting Date </label>
            <input type="date" name="selp_support_start_date[]" value="" id="" class="form-control form-control-sm">
        </div>
        <div class="col-md-3">
            <label class="control-label"> Closing Date </label>
            <input type="date" name="selp_support_closing_date[]" value="" id="" class="form-control form-control-sm">
        </div>
        <div class="form-group col-sm-3">
            <i style="margin-top:23px" class="fa fa-plus btn btn-sm btn-info" onclick="adrAdd($(this));"></i>
            <i style="margin-top:23px" class="fa fa-minus btn btn-sm btn-danger btn-remove d-none" data-type="delete" onclick="adrRemove($(this));"></i>
        </div>
        </div>
        <div class="extra_adr_support_multi"></div>
    </div>
@endif

<script>
    function adrAdd(item) 
      {
        // alert("clicked");
          var extra_adr_support_multi = item.closest('.adr_support_multi').clone();
          console.log(extra_adr_support_multi);
          extra_adr_support_multi.find('.btn-remove').removeClass('d-none');
          extra_adr_support_multi.find('input, select').each(function() {
              $(this).val('');
          });
  
          item.closest('.adr_support').find('.extra_adr_support_multi').append(extra_adr_support_multi);
      }
  
      function adrRemove(item) 
      {
          item.closest('.adr_support_multi').remove();
      }  
  </script>
