<form method="post" action="{{ route('incident.selp.step-6') }}">
    @csrf
    <input type="hidden" name="selp_incident_ref" value="{{ request()->selp_incident_ref }}">
    <input type="hidden" name="tab" value="3">
    <input type="hidden" name="step" value="6">
    <div class="form-row">
        <div class="form-group col-md-12">
            <p><strong><u>1. Survivor's previous violence history </u></strong></p>
        </div>
        <div class="form-group col-sm-3">
            <label class="control-label">Have you ever face any violence ? </label>
            <select name="have_survivor_face_violence_before" id="face_violence" class="form-control form-control-sm">
                <option value="">-- Select --</option>
                <option
                    {{ count($selpIncident) > 0 && $selpIncident[0]->have_survivor_face_violence_before == 1 ? 'selected' : '' }}
                    value="1"> Yes</option>
                <option
                    {{ count($selpIncident) > 0 && $selpIncident[0]->have_survivor_face_violence_before == 2 ? 'selected' : '' }}
                    value="2"> No</option>
            </select>
        </div>
    </div>
    <div class="row face_violence_yes"
        style="{{ count($selpIncident) > 0 && $selpIncident[0]->have_survivor_face_violence_before == 1 ? '' : 'display:none' }}">
        <div class="form-group col-sm-3">
            <label class="control-label">At what age </label>
            <input type="text"
                value="{{ count($selpIncident) > 0 ? $selpIncident[0]->survivor_first_face_violence_age : '' }}"
                name="survivor_first_violence_age" value="" id="survivor_name"
                class="form-control form-control-sm">
        </div>
        {{-- <div class="form-group col-sm-3" style="margin-top: -7px;">
      <label class="control-label">If yes, what type of violence was that (multiple answers from dropdown) </label>
      <select name="type_of_violence_was_yes_or_no" id="division_id" class="division_id form-control form-control-sm">
        <option value="">-- Select --</option>
        <option {{count($selpIncident)>0 && $selpIncident[0]->type_of_violence_was_yes_or_no==1 ? "selected" : ''}}  value="1"> Yes</option>
        <option {{count($selpIncident)>0 && $selpIncident[0]->type_of_violence_was_yes_or_no==2 ? "selected" : ''}}  value="2"> No</option>
      </select>
    </div> --}}
        <div class="form-group col-md-4">
            @php
                $allViolence = @$selpIncident[0]->survivor_first_face_violence_type;
                $volenceArray = explode(',', $allViolence);
            @endphp
            <label class="control-label">Previous types of disputes (Multiple selection) </label>
            <select style="width:100%;" name="violence_type_multiple_list[]" id="" multiple="multiple"
                class="form-control form-control-sm select2">
                @foreach ($previousViolenceCategory as $reason)
                    <option value="{{ $reason->id }}"
                        {{ @$volenceArray ? (in_array($reason->id, $volenceArray) ? 'selected' : '') : '' }}>
                        {{ $reason->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-sm-4">
            <label class="control-label">Did you seek support from BRAC for that? </label>
            <select name="survivor_seek_support_from_brac" id="survivor_seek_support_from_brac"
                class="division_id form-control form-control-sm">
                <option value="">-- Select --</option>
                <option
                    {{ count($selpIncident) > 0 && $selpIncident[0]->survivor_seek_support_from_brac == 1 ? 'selected' : '' }}
                    value="1"> Yes</option>
                <option
                    {{ count($selpIncident) > 0 && $selpIncident[0]->survivor_seek_support_from_brac == 2 ? 'selected' : '' }}
                    value="2"> No</option>
            </select>
        </div>
        <div class="form-group col-sm-4 from_brac"
            style="{{ (count($selpIncident) > 0 && $selpIncident[0]->brac_supporttype_id == 0) || (isset($selpIncident[0]) && $selpIncident[0]->brac_supporttype_id == null) ? 'display:none' : '' }}">
            <label class="control-label">What support did you receive from BRAC? </label>
            <select name="bracsupporttype_id" id="division_id" class="division_id form-control form-control-sm">
                <option value="">-- Select --</option>
                @foreach ($bracSupport as $support)
                    <option
                        {{ count($selpIncident) > 0 && $selpIncident[0]->brac_supporttype_id == $support->id ? 'selected' : '' }}
                        value="{{ $support->id }}">{{ $support->title }}</option>
                @endforeach
            </select>
        </div>
    </div>
    </div>

    <br>
    <div class="form-row" style="float: right">
        <a href="{{ route('incident.selp.add', ['tab' => 2, 'step' => 5, 'selp_incident_ref' => request()->selp_incident_ref]) }}"
            class="btn btn-success submit text-white mr-1">Back</a>
        {{-- <button type="submit" class="btn btn-info submit text-white mr-1">Save & Next</button>
  <button type="submit" class="btn btn-primary submit text-white mr-1">Save & Close</button> --}}
        @if ($user_info['user_role'][0]['role_id'] == 4 || $user_info['user_role'][0]['role_id'] == 1 || $user_info['user_role'][0]['role_id'] == 12)
            <button type="submit" name="save_destroy" class="btn btn-warning final text-white mr-1" onClick="this.form.submit(); this.disabled=true; this.innerHTML='Sending…';">Approve</button>
            <input type="hidden" name="dm_approve" value="2">
        @else
            <button type="submit" name="save_destroy" class="btn btn-warning final text-white mr-1" onClick="this.form.submit(); this.disabled=true; this.innerHTML='Sending…';">Submit</button>
        @endif
    </div>
</form>
<script>
    $(document).ready(function() {
        $("#section_A").show();
        $("#section_B").show();
    });

    $(document).ready(function() {
        $("#survivor_seek_support_from_brac").change(function() {
            var from_brac = $("#survivor_seek_support_from_brac").val();
            if (from_brac == 1) {
                $(".from_brac").show();
            } else {
                $(".from_brac").hide();
            }
        });
    });

    $(document).ready(function() {
        $("#face_violence").change(function() {
            var face_violence = $("#face_violence").val();
            if (face_violence == 1) {
                $(".face_violence_yes").show();
            } else if (face_violence == 2) {
                $(".face_violence_yes").hide();
            } else {
                $(".face_violence_yes").hide();
            }
        });
    });
</script>
