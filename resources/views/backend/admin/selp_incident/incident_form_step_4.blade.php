@php
    if (@$selpIncident[0]->types_of_disputes->name) {
        $moneyRecoverCourteCase = \App\Model\Moneyrecover::where('status', 1)
            ->where('title', 'like', '%' . @$selpIncident[0]->types_of_disputes->name . '%')
            ->get();
    } else {
        $moneyRecoverCourteCase = \App\Model\Moneyrecover::where('status', 1)->get();
    }

    $arr = [];
    $directServiceType = \App\Model\DirectServiceType::where('selp_incident_ref', request()->selp_incident_ref)
        ->get()
        ->toArray();
    $adrSupport = \App\Model\SurvivorDirectServiceModel::where('selp_incident_ref', request()->selp_incident_ref)
        ->get()
        ->toArray();
    $caseSupport = \App\Model\SurvivorCourtCaseModel::where('selp_incident_ref', request()->selp_incident_ref)
        ->get()
        ->toArray();

    $adrCourtCaseFlag = ['adrList' => null, 'caseList' => null];

    if (count($directServiceType) > 0) {
        for ($i = 0; $i < count($directServiceType); $i++) {
            if ($directServiceType[$i]['service_type_id'] == 3) {
                array_push($arr, [
                    'id' => $directServiceType[$i]['id'],
                    'val' => $directServiceType[$i]['service_type_id'],
                    'date' => $directServiceType[$i]['service_date'],
                    'adrList' => [],
                ]);

                $adrCourtCaseFlag['adrList'] = $i;
                continue;
            }

            if ($directServiceType[$i]['service_type_id'] == 4) {
                array_push($arr, [
                    'id' => $directServiceType[$i]['id'],
                    'val' => $directServiceType[$i]['service_type_id'],
                    'date' => $directServiceType[$i]['service_date'],
                    'caseList' => [],
                ]);

                $adrCourtCaseFlag['caseList'] = $i;
                continue;
            }

            array_push($arr, [
                'id' => $directServiceType[$i]['id'],
                'val' => $directServiceType[$i]['service_type_id'],
                'date' => $directServiceType[$i]['service_date'],
                'receive_money' => $directServiceType[$i]['receive_money'],
            ]);
        }
    } else {
        $arr = [['val' => '', 'date' => '']];
    }

    if (count($adrSupport) > 0 && count($directServiceType) > 0) {
        for ($i = 0; $i < count($adrSupport); $i++) {
            if (isset($arr[$adrCourtCaseFlag['adrList']]['adrList'])) {
                array_push($arr[$adrCourtCaseFlag['adrList']]['adrList'], [
                    'visibility'    => false,
                    'id'            => $adrSupport[$i]['id'],
                    'ending_date'   => $adrSupport[$i]['closing_date'],
                    'starting_date' => $adrSupport[$i]['starting_date'],
                    'val'           => $adrSupport[$i]['alternative_dispute_resolution_id'],
                    'money_recovered_through_adr'       => $adrSupport[$i]['money_recovered_through_adr'],
                    'amount_of_money_received'          => $adrSupport[$i]['amount_of_money_received'],
                    'no_of_adr_participants_benefited'  => $adrSupport[$i]['no_of_adr_participants_benefited'],
                ]);
            }
        }
    }

    if (count($caseSupport) > 0 && count($directServiceType) > 0) {
        for ($i = 0; $i < count($caseSupport); $i++) {
            if (isset($arr[$adrCourtCaseFlag['caseList']]['caseList'])) {
                array_push($arr[$adrCourtCaseFlag['caseList']]['caseList'], [
                    'visibility'    => false,
                    'id'            => $caseSupport[$i]['id'],
                    'case_status'   => $caseSupport[$i]['court_case_id'],
                    'jd_date'       => $caseSupport[$i]['case_judjement_date'],
                    'jd_status'     => $caseSupport[$i]['judjementstatus_id'],
                    'money_recover' => $caseSupport[$i]['moneyrecover_case_id'],
                    'starting_date' => $caseSupport[$i]['case_start_date'],
                    'val'           => $caseSupport[$i]['case_type'],
                    'case_type'     => $caseSupport[$i]['case_type'],
                    'amount_of_money_received'          => $caseSupport[$i]['amount_of_money_received'],
                    'no_of_case_participants_benefited' => $caseSupport[$i]['no_of_case_participants_benefited'],
                ]);
            }
        }
    }

@endphp
<meta name="services" content="{{ json_encode($arr) }}">

<form method="post" action="{{ route('incident.selp.step-4') }}" id="directServiceForm">
    @csrf
    <input type="hidden" name="selp_incident_ref" value="{{ request()->selp_incident_ref }}">
    <input type="hidden" name="tab" value="2">
    <input type="hidden" name="step" value="5">

    <div class="form-row">
        <div class="form-group col-md-12">
            <p><strong><u>3. Status of initiative taken for this complaint : </u></strong></p>
        </div>
        <div class="form-group col-sm-4">
            <label class="control-label" style="height: 45px;">Any initiatives taken by survivors earlier for this dispute </label>

            <select name="earlier_survivor_initiative" id="initiative_taken" class="form-control form-control-sm">
                <option value="">-- Select --</option>
                <option {{ (count($selpIncident) > 0 && $selpIncident[0]->earlier_survivor_initiative == 1) || old('earlier_survivor_initiative') == 1 ? 'selected' : '' }} value="1"> Yes </option>
                <option {{ (count($selpIncident) > 0 && $selpIncident[0]->earlier_survivor_initiative == 2) || old('earlier_survivor_initiative') == 2 ? 'selected' : '' }} value="2"> No </option>
            </select>
        </div>

        <div class="form-group col-sm-4 initiative_yes" style="{{ (count($selpIncident) > 0 && $selpIncident[0]->earlier_survivor_initiative == 1) || old('earlier_survivor_initiative') == 1 ? '' : 'display:none' }}">
            <label class="control-label" style="height: 45px;">If Yes where??</label>
            <select name="earlier_survivor_initiative_place" id=" " class="form-control form-control-sm">
                <option value="">-- Select --</option>
                @foreach ($survivorInitiatives as $initiative)
                    <option {{ count($selpIncident) > 0 && $selpIncident[0]->earlier_survivor_initiative_place == $initiative->id ? 'selected' : '' }} value="{{ $initiative->id }}">{{ $initiative->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-sm-4 initiative_yes" style="{{ (count($selpIncident) > 0 && $selpIncident[0]->earlier_survivor_initiative == 1) || old('earlier_survivor_initiative') == 1 ? '' : 'display:none' }}">
            <label class="control-label" style="height: 45px;">Causes of failure/coming to SELP <span class="text-danger">*</span></label>
            <select name="cause_of_failour_coming_to_selp" id="" class="form-control form-control-sm @error('cause_of_failour_coming_to_selp') is-invalid @enderror">
                <option value="">-- Select --</option>
                @foreach ($selpFailour as $failour)
                    <option {{ (count($selpIncident) > 0 && $selpIncident[0]->case_of_failour_coming_to_selp == $failour->id) || old('cause_of_failour_coming_to_selp') == $failour->id ? 'selected' : '' }} value="{{ $failour->id }}">{{ $failour->title }}</option>
                @endforeach.
            </select>
            @error('cause_of_failour_coming_to_selp')
                <p style="color:red; margin-top:5px;">This field is required</p>
            @enderror
        </div>
    </div>

    <div class="direct_support">
        <div class="">
            <p><strong><u>4. Detail of direct services : </u></strong></p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div id="service_data_container" class="row direct_multi_support_area">

        </div>

        <div class="form-group col-sm-3 through_adr" style="display: none;">
            <label class="control-label">If Money recovered through ADR </label>
            <select name="selp_adrmoneyrecover" id="" class="form-control form-control-sm if_money_recovered">
                <option value="">-- Select --</option>
                <option value="1"> Yes </option>
                <option value="2"> No </option>
            </select>
        </div>

        <div class="form-group col-sm-3 from_adr" style="display: none;">
            <label class="control-label"> Amount of Money from ADR </label>
            <input type="text" name="selp_amount_of_money_from_adr" value="" id="" class="form-control form-control-sm">
        </div>

        <div class="form-group col-sm-3 no_benify" style="display: none;">
            <label class="control-label"> No. of Boys </label>
            <input type="text" name="money_from_adr_boy" value="" id="" class="form-control form-control-sm">
        </div>

        <div class="form-group col-sm-3 no_benify" style="display: none;">
            <label class="control-label"> No. of Girls </label>
            <input type="text" name="money_from_adr_girl" value="" id="" class="form-control form-control-sm">
        </div>

        <div id="adr_service_container">
            {{-- @include('backend.admin.selp_incident.direct-support') --}}
        </div>

        <div id="court_case_container" class="court_case" style="{{ count($selpIncident) > 0 && $selpIncident[0]->direct_service_type == 4 ? '' : 'display: none;' }}">
            {{-- @include('backend.admin.selp_incident.courtcase') --}}
        </div>

        <div id="multi_suport_container" class="row col-md-12 direct_multi_support_extra_area">

        </div>

    </div>
    <br>
    <div class="form-row" style="float: right">
        <a href="{{ route('incident.selp.add', ['tab' => 2, 'step' => 3, 'selp_incident_ref' => request()->selp_incident_ref]) }}" class="btn btn-sm btn-success submit text-white mr-1">Back</a>
        <button type="submit" class="btn btn-sm btn-info submit text-white mr-1">Save & Next</button>
        @if ($user_info['user_role'][0]['role_id'] == 4)
            <button type="submit" name="save_destroy" class="btn btn-sm btn-primary submit text-white mr-1">Close</button>
        @else
            <button type="submit" name="save_destroy" class="btn btn-sm btn-primary submit text-white mr-1" >Draft & Close</button>
        @endif
        {{-- <button type="submit" name="save_destroy" class="btn btn-sm btn-warning final text-white mr-1 d-none" >Submit</button> --}}
    </div>
</form>
<script>
    // function directSupportAdd(item) 
    //   {
    //     // alert("clicked");
    //     return;
    //       var direct_multi_support_extra_area = item.closest('.direct_multi_support_area').clone();
    //       direct_multi_support_extra_area.find('.btn-remove').removeClass('d-none');
    //       direct_multi_support_extra_area.find('input, select').each(function() {
    //           $(this).val('');
    //       });

    //       item.closest('.direct_support').find('.direct_multi_support_extra_area').append(direct_multi_support_extra_area);
    //   }

    function directSupportRemove(item) {
        item.closest('.direct_multi_support_area').remove();
    }
</script>


<script>
    let services = JSON.parse($('meta[name="services"]').attr('content'));
    let userRoles = {!! json_encode(auth()->user()->user_role->pluck('role_id')->toArray()) !!};

    function adrAdd(item) {
        services[item.getAttribute('parent_idx')]['adrList'].push({
            'val': '',
            'no_of_adr_participants_benefited': '',
            'money_recovered_through_adr': '',
            'amount_of_money_received': '',
            'starting_date': '',
            'ending_date': ''
        });
        renderHtml(services);
        datepickerload();
    }

    function adrRemove(item) {
        services[item.getAttribute('parent_idx')]['adrList'].splice(item.getAttribute('idx'), 1)
        renderHtml(services);
    }

    function addCase(item) {
        services[item.getAttribute('parent_idx')]['caseList'].push({
            'val': '',
            'no_of_case_participants_benefited': '',
            'amount_of_money_received': '',
            'case_status': '',
            'starting_date': '',
            'jd_date': '',
            'money_recover': '',
            'jd_status': '',
            'case_type': null
        });
        renderHtml(services);
        datepickerload();
    }

    function removeCase(item) {
        services[item.getAttribute('parent_idx')]['caseList'].splice(item.getAttribute('idx'), 1)
        renderHtml(services);
    }

    function directSupportAdd(item) {
        services.push({
            val: '',
            date: ''
        })
        renderHtml(services);
    }

    function directSupportRemove(item) {
        services.splice(item.getAttribute('idx'), 1)
        renderHtml(services);
    }

    function performValidation() {
        console.log('triggered');
        document.querySelectorAll('select[adr_select="true"]').forEach(select => {
            const parentIdx = select.getAttribute('parent_idx');
            const idx = select.getAttribute('idx');
            const adrList = services[parentIdx]['adrList'][idx];
            validateAdrFields(adrList, parentIdx, idx);
        });

        document.querySelectorAll('select[case_type="true"]').forEach(select => {
            const parentIdxCase = select.getAttribute('parent_idx');
            const idxCase = select.getAttribute('idx');
            const caseList = services[parentIdxCase]['caseList'][idxCase];
            validateCaseFields(caseList, parentIdxCase, idxCase);
        });
    }

    function validateAdrFields(adrList, parentIdx, idx) {

        const amountField = document.getElementById('mr_id_' + parentIdx + "_" + idx);
        const participantsField = document.getElementById('adr_ben_id_' + parentIdx + "_" + idx);
        const startingDateField = document.getElementById('adr_start_date_' + parentIdx + "_" + idx);
        const closingDateField = document.getElementById('adr_closing_date_' + parentIdx + "_" + idx);

        const currentDateMinus7 = new Date();
        currentDateMinus7.setDate(currentDateMinus7.getDate() - 7);
            
        const startingDate = adrList.starting_date ? new Date(adrList.starting_date) : null;
        const isStartingDateOld = startingDate && startingDate < currentDateMinus7;
            
        const closingDate = adrList.ending_date ? new Date(adrList.ending_date) : null;
        const isClosingDateOld = closingDate && closingDate < currentDateMinus7;


        if (adrList.val == 1 || adrList.val == 2 || adrList.val == 3 || adrList.val == 4 || adrList.val == 5 || adrList.val == 6) {
            amountField.readOnly = true;
            participantsField.readOnly = true;
            closingDateField.readOnly = true;

            if (userRoles.includes(1) || userRoles.includes(12)) {
                startingDateField.readOnly = false;
            } else {

                if (adrList.starting_date && adrList.id) {
                    startingDateField.readOnly = isStartingDateOld;
                } else {
                    startingDateField.readOnly = false;
                }
            }


        } else if (adrList.val == 7 || adrList.val == 9) {
            amountField.readOnly = false;
            participantsField.readOnly = false;
            startingDateField.readOnly = true;

            if (userRoles.includes(1) || userRoles.includes(12)) {
                closingDateField.readOnly  = false;
            } else {

                if (adrList.ending_date && adrList.id) {
                    closingDateField.readOnly = isClosingDateOld;
                } else {
                    closingDateField.readOnly  = false;
                }
            }

        } else if (adrList.val == 10) {
            amountField.readOnly = true;
            participantsField.readOnly = true;
            startingDateField.readOnly = true;

            if (userRoles.includes(1) || userRoles.includes(12)) {
                closingDateField.readOnly  = false;
            } else {

                if (adrList.ending_date && adrList.id) {
                    closingDateField.readOnly = isClosingDateOld;
                } else {
                    closingDateField.readOnly  = false;
                }
            }

        } else if (adrList.val == 11) {
            amountField.readOnly = false;
            participantsField.readOnly = true;
            startingDateField.readOnly = true;

            if (userRoles.includes(1) || userRoles.includes(12)) {
                closingDateField.readOnly  = false;
            } else {

                if (adrList.ending_date && adrList.id) {
                    closingDateField.readOnly = isClosingDateOld;
                } else {
                    closingDateField.readOnly  = false;
                }
            }

        } else {
            amountField.readOnly = false;
            participantsField.readOnly = false;
            closingDateField.readOnly = false;
            startingDateField.readOnly = false;
        }

    }

    function validateCaseFields(caseList, parentIdxCase, idxCase) {

        const caseAmountField = document.getElementById('case_money_id_' + parentIdxCase + "_" + idxCase);
        const caseParticipantsField = document.getElementById('case_ben_id_' + parentIdxCase + "_" + idxCase);
        const caseStartingDateField = document.getElementById('case_start_date_' + parentIdxCase + "_" + idxCase);
        const caseClosingDateField = document.getElementById('case_closing_date_' + parentIdxCase + "_" + idxCase);


        const caseCurrentDateMinus7 = new Date();
        caseCurrentDateMinus7.setDate(caseCurrentDateMinus7.getDate() - 7);
            
        const caseStartingDate = caseList.starting_date ? new Date(caseList.starting_date) : null;
        const isCaseStartingDateOld = caseStartingDate && caseStartingDate < caseCurrentDateMinus7;
            
        const caseClosingDate = caseList.jd_date ? new Date(caseList.jd_date) : null;
        const isCaseClosingDateOld = caseClosingDate && caseClosingDate < caseCurrentDateMinus7;

        if ((caseList.case_type == 1 && caseList.case_status == 23) || (caseList.case_type == 2 && caseList.case_status == 22) || (caseList.case_type == 3 && caseList.case_status == 26)) {
            caseStartingDateField.readOnly = true;

            if (userRoles.includes(1) || userRoles.includes(12)) {
                caseClosingDateField.readOnly = false;
            } else {

                if (caseList.jd_date && caseList.id) {
                    caseClosingDateField.readOnly = isCaseClosingDateOld;
                } else {
                    caseClosingDateField.readOnly = false;
                }
            }


        } else if ((caseList.case_type == 1 && caseList.case_status == 34) || (caseList.case_type == 2 && caseList.case_status == 36) || (caseList.case_type == 3 && caseList.case_status == 29)) {
            caseStartingDateField.readOnly = true;
            caseParticipantsField.readOnly = true;

            if (userRoles.includes(1) || userRoles.includes(12)) {
                caseClosingDateField.readOnly = false;
            } else {

                if (caseList.jd_date && caseList.id) {
                    caseClosingDateField.readOnly = isCaseClosingDateOld;
                } else {
                    caseClosingDateField.readOnly = false;
                }
            }


        } else {
            caseAmountField.readOnly = false;
            caseParticipantsField.readOnly = false;
            // caseStartingDateField.readOnly = false;
            // caseClosingDateField.readOnly = false;

            if (userRoles.includes(1) || userRoles.includes(12)) {
                caseStartingDateField.readOnly = false;
                caseClosingDateField.readOnly = false;
            } else {

                if (caseList.starting_date && caseList.id) {
                    caseStartingDateField.readOnly = isCaseStartingDateOld;
                } else {
                    caseStartingDateField.readOnly = false;
                }
    
                if (caseList.jd_date && caseList.id) {
                    caseClosingDateField.readOnly = isCaseClosingDateOld;
                } else {
                    caseClosingDateField.readOnly = false;
                }
            }

        }

        if (caseList.jd_status == 2 || caseList.jd_status == 4) {  
            caseParticipantsField.readOnly  = true;
        }

    }

    function isADRAlreadySelected(parentIdx, selectedValue) {
        let isDuplicate = false;
        services.forEach(service => {
            if (service.val == 3) {
                service.adrList.forEach(adr => {
                    if (adr.val && adr.val != '11' && adr.val == selectedValue) {
                        isDuplicate = true;
                    }
                });
            }
        });
        return isDuplicate;
    }

    function isCaseTypeAlreadySelected(parentIdx, selectedValue) {
        let isCaseDuplicate = false;
        let selectedCaseType = null;

        // If there's only one caseList item, allow any selection
        if (services[parentIdx].caseList.length === 1) {
            return false;
        }

        // Iterate through all services and their caseList items to check for duplicates
        services.forEach(service => {
            if (service.val == 4) {
                service.caseList.forEach(caseItem => {
                    if (caseItem.val) {
                        if (selectedCaseType === null) {
                            selectedCaseType = caseItem.val;
                        } else if (caseItem.val != selectedCaseType) {
                            isCaseDuplicate = true;
                        }
                    }
                });
            }
        });

        // Check if the new selected value is different from the existing selectedCaseType
        if (selectedValue && selectedValue != selectedCaseType) {
            isCaseDuplicate = true;
        }

        return isCaseDuplicate;
    }

    // addEventListener('change',(e)=>{
    addEventListener('change', onActivityChange);

    function onActivityChange(e) {
        console.log(e);
        if (e.target.hasAttribute('element_idx')) {
            if (services.find(el => el.val == e.target.value)) {
                alert("Already added");
                services[e.target.getAttribute('element_idx')]['val'] = '';
                e.target.value = '';
                return;
            }

            if (e.target.value == 3) {
                services[e.target.getAttribute('element_idx')] = {
                    'val': '',
                    'date': '',
                    'adrList': [{
                        'val': '',
                        'no_of_adr_participants_benefited': '',
                        'money_recovered_through_adr': '',
                        'amount_of_money_received': '',
                        'starting_date': '',
                        'ending_date': ''
                    }]
                }
                services[e.target.getAttribute('element_idx')]['val'] = e.target.value;
            } else if (e.target.value == 4) {
                services[e.target.getAttribute('element_idx')] = {
                    'val': '',
                    'date': '',
                    'caseList': [{
                        'val': '',
                        'amount_of_money_received': '',
                        'no_of_case_participants_benefited': '',
                        'case_status': '',
                        'starting_date': '',
                        'jd_date': '',
                        'money_recover': '',
                        'jd_status': '',
                        'case_type': null
                    }]
                }
                services[e.target.getAttribute('element_idx')]['val'] = e.target.value;
            } else {
                services[e.target.getAttribute('element_idx')]['val'] = e.target.value;
            }

        }

        if (e.target.hasAttribute('service_date_idx')) {
            services[e.target.getAttribute('service_date_idx')]['date'] = e.target.value;
        }

        if (e.target.hasAttribute('receive_money_container')) {
            services[e.target.getAttribute('receive_money_idx')].receive_money = document.getElementById('receive_money_container').value
        }

        if (e.target.hasAttribute('case_container')) {
            services[e.target.getAttribute('parent_idx')]['caseList'][e.target.getAttribute('idx')].no_of_case_participants_benefited = document.getElementById('case_ben_id_' + e.target.getAttribute('parent_idx') + "_" + e.target.getAttribute('idx')).value
            services[e.target.getAttribute('parent_idx')]['caseList'][e.target.getAttribute('idx')].amount_of_money_received = document.getElementById('case_money_id_' + e.target.getAttribute('parent_idx') + "_" + e.target.getAttribute('idx')).value
            if (e.target.hasAttribute('case_type')) {
                if (isCaseTypeAlreadySelected(e.target.getAttribute('parent_idx'), e.target.value)) {
                    alert("Can not select another case type.");
                    services[e.target.getAttribute('parent_idx')]['caseList'][e.target.getAttribute('idx')].val = '';
                    services[e.target.getAttribute('parent_idx')]['caseList'][e.target.getAttribute('idx')].visibility = true;
                    services[e.target.getAttribute('parent_idx')]['caseList'][e.target.getAttribute('idx')].case_type = '';
                    e.target.value = '';
                    return;
                } else {
                    services[e.target.getAttribute('parent_idx')]['caseList'][e.target.getAttribute('idx')].val = e.target.value
                    if (e.target.value == 1) {
                        services[e.target.getAttribute('parent_idx')]['caseList'][e.target.getAttribute('idx')].case_type = 1;
                    }
                    if (e.target.value == 2) {
                        services[e.target.getAttribute('parent_idx')]['caseList'][e.target.getAttribute('idx')].case_type = 2;
                    }
                    if (e.target.value == 3) {
                        services[e.target.getAttribute('parent_idx')]['caseList'][e.target.getAttribute('idx')].case_type = 3;
                    }
                }
            }
            if (e.target.hasAttribute('case_status')) {
                services[e.target.getAttribute('parent_idx')]['caseList'][e.target.getAttribute('idx')].case_status = e.target.value
            }

            if (e.target.hasAttribute('case_money')) {
                services[e.target.getAttribute('parent_idx')]['caseList'][e.target.getAttribute('idx')].amount_of_money_received = e.target.value
            }
            if (e.target.hasAttribute('case_mr')) {
                services[e.target.getAttribute('parent_idx')]['caseList'][e.target.getAttribute('idx')].money_recover = e.target.value
            }

            if (e.target.hasAttribute('jd_status')) {
                services[e.target.getAttribute('parent_idx')]['caseList'][e.target.getAttribute('idx')].jd_status = e.target.value
            }

            if (e.target.hasAttribute('case_starting_date')) {
                services[e.target.getAttribute('parent_idx')]['caseList'][e.target.getAttribute('idx')].starting_date = e.target.value
            }

            if (e.target.hasAttribute('case_jd_date')) {
                services[e.target.getAttribute('parent_idx')]['caseList'][e.target.getAttribute('idx')].jd_date = e.target.value
            }

        }

        if (e.target.hasAttribute('adr_container')) {

            services[e.target.getAttribute('parent_idx')]['adrList'][e.target.getAttribute('idx')].amount_of_money_received = document.getElementById('mr_id_' + e.target.getAttribute('parent_idx') + "_" + e.target.getAttribute('idx')).value
            services[e.target.getAttribute('parent_idx')]['adrList'][e.target.getAttribute('idx')].no_of_adr_participants_benefited = document.getElementById('adr_ben_id_' + e.target.getAttribute('parent_idx') + "_" + e.target.getAttribute('idx')).value
            if (e.target.hasAttribute('adr_select')) {
                if (isADRAlreadySelected(e.target.getAttribute('parent_idx'), e.target.value)) {
                    alert("This ADR is already selected. Please choose another ADR.");
                    services[e.target.getAttribute('parent_idx')]['adrList'][e.target.getAttribute('idx')].val = '';
                    services[e.target.getAttribute('parent_idx')]['adrList'][e.target.getAttribute('idx')].visibility = true
                    e.target.value = '';
                    return;
                } else {
                    services[e.target.getAttribute('parent_idx')]['adrList'][e.target.getAttribute('idx')].val = e.target.value;
                }
            }
            if (e.target.hasAttribute('money_recover_select')) {
                services[e.target.getAttribute('parent_idx')]['adrList'][e.target.getAttribute('idx')].money_recovered_through_adr = e.target.value
            }

            if (e.target.hasAttribute('adr_start_date')) {
                services[e.target.getAttribute('parent_idx')]['adrList'][e.target.getAttribute('idx')].starting_date = e.target.value
            }
            if (e.target.hasAttribute('adr_closing_date')) {
                services[e.target.getAttribute('parent_idx')]['adrList'][e.target.getAttribute('idx')].ending_date = e.target.value
            }
        }

        renderHtml(services);

    }

    function dateContainerDisplayHide(serviceValue) {
        if (serviceValue == 1) {
            return "style='display:block'";
        }
        if (serviceValue == 2) {
            return "style='display:block'";
        }
        if (serviceValue == 5) {
            console.log(serviceValue)
            return "style='display:block'";
        }
        if (serviceValue == 6) {
            console.log(serviceValue)
            return "style='display:block'";
        }
        // if(serviceValue==''){
        //   return "style='display:none'";
        // }
        return "style='display:none'";


    }

    // $(document).ready(functioen() {
    function renderHtml(services) {
        console.log(services);
        let counter = 0;
        let container = document.getElementById('service_data_container');
        container.innerHTML = '';
        for (let i = 0; i < services.length; i++) {

            let initialTemplate = `
                        <div class="col-lg-12 pt-3">
                          <div class="form-row">
                            <div class="form-group col-md-5 ">
                              <label class="control-label">Direct Service </label>
                              <select element_idx=${i} name="direct_service_type[]"  class="form-control form-control-sm services">
                                <option value="">-- Select --</option>
                                <option ${services[i].val==1 ? "selected" : ( services[i].val && services[i].id ? "disabled": "") } value="1"> Assistance to treatment /medical support </option>
                                <option ${services[i].val==2 ? "selected" : ( services[i].val && services[i].id ? "disabled": "") } value="2"> Assistance to OCC </option>
                                <option ${services[i].val==3 ? "selected" : ( services[i].val && services[i].id ? "disabled": "") } value="3"> Alternative Dispute Resolution (ADR) </option>
                                <option ${services[i].val==4 ? "selected" : ( services[i].val && services[i].id ? "disabled": "") } value="4"> Assistance with court case </option>
                                <option ${services[i].val==5 ? "selected" : ( services[i].val && services[i].id ? "disabled": "") } value="5"> Assistance to Police Station </option>
                                <option ${services[i].val==6 ? "selected" : ( services[i].val && services[i].id ? "disabled": "") } value="6"> Phycosocial Counselling </option>
                              </select>
                            </div>
                            
                            <div class="col-md-${services[i].val==1 ? 3 : 5} service_date" id="service_date" ${dateContainerDisplayHide(services[i].val)}>
                              <label class="control-label"> Date <span class="text-danger">*</span></label>
                              <input service_date_idx=${i} type="date" name="direct_service_date[]" value="${services[i].date}" id="service_date" class="form-control form-control-sm @error('direct_service_date') is-invalid @enderror">
                            </div>

                            ${services[i].val==1 ? `<div class="col-md-2"><label class="control-label"> Financial Support </label> <input ${services[i].visibility ? '' : ''} type="number" receive_money_idx=${i}  name="receive_money[]" value="${services[i].receive_money}"  receive_money_container="true" id="receive_money_container" class="form-control form-control-sm"></div>` : ''}
                            
                            <div class="form-group col-md-2">
                              <label class="control-label d-block" style="visibility:hidden;">button</label>
                              <i style="" btn_type="add_service" class="fa fa-plus btn btn-info" onclick="directSupportAdd(this);"></i>
                              <i style="" idx=${i} btn_type="rm_service" class="fa fa-minus btn btn-danger btn-remove ${i==0 ? 'd-none' : ''}" data-type="delete" onclick="directSupportRemove(this);"></i>
                            </div>

                          </div>
                        </div>
                      `;
            container.innerHTML += initialTemplate;
            if (services[i].val == 3 || services[i].val == 4) {
                let multiLength = services[i].val == 3 ? services[i]['adrList'].length : services[i]['caseList'].length
                for (let j = 0; j < multiLength; j++) {

                    if (services[i].val == 3) {
                        let adr_template = `
                          <div style="background:#17a2b80d;" class="row mt-3 mx-3 pt-2 px-1 border rounded align-items-center">
                            
                            <div class="col-md-2">
                                <label class="control-label" style="font-size: 12px; height:40px;">Alternative Dispute Resolution (ADR) <span class="text-danger">*</span></label>
                                <select name="selp_alternative_dispute_resolution[]" adr_select="true" adr_container="true" parent_idx=${i} idx=${j} id="selp_adr" class="form-control form-control-sm">
                                  <option value="">-- Select --</option>
                                  @foreach ($adrs as $adr)
                                    <option ${services[i]['adrList'][j].val=="{{ $adr->id }}" ? "selected" : '' } value="{{ $adr->id }}">{{ $adr->title }}</option>
                                  @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="control-label" style="font-size: 12px; height:40px;"> Purpose of disputes </label>
                                <select name="money_recovered_through_adr[]"  adr_container="true" money_recover_select='true'  parent_idx=${i} idx=${j} id="division_id" class="division_id form-control form-control-sm">
                                  <option value="">-- Select --</option>
                                  @foreach ($adrMoneyRecover as $CourteCase)
                                    <option ${services[i]['adrList'][j].money_recovered_through_adr=="{{ $CourteCase->id }}" ? "selected" : '' }  value="{{ $CourteCase->id }}">{{ $CourteCase->title }}</option>
                                  @endforeach            
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="control-label" style="font-size: 12px; height:40px;"> Amount of Money Received </label>
                                <input type="number" adr_container="true" adr_money_receive="true"  name="amount_of_money_received[]" adr_container="true" parent_idx=${i} idx=${j} value="${services[i]['adrList'][j].amount_of_money_received}" id="mr_id_${i}_${j}" class="form-control form-control-sm">
                            </div>

                            <div class="col-md-2">
                                <label class="control-label" style="font-size: 12px; height:40px;"> No. of participants benefited </label>
                                <input type="number" adr_container="true" adr_money_receive="true"  name="no_of_adr_participants_benefited[]" adr_container="true" parent_idx=${i} idx=${j} value="${services[i]['adrList'][j].no_of_adr_participants_benefited}" id="adr_ben_id_${i}_${j}" class="form-control form-control-sm">
                            </div>
                        
                            @if (in_array(1, auth()->user()->user_role->pluck('role_id')->toArray()) || in_array(12, auth()->user()->user_role->pluck('role_id')->toArray()))
                              <div class="col-md-2" >
                                  <label class="control-label" style="font-size: 12px; height:40px;"> Starting Date</label>
                                  <input ${services[i]['adrList'][j].visibility ? '' : '' }  type="date"  adr_container="true" adr_start_date="true" parent_idx=${i} idx=${j} name="selp_support_start_date[]" adr_container="true" parent_idx=${i} idx=${j} value="${services[i]['adrList'][j].starting_date??''}" id="adr_start_date_${i}_${j}" class="form-control form-control-sm ">
                              </div>
                              <div class="col-md-2">
                                  <label class="control-label" style="font-size: 12px; height:40px;"> Closing Date </label>
                                  <input ${services[i]['adrList'][j].visibility ? '' : '' }  type="date"  adr_container="true" adr_closing_date="true" parent_idx=${i} idx=${j} name="selp_support_closing_date[]" adr_container="true" parent_idx=${i} idx=${j} value="${services[i]['adrList'][j].ending_date??''}" id="adr_closing_date_${i}_${j}" class="form-control form-control-sm ">
                              </div>
                            @else 
                              <div class="col-md-2" >
                                  <label class="control-label" style="font-size: 12px; height:40px;"> Starting Date</label>
                                  <input 
                                    type="date"

                                    ${ services[i]['adrList'][j].starting_date && services[i]['adrList'][j].id 
                                        ? `min="${new Date(new Date(services[i]['adrList'][j].starting_date).setDate(new Date(services[i]['adrList'][j].starting_date).getDate() - 7)).toISOString().split('T')[0]}" max="${services[i]['adrList'][j].starting_date}"`
                                        : `min="<?php echo date('Y-m-d', strtotime('-7 days')); ?>" max="{{ date('Y-m-d') }}"`
                                    }
                                    adr_container="true" adr_start_date="true" parent_idx=${i} idx=${j} 
                                    name="selp_support_start_date[]" adr_container="true" parent_idx=${i} idx=${j} 
                                    value="${services[i]['adrList'][j].starting_date ?? ''}" 
                                    id="adr_start_date_${i}_${j}"  class="form-control form-control-sm ">
                              </div>
                              <div class="col-md-2" >
                                  <label class="control-label" style="font-size: 12px; height:40px;"> Closing Date </label>
                                  <input 
                                    
                                    type="date" 
                                    ${ services[i]['adrList'][j].ending_date && services[i]['adrList'][j].id 
                                        ? `min="${new Date(new Date(services[i]['adrList'][j].ending_date).setDate(new Date(services[i]['adrList'][j].ending_date).getDate() - 7)).toISOString().split('T')[0]}" max="${services[i]['adrList'][j].ending_date}"`
                                        : `min="<?php echo date('Y-m-d', strtotime('-7 days')); ?>" max="{{ date('Y-m-d') }}"`
                                    }
                                    adr_container="true" adr_closing_date="true" parent_idx=${i} idx=${j} 
                                    name="selp_support_closing_date[]" adr_container="true" parent_idx=${i} idx=${j} 
                                    value="${services[i]['adrList'][j].ending_date??''}" 
                                    id="adr_closing_date_${i}_${j}" class="form-control form-control-sm ">
                              </div>
                            @endif

                            <div class="form-group col-sm-2" style="margin-top: 13px;">
                                <i style="" parent_idx=${i} idx=${j} btn_type="add_service" class="fa fa-plus btn btn-success" onclick="adrAdd(this);"></i>
                                <i style="" parent_idx=${i} idx=${j} btn_type="rm_service" class="fa fa-minus btn btn-danger btn-remove ${j==0 ? 'd-none' : ''}" data-type="delete" onclick="adrRemove(this);"></i>
                            </div>
                            
                          </div>
                        `;
                        container.innerHTML += adr_template;
                    }
                    if (services[i].val == 4) {
                        let case_template = `
                          <div style="background:#007bff0a;" class="row court_case_support_multi mt-3 mx-3 pt-2 px-1 border rounded align-items-center">
                            
                            <div ${j==0 ? '' : 'style="display:none"' } class="form-group col-md-12">
                              <p><strong><u>5. Court Case : </u></strong></p>
                            </div>

                            <div class="form-group col-sm-2">
                              <label class="control-label" style="font-size: 12px; height:40px;"> Case Type </label>
                              <select name="case_type[]" case_type="true" case_container="true" parent_idx=${i} idx=${j} id="case_type" class="form-control form-control-sm">
                                <option value="">-- Select --</option>
                                <option ${services[i]['caseList'][j].val==1 ? "selected" : '' }  value="1"> Civil cases </option>
                                <option ${services[i]['caseList'][j].val==2 ? "selected" : '' } value="2"> GR/Police Case </option>
                                <option ${services[i]['caseList'][j].val==3 ? "selected" : '' } value="3"> CR/Petition Case </option>
                              </select>
                            </div>

                            <div id="court_case_${j}" class="form-group col-sm-2" style="${services[i]['caseList'][j].case_type==1 ? "" : "display:none"}">
                              <label class="control-label" style="font-size: 12px; height:40px;"> Case Status </label>
                              <select ${services[i]['caseList'][j].case_type==1 ? "" : "disabled"} name="court_case_id[]" case_status="true" case_container="true" parent_idx=${i} idx=${j} id="case_type_list" class="form-control form-control-sm">
                                <option value="">-- Select --</option>
                                @foreach ($civilCase as $civil)
                                  <option ${services[i]['caseList'][j].case_status=="{{ $civil->id }}" ? "selected" : '' } value="{{ $civil->id }}">{{ $civil->title }}</option>
                                @endforeach           
                              </select>
                            </div>

                            <div id="police_case_${j}" class="form-group col-sm-2" style="${services[i]['caseList'][j].case_type==2 ? "" : "display:none"}">
                              <label class="control-label" style="font-size: 12px; height:40px;"> Case Status </label>
                              <select ${services[i]['caseList'][j].case_type==2 ? "" : "disabled"} name="court_case_id[]" case_status="true" case_container="true" parent_idx=${i} idx=${j} id="case_type_list" class="form-control form-control-sm">
                                <option value="">-- Select --</option>
                                @foreach ($policeCase as $police)
                                  <option ${services[i]['caseList'][j].case_status=="{{ $police->id }}" ? "selected" : '' } value="{{ $police->id }}">{{ $police->title }}</option>
                                @endforeach         
                              </select>
                            </div>

                            <div id="peti_case_${j}" class="form-group col-sm-2" style="${services[i]['caseList'][j].case_type==3 ? "" : "display:none"}">
                              <label class="control-label" style="font-size: 12px; height:40px;"> Case Status </label>
                              <select ${services[i]['caseList'][j].case_type==3 ? "" : "disabled"} name="court_case_id[]" case_status="true" case_container="true" parent_idx=${i} idx=${j} id="case_type_list" class="form-control form-control-sm">
                                <option value="">-- Select --</option>
                                @foreach ($petitionCase as $petition)
                                  <option ${services[i]['caseList'][j].case_status=="{{ $petition->id }}" ? "selected" : '' } value="{{ $petition->id }}">{{ $petition->title }}</option>
                                @endforeach         
                              </select>
                            </div>
                        
                            <div class="form-group col-sm-2">
                              <label class="control-label" style="font-size: 12px; height:40px;"> Purpose of disputes </label>
                              <select name="court_case_moneyrecover_id[]" case_mr="true" case_container="true" parent_idx=${i} idx=${j} id="division_id" class="division_id form-control form-control-sm">
                                <option value="">-- Select --</option>
                                @foreach ($moneyRecoverCourteCase as $CourteCase)
                                  <option ${services[i]['caseList'][j].money_recover=="{{ $CourteCase->id }}" ? "selected" : '' } value="{{ $CourteCase->id }}">{{ $CourteCase->title }}</option>
                                @endforeach          
                                </select>
                            </div>

                            <div class="form-group col-md-2">
                              <label class="control-label" style="font-size: 12px; height:40px;"> Amount of Money Received </label>
                              <input type="number" case_container="true" case_money="true"  name="case_amount_of_money_received[]" parent_idx=${i} idx=${j} value="${services[i]['caseList'][j].amount_of_money_received}" id="case_money_id_${i}_${j}" class="form-control form-control-sm">
                            </div>

                            <div class="form-group col-md-2">
                                <label class="control-label" style="font-size: 12px; height:40px;"> No. of participants benefited </label>
                                <input type="number" case_container="true"  name="no_of_case_participants_benefited[]" parent_idx=${i} idx=${j} value="${services[i]['caseList'][j].no_of_case_participants_benefited}" id="case_ben_id_${i}_${j}" class="form-control form-control-sm">
                            </div>
                        
                            <div class="form-group col-sm-2">
                              <label class="control-label" style="font-size: 12px; height:40px;"> Judgment/Installment Status </label>
                              <select name="judgementstatus_id[]" jd_status="true" case_container="true" parent_idx=${i} idx=${j} id="division_id" class="division_id form-control form-control-sm">
                                <option value="">-- Select --</option>
                                @foreach ($judgementStatus as $status)
                                  <option ${services[i]['caseList'][j].jd_status=="{{ $status->id }}" ? "selected" : '' } value="{{ $status->id }}">{{ $status->title }}</option>
                                @endforeach
                              </select>
                            </div>

                            @if (in_array(1, auth()->user()->user_role->pluck('role_id')->toArray()) || in_array(12, auth()->user()->user_role->pluck('role_id')->toArray()))
                              <div class="form-group col-sm-2">
                                <label class="control-label" style="font-size: 12px; height:40px;"> Starting Date</label>
                                <input ${services[i]['caseList'][j].visibility ? "" : '' }   type="date"  case_starting_date="true" case_container="true" parent_idx=${i} idx=${j} name="case_start_date[]" value="${services[i]['caseList'][j].starting_date}" id="case_start_date_${i}_${j}" class="form-control form-control-sm">
                              </div>

                              <div class="form-group col-sm-2">
                                <label class="control-label" style="font-size: 12px; height:40px;"> Judgment/Installment date </label>
                                <input ${services[i]['caseList'][j].visibility ? "" : '' }  type="date"  case_jd_date="true" case_container="true" parent_idx=${i} idx=${j} name="judgement_date[]" value="${services[i]['caseList'][j].jd_date}" id="case_closing_date_${i}_${j}" class="form-control form-control-sm">
                              </div>
                            @else
                              <div class="form-group col-sm-2">
                                <label class="control-label" style="font-size: 12px; height:40px;"> Starting Date </label>
                                <input 
                                    ${ '' /* services[i]['caseList'][j].starting_date && Date.parse(services[i]['caseList'][j].starting_date) < new Date().setDate(new Date().getDate()-8) ?  "readonly" : '' */}  
                                    type="date"

                                    ${ services[i]['caseList'][j].starting_date && services[i]['caseList'][j].id 
                                        ? `min="${new Date(new Date(services[i]['caseList'][j].starting_date).setDate(new Date(services[i]['caseList'][j].starting_date).getDate() - 7)).toISOString().split('T')[0]}" max="${services[i]['caseList'][j].starting_date}"`
                                        : `min="<?php echo date('Y-m-d', strtotime('-7 days')); ?>" max="{{ date('Y-m-d') }}"`
                                    }

                                    case_starting_date="true" case_container="true" parent_idx=${i} idx=${j} 
                                    name="case_start_date[]" value="${services[i]['caseList'][j].starting_date}" 
                                    id="case_start_date_${i}_${j}" class="form-control form-control-sm  ">
                              </div>
                              <div class="form-group col-sm-2">
                                <label class="control-label" style="font-size: 12px; height:40px;"> Judgment/Installment date </label>
                                <input 
                                    ${ '' /* services[i]['caseList'][j].visibility ? "" : '' } ${services[i]['caseList'][j].jd_date && Date.parse(services[i]['caseList'][j].jd_date) < new Date().setDate(new Date().getDate()-8) ?  "readonly" : '' */} 
                                  
                                    type="date"

                                    ${ services[i]['caseList'][j].jd_date && services[i]['caseList'][j].id 
                                        ? `min="${new Date(new Date(services[i]['caseList'][j].jd_date).setDate(new Date(services[i]['caseList'][j].jd_date).getDate() - 7)).toISOString().split('T')[0]}" max="${services[i]['caseList'][j].jd_date}"`
                                        : `min="<?php echo date('Y-m-d', strtotime('-7 days')); ?>" max="{{ date('Y-m-d') }}"`
                                    }
                                    case_jd_date="true" case_container="true" parent_idx=${i} idx=${j} name="judgement_date[]" 
                                    value="${services[i]['caseList'][j].jd_date}" id="case_closing_date_${i}_${j}" 
                                    class="form-control form-control-sm ">
                              </div>
                            @endif

                            <div class="form-group col-sm-2">
                              <label class="control-label d-block" style="font-size: 12px; height:40px; visibility:hidden;"> Button </label>
                              <i style="" parent_idx=${i} idx=${j} class="fa fa-plus btn btn-success" onclick="addCase(this);"></i>
                              <i style=" parent_idx=${i} idx=${j} class="fa fa-minus btn btn-danger btn-remove ${j==0 ? 'd-none' : ''}" data-type="delete" onclick="removeCase(this);"></i>
                            </div>
                          </div>
                        `;
                        container.innerHTML += case_template;
                    }

                }
            }
            counter++;
        }
        // Call the validation function after populating the container
        performValidation();
    }

    renderHtml(services);


    function datepickerload() {
        // $('.datepickerservices').daterangepicker({
        //         singleDatePicker: true,
        //         showDropdowns: true,
        //         autoUpdateInput: false,

        //         // drops: "up",
        //         autoApply:true,
        //         locale: {
        //             format: 'DD-MM-YYYY',
        //             daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
        //             firstDay: 0
        //         },
        //         minDate: new Date(),
        //         maxDate: new Date(),
        //     },
        //     function(start) {
        //         this.element.val(start.format('DD-MM-YYYY'));
        //         this.element.parent().parent().removeClass('has-error');
        //     },
        //     function(chosen_date) {
        //         this.element.val(chosen_date.format('DD-MM-YYYY'));
        //     });

        //     $('.datepickerservices').on('apply.daterangepicker', function(ev, picker) {
        //         $(this).val(picker.startDate.format('DD-MM-YYYY')).change();
        //     });
    }
</script>



<script>
    /* $(document).ready(function() {
      $(".services").change(function() {
        var services = $(".services").val();
        if (services == 1 || services == 2) {
          $(".service_date").show();
        }else{
          $(".service_date").hide();
        }
      });
    });  */
</script>


<script>
    $(document).ready(function() {
        $("#section_A").show();
        $("#section_B").show();
    });


    // $(document).ready(function() {
    //   addEventListener('change',(e)=>{
    //       if (e.target.value == 3) {
    //         let html=document.getElementById('adr_service_container').innerHTML;
    //         document.getElementById('multi_suport_container').innerHTML+=html;
    //         $("#multi_suport_container > .adr_support").show();
    //         e.target.childNodes[7].setAttribute("selected","selected");

    //         $(".court_case").hide();
    //       } else if (e.target.value == 4) {
    //           let html=document.getElementById('court_case_container').innerHTML;
    //           document.getElementById('multi_suport_container').innerHTML+=html;
    //           $("#multi_suport_container > .court_case").show();

    //         $(".adr_support").hide();
    //       } else {
    //         1 & 2
    //         $(".court_case").hide();
    //         $(".adr_support").hide();
    //       }

    //   });
    // })
    // $('select').change(function() {
    //   // var services = $(".services");
    //   return;
    //   if (services == 3) {

    //       $(".adr_support").show();
    //       $(".court_case").hide();
    //     } else if (services == 4) {

    //       $(".court_case").show();
    //       $(".adr_support").hide();
    //     } else {
    //       // 1 & 2
    //       $(".court_case").hide();
    //       $(".adr_support").hide();
    //   }
    // });
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Add form submission handler
        document.getElementById('directServiceForm').addEventListener('submit', (e) => {
            const saveButton = e.submitter;
            saveButton.disabled = true;
            if (!validateForm()) {
                e.preventDefault(); // Prevent form submission
                saveButton.disabled = false;
            } else {
                saveButton.disabled = true;
                saveButton.innerHTML = 'Sending…';
            }
        });
    });
</script>

<script>
    function validateForm() {
        let isValid = true;

        const mrta_selects = document.querySelectorAll('select[name="money_recovered_through_adr[]"]');
        for (let i = 0; i < mrta_selects.length; i++) {
            const mrta_select = mrta_selects[i];
            if (!mrta_select.value) {
                alert("Please fill out all purpose of dispute fields.");
                mrta_select.focus();
                isValid = false;
                return false; // Exit the function immediately
            }

            // Get the parent div of the current select element
            const parentDiv = mrta_select.closest('.row');

            // Find the corresponding adr_select field within the same parent div
            const adr_select = parentDiv.querySelector('select[name="selp_alternative_dispute_resolution[]"]');

            // Find the corresponding amount_of_money_received field within the same parent div
            const amountInput = parentDiv.querySelector('input[name="amount_of_money_received[]"]');

            // Find the corresponding no_of_adr_participants_benefited field within the same parent div
            const participantsInput = parentDiv.querySelector('input[name="no_of_adr_participants_benefited[]"]');

            // Find the corresponding closing_date field within the same parent div
            const closingDateInput = parentDiv.querySelector('input[name="selp_support_closing_date[]"]');

            // Get the value of the adr_select field
            const adrValue = adr_select.value;

            // Apply additional validation for adrValue 7 and 9
            if (adrValue == 7 || adrValue == 9) {
                const participantsValue = participantsInput.value;

                if (!participantsValue) {
                    alert("Please fill out the 'Participants' field for selected ADR type.");
                    participantsInput.focus();
                    isValid = false;
                    return false;
                }

                if (parseInt(participantsValue) > 9) {
                    alert("The Number of Participants must not exceed 9.");
                    participantsInput.value = '';
                    participantsInput.focus();
                    isValid = false;
                    return false; // Exit the function immediately
                }
            }

            // Apply additional validation for adrValue 11
            if (adrValue == 11) {
                const amountValue = amountInput.value;
                const closingDateValue = closingDateInput.value;

                if (!amountValue) {
                    alert("Please fill out the 'Amount of Money Received' field for selected ADR type.");
                    amountInput.focus();
                    isValid = false;
                    return false;
                }

                if (!closingDateValue) {
                    alert("Please fill out the 'Closing Date' field for selected ADR type.");
                    closingDateInput.focus();
                    isValid = false;
                    return false;
                }
            }
        }

        const court_case_mr_selects = document.querySelectorAll('select[name="court_case_moneyrecover_id[]"]');
        for (let i = 0; i < court_case_mr_selects.length; i++) {
            const court_case_mr_select = court_case_mr_selects[i];
            let courtCaseSelectValue = null;
            if (!court_case_mr_select.value) {
                alert("Please fill out all court case purpose of dispute fields.");
                court_case_mr_select.focus();
                isValid = false;
                return false; // Exit the function immediately
            }


            // Get the parent div of the current select element
            const courtCaseParentDiv = court_case_mr_select.closest('.row');

            // Find the corresponding caseTypeselect field within the same parent div
            const caseTypeselect = courtCaseParentDiv.querySelector('select[name="case_type[]"]');

            // Find the corresponding amount_of_money_received field within the same parent div
            const courtCaseAmountInput = courtCaseParentDiv.querySelector('input[name="case_amount_of_money_received[]"]');

            // Find the corresponding no_of_adr_participants_benefited field within the same parent div
            const courtCaseParticipantsInput = courtCaseParentDiv.querySelector('input[name="no_of_case_participants_benefited[]"]');

            // Find the corresponding judgementstatus_id field within the same parent div
            const courtCaseJudgementStatusSelect = courtCaseParentDiv.querySelector('select[name="judgementstatus_id[]"]');

            // Find the corresponding closing_date field within the same parent div
            const courtCaseClosingDateInput = courtCaseParentDiv.querySelector('input[name="judgement_date[]"]');

            // Get the value of the field
            const caseTypeValue = caseTypeselect.value;
            const courtCaseAmountValue = courtCaseAmountInput.value;
            const courtCaseParticipantsValue = courtCaseParticipantsInput.value;
            const courtCaseclosingDateValue = courtCaseClosingDateInput.value;
            const courtCaseJudgementStatusValue = courtCaseJudgementStatusSelect.value;


            if (caseTypeValue) {
                courtCaseParentDiv.querySelectorAll('select[name="court_case_id[]"]').forEach(courtCaseSelect => {
                    if (courtCaseSelect.closest('.form-group').style.display !== 'none') {
                        courtCaseSelectValue = courtCaseSelect.value;
                    }
                });

            } else {
                alert("Please fill out all case type fields.");
                caseTypeselect.focus();
                isValid = false;
                return false; // Exit the function immediately
            }

            if (!courtCaseSelectValue) {
                alert("Please fill out the 'Case Status' field for selected Court Case type.");
                isValid = false;
                return false;
            }

            // Apply additional validation for  Judgment(1:23 / 2:22 / 3:26)
            if ((caseTypeValue == 1 && courtCaseSelectValue == 23) || (caseTypeValue == 2 && courtCaseSelectValue == 22) || (caseTypeValue == 3 && courtCaseSelectValue == 26)) {

                if (!courtCaseParticipantsValue) {
                    alert("Please fill out the 'Participants' field for selected Court Case type.");
                    courtCaseParticipantsInput.focus();
                    isValid = false;
                    return false;
                }

                if (parseInt(courtCaseParticipantsValue) > 9) {
                    alert("The Number of Participants must not exceed 9.");
                    courtCaseParticipantsInput.value = '';
                    courtCaseParticipantsInput.focus();
                    isValid = false;
                    return false; // Exit the function immediately
                }


                if (!courtCaseclosingDateValue) {
                    alert("Please fill out the 'Closing Date' field for selected Court Case type.");
                    courtCaseClosingDateInput.focus();
                    isValid = false;
                    return false;
                }

                if (!courtCaseJudgementStatusValue) {
                    alert("Please fill out the 'Judgement Status' field for selected Court Case type.");
                    courtCaseJudgementStatusSelect.focus();
                    isValid = false;
                    return false;
                }

                // Ensure 'Installment Running' is not selected
                if (courtCaseJudgementStatusValue == 5) { // 5 is the value for 'Installment Running'
                    alert("'Installment Running' cannot be selected for this Court Case type.");
                    courtCaseJudgementStatusSelect.focus();
                    courtCaseJudgementStatusSelect.value = '';
                    isValid = false;
                    return false;
                }

            }

            // Apply additional validation for  Installment(1:34 / 2:36 / 3:29)
            if ((caseTypeValue == 1 && courtCaseSelectValue == 34) || (caseTypeValue == 2 && courtCaseSelectValue == 36) || (caseTypeValue == 3 && courtCaseSelectValue == 29)) {

                if (!courtCaseAmountValue) {
                    alert("Please fill out the 'Amount of Money Received' field for selected Court Case type.");
                    courtCaseAmountInput.focus();
                    isValid = false;
                    return false;
                }

                if (!courtCaseclosingDateValue) {
                    alert("Please fill out the 'Closing Date' field for selected Court Case type.");
                    courtCaseClosingDateInput.focus();
                    isValid = false;
                    return false;
                }

                if (!courtCaseJudgementStatusValue) {
                    alert("Please fill out the 'Judgement Status' field for selected Court Case type.");
                    courtCaseJudgementStatusSelect.focus();
                    isValid = false;
                    return false;
                }

                // Ensure 'Installment Running' is selected
                if (courtCaseJudgementStatusValue != 5) { // 5 is the value for 'Installment Running'
                    alert("Only 'Installment Running' can be selected for this Court Case type.");
                    courtCaseJudgementStatusSelect.focus();
                    courtCaseJudgementStatusSelect.value = '';
                    isValid = false;
                    return false;
                }

            }

        }
        return isValid;
    }
</script>
