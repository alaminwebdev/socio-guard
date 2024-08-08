<style type="text/css">
    .tg  {border-collapse:collapse;border-spacing:0;width:100%}
    .tg td{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
      overflow:hidden;padding:10px 5px;word-break:normal;}
    .tg th{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
      font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
    .tg .tg-0pky{border-color:inherit;text-align:left;vertical-align:top}
    </style>

@extends('backend.layouts.app')
@section('content')

<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Manage Zone Wise User</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active">Zone Wise User</li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div>
@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            $(function () {
                $.notify("{{ $error }}", {globalPosition: 'bottom right', className: 'error'});
            });
        </script>
    @endforeach
@endif
<div class="container fullbody">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h5>
            Zone Wise User List
            <a class="btn btn-sm btn-success float-right" href="{{ route('user.setup.add') }}"><i class="fa fa-plus-circle"></i> Add Zone Wise User</a>
          </h5>
        </div>
              <div class="card-body" style="width:100%;overflow-x:scroll">
                <form method="get" action="{{route('user.setup.view')}}">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="email">PIN Number:</label>
                          <input type="text" class="form-control" name="pin" value="{{$queryparam->pin}}" id="email">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <label style="visibility:hidden;display:block" for="email">PIN Number:</label>
                        <button type="submit" class="btn btn-success">Search</button>
                        <a class="btn btn-warning" href="{{ route('user.setup.view') }}"><i class="fa fa-refresh"></i> Reset</a>
                      </div>
                    </div>
                    
                    
                </form>
                <hr>
                  <table class="table-bordered tg">
                      <thead>
                        <tr>
                          <th class="tg-0pky" rowspan="2">SI</th>
                          <th class="tg-0pky" rowspan="2">Zone</th>
                          <th class="tg-0pky" rowspan="2">Role</th>
                          <th class="tg-0pky" rowspan="2">Name</th>
                          <th class="tg-0pky" rowspan="2">Pin</th>
                          <th class="tg-0pky">Address</th>
                          <th class="tg-0pky"></th>
                          <th class="tg-0pky"></th>
                          <th class="tg-0pky"></th>
                          <th class="tg-0pky"></th>
                          <th class="tg-0pky"></th>
                          <th class="tg-0pky" rowspan="2">Status</th>
                          <th class="tg-0pky" rowspan="2">Action</th>
                        </tr>
                        <tr>
                          <th class="tg-0pky">Division</th>
                          <th class="tg-0pky">District</th>
                          <th class="tg-0pky">Upazila</th>
                          <th class="tg-0pky">Union</th>
                          <th class="tg-0pky">Date from</th>
                          <th class="tg-0pky">Date to</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($userssetup as $key=>$item)
                          @php
                              $getUserList=\App\Model\Admin\Setup\CEP_Region\SetupUserArea
                              
                              ::withTrashed()
                              ->with(['setup_user_division','setup_user_district','setup_user_upazila','setup_user_union'])
                              ->where('region_id',$item->region_id)
                              ->join('users','users.id','=','setup_user_areas.user_id')
                              ->select('setup_user_areas.*')
                              ->when($queryparam,function($query,$queryparam){
                                  if($queryparam->pin!=null || isset($queryparam->pin)){
                                      return $query->where('users.pin',$queryparam->pin);
                                  }
                                  return $query;
                              })
                              ->get();
                              // dd($getUserList[0]->setup_user_union);
                          @endphp
                          @if ($item->Totaluser >1)
                            
                            @for ($i = 0; $i < count($getUserList); $i++)
                              @if ($getUserList[$i]->users !=null)
                                  
                              
                                @if ($i==0)
                                  <tr>
                                    <td class="tg-0pky" rowspan="{{$item->Totaluser}}">{{$key+1}}</td>
                                    <td class="tg-0pky" rowspan="{{$item->Totaluser}}">{{$item->region_name}}</td>
                                    <td class="tg-0pky">{{$getUserList[$i]->users->designation}}</td>
                                    <td class="tg-0pky">{{$getUserList[$i]->users->name}}</td>
                                    <td class="tg-0pky">{{$getUserList[$i]->users->pin}}</td>
                                    <td class="tg-0pky">{{@$getUserList[$i]->setup_user_division->name}}</td>
                                    <td class="tg-0pky">{{@$getUserList[$i]->setup_user_district->name}}</td>
                                    <td class="tg-0pky">{{@$getUserList[$i]->setup_user_upazila->name}}</td>
                                    <td class="tg-0pky">{{@$getUserList[$i]->setup_user_union->name}}</td>
                                    <td class="tg-0pky">{{$getUserList[$i]->date_from}}</td>
                                    <td class="tg-0pky">{{$getUserList[$i]->date_to}}</td>
                                    <td class="tg-0pky"><input type="checkbox" {{ ($getUserList[$i]['status'] == 1) ? 'checked' : '' }} data-toggle="toggle" data-on="Active" data-off="Inactive" data-size="small" onchange="changeStatus($(this), {{ $getUserList[$i]->id }});"></td>
                                    
                                    <td class="tg-0pky">
                                      <a class="btn btn-sm btn-success" title="Edit" href="{{ route('user.setup.edit', ['user_id'=>$getUserList[$i]->user_id,'region_id'=>$item->region_id]) }}"><i class="fa fa-edit"></i></a>
                                    </td>
                                  </tr>
                                @else
                                  
                                      <tr>
                                        <td class="tg-0pky">{{$getUserList[$i]->users->designation}}</td>
                                        <td class="tg-0pky">{{$getUserList[$i]->users->name}}</td>
                                        <td class="tg-0pky">{{$getUserList[$i]->users->pin}}</td>
                                        <td class="tg-0pky">{{@$getUserList[$i]->setup_user_division->name}}</td>
                                        <td class="tg-0pky">{{@$getUserList[$i]->setup_user_district->name}}</td>
                                        <td class="tg-0pky">{{@$getUserList[$i]->setup_user_upazila->name}}</td>
                                        <td class="tg-0pky">{{@$getUserList[$i]->setup_user_union->name}}</td>
                                        <td class="tg-0pky">{{$getUserList[$i]->date_from}}</td>
                                        <td class="tg-0pky">{{$getUserList[$i]->date_to}}</td>
                                        <td class="tg-0pky"><input type="checkbox" {{ ($getUserList[$i]['status'] == 1) ? 'checked' : '' }} data-toggle="toggle" data-on="Active" data-off="Inactive" data-size="small" onchange="changeStatus($(this), {{ $getUserList[$i]->id }});"></td>
                                        
                                        <td class="tg-0pky">
                                          <a class="btn btn-sm btn-success" title="Edit" href="{{ route('user.setup.edit', ['user_id'=>$getUserList[$i]->user_id,'region_id'=>$item->region_id]) }}"><i class="fa fa-edit"></i></a>
                                        </td>
                                      </tr>
                                  
                                  
                                @endif
                              @endif  
                            @endfor
                           
                            
                          @else
                            
                              @for ($i = 0; $i < count($getUserList); $i++)
                                @if ($getUserList[$i]->users!=null)
                                  <tr>
                                    <td class="tg-0pky">{{$key+1}}</td>
                                    <td class="tg-0pky">{{$item->region_name}}</td>
                                    <td class="tg-0pky">{{$getUserList[$i]->users->designation}}</td>
                                    <td class="tg-0pky">{{$getUserList[$i]->users->name}}</td>
                                    <td class="tg-0pky">{{$getUserList[$i]->users->pin}}</td>
                                    <td class="tg-0pky">{{@$getUserList[$i]->setup_user_division->name}}</td>
                                    <td class="tg-0pky">{{@$getUserList[$i]->setup_user_district->name}}</td>
                                    <td class="tg-0pky">{{@$getUserList[$i]->setup_user_upazila->name}}</td>
                                    <td class="tg-0pky">{{@$getUserList[$i]->setup_user_union->name}}</td>
                                    <td class="tg-0pky">{{$getUserList[$i]->date_from}}</td>
                                    <td class="tg-0pky">{{$getUserList[$i]->date_to}}</td>
                                    <td class="tg-0pky"><input type="checkbox" {{ ($getUserList[$i]['status'] == 1) ? 'checked' : '' }} data-toggle="toggle" data-on="Active" data-off="Inactive" data-size="small" onchange="changeStatus($(this), {{ $getUserList[$i]->id }});"></td>
                                    <td class="tg-0pky">
                                      <a class="btn btn-sm btn-success" title="Edit" href="{{ route('user.setup.edit', ['user_id'=>$getUserList[$i]->user_id,'region_id'=>$item->region_id]) }}"><i class="fa fa-edit"></i></a>
                                    </td>
                                  </tr>
                                @endif  
                              @endfor  
                            
                            
                          @endif
                            
                        @endforeach
                        
                        
                      </tbody>
                  </table>
              </div>
              <hr>
              <div class="row">
                <div class="offset-1 col-md-12">
                  {{$userssetup->withQueryString()->links()}}
                </div>
              </div>
              
          </div>
    </div>
  </div>
	
</div>      


<script>
  function changeStatus(item, id)
    {
    	var status = 0;
    	if (item.is(':checked')) {
    		status = 1;
    	}

    	var url  = "{{ route('changeUserRegionAreaStatus') }}";
    	var data = {
    		id: id,
    		status: status
    	}

    	$.get(url, data, function(response) {
    		console.log(response);
    	});
    }
</script>
@endsection