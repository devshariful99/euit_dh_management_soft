@extends('admin.layouts.app', ['pageSlug' => 'domain'])

@section('title', 'Edit Domain')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card m-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ __('Edit Domain') }}</h3>
                    <div class="button_">
                        @include('admin.partials.button', [
                            'routeName' => 'domain.domain_list',
                            'className' => 'btn-outline-info',
                            'label' => 'Back',
                        ])
                    </div>

                </div>
                <div class="card-body">
                    <form action="{{ route('domain.domain_edit', $domain->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="hosting_id">{{ __('Hosting') }}</label>
                                <select name="hosting_id" id="hosting_id" class="form-control">
                                    <option selected value="">{{ __('Select Hosting') }}</option>
                                    @foreach ($hostings as $hosting)
                                        <option value="{{ $hosting->id }}"
                                            {{ $domain->hosting_id == $hosting->id ? 'selected' : '' }}>
                                            {{ $hosting->name }}</option>
                                    @endforeach
                                </select>
                                @include('alerts.feedback', ['field' => 'hosting_id'])
                            </div>
                            <div class="form-group">
                                <label for="name">{{ __('Name') }}<span class="text-danger">*</span></label>
                                <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                    id="name" name="name" value="{{ $domain->name }}" placeholder="Enter name">
                                @include('alerts.feedback', ['field' => 'name'])
                            </div>
                            <div class="form-group">
                                <label for="company_id">{{ __('Company') }}<span class="text-danger">*</span></label>
                                <select name="company_id" id="company_id" class="form-control">
                                    <option selected hidden value="">{{ __('Select Company') }}</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ $domain->company_id == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}</option>
                                    @endforeach
                                </select>
                                @include('alerts.feedback', ['field' => 'company_id'])
                            </div>
                            <div class="form-group">
                                <label for="admin_url">{{ __('Login URL') }}<span class="text-danger">*</span></label>
                                <input type="url"
                                    class="form-control {{ $errors->has('admin_url') ? ' is-invalid' : '' }}"
                                    id="admin_url" name="admin_url" value="{{ $domain->admin_url }}"
                                    placeholder="Enter admin url">
                                @include('alerts.feedback', ['field' => 'admin_url'])
                            </div>
                            <div class="form-group">
                                <label for="username">{{ __('Username') }}</label>
                                <input type="text"
                                    class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}" id="username"
                                    name="username" value="{{ $domain->username }}" placeholder="Enter username">
                                @include('alerts.feedback', ['field' => 'username'])
                            </div>
                            <div class="form-group">
                                <label for="email">{{ __('Email') }}<span class="text-danger">*</span></label>
                                <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                    id="email" name="email" value="{{ $domain->email }}" placeholder="Enter email">
                                @include('alerts.feedback', ['field' => 'email'])
                            </div>
                            <div class="form-group">
                                <label for="password">{{ __('Password') }}<span class="text-danger">*</span></label>
                                <input type="text"
                                    class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" id="password"
                                    name="password" value="{{ $domain->password }}" placeholder="Enter password">
                                @include('alerts.feedback', ['field' => 'password'])
                            </div>
                            <div class="form-group">
                                <label for="note">{{ __('Note') }}</label>
                                <textarea name="note" id="note" class="form-control" placeholder="Note...">{{ $domain->note }}</textarea>
                                @include('alerts.feedback', ['field' => 'note'])
                            </div>

                        </div>

                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
