@extends('backend.layouts.app')
@section('content')

<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Swapnosarothi Skill Setup</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active"> Swapnosarothi Skill Setup</li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div>
<div class="container fullbody">
	<div class="col-md-12 mb-3">
		<div class="card">
			<div class="card-header">
				<h5>
					<a class="btn btn-sm btn-success float-right" href="{{ route('swapnosarothiskill.create') }}">
                        <i class="fa fa-list"></i> Add Skill</a></h5>
			</div>
			
		</div>
	</div>
    <div class="col-md-12 ">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sl.</th>
                            <th>Order</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($skills as $skill)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $skill->order }}</td>
                                <td>{{ $skill->code }}</td>
                                <td>{{ $skill->name }}</td>
                                <td>{{ $skill->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('swapnosarothiskill.edit', $skill->id) }}" class="btn btn-sm btn-info" title="Edit"><i class="fa fa-edit"></i></a>

                                    <form action="{{ route('swapnosarothiskill.destroy', $skill->id) }}" method="POST"  class=" d-inline" title="Delete">
                                        @csrf
                                        @method('DELETE')
                                         <button type="submit" class="btn btn-sm btn-danger" style="min-width:auto"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- extra html -->

@endsection