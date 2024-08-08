@extends('backend.layouts.app')
@section('content')
<div class="container fullbody">
    
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Incident List
                        <a class="btn btn-sm btn-success float-right" href="{{url('incident/selp/add')}}?addnew=true"><i class="fa fa-plus-circle"></i> Add Selp Incident</a>
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table-sm table-bordered table-striped dt-responsive nowrap" style="width: 100%" id="datatable">
                        <thead  >
                            <tr>
                                <th>Sl.</th>
                                <th>Incident Id</th>
                                <th>Survivor Name</th>
                                <th>Survivor Age</th>
                                <th>Posting Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        @foreach ($incidents as $key=>$item)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$item->dispute_id}}</td>
                                <td>{{$item->survivor_name}}</td>
                                <td>{{$item->survivor_age}}</td>
                                <td>{{date("d-m-Y", strtotime($item->created_at))}}</td>
                                <td>
                                    <a class="btn btn-sm btn-success" title="view" href="{{route('view-single-incident',$item->id)}}"><i class="fa fa-eye"></i></a>
                                    <a class="btn btn-sm btn-primary" title="Edit" href="{{route('incident.selp.edit',$item->selp_incident_ref)}}"><i class="fa fa-edit"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                
        </div>
    </div>


@endsection