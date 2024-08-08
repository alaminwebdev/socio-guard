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

    .bg-color{
        background: #e9ecef;
    }

    .m-bottom{
        margin-bottom: 10px;
    }

    .v-hidden{
        visibility: hidden;
    }

    .m-top{
        margin-top:10px;
    }

    .p-top{
        padding-top:10px;
    }

    .p-left{
        padding-top:10px;
    }
</style>
<section style="margin-top:70px" class="content">
    <div class="container-fluid">
        <div class="card card-success card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fa fa-plus"></i>
                    Activity Data Entry
                  {{-- <a href="{{route('view.pollisomaj')}}" class="btn btn-primary btn-sm btn-flat float-right"><i class="fas fa-list"></i> View Pollisomaj Wise Member</a> --}}
			    </h3>
                <p style="text-align: right;margin-top: -17px;">Data Entry No. {{count($activityData)>0 ? $activityData[0]->id : ''}}</p>
            </div> 
            <div class="card-body show_module_more_event region_area_info">
                <div class="row">
                    @if ($step==null)
                        @include('backend.activity.create_step_1')
                    @else 
                        @php
                            $template='backend.activity.create_step_'.$step;
                        @endphp
                        @include($template)  
                    @endif
                </div> 
            </div>      
        </div>
    </div>
</section>    


@endsection