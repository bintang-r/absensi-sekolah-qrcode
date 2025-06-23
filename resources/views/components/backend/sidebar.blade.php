<aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
            aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark">
            <a href="{{ route('home') }}" class="px-3">
                <img src="{{ asset('static/ryoogen.svg') }}" width="100%" height="100%" alt="Tabler">
            </a>
        </h1>
        <div class="navbar-nav flex-row d-lg-none">
            <x-backend._partials.profile-dropdown />
        </div>
        <div class="collapse navbar-collapse" id="sidebar-menu">
            <ul class="navbar-nav pt-lg-3">
                @foreach (config('sidebar') as $item)
                    <li
                        class="nav-item {{ isset($item['sub-menus']) ? 'dropdown' : '' }} {{ Route::is($item['route-name']) || Route::is($item['is-active']) ? 'active' : '' }}">
                        @if (!isset($item['sub-menus']))
                            @if (in_array(auth()->user()->roles, $item['roles']))
                                <a class="nav-link" href="{{ route($item['route-name']) }}"
                                    title="{{ $item['description'] }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <h2 class="las la-{{ $item['icon'] }}"></h2>
                                    </span>

                                    <span class="nav-link-title">
                                        {{ $item['title'] }}
                                    </span>
                                </a>
                            @endif
                        @else
                            @if (in_array(auth()->user()->roles, $item['roles']))
                                <a class="nav-link dropdown-toggle"
                                    href="#sidebar-{{ Str::random(10) }}-{{ Str::slug($item['title']) }}"
                                    data-bs-toggle="dropdown" role="button" aria-expanded="false"
                                    title="{{ $item['description'] }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <h2 class="las la-{{ $item['icon'] }}"></h2>
                                    </span>

                                    <span class="nav-link-title">
                                        {{ $item['title'] }}
                                    </span>
                                </a>

                                <div
                                    class="dropdown-menu {{ Route::is($item['route-name']) || Route::is($item['is-active']) ? 'show' : '' }}">
                                    <div class="dropdown-menu-columns">
                                        <div class="dropdown-menu-column">
                                            @foreach ($item['sub-menus'] as $item => $subMenu)
                                                @if (!isset($subMenu['sub-menus']))
                                                    <a class="dropdown-item {{ Route::is($subMenu['route-name']) || Route::is($subMenu['is-active']) ? 'active' : '' }}"
                                                        href="{{ route($subMenu['route-name']) }}">{{ $subMenu['title'] }}</a>
                                                @else
                                                    <div class="dropend">
                                                        <a class="dropdown-item dropdown-toggle"
                                                            href="#sidebar-{{ Str::random(10) }}-{{ Str::slug($subMenu['title']) }}"
                                                            data-bs-toggle="dropdown" role="button"
                                                            aria-expanded="false">{{ $subMenu['title'] }}</a>

                                                        <div
                                                            class="dropdown-menu {{ Route::is($subMenu['route-name']) || Route::is($subMenu['is-active']) ? 'show' : '' }}">
                                                            @foreach ($subMenu['sub-menus'] as $lastMenu)
                                                                <a href="{{ route($lastMenu['route-name']) }}"
                                                                    class="dropdown-item {{ Route::is($lastMenu['route-name']) || Route::is($lastMenu['is-active']) ? 'active' : '' }}">{{ $lastMenu['title'] }}</a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</aside>
