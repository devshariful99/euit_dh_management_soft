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

<li class="nav-item
@if ($pageSlug == 'client' || $pageSlug == 'ch' || $pageSlug == 'cd') menu-is-opening menu-open @endif">

    <a href="javescript:void(0)" class="nav-link @if ($pageSlug == 'client' || $pageSlug == 'ch' || $pageSlug == 'cd') active @endif">
        <i class="fa-solid fa-people-roof"></i>
        <p>
            {{ __('Client Management') }}
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview" style="@if ($pageSlug == 'client' || $pageSlug == 'ch' || $pageSlug == 'cd') display:block @endif">
        @include('admin.partials.menu_buttons', [
            'menuItems' => [
                [
                    'pageSlug' => 'client',
                    'routeName' => 'cm.client.client_list',
                    'label' => 'Clients',
                ],
                [
                    'pageSlug' => 'ch',
                    'routeName' => 'cm.ch.ch_list',
                    'label' => 'Client Hostings',
                ],
                [
                    'pageSlug' => 'cd',
                    'routeName' => 'cm.cd.cd_list',
                    'label' => 'Client Domains',
                ],
            ],
        ])

    </ul>
</li>
