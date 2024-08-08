@extends('backend.layouts.app')
@section('content')
<style>
    .card-header{
        background: #4980b5;
        color:white;
        font-size:16px;
    }

    .custom-card-style{
        width:100%;
        margin: 10px 0px;
    }

    .custom_card_header{
        background: #667380;color: white;"
    }
</style>
<section style="margin-top:70px" class="content">
    <div class="container-fluid">
        <div class="card card-success card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fa fa-plus"></i>
                    Community Mobilisation Data Entry
                  {{-- <a href="{{route('incident.pollisomaj.viewpollisomajlist')}}" class="btn btn-sm btn-success float-right"><i class="fas fa-list"></i> Community Mobilization Data List</a> --}}
                  {{-- <a class="btn btn-sm btn-success float-right" href="{{route('incident.pollisomaj.viewpollisomajlist')}}"><i class="fa fa-list"></i> Community Mobilization Data List</a> --}}
			    </h3>
                <p style="text-align: right;margin-top: -17px;">Data Entry No. {{count($pollisomajData)>0 ? $pollisomajData[0]->id : ''}}</p>
            </div> 
            <div class="card-body show_module_more_event region_area_info">
                <div class="row">
                    @if ($step==null)
                        @include('backend.pollisomaj.pollisomajdata.create_step_1')
                    @else 
                        @php
                            $template='backend.pollisomaj.pollisomajdata.create_step_'.$step;
                        @endphp
                        @include($template)  
                    @endif
                </div> 
            </div>      
        </div>
    </div>
</section>    


@endsection