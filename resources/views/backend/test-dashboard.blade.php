@extends('backend.layouts.app')
@section('content')
<style>
  .small-box>.inner {
    padding: 10px;
    color:white;
}
.small-box
{
  margin-bottom:10px;
  padding-bottom: 20px;
}

.bg-info {
    background-color: #3db9dc !important;
}

.bg-warning {
    background-color: #f1b53d !important;
}

.bg-success {
    background-color: #1bb99a !important;
}

.bg-danger {
    background-color: #ff5d48 !important;
}
.small-box .icon {
    color: rgba(0,0,0,.15);
    z-index: 0;
}
.small-box .icon>i {
    font-size: 90px;
    position: absolute;
    right: 15px;
    top: 15px;
    transition: all .3s linear;
}
</style>
<div class="col-xl-12">
	
</div>
<div class="container fullbody">

	<div class="col-md-12">
		<div class="row">
            <div class="col-md-4 col-sm-12">
              <div class="small-box bg-info">
                <div class="inner">
                  <h3>60 </h3>
  
                  <p>New Incident (Test Data)</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
              </div>
            </div>
            <div class="col-md-4 col-sm-12">
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3>1500</h3>
    
                  <p>Total Incident (Test Data)</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
              </div>
            </div>
            <div class="col-md-4 col-sm-12">
              <div class="small-box bg-success">
                <div class="inner">
                  <h3>3500</h3>
  
                  <p>(Test Data)</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3>10500</h3>
  
                  <p>(Test Data)</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
              </div>
            </div>
            
            
        </div>
	</div>
</div>
    
@endsection