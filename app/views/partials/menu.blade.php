<ul class="nav nav-pills nav-stacked">
  @if($controller === 'Home')<li class="active">@else<li>@endif
    <a href="/">Home</a>
  </li>
  @if($controller === 'OrganizationUnitsController')<li class="active">@else<li>@endif
    <a href="{{action('OrganizationUnitsController@index')}}">Organizations</a>
  </li>
  @if($controller === 'PermissionsController')<li class="active">@else<li>@endif
    <a href="{{action('PermissionsController@index')}}">Permissions</a>
  </li>
  @if($controller === 'RolesController')<li class="active">@else<li>@endif
    <a href="{{action('RolesController@index')}}">Roles</a>
  </li>
  @if($controller === 'UserController')<li class="active">@else<li>@endif
    <a href="{{action('UserController@index')}}">Users</a>
  </li>
</ul>