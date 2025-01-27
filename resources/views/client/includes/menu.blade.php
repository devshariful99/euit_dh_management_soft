<!-- need to remove -->
@include('client.partials.menu_buttons', [
    'menuItems' => [
        [
            'pageSlug' => 'dashboard',
            'routeName' => 'cp.dashboard',
            'iconClass' => 'fa-solid fa-chart-line',
            'label' => 'Dashboard',
        ],
    ],
])
