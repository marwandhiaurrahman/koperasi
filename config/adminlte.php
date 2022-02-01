<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'Koperasi SMK 5 Kuningan',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => true,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>SMK 5 Kuningan</b>',
    'logo_img' => 'vendor/adminlte/dist/img/smk5kuningan500x500.png',
    'logo_img_class' => 'brand-image img-circle',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Koperasi',

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => true,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => 'text-sm ',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items:
        [
            'type'         => 'navbar-search',
            'text'         => 'search',
            'topnav_right' => true,
        ],
        [
            'type'         => 'fullscreen-widget',
            'topnav_right' => true,
        ],

        // Sidebar items:
        [
            'type' => 'sidebar-menu-search',
            'text' => 'search',
        ],

        [
            'text'        => 'Dashboard',
            'url'         => 'dashboard',
            'icon'        => 'fas fa-fw fa-home',
        ],
        [
            'header' => 'MENU ANGGOTA',
            // 'can' => 'user-role'
        ],
        [
            'text'        => 'Simpanan',
            'url'         => 'anggota/simpanan',
            'icon'        => 'fas fa-fw fa-coins',
        ],
        [
            'text'        => 'Pinjaman',
            'url'         => 'anggota/pinjaman',
            'icon'        => 'fas fa-fw fa-hand-holding-usd',
        ],
        [
            'text'        => 'Transaksi',
            'url'         => 'anggota/transaksi',
            'active' => ['anggota/transaksi', 'regex:@^anggota/transaksi/[0-9]+$@', 'regex:@^anggota/transaksi/[0-9]/edit+$@', 'anggota/transaksi/create'],
            'icon'        => 'fas fa-fw fa-money-bill-wave',
        ],
        [
            'text'        => 'Laporan',
            'url'         => '#',
            'icon'        => 'fas fa-fw fa-file-invoice-dollar',
            'can' => ['admin', 'pengawas', 'anggota-role']
        ],
        ['header' => 'MENU ADMIN', 'can' => ['admin', 'pengawas']],
        [
            'text'        => 'Keanggotaan',
            'url'         => 'admin/anggota',
            'icon'        => 'fas fa-fw fa-users',
            'can' => ['admin', 'pengawas']

        ],
        [
            'text'        => 'Simpanan',
            'url'         => 'admin/simpanan',
            'icon'        => 'fas fa-fw fa-coins',
            'active' => ['admin/simpanan', 'regex:@^admin/simpanan/[0-9]+$@', 'regex:@^admin/simpanan/[0-9]/edit+$@', 'admin/simpanan/create', 'regex:@^admin/simpanan/[0-9]/warna+$@', 'regex:@^admin/simpanan/[0-9]/ukuran+$@', 'regex:@^admin/simpanan/[0-9]/image+$@'],
            'can' => ['admin', 'pengawas']

        ],
        [
            'text'        => 'Pinjaman',
            'url'         => 'admin/pinjaman',
            'icon'        => 'fas fa-fw fa-hand-holding-usd',
            'can' => ['admin', 'pengawas']

        ],
        [
            'text'        => 'Transaksi',
            'url'         => 'admin/transaksi',
            'icon'        => 'fas fa-fw fa-money-bill-wave',
            'active' => ['admin/transaksi', 'regex:@^admin/transaksi/[0-9]+$@', 'regex:@^admin/transaksi/[0-9]/edit+$@', 'admin/transaksi/create', 'regex:@^admin/transaksi/[0-9]/warna+$@', 'regex:@^admin/transaksi/[0-9]/ukuran+$@', 'regex:@^admin/transaksi/[0-9]/image+$@'],
            'can' => ['admin', 'pengawas']

        ],
        [
            'text'        => 'Laporan',
            'url'         => '#',
            'icon'        => 'fas fa-fw fa-file-invoice-dollar',
            'can' => ['admin', 'pengawas']

        ],
        [
            'text'        => 'Pengaturan',
            'url'         => '#',
            'icon'        => 'fas fa-fw fa-cogs',
            'can' => ['admin', 'pengawas']
        ],

        ['header' => 'account_settings'],
        //MENU ADMIN
        [
            'text'    => 'User Access Control',
            'icon'    => 'fas fa-users-cog',
            'can' => 'admin',
            'submenu' => [
                [
                    'text' => 'User',
                    'icon'    => 'fas fa-users',
                    'url'  => 'admin/user',
                    'shift'   => 'ml-2',
                    'can' => 'admin',
                    'active'  => ['admin/user', 'regex:@^admin/user(\/[0-9]+)?+$@', 'regex:@^admin/user(\/[0-9]+)?\/edit+$@',  'admin/user/create'],

                ],
                [
                    'text' => 'Role & Permission',
                    'icon'    => 'fas fa-user-shield',
                    'url'  => 'admin/role',
                    'shift'   => 'ml-2',
                    'can' => 'admin',
                    'active'  => ['admin/role', 'regex:@^admin/role(\/[0-9]+)?+$@', 'regex:@^admin/role(\/[0-9]+)?\/edit+$@', 'regex:@^admin/permission(\/[0-9]+)?\/edit+$@', 'admin/role/create'],
                ],
            ],
        ],
        [
            'text' => 'Profil',
            'url'  => 'profil',
            'icon' => 'fas fa-fw fa-user',
        ],
        [
            'text' => 'change_password',
            'url'  => 'password/reset',
            'icon' => 'fas fa-fw fa-lock',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        // 'Datatables' => [
        //     'active' => false,
        //     'files' => [
        //         [
        //             'type' => 'js',
        //             'asset' => false,
        //             'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
        //         ],

        //         [
        //             'type' => 'js',
        //             'asset' => false,
        //             'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
        //         ],
        //         [
        //             'type' => 'js',
        //             'asset' => false,
        //             'location' => '//cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js',
        //         ],
        //         [
        //             'type' => 'js',
        //             'asset' => false,
        //             'location' => '//cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js',
        //         ],
        //         [
        //             'type' => 'js',
        //             'asset' => false,
        //             'location' => '//cdn.datatables.net/buttons/2.0.0/js/buttons.colVis.min.js',
        //         ],
        //         [
        //             'type' => 'js',
        //             'asset' => false,
        //             'location' => '//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js',
        //         ],
        //         [
        //             'type' => 'js',
        //             'asset' => false,
        //             'location' => '//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js',
        //         ],
        //         [
        //             'type' => 'js',
        //             'asset' => false,
        //             'location' => '//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js',
        //         ],
        //         [
        //             'type' => 'js',
        //             'asset' => false,
        //             'location' => '//cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js',
        //         ],
        //         [
        //             'type' => 'js',
        //             'asset' => false,
        //             'location' => '//cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js',
        //         ],
        //         [
        //             'type' => 'css',
        //             'asset' => false,
        //             'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
        //         ],
        //         [
        //             'type' => 'css',
        //             'asset' => false,
        //             'location' => '//cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css',
        //         ],
        //         [
        //             'type' => 'css',
        //             'asset' => false,
        //             'location' => '//cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css',
        //         ],
        //     ],
        // ],
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/responsive/js/dataTables.responsive.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/datatables/css/dataTables.bootstrap4.min.css',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/responsive/css/responsive.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/select2/js/select2.full.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/select2/css/select2.min.css',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@9',
                ],
            ],
        ],
        'Pace' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-flat-top.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,
];
