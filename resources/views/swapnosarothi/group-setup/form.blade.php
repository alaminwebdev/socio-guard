
@if (@$editData)
    <form method="post" action="{{ route('swapnosarothisetupgroup.update', @$editData->id) }}" id="myForm">   
    @method('PUT')
@else
    <form method="post" action="{{ route('swapnosarothisetupgroup.store') }}" id="myForm">
@endif
@csrf
    <div class="card-body">
        <div class="show_module_more_event">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label class="control-label">Group Id <span class="text-danger">*</span></label>
                    <input type="text" name="group_id" id="group_id" class="form-control form-control-sm" value="{{@$editData->group_id}}" placeholder="Group Id" readonly>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Start Date <span class="text-danger">*</span> </label>
                    <input type="date" name="start_date" class="form-control form-control-sm" value="{{old('start_date', @$editData->start_date)}}">
                    @error('start_date')
                        <p class="text-danger pb-0">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">End Date </label>
                    <input type="date" name="end_date" class="form-control form-control-sm" value="{{old('end_date', @$editData->end_date)}}">
                    @error('end_date')
                        <p class="text-danger pb-0">{{ $message }}</p>
                    @enderror
                </div>
                @if (@$editData)
                <div class="form-group col-md-3">
                    <label class="control-label">Status <span class="text-danger">*</span> </label>
                    <select name="status" id="status" class="form-control form-control-sm">
                        <option value="1" {{ $editData->status == 1 ? 'selected' : '' }}>Active</option>
                        <option value="2" {{ $editData->status == 2 ? 'selected' : '' }}>Deactive</option>
                        
                    </select>
                    @error('status')
                        <p class="text-danger pb-0">{{ $message }}</p>
                    @enderror
                </div>
                @endif
            </div>
            <hr>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label class="control-label">Group Name And Code <span class="text-danger">*</span> </label>
                    <input type="text" name="group_name" class="form-control form-control-sm" value="{{old('group_name', @$editData->group_name)}}" placeholder="Ex:008-name">
                    @error('group_name')
                        <p class="text-danger pb-0">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Zone <span class="text-danger">*</span> </label>
                    <select name="zone_id" id="zone_id" class="form-control form-control-sm">
                        <option value="">Select Zone</option>
                        @foreach ($zones as $zone)
                            <option value="{{ $zone->id }}" {{ $zone->id == @$editData->zone_id ? 'selected' : '' }}>{{ $zone->region_name }}</option>
                        @endforeach
                    </select>
                    @error('zone_id')
                        <p class="text-danger pb-0">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Division <span class="text-danger">*</span> </label>
                    <select name="division_id" id="division_id" class="form-control form-control-sm">
                        @if (@$editData)
                            {!! getdivision($editData->division_id) !!};
                        @else
                            <option value="">Select Division</option>
                        @endif
                    </select>
                    @error('division_id')
                        <p class="text-danger pb-0">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">District <span class="text-danger">*</span> </label>
                    <select name="district_id" id="district_id" class="form-control form-control-sm">
                        @if (@$editData)
                            {!! getdistrict($editData->division_id, $editData->district_id) !!};
                        @else
                            <option value="">Select District</option>
                        @endif
                    </select>
                    @error('district_id')
                        <p class="text-danger pb-0">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Upazila <span class="text-danger">*</span> </label>
                    <select name="upazila_id" id="upazila_id" class="form-control form-control-sm">
                        @if (@$editData)
                            {!! getupazila(@$editData->district_id, @$editData->upazila_id) !!};
                        @else
                            <option value="">Select Upazila</option>
                        @endif
                    </select>
                    @error('upazila_id')
                        <p class="text-danger pb-0">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Union <span class="text-danger">*</span> </label>
                    <select name="union_id" id="union_id" class="form-control form-control-sm">
                        @if (@$editData)
                            {!! getunion(@$editData->upazila_id, @$editData->union_id) !!};
                        @else
                            <option value="">Select Union</option>
                        @endif
                    </select>
                    @error('union_id')
                        <p class="text-danger pb-0">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label class="control-label">Village <span class="text-danger">*</span> </label>
                    <select name="village_id[]" id="village_id" class="form-control form-control-sm select2" multiple>
                        @if (@$editData)
                            @foreach (@$villages as $village)
                                <option value="{{ $village->id }}"{{ $editData->villages->pluck('id')->contains($village->id) ? 'selected' : '' }}>{{ $village->name }}</option>
                            @endforeach
                        @else
                            <option value="" disabled>Select Union</option>
                        @endif
                    </select>
                    @error('village_id')
                        <p class="text-danger pb-0">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
            
        <button type="submit" class="btn btn-success btn-sm">{{  @$editData ? 'Update' : 'Submit' }}</button>
        <button type="reset" class="btn btn-danger btn-sm">Reset</button>
    </div>
</form>

<script type="text/javascript">
    $(function() {

        

        $(document).on('change','#zone_id',function(){
			var region_id = $(this).val();
			$.ajax({
				url : "{{route('default.get-division')}}",
				type : "GET",
				data : {region_id:region_id},
				success:function(data){
					var html = '<option value="">Select Division</option>';
					$.each(data,function(key,v){
						html +='<option value="'+v.division_id+'">'+v.regional_division.name+'</option>';
					});
					$('#division_id').html(html);
				}
			});
		});

        $(document).on('change', '#division_id', function() {
            // var region_id = $('#region_id').val();
            var division_id = $(this).val();
            $.ajax({
                url: "{{ route('default.get-district') }}",
                type: "GET",
                data: {
                    division_id: division_id
                },
                success: function(data) {

                    var html = '<option value="">Select District</option>';
                    for (var i = 0; i < data[0].length; i++) {
                        html += '<option value="' + data[0][i].id + '">' + data[0][i].name +
                            '</option>';
                    }
                    // $.each(data,function(key,v){
                    //   console.log(data[key]);
                    // 	//html +='<option value="'+v[key].district_id+'">'+v[key].name+'</option>';
                    // });
                    $('#district_id').html(html);
                }
            });
        });

        $(document).on('change', '#district_id', function() {
            // var region_id = $('#region_id').val();
            var district_id = $(this).val();
            $.ajax({
                url: "{{ route('default.get-upazila') }}",
                type: "GET",
                data: {
                    district_id: district_id
                },
                success: function(data) {

                    var html = '<option value="">Select Upazila</option>';
                    for (var i = 0; i < data[0].length; i++) {
                        html += '<option value="' + data[0][i].id + '">' + data[0][i].name +
                            '</option>';
                    }
                    // $.each(data,function(key,v){
                    //   console.log(data[key]);
                    // 	//html +='<option value="'+v[key].district_id+'">'+v[key].name+'</option>';
                    // });
                    $('#upazila_id').html(html);
                }
            });
        });

        $(document).on('change', '#upazila_id', function() {
            // var region_id = $('#region_id').val();
            var upazila_id = $(this).val();
            $.ajax({
                url: "{{ route('default.get-union') }}",
                type: "GET",
                data: {
                    upazila_id: upazila_id
                },
                success: function(data) {

                    var html = '<option value="">Select Union</option>';
                    for (var i = 0; i < data.length; i++) {
                        html += '<option value="' + data[i].id + '">' + data[i].name +
                            '</option>';
                    }
                    // $.each(data,function(key,v){
                    //   console.log(data[key]);
                    // 	//html +='<option value="'+v[key].district_id+'">'+v[key].name+'</option>';
                    // });
                    $('#union_id').html(html);
                }
            });
        });

        $(document).on('change', '#union_id', function() {
            // var region_id = $('#region_id').val();
            var union_id = $(this).val();
            $.ajax({
                url: "{{ route('default.get-village') }}",
                type: "GET",
                data: {
                    union_id: union_id
                },
                success: function(data) {

                    var html = '<option value="">Select Village</option>';
                    for (var i = 0; i < data.length; i++) {
                        html += '<option value="' + data[i].id + '">' + data[i].name +
                            '</option>';
                    }
                    // $.each(data,function(key,v){
                    //   console.log(data[key]);
                    // 	//html +='<option value="'+v[key].district_id+'">'+v[key].name+'</option>';
                    // });
                    $('#village_id').html(html);
                }
            });
        });

    });
</script>

