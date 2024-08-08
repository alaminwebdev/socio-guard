@extends('backend.layouts.app')
@section('content')
<div class="col-xl-12">
  <div class="breadcrumb-holder">
    <h1 class="main-title float-left">User Information</h1>
    <ol class="breadcrumb float-right">
      <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><strong>Home</strong></a></li>
      <li class="breadcrumb-item active">User</li>
    </ol>
    <div class="clearfix"></div>
  </div>
</div>
@if ($errors->any())
  @foreach ($errors->all() as $error)
  <script type="text/javascript">
    $(function () {
      $.notify("{{$error}}", {globalPosition: 'top right', className: 'error'});
    });
  </script>
  @endforeach
  @endif
<div class="container fullbody">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <button id="addUser" class="btn btn-success btn-sm" data-toggle="modal" data-target="#userModal">
          <i class="ion-plus"></i> Add User</button>
        </div>
        <div class="card-body">
          <table id="datatable" class="table-sm table-hover table-bordered">
            <thead>
              <tr>
                <th>SN</th>
                <th>Name</th>
                <th>Email</th>                
                <th>Role</th>
                <th style="width:10%">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($user as $u)
              <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$u['name']}}</td>
                <td>{{$u['email']}}</td>                    
                <td>{{$u['role']['name']}}</td>
                <td>
                  <a class="editUser btn btn-sm btn-success" data-id="{{$u['id']}}">
                    <i class="fa fa-pencil-square-o"></i>
                  </a>
                  <a class="delete btn btn-sm btn-danger" data-id="{{$u['id']}}" 
                  data-table="users">
                  <i class="fa fa-trash"></i>
                </a>
              </td>

            </tr>
            @endforeach 
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!--End page content-->
<!--Bootstrap Modal without Animation-->
<!--===================================================-->


</div>

<!-- Modal -->
<div class="modal fade" id="userModal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Create User</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form id="menuForm" action="{{ route('user.store') }}" method="post" >
          {{ csrf_field()}}
          <input type="hidden" id="id" name="id" value="">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label class="control-label"><strong>User Name</strong></label>
                  <input type="text" id="name" name="name" value="{{old('name')}}" class="form-control" placeholder="Enter name" required>              
                </div>
              </div> 

              <div class="col-sm-12">
                <div class="form-group">
                  <label class="control-label"><strong>Email</strong></label>
                  <input type="email" id="email" name="email" value="{{old('email')}}" class="form-control" placeholder="Enter Email" required>               
                </div>
              </div> 

              <div class="col-sm-12">
                <div class="form-group">
                  <label class="control-label"><strong>Password</strong></label>
                  <input type="password" id="password"  value="" name="password" class="form-control" placeholder="Enter Password" required>
                  
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group">
                  <label class="control-label"><strong>Confirm Password</strong></label>
                  <input type="password"  value="" name="password_confirmation" class="form-control" placeholder="Enter Password Again" required>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label class="control-label"><strong>User Role</strong></label>
                  <select id="role_id" name="role_id" class="form-control">
                    <option value="">Select Role</option>      
                    @foreach($role as $r)
                    <option value="{{$r->id}}">{{$r->name}}</option>
                    @endforeach  
                  </select>   
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer text-right">
          <button id="submitButton" class="btn btn-success" type="submit">Store User</button>
        </div>

      </form>
    </div>
  </div>
</div>
</div>


<script type="text/javascript">

  $(document).ready(function() {
    $("#addUser").click(function(){
      $("input[type=text],select,input[type=email],input[type=password]").val("");
    });

     // var err='{{count($errors->all())}}';
     // if(err>0){
     //   $('#userModal').modal('show');
     // }
   });


  $(document).on('click','.editUser',function(){
    var id=$(this).attr("data-id");  
    $.ajax({
      url: "{{ route('user.edit','') }}"+"/"+id,
      type: "GET",
      success: function(data){
        $('#id').val(data.id);
        $('#name').val(data.name);
        $('#email').val(data.email);      
        $('#role_id').val(data.role_id).trigger('change');
        $('#submitButton').text('Update Menu');
        $('.modal-title').text('Edit User');
        $('#menuForm').attr('action', '{{route("user.update")}}');
        $('#userModal').modal('show');
      }
    });
  });
</script>

<!--===================================================-->
<!--End Bootstrap Modal without Animation-->
@endsection
