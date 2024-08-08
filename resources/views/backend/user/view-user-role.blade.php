@extends('backend.layouts.app')
@section('content')
<div class="col-xl-12">
  <div class="breadcrumb-holder">
    <h1 class="main-title float-left">User Role</h1>
    <ol class="breadcrumb float-right">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><strong>Home</strong></a></li>
      <li class="breadcrumb-item"><a href="{{ route('user') }}">User</a></li>
      <li class="breadcrumb-item active">Role</li>
    </ol>
    <div class="clearfix"></div>
  </div>
</div>
<div class="container fullbody">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <a href="{{ route('user.role.add') }}" class="btn btn-success btn-sm"><i class="ion-plus"></i> Add Role</a>
      </div>
      <div class="card-body">
        <table id="dataTable" class="table table-sm table-hover table-bordered">
          <thead>
            <tr>
              <th class="min-width">SL</th>
              <th>Role Name</th>
              <th>Parent Role</th>
              <th class="text-center" style="width: 8%">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($roles as $key => $role)
            <tr>
              <td>{{ ++$key }}</td>
              <td>{{ @$role->name }}</td>                
              <td>{{ @$role->parent_role['name'] }}</td>                
              <td class="text-center">
                <a href="{{ route('user.role.edit', @$role->id) }}" class="btn btn-sm btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <!--End Hover Rows-->
    </div>
  </div>
</div>

@endsection
