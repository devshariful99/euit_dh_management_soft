@extends('admin.layouts.app', ['pageSlug' => 'admin'])

@section('title', 'Edit Admin')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card m-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ __('Edit Admin') }}</h3>
                    <div class="button_ ms-auto">
                        @include('admin.partials.button', [
                            'routeName' => 'am.admin.admin_list',
                            'className' => 'btn-outline-info',
                            'label' => 'Back',
                        ])
                    </div>

                </div>
                <div class="card-body">
                    <form action="{{ route('am.admin.admin_edit', $admin->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">{{ __('Name') }}</label>
                                <input type="name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                    id="name" name="name" value="{{ $admin->name }}" placeholder="Enter name">
                                @include('alerts.feedback', ['field' => 'name'])
                            </div>
                            <div class="form-group">
                                <label for="email">{{ __('Email') }}</label>
                                <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                    id="email" name="email" value="{{ $admin->email }}" placeholder="Enter email">
                                @include('alerts.feedback', ['field' => 'email'])
                            </div>
                            <div class="form-group">
                                <label for="password">{{ __('Password') }}</label>
                                <input type="password"
                                    class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" id="password"
                                    name="password" placeholder="Password">
                                @include('alerts.feedback', ['field' => 'password'])
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                                <input type="password"
                                    class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                                    id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
                                @include('alerts.feedback', ['field' => 'password_confirmation'])
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


