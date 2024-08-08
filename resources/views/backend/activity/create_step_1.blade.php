<div class="col-md-12">
    <form action="{{ route('activity.add_step_1', ['step' => 2]) }}" method="post">
        {{ csrf_field() }}
        @if (count($activityData) > 0)
            <input type="hidden" value="{{ $activityData[0]->selp_activity_ref }}" name="selp_activity_ref">
        @endif
        <input type="hidden" name="employee_id" value="{{ count($activityData) > 0 ? $activityData[0]->employee_id : @$user_info->id }}" id="employee_id" class="form-control form-control-sm">
        <input type="hidden" name="employee_pin" value="" id="employee_pin" class="form-control form-control-sm">
        <div class="card custom-card-style">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6" style="margin-top: 7px;">
                        1. Data Entry for month: {{ date('d-M-Y') }}
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6" style="text-align:right;margin-top: 7px;">
                                <label>Reporting Date</label>
                            </div>
                            <div class="col-md-6">
                                {{-- <p style="font-size: 15px;margin-top: 9px;">{{count($activityData)>0 && $activityData[0]->reporting_date != null ? date("d-m-Y", strtotime($activityData[0]->reporting_date)) : date("d-m-Y")}}</p> --}}
                                @if (loginUserRole()->user_role[0]->role_id && loginUserRole()->user_role[0]->role_id == 1)
                                    <input type="text" class="form-control form-control-sm  singledatepicker" value="{{ count($activityData) > 0 && $activityData[0]->reporting_date != null ? date('d-m-Y', strtotime($activityData[0]->reporting_date)) : '' }}" name="reporting_date" id="reporting_date" required>
                                @elseif (loginUserRole()->user_role[0]->role_id && loginUserRole()->user_role[0]->role_id != 1)
                                    @if (count($activityData) > 0)
                                        <input type="text" id="reporting_date" value="{{ $activityData[0]->reporting_date != null ? date('d-m-Y', strtotime($activityData[0]->reporting_date)) : '' }}" class="form-control form-control-sm activityeditdatepicker" name="reporting_date" required>
                                    @else
                                        <input type="text" class="form-control form-control-sm  {{ count($activityData) > 0 && $activityData[0]->reporting_date != null && date('Y-m-d', strtotime($activityData[0]->reporting_date)) < now()->subDays(7) ? '' : 'postingdatepicker' }}" value="{{ count($activityData) > 0 && $activityData[0]->reporting_date != null ? date('d-m-Y', strtotime($activityData[0]->reporting_date)) : '' }}" name="reporting_date" id="reporting_date" required>
                                    @endif
                                    
                                @endif
                                {{-- @if (loginUserRole()->user_role[0]->role_id && count($activityData) > 0)
                                    <input type="text" id="reporting_date" value="{{ $activityData[0]->reporting_date != null ? date('d-m-Y', strtotime($activityData[0]->reporting_date)) : '' }}" class="form-control form-control-sm activityeditdatepicker" name="reporting_date">

                                @else
                                    <input type="text" class="form-control form-control-sm  {{ count($activityData) > 0 && $activityData[0]->reporting_date != null && date('Y-m-d', strtotime($activityData[0]->reporting_date)) < now()->subDays(7) ? '' : 'postingdatepicker' }}" value="{{ count($activityData) > 0 && $activityData[0]->reporting_date != null ? date('d-m-Y', strtotime($activityData[0]->reporting_date)) : '' }}" name="reporting_date" id="reporting_date" readonly>
                                @endif --}}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="form-row pollisomaj_data_entry">
                    <div class="form-group col-sm-3">
                        <label class="control-label">Name</label>
                        <input type="text" name="employee_name" value="{{ count($activityData) > 0 ? $activityData[0]->employee_name : @$user_info->name }}" id="employee_name" class="form-control form-control-sm" readonly="">
                    </div>
                    <div class="form-group col-sm-3">
                        <label class="control-label">Cell</label>
                        <input type="text" name="employee_mobile_number" value="{{ count($activityData) > 0 ? $activityData[0]->employee_mobile_number : @$user_info->mobile }}" id="employee_mobile_number" class="form-control form-control-sm" readonly="">
                    </div>
                    <div class="form-group col-sm-3">
                        <label class="control-label">Designation</label>
                        <input type="text" name="employee_designation" value="{{ count($activityData) > 0 ? $activityData[0]->employee_designation : @$user_info->designation }}" id="employee_designation" class="form-control form-control-sm" readonly="">
                    </div>
                    <div class="form-group col-sm-3">
                        <label class="control-label">Pin</label>
                        <input type="text" name="employee_pin" value="{{ count($activityData) > 0 ? $activityData[0]->employee_pin : @$user_info->pin }}" id="employee_pin" class="form-control form-control-sm" readonly="">
                    </div>
                </div>
                <div class="form-row" style="margin-top: -12px;margin-bottom: -12px;">
                    <div class="form-group col-md-12">
                        <p><strong><u>Address:</u></strong></p>
                    </div>
                    <div class="form-group col-md-3">
                        <label class="control-label">Zone</label>
                        {{-- <select name="employee_zone_id" id="zone_id" class="zone_id form-control form-control-sm">
                        <option value="">Select Zone</option> --}}
                        {{-- {{ dd(session()->get('userareaaccess.sregions')) }} --}}
                        @if (count(session()->get('userareaaccess.sregions')) > 0)
                            <select name="employee_zone_id" id="region_id" class="region_id form-control form-control-sm select2" required="">


                                <option value="">Select zone</option>
                                @foreach ($regions as $key => $region)
                                    @if (in_array($region->id, session()->get('userareaaccess.sregions')))
                                        <option value="{{ $region->id }}" {{ count($activityData) > 0 && $activityData[0]->employee_zone_id == $region->id ? 'selected' : '' }}>
                                            {{ $region->region_name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        @else
                            <select name="employee_zone_id" id="region_id" class="region_id form-control form-control-sm select2" required="">
                                <option value="">Select Zone</option>
                                @foreach ($regions as $region)
                                    {{-- @if (count(session()->get('userareaaccess.sregions')) == 1)
                                        <option value="{{$region->id}}" {{(session()->get('userareaaccess.sregions')[0] == $region->id)?('selected'):''}}>{{$region->region_name}}</option>
                                    @else --}}

                                    <option value="{{ $region->id }}" {{ checkCurrentRegion($region->id, $activityData) }}>
                                        {{ $region->region_name }}
                                    </option>
                                    {{-- @endif --}}
                                @endforeach
                            </select>
                        @endif

                        {{-- </select> --}}
                    </div>
                    <div class="form-group col-md-3">
                        <label class="control-label">Division</label>
                        <select name="employee_division_id" id="division_id" class="division_id form-control form-control-sm" required="">
                            @if (count($activityData) > 0)
                                @if (count(session()->get('userareaaccess.sregions')) == 1)
                                    {!! getUserDivisions(session()->get('userareaaccess.sregions')[0]) !!}
                                @else
                                    {!! getRegionalDivision($activityData[0]->employee_zone_id, $activityData[0]->employee_division_id) !!};
                                @endif
                            @else
                                @if (count(session()->get('userareaaccess.sregions')) == 1)
                                    {!! getUserDivisions(session()->get('userareaaccess.sregions')[0]) !!}
                                @else
                                    <option value="">Select Division</option>
                                @endif
                            @endif

                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label class="control-label">District</label>
                        <select name="employee_district_id" id="district_id" class="district_id form-control form-control-sm" required="">
                            @if (count($activityData) > 0)
                                {!! getRegionalDivisionDistrict($activityData[0]->employee_zone_id, $activityData[0]->employee_division_id, $activityData[0]->employee_district_id) !!};
                            @else
                                <option value="">Select District</option>
                            @endif
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label class="control-label">Upazila</label>
                        <select name="employee_upazila_id" id="upazila_id" class="upazila_id form-control form-control-sm" required>
                            @if (count($activityData) > 0)
                                {!! getUpazila($activityData[0]->employee_district_id, $activityData[0]->employee_upazila_id) !!};
                            @else
                                <option value="">Select Upazila</option>
                            @endif
                        </select>
                    </div>
                </div>
            </div>
        </div>





        <div class="text-right">
            <input type="submit" class="btn btn-success" value="Save & Next" />
            {{-- <a href="{{route('activity.add',['step'=>2])}}" class="btn  btn-success" >Save & Next</a> --}}
            @if (@$user_info['user_role'][0]['role_id'] == 5)
                <input type="submit" name="save_destroy" class="btn btn-primary" value="Draft & Close">
            @endif
            <a href="{{ route('activity.draft.list') }}" class="btn btn-danger">Cancel</a>
        </div>
    </form>
</div>


<!-- Start JS for Date time Picker -->
<script type="text/javascript">
    $(function() {

        //loader
        var submitBtn = $('input[type="submit"]');
        submitBtn.on('click', function() {
            var zone = $(this).parents('form').find('#region_id').val();
            var division = $(this).parents('form').find('#division_id').val();
            var district = $(this).parents('form').find('#district_id').val();
            var upazila_id = $(this).parents('form').find('#upazila_id').val();



            if (zone != "" && division != "" && district != "" && upazila_id != "") {

                $('.from_loader').css({
                    "display": 'block'
                });
            }
        });

        var date = new Date();
        @if (Session::has('activity_edit_mode') && Session::get('activity_edit_mode') && (count($activityData) > 0 && $activityData[0]->reporting_date != null))
            var editDate = Math.floor(Math.abs((new Date()) - (new Date(
                "{{ $activityData[0]->reporting_date }}"))) / (1000 * 60 * 60 * 24));
            var rrr = new Date("{{ $activityData[0]->reporting_date }}");
            // alert(new Date(rrr.setDate((rrr.getDate()+editDate))));
            var result = new Date("{{ $activityData[0]->reporting_date }}") + editDate;
        @endif
        $('.postingdatepicker').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,

                @if (!(Session::has('activity_edit_mode') && Session::get('activity_edit_mode')) && (count($activityData) > 0 && $activityData[0]->reporting_date != null))
                    autoUpdateInput: false,
                @else
                    minDate: new Date(date.setDate(date.getDate() - 7)),
                    @if (Session::has('activity_edit_mode') && Session::get('activity_edit_mode') && (count($activityData) > 0 && $activityData[0]->reporting_date != null))
                        // let diffTime = Math.abs(date2 - date1);
                        // let diffDays = (diffTime / (1000 * 60 * 60 * 24));
                        maxDate: new Date(rrr.setDate((rrr.getDate() + editDate))),
                        // maxDate :  new Date("{{ $activityData[0]->reporting_date }}"),
                    @else
                        maxDate: new Date(),
                    @endif
                @endif
                // drops: "up",
                autoApply: true,
                locale: {
                    format: 'DD-MM-YYYY',
                    daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                    firstDay: 0
                },
                // minDate: '01/01/2018',
                // maxDate: new Date(),
            },
            function(start) {
                this.element.val(start.format('DD-MM-YYYY'));
                this.element.parent().parent().removeClass('has-error');
            },
            function(chosen_date) {
                this.element.val(chosen_date.format('DD-MM-YYYY'));
            });

        $('.singledatepicker').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD-MM-YYYY'));
        });
    });
</script>

<script>
    $(function() {
        // Retrieve the initial date value from the input field
        var initialDateStr = $('#reporting_date').val();

        console.log("Initial Date String:", initialDateStr);

        var initialDate = moment(initialDateStr, 'DD-MM-YYYY', true);

        if (!initialDate.isValid()) {
            console.error("Invalid initial date format. Please check the server-side code.");
            return;
        }

        console.log("Parsed Initial Date:", initialDate.format('YYYY-MM-DD'));

        $('.activityeditdatepicker').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                autoApply: true,
                locale: {
                    format: 'DD-MM-YYYY',
                    daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                    firstDay: 0
                },
                minDate: moment(initialDate).subtract(7, 'days'), // Set the minimum date based on the initial date
                maxDate: initialDate,
            },
            function(start) {
                // Set the value when chosen
                $(this.element).val(start.format('DD-MM-YYYY'));
            });
    });
</script>



<script>
    $(document).ready(function() {
        $("input").keyup(function() {
            var member_girls = +$("#member_girls").val();
            var member_boys = +$("#member_boys").val();
            var member_female = +$("#member_female").val();
            var member_male = +$("#member_male").val();
            var member_transgender = +$("#member_transgender").val();
            var total = member_girls + member_boys + member_female + member_male + member_transgender;
            $("#general_member_total").val(total);

            var member_girls_pwd = +$("#member_girls_pwd").val();
            var member_boys_pwd = +$("#member_boys_pwd").val();
            var member_female_pwd = +$("#member_female_pwd").val();
            var member_male_pwd = +$("#member_male_pwd").val();
            var member_transgender_pwd = +$("#member_transgender_pwd").val();
            var total_pwd = member_girls_pwd + member_boys_pwd + member_female_pwd + member_male_pwd +
                member_transgender_pwd;
            $("#general_member_pwd_total").val(total_pwd);
        });
    });
</script>


<script>
    function getPollisomajInfo(item) {
        var pollisomaj_no = item.val();
        // var employee_pin = $('#pin').val();
        var url = "{{ route('setup.getPollisomajInfo') }}";
        var data = {
            pollisomaj_no: pollisomaj_no
        }

        $.get(url, data, function(response) {
            console.log(response);
            var moment_date = moment(response.date_from).format("DD-MM-YYYY");
            // let moment_date = services[i].followup_date;
            console.log(moment_date);

            if (response) {
                document.getElementById("pollisomaj_name").value = response.pollisomaj_name;
                document.getElementById("ps_reform_date").value = moment_date;
                document.getElementById("p_number").value = response.mob_1;
                document.getElementById("s_number").value = response.mob_2;
                document.getElementById("c_number").value = response.mob_3;
                document.getElementById("f_number").value = response.mob_4;
            } else {
                alert("In this Pollisomaj No. has no Pollisomaj Information");
                document.getElementById("pollisomaj_name").value = "";
                document.getElementById("ps_reform_date").value = "";
                document.getElementById("p_number").value = "";
                document.getElementById("s_number").value = "";
                document.getElementById("c_number").value = "";
                document.getElementById("f_number").value = "";
            }
            // item.closest('.pollisomaj_data_entry').find('#pollisomaj_name').val(response.pollisomaj_name);
            // document.getElementById("pollisomaj_name").value=response.pollisomaj_name;
            // document.getElementById("p_number").value=response.mob_1;
            // document.getElementById("s_number").value=response.mob_2;
            // document.getElementById("c_number").value=response.mob_3;
            // document.getElementById("f_number").value=response.mob_4;
        });
    }
</script>



<script>
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
</script>

<script type="text/javascript">
    $(function() {
        $(document).on('change', '#region_id', function() {
            var region_id = $(this).val();
            $.ajax({
                url: "{{ route('default.get-division') }}",
                type: "GET",
                data: {
                    region_id: region_id
                },
                success: function(data) {
                    var html = '<option value="">Select Division</option>';
                    $.each(data, function(key, v) {
                        html += '<option value="' + v.division_id + '">' + v
                            .regional_division.name + '</option>';
                    });
                    $('#division_id').html(html);
                }
            });
        });
    });
</script>
<script type="text/javascript">
    $(function() {
        $(document).on('change', '#division_id', function() {
            var region_id = $('#region_id').val();
            var division_id = $(this).val();
            $.ajax({
                url: "{{ route('default.get-region-district') }}",
                type: "GET",
                data: {
                    region_id: region_id,
                    division_id: division_id
                },
                success: function(data) {
                    var html = '<option value="">Select District</option>';
                    $.each(data, function(key, v) {
                        html += '<option value="' + v.district_id + '">' + v
                            .regional_district.name + '</option>';
                    });
                    $('#district_id').html(html);
                }
            });
        });
    });
</script>
<script type="text/javascript">
    $(function() {
        $(document).on('change', '#district_id', function() {
            var district_id = $(this).val();
            $.ajax({
                url: "{{ route('default.get-region-upazila') }}",
                type: "GET",
                data: {
                    district_id: district_id
                },
                success: function(data) {
                    var html = '<option value="">Select Upazila</option>';
                    $.each(data, function(key, v) {
                        if (v.setup_user_upazila == undefined) {
                            html += '<option value="' + v.id + '">' + v.name +
                                '</option>';
                        } else {
                            html += '<option value="' + v.setup_user_upazila.id +
                                '">' + v.setup_user_upazila.name + '</option>';
                        }
                    });
                    $('#upazila_id').html(html);
                }
            });
        });
    });
</script>
@if (!(Session::has('activity_edit_mode') && Session::get('activity_edit_mode')))
    <script type="text/javascript">
        $(function() {
            $('#region_id').trigger('change');
        });
    </script>
@endif

<script>
    function getRegionalDivision(region_id, item) {
        var url = "{{ route('setup.getRegionalDivision') }}";
        var data = {
            region_id: region_id
        }

        $.get(url, data, function(response) {
            // console.log(response);
            item.closest('.show_module_more_event').find('.division_id').html(response);
        });
    }

    function getRegionalDivisionDistrict(division_id, item) {
        var region_id = $('.region_id').val();
        var url = "{{ route('setup.getRegionalDivisionDistrict') }}";
        var data = {
            region_id: region_id,
            division_id: division_id
        }

        $.get(url, data, function(response) {
            console.log(item);
            item.closest('.region_area_info').find('.district_id').html(response);
        });
    }

    function getDistrictUpazila(district_id, item) {
        var url = "{{ route('setup.getDistrictUpazila') }}";
        var data = {
            district_id: district_id
        }

        $.get(url, data, function(response) {
            // console.log(response);
            item.closest('.region_area_info').find('.upazila_id').html(response);
        });
    }

    // function getUpazilaUnion(upazila_id, item)
    // {
    // 	var url  = "{{ route('setup.getUpazilaUnion') }}";
    //   	var data = {
    // 		upazila_id: upazila_id
    // 	}

    //   	$.get(url, data, function(response) {
    //         // console.log(response);
    //         item.closest('.region_area_info').find('.union_id').html(response);
    //     });
    // }

    function getUpazilaPollisomaj(upazila_id, union_id) {
        var url = "{{ route('setup.getUpazilaPollisomaj') }}";
        var data = {
            upazila_id: upazila_id,
            union_id: union_id
        }

        $.get(url, data, function(response) {
            // console.log(response);
            $('#pollisomaj_no').html(response);
        });
    }



    // function getUnionVillage(union_id,item){
    //     var url  = "{{ route('setup.getUnionVillage') }}";
    //   	var data = {
    // 		union_id: union_id
    // 	}

    //   	$.get(url, data, function(response) {
    //         // console.log(response);
    //         item.closest('.region_area_info').find('.village_id').html(response);
    //     });
    // }
</script>



<script>
    $(function() {
        $("#ps_reform_date").datepicker({
            dateFormat: "d-M-yy"
        });
    });
</script>



<script type="text/javascript">
    $(function() {
        $(document).on('change', '#region_id', function() {
            var region_id = $(this).val();
            $.ajax({
                url: "{{ route('default.get-division') }}",
                type: "GET",
                data: {
                    region_id: region_id
                },
                success: function(data) {
                    var html = '<option value="">Select Division</option>';
                    $.each(data, function(key, v) {
                        html += '<option value="' + v.division_id + '">' + v
                            .regional_division.name + '</option>';
                    });
                    $('#division_id').html(html);
                }
            });
        });
    });
</script>
<script type="text/javascript">
    $(function() {
        $(document).on('change', '#division_id', function() {
            var region_id = $('#region_id').val();
            var division_id = $(this).val();
            $.ajax({
                url: "{{ route('default.get-region-district') }}",
                type: "GET",
                data: {
                    region_id: region_id,
                    division_id: division_id
                },
                success: function(data) {
                    var html = '<option value="">Select District</option>';
                    $.each(data, function(key, v) {
                        html += '<option value="' + v.district_id + '">' + v
                            .regional_district.name + '</option>';
                    });
                    $('#district_id').html(html);
                }
            });
        });
    });
</script>

<script type="text/javascript">
    $(function() {
        // $(document).on('change','#district_id',function(){
        // 	var district_id = $(this).val();
        // 	$.ajax({
        // 		url : "{{ route('default.get-upazila') }}",
        // 		type : "GET",
        // 		data : {district_id:district_id},
        // 		success:function(data){
        // 			var html = '<option value="">Select Upazila</option>';
        // 			$.each(data[0],function(key,v){
        // 				html +='<option value="'+v.id+'">'+v.name+'</option>';
        // 			});
        // 			$('#upazila_id').html(html);
        // 		}
        // 	});
        // });
    });
</script>

<script type="text/javascript">
    $(function() {
        $(document).on('change', '#upazila_id', function() {
            var upazila_id = $(this).val();
            $.ajax({
                url: "{{ route('default.get-union') }}",
                type: "GET",
                data: {
                    upazila_id: upazila_id
                },
                success: function(data) {
                    var html = '<option value="">Select Union</option>';
                    $.each(data, function(key, v) {
                        html += '<option value="' + v.id + '">' + v.name +
                            '</option>';
                    });
                    $('#union_id').html(html);
                }
            });
        });
    });
</script>

<script type="text/javascript">
    $(function() {
        $(document).on('change', '.pollisomaj_list', function() {
            setTimeout(() => {
                getUpazilaPollisomaj($('#upazila_id').val(), $('#union_id').val())
            }, 500);

        });
    });
</script>

<script type="text/javascript">
    $(document).on('change', '.pollisomaj_list', function() {
        $('.pollisomaj_info').val('');

    });
    // addEventListener('change', ()=>{
    // })
</script>


{{-- <script type="text/javascript">
	$(function(){
		$(document).on('change','#village_id',function(){
			var village_id = $(this).val();
			$.ajax({
				url : "{{route('get-details.pollisomaj')}}",
				type : "GET",
				data : {village_id:village_id},
				success:function(data){
					let info=JSON.parse(data);
                    if(info.length > 0){
                        console.log(info);
                        document.getElementById("p1_cell").value=info[0]['mob_1']
                        document.getElementById("p2_cell").value=info[0]['mob_2']
                        document.getElementById("p3_cell").value=info[0]['mob_3']
                        document.getElementById("p4_cell").value=info[0]['mob_4']
                        document.getElementById("pollisomaj_id").value=info[0]['id']
                        document.getElementById("pollisomaj_name").value=info[0]['pollisomaj_name']
                    }else{
                        document.getElementById("p1_cell").value=""
                        document.getElementById("p2_cell").value=""
                        document.getElementById("p3_cell").value=""
                        document.getElementById("p4_cell").value=""
                        document.getElementById("pollisomaj_id").value=""
                        document.getElementById("pollisomaj_name").value=""
                    }
				}
			});
		});
	});
</script> --}}


{{-- <script type="text/javascript">
	$(function(){
        
		$("#village_id").ready(function(){
			var village_id = $("#village_id").val();
            console.log(village_id);
            //alert("Hellow")
			$.ajax({
				url : "{{route('get-details.pollisomaj')}}",
				type : "GET",
				data : {village_id:village_id},
				success:function(data){
					let info=JSON.parse(data);
                    if(info.length > 0){
                        console.log(info);
                        document.getElementById("p1_cell").value=info[0]['mob_1']
                        document.getElementById("p2_cell").value=info[0]['mob_2']
                        document.getElementById("p3_cell").value=info[0]['mob_3']
                        document.getElementById("pollisomaj_id").value=info[0]['id']
                        document.getElementById("pollisomaj_name").value=info[0]['pollisomaj_name']
                    }else{
                        document.getElementById("p1_cell").value=""
                        document.getElementById("p2_cell").value=""
                        document.getElementById("p3_cell").value=""
                        document.getElementById("pollisomaj_id").value=""
                        document.getElementById("pollisomaj_name").value=""
                    }
				}
			});
		});
	});
</script> --}}
