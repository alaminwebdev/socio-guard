@extends('backend.layouts.app')
@section('content')

<div class="col-xl-12">
  <div class="breadcrumb-holder">
    <h1 class="main-title float-left">Manage User sdf</h1>
    <ol class="breadcrumb float-right">
      <li class="breadcrumb-item">Home </li>
      <li class="breadcrumb-item active">User</li>
    </ol>
    <div class="clearfix"></div>
  </div>
</div>
<div class="container fullbody">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <div>
          <h5 class="m-0">User List</h5>
        </div>
        <div class="">
          <a class="btn btn-sm btn-success mr-1" href="{{route('user.add')}}"><i class="fa fa-plus-circle"></i> Add User</a>
          <a class="btn btn-sm btn-danger" target="_blank" href="{{route('user.export')}}" ><i class="fa fa-file-excel-o mr-1"></i>Export User</a>
        </div>
      </div>
      <div class="card-body">
        <table class="table-sm table-bordered table-striped dt-responsive nowrap" style="width: 100%" id="datatable">
          <thead>
            <tr>
              <th>Sl.</th>
              <th>Name</th>
              <th>Email</th>
              <th>User Role</th>
              <th>Mobile</th>
              <th>Pin</th>
              <th>Designation</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($allData as $key => $user)
            <tr class="{{$user->id}}">
              <td>{{$key+1}}</td>
              <td>{{$user->name}}</td>
              <td>{{$user->email}}</td>
              <td>
                @if($user->user_role->isEmpty())
                  <label class="badge badge-danger">Has no role</label>
                @else
                  @foreach($user->user_role as $role)
                    @if(!empty($role->role_details))                        
                      <label class="badge badge-success">{{$role->role_details->name}}</label>
                    @endif
                  @endforeach
                @endif
              </td>
              <td>{{$user->mobile}}</td>
              <td>{{$user->pin}}</td>
              <td>{{$user->designation}}</td>
              <td>
                <a class="btn btn-sm btn-success" title="Edit" href="{{route('user.edit',$user->id)}}"><i class="fa fa-edit"></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection