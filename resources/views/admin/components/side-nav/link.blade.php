@php
    $current_route = Route::currentRouteName();
@endphp
@if (isset($route) && $route != "")
      @if (auth()->user()->can($permission) || auth()->user()->hasRole('admin')) 
        <li class="sidebar-menu-item @if ($current_route == $route) active @endif">
            <a href="{{ setRoute($route) }}">
                <i class="{{ $icon ?? "" }}"></i>
                @php
                    $title = $title ?? "";
                @endphp
                <span class="menu-title">{{ __($title) }}</span>
            </a>
        </li>
    @endif
@endif
