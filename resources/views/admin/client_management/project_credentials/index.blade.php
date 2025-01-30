@extends('admin.layouts.app', ['pageSlug' => 'cpc'])

@section('title', 'Project Credential List')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card m-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ __('Project Credential List') }}</h3>
                    <div class="button_ ms-auto">
                        @include('admin.partials.button', [
                            'routeName' => 'cm.cpc.cpc_create',
                            'className' => 'btn-outline-info',
                            'label' => 'Add new credential',
                        ])
                    </div>

                </div>
                <div class="card-body">
                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Project') }}</th>
                                <th>{{ __('Client') }}</th>
                                <th>{{ __('Title') }}</th>
                                <th>{{ __('Username') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Password') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Created By') }}</th>
                                <th>{{ __('Creation Date') }}</th>
                                <th class="text-center">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($credentials as $credential)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td>{{ optional($credential->project)->name }}</td>
                                    <td>{{ optional(optional($credential->project)->client)->name }}</td>
                                    <td>{{ $credential->title }}</td>
                                    <td>
                                        <span id="username{{ $credential->id }}">{{ $credential->username }}<span>
                                                <a href="javascript:void(0)" title="Copy"
                                                    class="copy-btn text-info p-2 fs-5"
                                                    data-clipboard-target="#username{{ $credential->id }}">
                                                    <i class="fas fa-copy"></i>
                                                </a>
                                    </td>
                                    <td>
                                        <span id="email{{ $credential->id }}">{{ $credential->email }}<span>
                                                <a href="javascript:void(0)" title="Copy"
                                                    class="copy-btn text-info p-2 fs-5"
                                                    data-clipboard-target="#email{{ $credential->id }}">
                                                    <i class="fas fa-copy"></i>
                                                </a>
                                    </td>
                                    <td>
                                        <span id="password{{ $credential->id }}">{{ $credential->password }}<span>
                                                <a href="javascript:void(0)" title="Copy"
                                                    class="copy-btn text-info p-2 fs-5"
                                                    data-clipboard-target="#password{{ $credential->id }}">
                                                    <i class="fas fa-copy"></i>
                                                </a>
                                    </td>
                                    <td><span
                                            class="{{ $credential->getStatusBadgeClass() }}">{{ $credential->getStatus() }}</span>
                                    </td>
                                    <td>{{ c_user_name($credential->creater) }}</td>
                                    <td>{{ c_date($credential->created_at) }}</td>
                                    <td class="text-center align-middle">
                                        @include('admin.partials.action_buttons', [
                                            'menuItems' => [
                                                [
                                                    'routeName' => 'cm.cpc.details.cpc_list',
                                                    'params' => [$credential->id],
                                                    'iconClass' => 'fa-regular fa-eye',
                                                    'className' => 'btn btn-primary',
                                                    'title' => 'Details',
                                                ],
                                                [
                                                    'routeName' => 'cm.cpc.cpc_edit',
                                                    'params' => [$credential->id],
                                                    'iconClass' => 'fa-regular fa-pen-to-square',
                                                    'className' => 'btn btn-info',
                                                    'title' => 'Edit',
                                                ],
                                        
                                                [
                                                    'routeName' => 'cm.cpc.status.cpc_edit',
                                                    'params' => [$credential->id],
                                                    'iconClass' => 'fa-solid fa-power-off',
                                                    'className' => $credential->getStatusClass(),
                                                    'title' => $credential->getStatusTitle(),
                                                ],
                                                [
                                                    'routeName' => 'cm.cpc.cpc_delete',
                                                    'params' => [$credential->id],
                                                    'iconClass' => 'fa-regular fa-trash-can',
                                                    'className' => 'btn btn-danger',
                                                    'title' => 'Delete',
                                                    'delete' => true,
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
@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4, 5, 6, 7]])
