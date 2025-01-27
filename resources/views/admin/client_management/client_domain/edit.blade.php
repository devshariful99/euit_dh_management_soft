@extends('admin.layouts.app', ['pageSlug' => 'cd'])

@section('title', 'Edit Client Domain')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card m-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ __('Edit Client Domain') }}</h3>
                    <div class="button_">
                        @include('admin.partials.button', [
                            'routeName' => 'cm.cd.cd_list',
                            'className' => 'btn-outline-info',
                            'label' => 'Back',
                        ])
                    </div>

                </div>
                <div class="card-body">
                    <form action="{{ route('cm.cd.cd_edit', $cd->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="client_id">{{ __('Client') }}<span class="text-danger">*</span></label>
                                    <select name="client_id"
                                        class="form-control {{ $errors->has('client_id') ? ' is-invalid' : '' }}"
                                        id="client_id">
                                        <option selected hidden value="">{{ __('Select Client') }}</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}"
                                                {{ $cd->client_id == $client->id ? 'selected' : '' }}>{{ $client->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @include('alerts.feedback', ['field' => 'client_id'])
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="domain_name">{{ __('Domain Name') }}<span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('domain_name') ? ' is-invalid' : '' }}"
                                        id="domain_name" name="domain_name" value="{{ $cd->domain_name }}"
                                        placeholder="Enter domain name">
                                    @include('alerts.feedback', ['field' => 'domain_name'])
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="purchase_type">{{ __('Purchase Type') }}<span
                                            class="text-danger">*</span></label>
                                    <select name="purchase_type" id="purchase_type" class="form-control">
                                        <option selected hidden value="">{{ __('Select Purchase Type') }}</option>
                                        <option value="1" {{ $cd->purchase_type == '1' ? 'selected' : '' }}>
                                            {{ __('Purchase From Us') }}</option>
                                        <option value="2" {{ $cd->purchase_type == '2' ? 'selected' : '' }}>
                                            {{ __('Purchase From Others') }}</option>
                                    </select>
                                    @include('alerts.feedback', ['field' => 'purchase_type'])
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="company_id">{{ __('Company') }}</label>
                                    <select name="company_id" id="company_id" class="form-control">
                                        <option selected value="">{{ __('Select Company') }}</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}"
                                                {{ $cd->company_id == $company->id ? 'selected' : '' }}>
                                                {{ $company->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @include('alerts.feedback', ['field' => 'company_id'])
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="hosting_id">{{ __('Hosting') }}</label>
                                    <select name="hosting_id" id="hosting_id" class="form-control">
                                        <option selected value="">{{ __('Select Hosting') }}</option>
                                        @foreach ($hostings as $hosting)
                                            <option value="{{ $hosting->id }}"
                                                {{ $cd->hosting_id == $hosting->id ? 'selected' : '' }}>
                                                {{ $hosting->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @include('alerts.feedback', ['field' => 'hosting_id'])
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="type">{{ __('Type') }}<span class="text-danger">*</span></label>
                                    <select name="type" id="type" class="form-control">
                                        <option selected hidden value="">{{ __('Select Type') }}</option>
                                        <option value="1" {{ $cd->type == '1' ? 'selected' : '' }}>
                                            {{ __('Main Domain') }}</option>
                                        <option value="2" {{ $cd->type == '2' ? 'selected' : '' }}>
                                            {{ __('Sub Domain') }}</option>
                                    </select>
                                    @include('alerts.feedback', ['field' => 'type'])
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="price">{{ __('Purchase Price') }}<span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('price') ? ' is-invalid' : '' }}"
                                        id="price" name="price" value="{{ $cd->price }}"
                                        placeholder="Enter price">
                                    @include('alerts.feedback', ['field' => 'price'])
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="currency_id">{{ __('Currency') }}<span class="text-danger">*</span></label>
                                    <select name="currency_id" id="currency_id" class="form-control">
                                        <option selected hidden value="">{{ __('Select Currency') }}</option>
                                        @foreach ($currencies as $currency)
                                            <option value="{{ $currency->id }}"
                                                {{ $cd->currency_id == $currency->id ? 'selected' : '' }}>
                                                {{ $currency->short_form }}</option>
                                        @endforeach
                                    </select>
                                    @include('alerts.feedback', ['field' => 'currency_id'])
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="purchase_date">{{ __('Purchase Date') }}<span
                                            class="text-danger">*</span></label>
                                    <input type="date"
                                        class="form-control {{ $errors->has('purchase_date') ? ' is-invalid' : '' }}"
                                        id="purchase_date" name="purchase_date" value="{{ $cd->purchase_date }}">
                                    @include('alerts.feedback', ['field' => 'purchase_date'])
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="duration">{{ __('Duration') }}<span class="text-danger">*</span></label>
                                    <select name="duration" id="duration"
                                        class="form-control {{ $errors->has('duration') ? ' is-invalid' : '' }}">
                                        <option selected hidden value="">{{ __('Select Duration') }}</option>
                                        <option value="0.5" {{ $cd->duration == '0.5' ? 'selected' : '' }}>
                                            {{ __('6 Month') }}</option>
                                        <option value="1" {{ $cd->duration == '1' ? 'selected' : '' }}>
                                            {{ __('1 Year') }}</option>
                                        <option value="1.5" {{ $cd->duration == '1.5' ? 'selected' : '' }}>
                                            {{ __('1.5 Year') }}</option>
                                        <option value="2" {{ $cd->duration == '2' ? 'selected' : '' }}>
                                            {{ __('2 Year') }}</option>
                                        <option value="2.5" {{ $cd->duration == '2.5' ? 'selected' : '' }}>
                                            {{ __('2.5 Year') }}</option>
                                        <option value="3" {{ $cd->duration == '3' ? 'selected' : '' }}>
                                            {{ __('3 Year') }}</option>
                                        <option value="3.5" {{ $cd->duration == '3.5' ? 'selected' : '' }}>
                                            {{ __('3.5 Year') }}</option>
                                        <option value="4" {{ $cd->duration == '4' ? 'selected' : '' }}>
                                            {{ __('4 Year') }}</option>
                                        <option value="4.5" {{ $cd->duration == '4.5' ? 'selected' : '' }}>
                                            {{ __('4.5 Year') }}</option>
                                        <option value="5" {{ $cd->duration == '5' ? 'selected' : '' }}>
                                            {{ __('5 Year') }}</option>
                                        <option value="5.5" {{ $cd->duration == '5.5' ? 'selected' : '' }}>
                                            {{ __('5.5 Year') }}</option>
                                        <option value="6" {{ $cd->duration == '6' ? 'selected' : '' }}>
                                            {{ __('6 Year') }}</option>
                                        <option value="6.5" {{ $cd->duration == '6.5' ? 'selected' : '' }}>
                                            {{ __('6.5 Year') }}</option>
                                        <option value="7" {{ $cd->duration == '7' ? 'selected' : '' }}>
                                            {{ __('7 Year') }}</option>
                                        <option value="7.5" {{ $cd->duration == '7.5' ? 'selected' : '' }}>
                                            {{ __('7.5 Year') }}</option>
                                        <option value="8" {{ $cd->duration == '8' ? 'selected' : '' }}>
                                            {{ __('8 Year') }}</option>
                                        <option value="8.5" {{ $cd->duration == '8.5' ? 'selected' : '' }}>
                                            {{ __('8.5 Year') }}</option>
                                        <option value="9" {{ $cd->duration == '9' ? 'selected' : '' }}>
                                            {{ __('9 Year') }}</option>
                                        <option value="9.5" {{ $cd->duration == '9.5' ? 'selected' : '' }}>
                                            {{ __('9.5 Year') }}</option>
                                        <option value="10" {{ $cd->duration == '10' ? 'selected' : '' }}>
                                            {{ __('10 Year') }}</option>
                                    </select>
                                    @include('alerts.feedback', ['field' => 'duration'])
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="admin_url">{{ __('Login URL') }}<span
                                            class="text-danger">*</span></label>
                                    <input type="url"
                                        class="form-control {{ $errors->has('admin_url') ? ' is-invalid' : '' }}"
                                        id="admin_url" name="admin_url" value="{{ $cd->admin_url }}"
                                        placeholder="Enter login url">
                                    @include('alerts.feedback', ['field' => 'admin_url'])
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="username">{{ __('Username') }}</label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}"
                                        id="username" name="username" value="{{ $cd->username }}"
                                        placeholder="Enter username">
                                    @include('alerts.feedback', ['field' => 'username'])
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email">{{ __('Email') }}<span class="text-danger">*</span></label>
                                    <input type="email"
                                        class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                        id="email" name="email" value="{{ $cd->email }}"
                                        placeholder="Enter email">
                                    @include('alerts.feedback', ['field' => 'email'])
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="password">{{ __('Password') }}<span class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                        id="password" name="password" value="{{ $cd->password }}"
                                        placeholder="Enter password">
                                    @include('alerts.feedback', ['field' => 'password'])
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="note">{{ __('Note') }}</label>
                                    <textarea name="note" id="note" class="form-control" placeholder="Note...">{{ $cd->note }}</textarea>
                                    @include('alerts.feedback', ['field' => 'note'])
                                </div>

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
@push('js')
    <script>
        function purchase_type(purchase_type) {
            if (purchase_type == 2) {
                $('#company_id').prop('disabled', true).parent().hide();
                $('#hosting_id').prop('disabled', true).parent().hide();
                $('#price').prop('disabled', true).parent().hide();
                $('#currency_id').prop('disabled', true).parent().hide();
                $('#purchase_date').prop('disabled', true).parent().hide();
                $('#duration').prop('disabled', true).parent().hide();
                $('#admin_url').prop('disabled', true).parent().hide();
                $('#username').prop('disabled', true).parent().hide();
                $('#email').prop('disabled', true).parent().hide();
                $('#password').prop('disabled', true).parent().hide();
            } else if (purchase_type == 1) {
                $('#company_id').prop('disabled', false).parent().show();
                $('#hosting_id').prop('disabled', false).parent().show();
                $('#price').prop('disabled', false).parent().show();
                $('#currency_id').prop('disabled', false).parent().show();
                $('#purchase_date').prop('disabled', false).parent().show();
                $('#duration').prop('disabled', false).parent().show();
                $('#admin_url').prop('disabled', false).parent().show();
                $('#username').prop('disabled', false).parent().show();
                $('#email').prop('disabled', false).parent().show();
                $('#password').prop('disabled', false).parent().show();
            }
        }
        $(document).ready(function() {
            $('#purchase_type').on('change', function() {
                purchase_type($(this).val());
            });
            purchase_type($('#purchase_type').val());
        });
    </script>
@endpush
