<form method="POST" action="{{ route('swapnosarothiprofileskill.store') }}" id="myForm">
@csrf
    <div class="card-body">
        <div class="show_module_more_event">
            <div class="form-row">
                <input type="hidden" name="profile_table_id" value="{{ $skillDatas->profile_id }}">
                <input type="hidden" name="group_table_id" value="{{ $skillDatas->group_id }}">
                <div class="form-group col-md-4">
                    <label class="control-label">Skill</label>
                    <select name="skill_table_id" class="form-control form-control-sm select2">
                        <option value="">Select Skill</option>
                        @foreach ($skills as $skill)
                            <option value="{{ $skill->id }}" {{ $loop->iteration == 1 ? 'selected' : 'disabled' }}>{{ $skill->name }}</option>
                        @endforeach
                    </select>
                    @error('skill_table_id')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label class="control-label">Skill Date <span class="text-danger">*</span></label>
                    <input type="date" name="skill_date" class="form-control form-control-sm" value="{{old('skill_date')}}"   min="{{ count($skillDatas->profile_skills) >= 1 ? $skillDatas->profile_skills->last()->skill_date->format('Y-m-d') : ($skillDatas->start_date ? $skillDatas->start_date->format('Y-m-d') : "") }}">
                    @error('skill_date')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
            
        <button type="submit" class="btn btn-success btn-sm">Submit</button>
        <button type="reset" class="btn btn-danger btn-sm">Reset</button>
    </div>
</form>

