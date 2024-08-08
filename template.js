let template=`
    <div class="form-group col-sm-3">
        <label class="control-label">No.of follow up made by SELP staff </label>
        <select name="no_of_followup_madeby_selp_staff" id="division_id" class="division_id form-control form-control-sm">
            <option value="">-- Select --</option>
            <option value="1"> First Time </option>
            <option value="2"> Second Time </option>
            <option value="3"> Third Time </option>
        </select>
    </div>
    <div class="form-group col-sm-3">
        <label class="control-label" style="font-size: 12px;">Programme participants followed up </label>
        <select name="program_participent_followup" id="division_id" class="division_id form-control form-control-sm">
            <option value="">-- Select --</option>
            <option  value="1"> Physically/ In-person</option>
            <option  value="2"> Online</option>
        </select>
    </div>
    <div class="form-group col-sm-3">
        <label class="control-label">Findings from follow up </label>
        <select name="followup_id" id="division_id" class="division_id form-control form-control-sm">
            <option value="">-- Select --</option>
            @foreach($findingsFromFollowUp as $FollowUp)
            <option  value="{{ $FollowUp->id }}">{{ $FollowUp->title }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-sm-3">
        <label class="control-label">Follow Up Date </label>
        <input type="date" name="followup_date" value="{{count($selpIncident)>0  ? $selpIncident[0]->followup_date : ''}}" id="" class="form-control form-control-sm">
    </div>`