@extends('admin.layouts.app', ['pageSlug' => 'client'])

@section('title', 'Create Client')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card m-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ __('Create Client') }}</h3>
                    <div class="button_">
                        @include('admin.partials.button', [
                            'routeName' => 'cm.client.client_list',
                            'className' => 'btn-outline-info',
                            'label' => 'Back',
                        ])
                    </div>

                </div>
                <div class="card-body">
                    <form action="{{ route('cm.client.client_create') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">{{ __('Name') }}<span class="text-danger">*</span></label>
                                <input type="name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                    id="name" name="name" value="{{ old('name') }}" placeholder="Enter name">
                                @include('alerts.feedback', ['field' => 'name'])
                            </div>
                            <div class="form-group">
                                <label for="email">{{ __('Email') }}<span class="text-danger">*</span></label>
                                <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                    id="email" name="email" value="{{ old('email') }}" placeholder="Enter email">
                                @include('alerts.feedback', ['field' => 'email'])
                            </div>
                            <div class="form-group">
                                <label for="phone">{{ __('Phone') }}</label>
                                <input type="text" value="{{ old('phone') }}"
                                    class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" id="phone"
                                    name="phone" placeholder="phone">
                                @include('alerts.feedback', ['field' => 'phone'])
                            </div>
                            <div class="form-group">
                                <label for="company_name">{{ __('Company Name') }}</label>
                                <input type="text" value="{{ old('company_name') }}"
                                    class="form-control {{ $errors->has('company_name') ? ' is-invalid' : '' }}"
                                    id="company_name" name="company_name" placeholder="Enter company name">
                                @include('alerts.feedback', ['field' => 'company_name'])
                            </div>
                            <div class="form-group">
                                <label for="address">{{ __('Address') }}<span class="text-danger">*</span></label>
                                <textarea name="address" id= "address" class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}">{{ old('address') }}</textarea>
                                @include('alerts.feedback', ['field' => 'address'])
                            </div>
                            <div class="form-group">
                                <label for="note">{{ __('Note') }}</label>
                                <textarea name="note" id= "note" class="form-control {{ $errors->has('note') ? ' is-invalid' : '' }}">{{ old('note') }}</textarea>
                                @include('alerts.feedback', ['field' => 'note'])
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
