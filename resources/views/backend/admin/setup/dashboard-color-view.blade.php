@extends('backend.layouts.app')
@section('content')

<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">ড্যাশবোর্ড জন্য রঙ পরিচালনা করুন</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">হোম </li>
			<li class="breadcrumb-item active">ড্যাশবোর্ড জন্য রঙ</li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div>
<div class="container fullbody">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5>
ড্যাশবোর্ডের জন্য রঙের তালিকা
					<a class="btn btn-sm btn-success float-right" href="{{route('setup.color.add')}}"><i class="fa fa-plus-circle"></i> ড্যাশবোর্ড জন্য রঙ যোগ করুন</a>
				</h5>
			</div>
			<div class="card-body">
				<table class="table-sm table-bordered table-striped dt-responsive nowrap" style="width: 100%" id="datatable">
						<thead  >
							<tr>
								<th>ক্রমিক।</th>
								<th>ব্যবহারকারীর ধরন</th>
								<th>নাভবার রঙ</th>
								<th>শিশু নাভবার রঙ</th>
								<th>টেবিল রঙ</th>
								<th>কর্ম</th>
							</tr>
						</thead>
						<tbody>
							    <?php
							        if(Auth()->user()->usertype == '1'){
							            $usertype = 'admin';
							        }else{
							            $usertype = Auth()->user()->usertype;
							        }
							        $dashboardColors = DB::table('dashboard_colors')->where('usertype',$usertype)->first();
							    ?>
							@foreach($allData as $key => $color)
							<?php 
								if($color->usertype == 'admin'){
									$usertype = 'Admin';
								}else if($color->usertype == 'guestspeaker'){
									$usertype = 'Guest Speaker';
								}else if($color->usertype == 'participant'){
									$usertype = 'Participant';
								}
							?>
							<tr class="{{$color->id}}">
								<td>{{$key+1}}</td>
								<td>{{$usertype}}</td>
								<td class="text-center">
									<span style ="background:{{@$color->navbarbgcode}}; padding: 5px 25px 5px 25px; border-radius: 8px"></span>
									<span style ="background:{{@$color->navbartxtcode}}; padding: 5px 25px 5px 25px; border-radius: 8px; margin-left: 5px"></span>
								</td>
								<td class="text-center">
									<span style ="background:{{@$color->childnavbarbgcode}}; padding: 5px 25px 5px 25px; border-radius: 8px"></span>
									<span style ="background:{{@$color->childnavbartxtcode}}; padding: 5px 25px 5px 25px; border-radius: 8px; margin-left: 5px"></span>
								</td>
								<td class="text-center">
									<span style ="background:{{@$color->tablebgcode}}; padding: 5px 25px 5px 25px; border-radius: 8px"></span>
									<span style ="background:{{@$color->tabletxtcode}}; padding: 5px 25px 5px 25px; border-radius: 8px; margin-left: 5px"></span>
								</td>
								@if(crudpermission('setup.color.edit') !='')
								<td>
									<a class="btn btn-sm btn-success" title="Edit" href="{{route('setup.color.edit',$color->id)}}"><i class="fa fa-edit"></i></a>
								</td>
								@endif
							</tr>
							@endforeach
						</tbody>
					</table>
			</div>
		</div>
	</div>
</div>
@endsection