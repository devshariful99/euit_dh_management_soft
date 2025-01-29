@extends('admin.layouts.app', ['pageSlug' => 'cpc'])

@section('title', 'Create Project Credentials')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card m-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ __('Create Project Credentials') }}</h3>
                    <div class="button_">
                        @include('admin.partials.button', [
                            'routeName' => 'cm.cpc.cpc_list',
                            'className' => 'btn-outline-info',
                            'label' => 'Back',
                        ])
                    </div>

                </div>
                <div class="card-body">
                    <form action="{{ route('cm.cpc.cpc_create') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="project">{{ __('Project') }}<span class="text-danger">*</span></label>
                                    <select name="project" id="project" class="form-control">
                                        <option value="" selected>{{ __('Select Project') }}</option>
                                        @foreach ($projects as $project)
                                            <option value="{{ $project->id }}"
                                                {{ old('project') == $project->id ? 'selected' : '' }}>
                                                {{ $project->name }}</option>
                                        @endforeach
                                    </select>
                                    @include('alerts.feedback', ['field' => 'project'])
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="title">{{ __('Title') }}<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title"
                                        value="{{ old('title') }}" placeholder="Enter title">
                                    @include('alerts.feedback', [
                                        'field' => 'title',
                                    ])
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="credential_url">{{ __('URL') }}</label>
                                    <input type="url" class="form-control" id="credential_url" name="url"
                                        value="{{ old('url') }}" placeholder="Enter url">
                                    @include('alerts.feedback', [
                                        'field' => 'url',
                                    ])
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="credential_email">{{ __('Email') }}</label>
                                    <input type="email" class="form-control" id="credential_email" name="email"
                                        value="{{ old('email') }}" placeholder="Enter email">
                                    @include('alerts.feedback', [
                                        'field' => 'email',
                                    ])
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="credential_username">{{ __('Username') }}</label>
                                    <input type="text" class="form-control" id="credential_username" name="username"
                                        value="{{ old('username') }}" placeholder="Enter username">
                                    @include('alerts.feedback', [
                                        'field' => 'username',
                                    ])
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="credential_password">{{ __('Password') }}<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="credential_password" name="password"
                                        value="{{ old('password') }}" placeholder="Enter password">
                                    @include('alerts.feedback', [
                                        'field' => 'password',
                                    ])
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="credential_note">{{ __('Credential Note') }}</label>
                                    <textarea name="note" id="credential_note" class="form-control" placeholder="Enter note">{{ old('note') }}</textarea>
                                    @include('alerts.feedback', [
                                        'field' => 'note',
                                    ])
                                </div>
                            </div>
                        </div>

                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
