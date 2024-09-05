<!-- need to remove -->
@include('admin.partials.menu_buttons', [
        'menuItems' => [
            [
                'pageSlug' => 'dashboard',
                'routeName' => 'admin.dashboard',
                'iconClass' => 'fa-solid fa-chart-line',
                'label' => 'Dashboard',
            ],
            [
                'pageSlug' => 'admin',
                'routeName' => 'am.admin.admin_list',
                'iconClass' => 'fa-solid fa-user-tie',
                'label' => 'Admins',
            ],
            [
                'pageSlug' => 'company',
                'routeName' => 'company.company_list',
                'iconClass' => 'fa-solid fa-shop-lock',
                'label' => 'Companies',
            ],
            [
                'pageSlug' => 'hosting',
                'routeName' => 'hosting.hosting_list',
                'iconClass' => 'fa-solid fa-server',
                'label' => 'Hostings',
            ],
            [
                'pageSlug' => 'domain',
                'routeName' => 'domain.domain_list',
                'iconClass' => 'fa-solid fa-globe',
                'label' => 'Domains',
            ],
            [
                'pageSlug' => 'payment',
                'routeName' => 'payment.payment_list',
                'iconClass' => 'fa-regular fa-money-bill-1',
                'label' => 'Payments',
            ],
        ],
    ])
