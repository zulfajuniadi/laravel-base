<ul class="nav nav-pills nav-stacked">
  @if($controller === 'Home')<li class="active">@else<li>@endif
    <a href="/">Home</a>
  </li>
  @if(User::canList())
    @if($controller === 'UsersController')<li class="active">@else<li>@endif
      <a href="{{action('UsersController@index')}}">Users</a>
    </li>
  @endif
  @if(OrganizationUnit::canList())
    @if($controller === 'OrganizationUnitsController')<li class="active">@else<li>@endif
      <a href="{{action('OrganizationUnitsController@index')}}">Organizations</a>
    </li>
  @endif
  @if(Role::canList())
    @if($controller === 'RolesController')<li class="active">@else<li>@endif
      <a href="{{action('RolesController@index')}}">Roles</a>
    </li>
  @endif
  @if(Permission::canList())
    @if($controller === 'PermissionsController')<li class="active">@else<li>@endif
      <a href="{{action('PermissionsController@index')}}">Permissions</a>
    </li>
  @endif
  <li>
    <a href="{{action('AuthController@logout')}}">Logout</a>
  </li>
</ul>