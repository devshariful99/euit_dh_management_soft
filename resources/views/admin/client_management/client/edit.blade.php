@extends('admin.layouts.app', ['pageSlug' => 'client'])

@section('title', 'Edit Client')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card m-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ __('Edit Client') }}</h3>
                    <div class="button_">
                        @include('admin.partials.button', [
                            'routeName' => 'cm.client.client_list',
                            'className' => 'btn-outline-info',
                            'label' => 'Back',
                        ])
                    </div>

                </div>
                <div class="card-body">
                    <form action="{{ route('cm.client.client_edit', $client->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">{{ __('Name') }}<span class="text-danger">*</span></label>
                                <input type="name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                    id="name" name="name" value="{{ $client->name }}" placeholder="Enter name">
                                @include('alerts.feedback', ['field' => 'name'])
                            </div>
                            <div class="form-group">
                                <label for="email">{{ __('Email') }}<span class="text-danger">*</span></label>
                                <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                    id="email" name="email" value="{{ $client->email }}" placeholder="Enter email">
                                @include('alerts.feedback', ['field' => 'email'])
                            </div>
                            <div class="form-group">
                                <label for="password">{{ __('Password') }}</label>
                                <input type="password"
                                    class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" id="password"
                                    name="password" placeholder="Enter password">
                                @include('alerts.feedback', ['field' => 'password'])
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">{{ __('Confirm Password') }}</label>
                                <input type="password" class="form-control" id="confirm_password"
                                    name="password_confirmation" placeholder="Enter confirm password">
                            </div>
                            <div class="form-group">
                                <label for="phone">{{ __('Phone') }}</label>
                                <input type="text" value="{{ $client->phone }}"
                                    class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" id="phone"
                                    name="phone" placeholder="phone">
                                @include('alerts.feedback', ['field' => 'phone'])
                            </div>
                            <div class="form-group">
                                <label for="company_name">{{ __('Company Name') }}</label>
                                <input type="text" value="{{ $client->company_name }}"
                                    class="form-control {{ $errors->has('company_name') ? ' is-invalid' : '' }}"
                                    id="company_name" name="company_name" placeholder="Enter company name">
                                @include('alerts.feedback', ['field' => 'company_name'])
                            </div>
                            <div class="form-group">
                                <label for="address">{{ __('Address') }}<span class="text-danger">*</span></label>
                                <textarea name="address" id= "address" class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}">{{ $client->address }}</textarea>
                                @include('alerts.feedback', ['field' => 'address'])
                            </div>
                            <div class="form-group">
                                <label for="note">{{ __('Note') }}</label>
                                <textarea name="note" id= "note" class="form-control {{ $errors->has('note') ? ' is-invalid' : '' }}">{{ $client->note }}</textarea>
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
