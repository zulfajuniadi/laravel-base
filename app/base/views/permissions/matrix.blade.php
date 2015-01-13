<div class="form-group">
    <label for="name" class="control-label col-lg-2 col-sm-2">Permissions</label>
    <div class="col-lg-10 col-sm-10">
        <div class="row permission-matrix">
            @if ($last = null) @endif
            @foreach(Permission::orderBy('group_name')->get() as $permission)
                @if($permission->group_name !== $last)
                    <div class="clearfix"></div>
                    <p><b>{{ $permission->group_name }}</b></p>
                    <hr>
                @endif
                <div class="col-sm-3">
                    <input type="checkbox" name="perms[]" value="{{$permission->id}}"
                    @if(isset($role) && in_array($permission->id, $role->perms->lists('id')))checked="checked"@endif>
                    {{$permission->display_name}}
                </div>
                @if($permission->group_name !== $last)
                    @if ($last = $permission->group_name) @endif
                @endif
            @endforeach
            <div class="clearfix"></div>
        </div>
    </div>
</div>
