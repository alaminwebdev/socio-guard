

@if (count($pollisomajData) > 0 && count($pollisomajData[0]->theatreList) > 0 )
    <div class="card custom-card-style region_area">
        <div class="card-header">
            16. Popular Theatre show
        </div>
        @foreach ($pollisomajData[0]->theatreList as $key=>$item)
        
        <div class="card-body card-bg margin-bottom">
            <div class="row  region_area_info card-bg">
                <div class="col-md-2">
                    1. Spot name
                </div>
                <div class="col-md-2">
                    <input value="{{$item->spot_name}}" type="text" class=" form-control form-control-sm" name="spot_name[]" id="">
                </div>
                <div class="col-md-1">
                    Category
                </div>
                <div class="col-md-3">
                    <select class="form-control-sm" name="theatre_category[]" id="">
                        <option value="">Select category</option>
                        <option {{$item->theatre_category ==1 ? "selected" : ''}} value="1">SPA</option>
                        <option {{$item->theatre_category ==2 ? "selected" : ''}} value="2">Cost Recovery</option>
                        <option {{$item->theatre_category ==3 ? "selected" : ''}} value="3">Project</option>
                        <option {{$item->theatre_category ==4 ? "selected" : ''}} value="4">Special</option>
                        <option {{$item->theatre_category ==5 ? "selected" : ''}} value="5">Others</option>
                    </select>
                </div>
                
                <div class="col-md-1">
                    Theme
                </div>
                <div class="col-md-3">
                    <select class="form-control-sm" name="theatre_theme[]" id="">
                        <option value="">Select theme</option>
                        <option {{$item->theatre_theme ==1 ? "selected" : ''}} value="1">Child marriage</option>
                        <option {{$item->theatre_theme ==2 ? "selected" : ''}} value="2">Dowry</option>
                        <option {{$item->theatre_theme ==3 ? "selected" : ''}} value="3">Rape</option>
                        <option {{$item->theatre_theme ==4 ? "selected" : ''}} value="4">Sexual harassment</option>
                        <option {{$item->theatre_theme ==5 ? "selected" : ''}} value="5">Cyberbullying</option>
                        <option {{$item->theatre_theme ==6 ? "selected" : ''}} value="6">Bkash, Ramitance, microfinance</option>
                        <option {{$item->theatre_theme ==7 ? "selected" : ''}} value="7">Migration / Trafficking</option>
                        <option {{$item->theatre_theme ==8 ? "selected" : ''}} value="8">Disaster management</option>
                        <option {{$item->theatre_theme ==9 ? "selected" : ''}} value="9">Agriculture and food security</option>
                        <option {{$item->theatre_theme ==10 ? "selected" : ''}} value="10">Health</option>
                    </select>
                </div>
                <br>
                <div class="form-group col-md-3">
                    <input  type="text" style="visibility:hidden" class="form-control form-control-sm" name="theatre_perticipent[]" id="">
                    <label class="control-label">2. Participants</label>
                    
                </div>
                <div class="col-md-9">
                    <div class="margin-bottom row">
                        <div class="form-group col-md-2">
                            <label class="control-label">Girls</label>
                            <input value="{{$item->par_girl}}" type="number" class="form-control form-control-sm" name="theatre_perticipent_girl[]" id="">
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label">Boys</label>
                            <input value="{{$item->par_boy}}" type="number" class="form-control form-control-sm" name="theatre_perticipent_boy[]" id="">
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label">Women</label>
                            <input value="{{$item->par_women}}" type="number" class="form-control form-control-sm" name="theatre_perticipent_women[]" id="">
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label">Men</label>
                            <input value="{{$item->par_men}}" type="number" class="form-control form-control-sm" name="theatre_perticipent_men[]" id="">
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label">Transgender</label>
                            <input value="{{$item->par_transgender}}" type="number" class="form-control form-control-sm" name="theatre_perticipent_transgender[]" id="">
                        </div>
                        <div class="form-group col-md-2">
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label">Girls</label>
                            <input value="{{$item->par_girl}}" type="number" class="form-control form-control-sm" name="theatre_perticipent_girl_pwd[]" id="">
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label">Boys</label>
                            <input value="{{$item->par_boy}}" type="number" class="form-control form-control-sm" name="theatre_perticipent_boy_pwd[]" id="">
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label">Women</label>
                            <input value="{{$item->par_women}}" type="number" class="form-control form-control-sm" name="theatre_perticipent_women_pwd[]" id="">
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label">Men</label>
                            <input value="{{$item->par_men}}" type="number" class="form-control form-control-sm" name="theatre_perticipent_men_pwd[]" id="">
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label">Transgender</label>
                            <input value="{{$item->par_transgender}}" type="number" class="form-control form-control-sm" name="theatre_perticipent_transgender_pwd[]" id="">
                        </div>
                        <div class="form-group col-md-2">
                            <i style="margin-top:23px" class="fa fa-plus btn btn-sm btn-info" onclick="add($(this));"></i>
                            <i style="margin-top:23px" class="fa fa-minus btn btn-sm btn-danger btn-remove {{$key > 0 ? "" : "d-none"}}" data-type="delete" onclick="remove($(this));"></i>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        @endforeach
        
        <div style="margin:10px" class="extra_region_area_info"></div>
    </div> 
@else
<div class="card custom-card-style region_area ">
    <div class="card-header">
        16. Popular Theatre show
    </div>
    
    
    <div class="card-body card-bg margin-bottom">
        <div class="row  region_area_info margin-bottom">
            <div class="col-md-2">
                1. Spot name
            </div>
            <div class="col-md-2">
                <input type="text" class=" form-control form-control-sm" name="spot_name[]" id="">
            </div>
            <div class="col-md-1">
                Category
            </div>
            <div class="col-md-3">
                <select class="form-control-sm" name="theatre_category[]" id="">
                    <option value="">Select category</option>
                    <option value="">SPA</option>
                    <option value="">Cost Recovery</option>
                    <option value="">Project</option>
                    <option value="">Special</option>
                    <option value="">Others</option>
                </select>
            </div>
            
            <div class="col-md-1">
                Theme
            </div>
            <div class="col-md-3">
                <select class="form-control-sm" name="theatre_theme[]" id="">
                    <option value="">Select theme</option>
                    <option value="">Child marriage</option>
                    <option value="">Dowry</option>
                    <option value="">Rape</option>
                    <option value="">Sexual harassment</option>
                    <option value="">Cyberbullying</option>
                    <option value="">Bkash, Ramitance, microfinance</option>
                    <option value="">Migration / Trafficking</option>
                    <option value="">Disaster management</option>
                    <option value="">Agriculture and food security</option>
                    <option value="">Health</option>
                </select>
            </div>
            <br>
            <div class="form-group col-md-3">
                <input  type="text" style="visibility:hidden" class="form-control form-control-sm" name="theatre_perticipent[]" id="">
                <label class="control-label">2. Participants</label>
                
            </div>
            <div class="col-md-9 ">
                <div class="margin-bottom row">
                    <div class="form-group col-md-2">
                        <label class="control-label">Girls</label>
                        <input  type="number" class="form-control form-control-sm" name="theatre_perticipent_girl[]" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Boys</label>
                        <input  type="number" class="form-control form-control-sm" name="theatre_perticipent_boy[]" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Women</label>
                        <input  type="number" class="form-control form-control-sm" name="theatre_perticipent_women[]" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Men</label>
                        <input  type="number" class="form-control form-control-sm" name="theatre_perticipent_men[]" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Transgender</label>
                        <input  type="number" class="form-control form-control-sm" name="theatre_perticipent_transgender[]" id="">
                    </div>
                    <div class="form-group col-md-2">
                        <i style="margin-top:23px" class="fa fa-plus btn btn-sm btn-info" onclick="add($(this));"></i>
                        <i style="margin-top:23px" class="fa fa-minus btn btn-sm btn-danger btn-remove d-none" data-type="delete" onclick="remove($(this));"></i>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
  
    
    <div class="card-body extra_region_area_info"></div>
</div> 
@endif
     