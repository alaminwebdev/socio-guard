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
      <div class="card-header">Create Role</div>
      <form action="{{ route('user.role.update', $editData->id) }}" method="post" id="myForm" autocomplete="off">
        {{ csrf_field() }}
        <div class="card-body">
          <div class="form-row">
            <div class="form-group col-sm-4">
              <label class="control-label">Role Name</label>
              <input type="text" value="{{ $editData->name }}" name="name" class="form-control">
              @if ($errors->has('name'))
              <span class="invalid-feedback">
                <strong>{{ $errors->first('name') }}</strong>
              </span>
              @endif
            </div>
            <div class="form-group col-md-4">
              <label class="control-label">Parent Role</label>
              <select name="role_id" class="form-control form-control">
                <option value="">Select Option</option>
                @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ ($editData->role_id == $role->id) ? "selected" : "" }}>{{ $role->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-8">
              <label class="control-label">Role Description</label>
              <textarea name="description" class="form-control" rows="4">{{ $editData->description }}</textarea>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-success">Submit</button>
          <button type="reset" class="btn btn-danger">Reset</button>
        </div>
      </form>
      <!--End Hover Rows-->
    </div>
  </div>
</div>

<script>
  $(document).ready(function(){
    $('#myForm').validate({
      errorClass:'text-danger',
        validClass:'text-success',
        rules : {
          'name' : {
            required : true,
          },
        },
        messages : {

        }
    });
  });
</script>
@endsection
