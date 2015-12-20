<div class="row">
    <div class="col-md-2 text-center">
        <img class="avatar img-responsive img-thumbnail" alt="Avatar" src="{!! $user->getAvatarUrl() !!}">
    </div>
    <div class="col-md-10">
        <div class="row">
            <dl class="col-md-6">
                <dt>{{trans('users.name')}}</dt>
                <dd>{{$user->name}}</dd>
            </dl>
            <dl class="col-md-6">
                <dt>{{trans('users.email')}}</dt>
                <dd>{{$user->email}}</dd>
            </dl>
            <dl class="col-md-6">
                <dt>{{trans('users.avatar_url')}}</dt>
                <dd>{{$user->avatar_url}}</dd>
            </dl>
            <dl class="col-md-6">
                <dt>{{trans('users.is_active')}}</dt>
                <dd>{{$user->status()}}</dd>
            </dl>
            <dl class="col-md-6">
                <dt>{{trans('roles.roles')}}</dt>
                <dd>
                    <ul class="list-unstyled">
                    @forelse($user->roles as $role)
                        <li>{{$role->display_name}}</li>
                    @empty
                        {{trans('users.profile_no_roles')}}
                    @endforelse
                    </ul>
                </dd>
            </dl>
            <dl class="col-md-6">
                <dt>{{trans('users.created_at')}}</dt>
                <dd>{{$user->created_at}}</dd>
            </dl>
            <dl class="col-md-6">
                <dt>{{trans('users.updated_at')}}</dt>
                <dd>{{$user->updated_at}}</dd>
            </dl>
        </div>
    </div>
</div>