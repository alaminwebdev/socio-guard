let item=2;

function addNewRegionContainer(){
    let html=`<div class="row">
    <div class="form-group col-md-2">
        <label class="control-label">Zone</label>
        <select name="region_id[]"  id="region_id_${item}" class="form-control form-control-sm region_id" required="" onchange="getRegionalDivision(this.options[this.selectedIndex].value, $(this));">
            <option value="">Select Zone</option>
            @foreach($regions as $region)
            <option value="{{ $region->id }}">{{ $region->region_name }}</option>
            @endforeach
        </select>
        
    </div>
    <div class="form-group col-md-2">
        <label class="control-label">Division</label>
        <select name="division_id[]" id="division_id_${item}" class="form-control form-control-sm division_id" onchange="getRegionalDivisionDistrict(this.options[this.selectedIndex].value, $(this));">
            <option value="">Select Division</option>
        </select>
    </div>
    <div class="form-group col-md-2">
        <label class="control-label">District</label>
        <select name="district_id[]" id="district_id_${item}" class="form-control form-control-sm district_id" onchange="getDistrictUpazila(this.options[this.selectedIndex].value, $(this));">
            <option value="">Select District</option>
        </select>
    </div>
    <div class="form-group col-md-2">
        <label class="control-label">Upazila</label>
        <select name="upazila_id[]" id="upazila_id_${item}" class="form-control form-control-sm upazila_id" onchange="getUpazilaUnion(this.options[this.selectedIndex].value, $(this));">
            <option value="">Select Upazila</option>
        </select>
    </div>
    <div class="form-group col-md-2">
        <label class="control-label">Union</label>
        <select name="union_id[]" id="union_id_${item}" class="form-control form-control-sm union_id">
            <option value="">Select Union</option>
        </select>
    </div>
    <div class="form-group col-md-1">
        <label class="control-label">Date from</label>
        <input type="date" class="form-control form-control-sm" name="date_from[]" id="">
    </div>
    <div class="form-group col-md-1">
        <label class="control-label">Date to</label>
        <input type="date" class="form-control form-control-sm" name="date_to[]" id="">
    </div>
    <div class="form-group col-md-1">
        <i class="fa fa-plus btn btn-sm btn-info" onclick="add($(this));"></i>
        <i class="fa fa-minus btn btn-sm btn-danger btn-remove" data-type="delete" onclick="remove($(this));"></i>
    </div>
</div>`
    item++
    return html;
}