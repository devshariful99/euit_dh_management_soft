@extends('client.layouts.app', ['pageSlug' => 'project'])

@section('title', 'Project Details')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card m-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fw-bold">{{ $project->name . ' Details' }}</h3>
                    <div class="button_ ms-auto">
                        @include('admin.partials.button', [
                            'routeName' => 'cm.cp.cp_list',
                            'className' => 'btn-outline-info',
                            'label' => 'Back',
                        ])
                    </div>

                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td class="fw-bold">{{ __('Name') }}</td>
                                <td>{{ __(':') }}</td>
                                <td>{{ $project->name }}</td>
                                <td class="fw-bold">{{ __('URL') }}</td>
                                <td>{{ __(':') }}</td>
                                <td>
                                    <span id="url{{ $project->id }}">{{ $project->url }}<span>
                                            <a href="javascript:void(0)" title="Copy" class="copy-btn text-info p-2 fs-5"
                                                data-clipboard-target="#url{{ $project->id }}">
                                                <i class="fas fa-copy"></i>
                                            </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">{{ __('Client') }}</td>
                                <td>{{ __(':') }}</td>
                                <td>{{ $project->client->name }}</td>
                                <td class="fw-bold">{{ __('Domain') }}</td>
                                <td>{{ __(':') }}</td>
                                <td>{{ optional($project->domain)->domain_name }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">{{ __('Hosting') }}</td>
                                <td>{{ __(':') }}</td>
                                <td>{{ optional(optional($project->hosting)->hosting)->name }}</td>
                                <td class="fw-bold">{{ __('Status') }}</td>
                                <td>{{ __(':') }}</td>
                                <td><span class="{{ $project->getStatusBadgeClass() }}">{{ $project->getStatus() }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">{{ __('Created By') }}</td>
                                <td>{{ __(':') }}</td>
                                <td>{{ c_user_name($project->creater) }}</td>
                                <td class="fw-bold">{{ __('Created Date') }}</td>
                                <td>{{ __(':') }}</td>
                                <td>{{ c_date($project->created_at) }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">{{ __('Updated By') }}</td>
                                <td>{{ __(':') }}</td>
                                <td>{{ u_user_name($project->updater) }}</td>
                                <td class="fw-bold">{{ __('Updated Date') }}</td>
                                <td>{{ __(':') }}</td>
                                <td>{{ u_date($project->created_at, $project->updated_at) }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">{{ __('Project Note') }}</td>
                                <td>{{ __(':') }}</td>
                                <td colspan="4">{{ $project->note }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @if ($project->credentials->count() > 0)
                    <div class="card-footer">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title fw-bold">{{ __($project->name . ' Credentials') }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach ($project->credentials as $credential)
                                        <div class="col-6">
                                            <div class="card h-100">
                                                <div class="card-header d-flex justify-content-between align-items-center">
                                                    <h3 class="card-title">{{ $credential->title }}</h3>
                                                </div>
                                                <div class="card-body">
                                                    <table class="table table-striped table-responsive w-100">
                                                        <tbody>
                                                            <tr>
                                                                <td class="fw-bold">{{ __('Title') }}</td>
                                                                <td>{{ __(':') }}</td>
                                                                <td>{{ $credential->title }}</td>
                                                                <td class="fw-bold">{{ __('URL') }}</td>
                                                                <td>{{ __(':') }}</td>
                                                                <td>
                                                                    <span
                                                                        id="cd_url{{ $credential->id }}">{{ $credential->url }}<span>
                                                                            <a href="javascript:void(0)" title="Copy"
                                                                                class="copy-btn text-info p-2 fs-5"
                                                                                data-clipboard-target="#cd_url{{ $credential->id }}">
                                                                                <i class="fas fa-copy"></i>
                                                                            </a>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold">{{ __('Email') }}</td>
                                                                <td>{{ __(':') }}</td>
                                                                <td>
                                                                    <span
                                                                        id="cd_email{{ $credential->id }}">{{ $credential->email }}<span>
                                                                            <a href="javascript:void(0)" title="Copy"
                                                                                class="copy-btn text-info p-2 fs-5"
                                                                                data-clipboard-target="#cd_email{{ $credential->id }}">
                                                                                <i class="fas fa-copy"></i>
                                                                            </a>
                                                                </td>
                                                                <td class="fw-bold">{{ __('Username') }}</td>
                                                                <td>{{ __(':') }}</td>
                                                                <td>
                                                                    <span
                                                                        id="cd_username{{ $credential->id }}">{{ $credential->username }}<span>
                                                                            <a href="javascript:void(0)" title="Copy"
                                                                                class="copy-btn text-info p-2 fs-5"
                                                                                data-clipboard-target="#cd_username{{ $credential->id }}">
                                                                                <i class="fas fa-copy"></i>
                                                                            </a>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold">{{ __('Password') }}</td>
                                                                <td>{{ __(':') }}</td>
                                                                <td>
                                                                    <span
                                                                        id="cd_password{{ $credential->id }}">{{ $credential->password }}<span>
                                                                            <a href="javascript:void(0)" title="Copy"
                                                                                class="copy-btn text-info p-2 fs-5"
                                                                                data-clipboard-target="#cd_password{{ $credential->id }}">
                                                                                <i class="fas fa-copy"></i>
                                                                            </a>
                                                                </td>
                                                                <td class="fw-bold">{{ __('Status') }}</td>
                                                                <td>{{ __(':') }}</td>
                                                                <td><span
                                                                        class="{{ $credential->getStatusBadgeClass() }}">{{ $credential->getStatus() }}</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold">{{ __('Created By') }}</td>
                                                                <td>{{ __(':') }}</td>
                                                                <td>{{ c_user_name($credential->creater) }}</td>
                                                                <td class="fw-bold">{{ __('Created Date') }}</td>
                                                                <td>{{ __(':') }}</td>
                                                                <td>{{ c_date($credential->created_at) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold">{{ __('Updated By') }}</td>
                                                                <td>{{ __(':') }}</td>
                                                                <td>{{ u_user_name($credential->updater) }}</td>
                                                                <td class="fw-bold">{{ __('Updated Date') }}</td>
                                                                <td>{{ __(':') }}</td>
                                                                <td>{{ u_date($credential->created_at, $credential->updated_at) }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold">{{ __('Credential Note') }}</td>
                                                                <td>{{ __(':') }}</td>
                                                                <td colspan="4">{{ $credential->note }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
