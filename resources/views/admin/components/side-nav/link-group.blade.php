@php
    $current_route = Route::currentRouteName();
@endphp
@if (isset($group_links) && is_array($group_links))

    @if (isset($group_links['dropdown']) && count($group_links['dropdown']) > 0)

        @php
            $title_permission = false;
            $dropdown_items = [];
        @endphp
        @foreach ($group_links['dropdown'] as $key => $item)
            @if (isset($item['links']) && count($item['links']) > 0)
                @php
                    $routes = Arr::pluck($item['links'],"route");
                        foreach($item['links'] as $nas){
                             if(auth()->user()->can($nas['permission']) || auth()->user()->hasRole('admin')) {
                                $title_permission = true;
                                continue;
                             }
                        }
                    $dropdown_items[] = [
                        'title'     => __($item['title']),
                        'links'     => $item['links'],
                        'routes'    => $routes,
                        'icon'      => $item['icon'] ?? "",
                    ];
                @endphp
            @endif
        @endforeach
        @if ($title_permission === true)
            <li class="sidebar-menu-header">{{ $group_title ? __($group_title) : "" }}</li>
        @endif

        @foreach ($dropdown_items as $item)
            <li class="sidebar-menu-item sidebar-dropdown @if (in_array($current_route,$item['routes'])) active @endif">
                @if ($title_permission === true)
                    <a href="javascript:void(0)">
                        <i class="{{ $item['icon'] ?? "" }}"></i>
                        <span class="menu-title">{{ $item['title'] ?? "" }}</span>
                    </a>
                 @endif
                <ul class="sidebar-submenu">
                    <li class="sidebar-menu-item">
                        @foreach ($item['links'] as $nav_item)
                         @if (auth()->user()->can($nav_item['permission']) || auth()->user()->hasRole('admin')) 
                                @include('admin.components.side-nav.dropdown-link',[
                                    'title'         => __($nav_item['title']),
                                    'route'         => $nav_item['route'],
                                ])
                            @endif
                        @endforeach
                    </li>
                </ul>
            </li>
        @endforeach
    @endif

@endif
