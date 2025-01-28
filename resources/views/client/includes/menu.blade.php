<!-- need to remove -->
@include('client.partials.menu_buttons', [
    'menuItems' => [
        [
            'pageSlug' => 'dashboard',
            'routeName' => 'cp.dashboard',
            'iconClass' => 'fa-solid fa-chart-line',
            'label' => 'Dashboard',
        ],
        [
            'pageSlug' => 'domain',
            'routeName' => 'cp.domain.list',
            'iconClass' => 'fa-brands fa-hubspot',
            'label' => 'Domain',
        ],
        [
            'pageSlug' => 'hosting',
            'routeName' => 'cp.hosting.list',
            'iconClass' => 'fa-solid fa-server',
            'label' => 'Hosting',
        ],
        [
            'pageSlug' => 'exp_domain',
            'routeName' => 'cp.domain.exd.list',
            'iconClass' => 'fa-brands fa-hubspot',
            'label' => 'Expire Domain',
        ],
        [
            'pageSlug' => 'exp_hosting',
            'routeName' => 'cp.hosting.exh.list',
            'iconClass' => 'fa-solid fa-server',
            'label' => 'Expire Hosting',
        ],
        [
            'pageSlug' => 'renewal',
            'routeName' => 'cp.renewal.list',
            'iconClass' => 'fa-regular fa-money-bill-1',
            'label' => 'Renewal History',
        ],
    ],
])
