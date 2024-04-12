<button class="btn btn-{{ auth()->user()->getTheme() === 'light' ? 'dark' : 'light' }}"
        id="show-sidebar"
        style="padding-left: .60rem">
  <i class="fas fa-bars"></i>
</button>

<div class="sidebar-wrapper"
     id="sidebar">

  <div class="sidebar-content pb-2">
    <div class="sidebar-item text-white sidebar-brand">
      <a class="d-flex align-items-center justify-content-center"
         href="/">
        <i class="{{ env('APP_ICON', 'fas fa-dice') }} fa-rotate-by"
           style="--fa-rotate-angle: -25deg;"></i>
        <span class="sidebar-title ms-2">{{ config('app.name') }}</span>
      </a>
      <div class="ms-auto"
           id="close-sidebar"><i class="fas fa-times"></i></div>
    </div>

    <div class="sidebar-item sidebar-header d-flex align-items-center">
      <a class="user-info d-flex align-items-center me-auto"
         href="{{ route('user.edit', ['id' => auth()->user()->id]) }}">
        <div class="user-pic me-2">
          <img src="{{ \Creativeorange\Gravatar\Facades\Gravatar::get(auth()->user()->email) }}" />
        </div>
        <div class="d-flex flex-column">
          <span class="user-name text-nowrap">{{ auth()->user()->name }}</span>
          <div class="d-flex flex-nowrap">
            @foreach (auth()->user()->roles as $role)
              <span class="badge bg-{{ $role->name === 'admin' ? 'danger' : 'secondary' }} me-1">
                {{ ucfirst($role->name) }}
              </span>
            @endforeach
          </div>
        </div>
      </a>
      <a class="btn-form"
         data-bs-toggle="tooltip"
         data-bs-placement="right"
         data-form="#logout-form"
         href="#"
         title="Deconnexion">
        <i class="fas fa-arrow-right-from-bracket"></i>
      </a>
      <form id="logout-form"
            style="display: none;"
            method="POST"
            action="{{ route('logout') }}">
        @csrf
      </form>
    </div>

    <div class="sidebar-item sidebar-menu hide-scrollbar">
      <ul>

        <li class="primary d-flex align-items-center {{ Route::current()->getName() === 'dashboard' ? 'active' : '' }}">
          <a href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
          </a>
        </li>

        @if (auth()->user()->isAdmin())
          <li class="header-menu sidebar-item">Admin</li>

          <li
              class="dropdown danger sidebar-dropdown {{ Str::contains(Route::current()->getName(), 'game.') || Str::contains(Route::current()->getName(), 'option.') ? 'active' : '' }}">
            <a href="#">
              <i class="fas fa-fw fa-users"></i>
              <span>Games</span>
            </a>
            <div class="sidebar-submenu"
                 style="display:{{ Str::contains(Route::current()->getName(), 'game.') || Str::contains(Route::current()->getName(), 'option.') ? 'block' : 'none' }}">
              <ul class="p-0">
                <li class="danger {{ Str::contains(Route::current()->getName(), 'game.') ? 'active' : '' }}">
                  <a href="{{ route('game.index') }}">
                    <i class="fas fa-fw fa-dice"></i>
                    <span>Games</span>
                  </a>
                </li>
                <li class="danger {{ Str::contains(Route::current()->getName(), 'option.') ? 'active' : '' }}">
                  <a href="{{ route('option.index') }}">
                    <i class="fas fa-fw fa-cogs"></i>
                    <span>Options</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>

          <li
              class="dropdown danger sidebar-dropdown {{ Str::contains(Route::current()->getName(), 'user.') || Str::contains(Route::current()->getName(), 'preference.') ? 'active' : '' }}">
            <a href="#">
              <i class="fas fa-fw fa-users"></i>
              <span>Users</span>
            </a>
            <div class="sidebar-submenu"
                 style="display:{{ Str::contains(Route::current()->getName(), 'user.') || Str::contains(Route::current()->getName(), 'preference.') ? 'block' : 'none' }}">
              <ul class="p-0">
                <li class="danger {{ Str::contains(Route::current()->getName(), 'user.') ? 'active' : '' }}">
                  <a href="{{ route('user.index') }}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Users</span>
                  </a>
                </li>
                <li class="danger {{ Str::contains(Route::current()->getName(), 'preference.') ? 'active' : '' }}">
                  <a href="{{ route('preference.index') }}">
                    <i class="fas fa-fw fa-check"></i>
                    <span>Preferences</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
        @endif

      </ul>
    </div>
  </div>

  <div class="sidebar-footer">
    <div class="text-white m-auto"
         id="toggle-theme"
         data-bs-toggle="tooltip"
         data-bs-placement="top"
         title="Toggle {{ auth()->user()->getTheme() === 'light' ? 'dark' : 'light' }} mode"
         style="cursor: pointer">
      <i class="far fa-{{ auth()->user()->getTheme() === 'light' ? 'moon' : 'sun' }} m-auto"></i>
    </div>
  </div>
</div>
