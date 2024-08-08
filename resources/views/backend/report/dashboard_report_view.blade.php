@extends('backend.layouts.app')
@section('content')
<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />


<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Dashboard Report</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active">Dashboard Report</li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div>
<div class="container fullbody">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5>Select Filter Criteria</h5>
			</div>
			<div class="card-body">
				<form method="post" action="{{ route('dashboard-report-data.view') }}" id="filterForm">
				{{ csrf_field() }}
					<div class="form-row">
                        <div class="form-group col-md-2">
                            <label class="control-label" style="font-size: 11px;">Dashboard Attribute Name <span class="text-danger">*</span>&nbsp;</label>
                            <select name="report_name" id="report_name" class="report_name form-control form-control-sm" required="">
                                <option value="">Select Report Name</option>
                                <option value="1">District Wise Number</option>
                                <option value="2">Reason Behind The Violence</option>
                                <option value="3">Survivor Disability Status</option>
                                <option value="4">Age Group of Survivors</option>
                                <option value="5">Perpetrators Age Analysis</option>
                                <option value="6">Relationship Between Perpetrators and Survivors</option>
                                <option value="7">Current Situation of Perpetrator</option>
                                <option value="8">Violence Place</option>
                                <option value="9">Status of Legal Initiatives</option>
                                <option value="10">Survivor's Maritial Status</option>
                                <option value="11">Perpetrator Maritial Status</option>
                                <option value="12">Survivor's Occupation</option>
                                <option value="13">Perpetrator's Occupation</option>
                                <option value="14">Perpetrators analysis- in terms of family members</option>
                                <option value="15">Reasons of not taking legal initiatives</option>
                                <option value="16">Survivors situation</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label">Zone</label>&nbsp;&nbsp;&nbsp;
                            <input type="checkbox" name="region_all" value="1">&nbsp;All
                            <select name="region_id" id="region_id" class="region_id form-control form-control-sm select2">
                                <option value="">Select Zone</option>
                                @foreach($regions as $region)
                                <option value="{{$region->id}}">{{$region->region_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label">Division</label>
                            <select name="division_id" id="division_id" class="division_id form-control form-control-sm select2">
                                <option value="">Select Division</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                          <label class="control-label">District</label>
                          <select name="district_id" id="district_id" class="district_id form-control form-control-sm select2">
                            <option value="">Select District</option>
                          </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="">Violence Type</label>
                            <select name="violence_category_id" id="violence_category_id" class="violence_category_id form-control form-control-sm select2">
                              <option value="">Select Violence Type</option>
                              @foreach($violence_categories as $cat)
                              <option value="{{$cat->id}}" {{(@$editIncident->violence_category_id==$cat->id)?"selected":""}}>{{$cat->name}}</option>
                              @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-2">
                            <label class="control-label">Violence Sub Type</label>
                            <select name="violence_sub_category_id" id="violence_sub_category_id" class="violence_sub_category_id form-control form-control-sm">
                                <option value="">Select Sub Type</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-2">
                            <label class="control-label">Violence Name</label>
                            <select name="violence_name_id" id="violence_name_id" class="violence_name_id form-control form-control-sm">
                                <option value="">Select Name</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-2">
                          <label class="control-label">From Date</label>
                          <input type="text" name="start_date" id="start_date" class="singledatepicker form-control form-control-sm" placeholder="DD-MM-YYYY" autocomplete="off">
                        </div>
                        <div class="form-group col-sm-2">
                          <label class="control-label">End Date</label>
                          <input type="text" name="end_date" id="end_date" class="singledatepicker form-control form-control-sm" placeholder="DD-MM-YYYY" autocomplete="off">
                        </div>
                        <div class="form-group col-sm-1">
                            <button type="submit" class="btn btn-primary" style="margin-top: 29px;">Search</button>
                            <!-- <a class="btn btn-sm btn-primary" id="search" style="margin-top: 29px; color: white">Search</a> -->
                        </div>
                    </div>
				</form>
			</div>
		</div>
	</div>
</div>
@if(!empty($report))

<div class="container fullbody">
    <div class="col-md-12">
        <table id="examplew" class="display table table-striped table-bordered nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>SL.</th>
                    <th>{{ $header_left }}</th>
                    <th>{{ $header_right }}</th>
                </tr>
            </thead>
            <?php $i = 1; ?>
            <tbody>
                @foreach($report as $r)
                <tr>
                    <td>{{ $i++}}</td>
                    <td>{{ $r['pie_category']}}</td>
                    <td>{{ $r['pie_count']}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<!-- <script type="text/javascript">
	$(function(){
		$(".violence_sub_category_id").select2({
		    placeholder: "Select a option"
		});
	})

	$(function(){
		$(".violence_name_id").select2({
		    placeholder: "Select a option"
		});
	})
</script> -->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<!-- <script src="{{asset('backend/plugins/datatables/vfs_fonts.js')}}"></script> -->





<script type="text/javascript">
    $(document).ready(function() {
    $('#examplew').DataTable( {
        dom: 'Bfrtip',
        // buttons: [
        //     'copyHtml5',
        //     'excelHtml5',
        //     'csvHtml5',
        //     'pdfHtml5'
        // ]
        buttons: [
            'csv', 'excel', 'pdf'
        ]
    } );
} );
</script>



<script type="text/javascript">
  $(document).on('click','#search',function(){
    var region_id = $('#region_id').val();
    var division_id = $('#division_id').val();
    var district_id = $('#district_id').val();
    var violence_category_id = $('#violence_category_id').val();
    var violence_sub_category_id = $('#violence_sub_category_id').val();
    var violence_name_id = $('#violence_name_id').val();
    var start_date = $('#start_date').val();
    var end_date = $('#end_date').val();
    // $('#chartdiv1Display').hide();
    rtm(region_id,division_id,district_id,start_date,end_date);
  });
</script>

<script type="text/javascript">
  function rtm(region_id,division_id,district_id,start_date,end_date){
    $.ajax({
      url : "{{route('dashboard-report-data.view')}}",
      type : "GET",
      data : {
        region_id:region_id,
        division_id:division_id,
        district_id:district_id,
        start_date:start_date,
        end_date:end_date
      },
      success:function(data){
        console.log(datartm);
        $('#chartdiv1Display').show();
      }
    });
  }
</script>

<script type="text/javascript">
    $(function(){
        $(document).on('change','.violence_category_id',function(){
            var violence_category_id = $(this).val();
            $.ajax({
                url : "{{route('default.get-violence-sub-category')}}",
                type : "GET",
                data : {violence_category_id:violence_category_id},
                success:function(data){
                    var html = '<option value="">Select Violence Sub Category</option>';
                    $.each(data,function(key,v){
                        html +='<option value="'+v.id+'">'+v.name+'</option>';
                    });
                    $('.violence_sub_category_id').html(html);
                }
            });
        });
    });
</script>

<script type="text/javascript">
    $(function(){
        $(document).on('change','.violence_sub_category_id',function(){
            var violence_sub_category_id = $(this).val();
            $.ajax({
                url : "{{route('default.get-violence-name')}}",
                type : "GET",
                data : {violence_sub_category_id:violence_sub_category_id},
                success:function(data){
                    var html = '<option value="">Select Violence Name</option>';
                    $.each(data,function(key,v){
                        html +='<option value="'+v.id+'">'+v.name+'</option>';
                    });
                    $('.violence_name_id').html(html);
                }
            });
        });
    });
</script>

<script type="text/javascript">
  $(function(){
    $(document).on('change','#region_id',function(){
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
  });
</script>

<script type="text/javascript">
  $(function(){
    $(document).on('change','#division_id',function(){
      var region_id = $('#region_id').val();
      var division_id = $(this).val();
      $.ajax({
        url : "{{route('default.get-region-district')}}",
        type : "GET",
        data : {region_id:region_id,division_id:division_id},
        success:function(data){
          var html = '<option value="">Select District</option>';
          $.each(data,function(key,v){
            html +='<option value="'+v.district_id+'">'+v.regional_district.name+'</option>';
          });
          $('#district_id').html(html);
        }
      });
    });
  });
</script>

@endsection