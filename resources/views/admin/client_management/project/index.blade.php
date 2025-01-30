@extends('admin.layouts.app', ['pageSlug' => 'cp'])

@section('title', 'Project List')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card m-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ __('Project List') }}</h3>
                    <div class="button_ ms-auto">
                        @include('admin.partials.button', [
                            'routeName' => 'cm.cp.cp_create',
                            'className' => 'btn-outline-info',
                            'label' => 'Add new project',
                        ])
                    </div>

                </div>
                <div class="card-body">
                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Url') }}</th>
                                <th>{{ __('Client') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Created By') }}</th>
                                <th>{{ __('Creation Date') }}</th>
                                <th class="text-center">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projects as $project)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td>{{ $project->name }}</td>
                                    <td>
                                        <span id="url{{ $project->id }}">{{ $project->url }}<span>
                                                <a href="javascript:void(0)" title="Copy"
                                                    class="copy-btn text-info p-2 fs-5"
                                                    data-clipboard-target="#url{{ $project->id }}">
                                                    <i class="fas fa-copy"></i>
                                                </a>
                                    </td>
                                    <td>{{ $project->client->name }}</td>

                                    <td><span
                                            class="{{ $project->getStatusBadgeClass() }}">{{ $project->getStatus() }}</span>
                                    </td>
                                    <td>{{ c_user_name($project->creater) }}</td>
                                    <td>{{ c_date($project->created_at) }}</td>
                                    <td class="text-center align-middle">
                                        @include('admin.partials.action_buttons', [
                                            'menuItems' => [
                                                [
                                                    'routeName' => 'cm.cp.details.cp_list',
                                                    'params' => [$project->id],
                                                    'iconClass' => 'fa-regular fa-eye',
                                                    'className' => 'btn btn-primary',
                                                    'title' => 'Details',
                                                ],
                                                [
                                                    'routeName' => 'cm.cp.cp_edit',
                                                    'params' => [$project->id],
                                                    'iconClass' => 'fa-regular fa-pen-to-square',
                                                    'className' => 'btn btn-info',
                                                    'title' => 'Edit',
                                                ],
                                        
                                                [
                                                    'routeName' => 'cm.cp.status.cp_edit',
                                                    'params' => [$project->id],
                                                    'iconClass' => 'fa-solid fa-power-off',
                                                    'className' => $project->getStatusClass(),
                                                    'title' => $project->getStatusTitle(),
                                                ],
                                                [
                                                    'routeName' => 'cm.cp.cp_delete',
                                                    'params' => [$project->id],
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
