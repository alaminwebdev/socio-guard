
@if (@$editData)
    <form method="post" action="{{ route('swapnosarothiskill.update', @$editData->id) }}" id="myForm">   
    @method('PUT')
@else
    <form method="post" action="{{ route('swapnosarothiskill.store') }}" id="myForm">
@endif
@csrf
    <div class="card-body">
        <div class="show_module_more_event">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label class="control-label">Order</label>
                    <input type="number" name="order" class="form-control form-control-sm" value="{{old('order', @$editData->order)}}" placeholder="Order">
                    @error('order')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label class="control-label">Skill Code <span class="text-danger">*</span></label>
                    <input type="text" name="code" class="form-control form-control-sm" value="{{old('code', @$editData->code)}}" placeholder="Skill Code">
                    @error('code')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label class="control-label">Skill Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control form-control-sm" value="{{old('name', @$editData->name)}}" placeholder="Skill Name">
                    @error('name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
            
        <button type="submit" class="btn btn-success btn-sm">{{  @$editData ? 'Update' : 'Submit' }}</button>
        <button type="reset" class="btn btn-danger btn-sm">Reset</button>
    </div>
</form>

