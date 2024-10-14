@extends('admin.layouts.app', ['pageSlug' => 'company'])

@section('title', 'Company List')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card m-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ __('Company List') }}</h3>
                    <div class="button_ ms-auto">
                        @include('admin.partials.button', [
                            'routeName' => 'company.company_create',
                            'className' => 'btn-outline-info',
                            'label' => 'Add new company',
                        ])
                    </div>

                </div>
                <div class="card-body">
                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Website') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Created By') }}</th>
                                <th>{{ __('Creation Date') }}</th>
                                <th class="text-center">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($companies as $company)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td>{{ $company->name }}</td>
                                    <td><a target="_blank" class="btn btn-sm btn-primary"
                                            href="{{ $company->website_url }}">{{ __('Website') }}</a></td>
                                    <td><span
                                            class="{{ $company->getStatusBadgeClass() }}">{{ $company->getStatus() }}</span>
                                    </td>
                                    <td>{{ $company->created_user_name() }}</td>
                                    <td>{{ $company->created_date() }}</td>
                                    <td class="text-center align-middle">
                                        @include('admin.partials.action_buttons', [
                                            'menuItems' => [
                                                [
                                                    'routeName' => 'company.details.company_list',
                                                    'params' => [$company->id],
                                                    'iconClass' => 'fa-regular fa-eye',
                                                    'className' => 'btn btn-primary view',
                                                    'title' => 'Details',
                                                ],
                                                [
                                                    'routeName' => 'company.company_edit',
                                                    'params' => [$company->id],
                                                    'iconClass' => 'fa-regular fa-pen-to-square',
                                                    'className' => 'btn btn-info',
                                                    'title' => 'Edit',
                                                ],

                                                [
                                                    'routeName' => 'company.company_delete',
                                                    'params' => [$company->id],
                                                    'iconClass' => 'fa-regular fa-trash-can',
                                                    'className' => 'btn btn-danger',
                                                    'title' => 'Delete',
                                                    'delete' => true,
                                                ],
                                                [
                                                    'routeName' => 'company.status.company_edit',
                                                    'params' => [$company->id],
                                                    'iconClass' => 'fa-solid fa-power-off',
                                                    'className' => $company->getStatusClass(),
                                                    'title' => $company->getStatusTitle(),
                                                ],
                                            ],
                                        ])
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4, 5]])
