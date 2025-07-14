<div class="sidebar">
    <div class="sidebar-inner">
        <div class="sidebar-user-area">
        
            <div class="sidebar-user-content">
                 <a href="{{ setRoute('home') }}" class="sidebar-main-logo">
                    <h6 class="title">{{ Auth::user()->name }}</h6>
                 </a>
            </div>
        </div>
        @php
            $current_route = Route::currentRouteName();
        @endphp
        <div class="sidebar-menu-wrapper">
            <ul class="sidebar-menu">
                @include('admin.components.side-nav.link',[
                    'route'     => 'barang.index',
                    'title'     => "Barang Masuk",
                    'icon'      => "menu-icon las la-luggage-cart",
                    "permission" => "barang_masuk_index"
                ])
                @include('admin.components.side-nav.link-group',[
                    'group_title'       => "",
                    'group_links'       => [
                            'dropdown'      => [
                                [
                                    'title'             => "Master Data",
                                    'icon'              => "menu-icon las la-receipt",
                                    'links'     => [
                                        [
                                            'title'     => "Kategori",
                                            'route'     => "kategori.index",
                                            'permission' => "kategori_index"
                                        ],
                                        [
                                            'title'     => "Sub Kategori",
                                            'route'     => "subkategori.index",
                                            'permission' => "sub_kategori_index"
                                        ],
                                    ],
                                ],
                            ],
                    ]
                ])
                 @include('admin.components.side-nav.link',[
                    'route'     => 'user.index',
                    'title'     => "Manajemen User",
                    'icon'      => "menu-icon las la-user",
                    "permission" => "user_index"
                ])
            </ul>
        </div>
    </div>
</div>
