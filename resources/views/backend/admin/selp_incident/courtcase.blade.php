
<style>
  .margin-padding{
    padding-right: 10px;
    padding-left: 10px;
  }
</style>

@if (count($selpIncident) > 0 && count($selpIncident[0]->selpcourtcasesupport) >0)
<div class="form-group col-md-12">
  <p><strong><u>5. Court Case : </u></strong></p>
</div>
    @foreach ($selpIncident[0]->selpcourtcasesupport as $key=>$item)
    <div class="margin-padding form-row if_direct_support">
        <div class="col-md-12 court_case_support">
          <div class="row court_case_support_multi">
            <div class="form-group col-sm-2">
              <label class="control-label"> Case Type </label>
              <select name="case_type[]" id="case_type" class="form-control form-control-sm">
                <option value="">-- Select --</option>
                <option {{count($selpIncident)>0 && $item->case_type==1 ? "selected" : ''}} value="1"> Civil cases </option>
                <option {{count($selpIncident)>0 && $item->case_type==2 ? "selected" : ''}} value="2"> GR/Police Case </option>
                <option {{count($selpIncident)>0 && $item->case_type==3 ? "selected" : ''}} value="3"> CR/Petition Case </option>
              </select>
            </div>
            <div class="form-group col-sm-2" style="">
              <label class="control-label"> Case Status </label>
              <select name="court_case_id[]" id="case_type_list" class="form-control form-control-sm">
                <option value="">-- Select --</option>
                @foreach($civilCase as $civil)
                    <option {{count($selpIncident)>0 && $item->court_case_id==$civil->id ? "selected" : ''}} value="{{ $civil->id }}">{{ $civil->title }}</option>
                @endforeach
              </select>
            </div>
            {{-- <div class="form-group col-sm-2" style="display: none;">
              <label class="control-label"> GR/Police Case </label>
              <select name="policecase_id[]" id="" class="form-control form-control-sm">
                <option value="">-- Select --</option>
                @foreach($policeCase as $police)
                <option value="{{ $police->id }}">{{ $police->title }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group col-sm-2" style="display: none;">
              <label class="control-label"> CR/Petition Case </label>
              <select name="pititioncase_id[]" id="" class="form-control form-control-sm">
                <option value="">-- Select --</option>
                @foreach($petitionCase as $petition)
                <option value="{{ $petition->id }}">{{ $petition->title }}</option>
                @endforeach
              </select>
            </div> --}}
            <div class="form-group col-sm-3">
              <label class="control-label" style="font-size: 12px;"> Money recovered through court case </label>
              <select name="court_case_moneyrecover_id[]" id="division_id" class="division_id form-control form-control-sm">
                <option value="">-- Select --</option>
                @foreach($moneyRecoverCourteCase as $CourteCase)
                    <option {{count($selpIncident)>0 && $item->moneyrecover_case_id==$CourteCase->id ? "selected" : ''}} value="{{ $CourteCase->id }}">{{ $CourteCase->title }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group col-sm-2">
              <label class="control-label"> Judgment/Installment Status </label>
              <select name="judgementstatus_id[]" id="division_id" class="division_id form-control form-control-sm">
                <option value="">-- Select --</option>
                @foreach($judgementStatus as $status)
                    <option {{count($selpIncident)>0 && $item->judjementstatus_id==$status->id ? "selected" : ''}} value="{{ $status->id }}">{{ $status->title }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group col-sm-2">
              <label class="control-label"> Starting Date </label>
              <input type="date" value="{{$item->case_start_date}}" name="case_start_date[]" value="" id="" class="form-control form-control-sm">
            </div>
            <div class="form-group col-sm-2">
              <label class="control-label"> Judgment/Installment date </label>
              <input type="date" value="{{$item->case_judjement_date}}" name="judgement_date[]" value="" id="" class="form-control form-control-sm">
            </div>
            <div class="form-group col-sm-2">
              <i style="margin-top:23px" class="fa fa-plus btn btn-sm btn-info" onclick="add($(this));"></i>
              <i style="margin-top:23px" class="fa fa-minus btn btn-sm btn-danger btn-remove {{$key==0 ? "d-none" : ''}}" data-type="delete" onclick="remove($(this));"></i>
            </div>
          </div>
        
          <div class="court_case_extra"></div>
      </div>
      </div>
    @endforeach
@else
<div class="margin-padding form-row if_direct_support ">
    <div class="form-group col-md-12 ">
      <p><strong><u>5. Court Case : </u></strong></p>
    </div>
    <div class="col-md-12 court_case_support">
      <div class="row court_case_support_multi">
        <div class="form-group col-sm-2">
          <label class="control-label"> Case Type </label>
          <select name="case_type[]" id="case_type" class="form-control form-control-sm">
            <option value="">-- Select --</option>
            <option value="1"> Civil cases </option>
            <option value="2"> GR/Police Case </option>
            <option value="3"> CR/Petition Case </option>
          </select>
        </div>
        <div class="form-group col-sm-2" style="">
          <label class="control-label"> Case Status </label>
          <select name="court_case_id[]" id="case_type_list" class="form-control form-control-sm">
            <option value="">-- Select --</option>
            @foreach($civilCase as $civil)
            <option value="{{ $civil->id }}">{{ $civil->title }}</option>
            @endforeach
          </select>
        </div>
        {{-- <div class="form-group col-sm-2" style="display: none;">
          <label class="control-label"> GR/Police Case </label>
          <select name="policecase_id[]" id="" class="form-control form-control-sm">
            <option value="">-- Select --</option>
            @foreach($policeCase as $police)
            <option value="{{ $police->id }}">{{ $police->title }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group col-sm-2" style="display: none;">
          <label class="control-label"> CR/Petition Case </label>
          <select name="pititioncase_id[]" id="" class="form-control form-control-sm">
            <option value="">-- Select --</option>
            @foreach($petitionCase as $petition)
            <option value="{{ $petition->id }}">{{ $petition->title }}</option>
            @endforeach
          </select>
        </div> --}}
        <div class="form-group col-sm-3">
          <label class="control-label" style="font-size: 12px;"> Money recovered through court case </label>
          <select name="court_case_moneyrecover_id[]" id="division_id" class="division_id form-control form-control-sm">
            <option value="">-- Select --</option>
            @foreach($moneyRecoverCourteCase as $CourteCase)
            <option value="{{ $CourteCase->id }}">{{ $CourteCase->title }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group col-sm-2">
          <label class="control-label"> Judgment/Installment Status </label>
          <select name="judgementstatus_id[]" id="division_id" class="division_id form-control form-control-sm">
            <option value="">-- Select --</option>judgementStatus
            @foreach($judgementStatus as $status)
            <option value="{{ $status->id }}">{{ $status->title }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group col-sm-2">
          <label class="control-label"> Starting Date </label>
          <input type="date" name="case_start_date[]" value="" id="" class="form-control form-control-sm">
        </div>
        <div class="form-group col-sm-2">
          <label class="control-label"> Judgment/Installment date </label>
          <input type="date" name="judgement_date[]" value="" id="" class="form-control form-control-sm">
        </div>
        <div class="form-group col-sm-2">
          <i style="margin-top:23px" class="fa fa-plus btn btn-sm btn-info" onclick="add($(this));"></i>
          <i style="margin-top:23px" class="fa fa-minus btn btn-sm btn-danger btn-remove d-none" data-type="delete" onclick="remove($(this));"></i>
        </div>
      </div>
    
      <div class="court_case_extra"></div>
  </div>
  </div>
@endif

<script>
  function add(item) 
    {
      // alert("clicked");
        var court_case_extra = item.closest('.court_case_support_multi').clone();
        console.log(court_case_extra);
        court_case_extra.find('.btn-remove').removeClass('d-none');
        court_case_extra.find('input, select').each(function() {
            $(this).val('');
        });

        item.closest('.court_case_support').find('.court_case_extra').append(court_case_extra);
    }

    function remove(item) 
    {
        item.closest('.court_case_support_multi').remove();
    }  
</script>
