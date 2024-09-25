@extends('admin.layouts.app', ['pageSlug' => 'cd'])

@section('title', 'Create Client Domain')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card m-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ __('Create Client Domain') }}</h3>
                    <div class="button_">
                        @include('admin.partials.button', [
                            'routeName' => 'cm.cd.cd_list',
                            'className' => 'btn-outline-info',
                            'label' => 'Back',
                        ])
                    </div>

                </div>
                <div class="card-body">
                    <form action="{{ route('cm.cd.cd_create') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="domain_name">{{ __('Domain Name') }}<span class="text-danger">*</span></label>
                                <input type="text"
                                    class="form-control {{ $errors->has('domain_name') ? ' is-invalid' : '' }}"
                                    id="domain_name" name="domain_name" value="{{ old('domain_name') }}"
                                    placeholder="Enter domain name">
                                @include('alerts.feedback', ['field' => 'domain_name'])
                            </div>
                            <div class="form-group">
                                <label for="client_id">{{ __('Client') }}<span class="text-danger">*</span></label>
                                <select name="client_id"
                                    class="form-control {{ $errors->has('client_id') ? ' is-invalid' : '' }}"
                                    id="client_id">
                                    <option selected hidden value="">{{ __('Select Client') }}</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}"
                                            {{ old('client_id') == $client->id ? 'selected' : '' }}>{{ $client->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @include('alerts.feedback', ['field' => 'client_id'])
                            </div>
                            <div class="form-group">
                                <label for="hosting_id">{{ __('Hosting') }}</label>
                                <select name="hosting_id" id="hosting_id" class="form-control">
                                    <option selected hidden value="">{{ __('Select Company') }}</option>
                                    @foreach ($hostings as $hosting)
                                        <option value="{{ $hosting->id }}"
                                            {{ old('hosting_id') == $hosting->id ? 'selected' : '' }}>{{ $hosting->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @include('alerts.feedback', ['field' => 'hosting_id'])
                            </div>
                            <div class="form-group">
                                <label for="domain_id">{{ __('Domain') }}</label>
                                <select name="domain_id" id="domain_id" class="form-control">
                                    <option selected hidden value="">{{ __('Select Domain') }}</option>
                                    @foreach ($domains as $domain)
                                        <option value="{{ $domain->id }}"
                                            {{ old('domain_id') == $domain->id ? 'selected' : '' }}>{{ $domain->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @include('alerts.feedback', ['field' => 'domain_id'])
                            </div>
                            <div class="form-group">
                                <label for="type">{{ __('Type') }}<span class="text-danger">*</span></label>
                                <select name="type" id="type" class="form-control">
                                    <option selected hidden value="">{{ __('Select Type') }}</option>
                                    <option value="1" {{ old('type') == '1' ? 'selected' : '' }}>
                                        {{ __('Main Domain') }}</option>
                                    <option value="2" {{ old('type') == '2' ? 'selected' : '' }}>
                                        {{ __('Sub Domain') }}</option>
                                    <option value="3" {{ old('type') == '3' ? 'selected' : '' }}>
                                        {{ __('Custom Domain') }}</option>
                                </select>
                                @include('alerts.feedback', ['field' => 'type'])
                            </div>
                            <div class="form-group">
                                <label for="price">{{ __('Purchase Price') }}<span class="text-danger">*</span></label>
                                <input type="text" class="form-control {{ $errors->has('price') ? ' is-invalid' : '' }}"
                                    id="price" name="price" value="{{ old('price') }}"
                                    placeholder="Enter price in USD">
                                @include('alerts.feedback', ['field' => 'price'])
                            </div>
                            <div class="form-group">
                                <label for="purchase_date">{{ __('Purchase Date') }}<span
                                        class="text-danger">*</span></label>
                                <input type="date"
                                    class="form-control {{ $errors->has('purchase_date') ? ' is-invalid' : '' }}"
                                    id="purchase_date" name="purchase_date" value="{{ old('purchase_date') }}">
                                @include('alerts.feedback', ['field' => 'purchase_date'])
                            </div>
                            <div class="form-group">
                                <label for="duration">{{ __('Duration') }}<span class="text-danger">*</span></label>
                                <select name="duration" id="duration"
                                    class="form-control {{ $errors->has('duration') ? ' is-invalid' : '' }}">
                                    <option selected hidden value="">{{ __('Select Duration') }}</option>
                                    <option value="0.5" {{ old('duration') == '0.5' ? 'selected' : '' }}>
                                        {{ __('6 Month') }}</option>
                                    <option value="1" {{ old('duration') == '1' ? 'selected' : '' }}>
                                        {{ __('1 Year') }}</option>
                                    <option value="1.5" {{ old('duration') == '1.5' ? 'selected' : '' }}>
                                        {{ __('1.5 Year') }}</option>
                                    <option value="2" {{ old('duration') == '2' ? 'selected' : '' }}>
                                        {{ __('2 Year') }}</option>
                                    <option value="2.5" {{ old('duration') == '2.5' ? 'selected' : '' }}>
                                        {{ __('2.5 Year') }}</option>
                                    <option value="3" {{ old('duration') == '3' ? 'selected' : '' }}>
                                        {{ __('3 Year') }}</option>
                                    <option value="3.5" {{ old('duration') == '3.5' ? 'selected' : '' }}>
                                        {{ __('3.5 Year') }}</option>
                                    <option value="4" {{ old('duration') == '4' ? 'selected' : '' }}>
                                        {{ __('4 Year') }}</option>
                                    <option value="4.5" {{ old('duration') == '4.5' ? 'selected' : '' }}>
                                        {{ __('4.5 Year') }}</option>
                                    <option value="5" {{ old('duration') == '5' ? 'selected' : '' }}>
                                        {{ __('5 Year') }}</option>
                                    <option value="5.5" {{ old('duration') == '5.5' ? 'selected' : '' }}>
                                        {{ __('5.5 Year') }}</option>
                                    <option value="6" {{ old('duration') == '6' ? 'selected' : '' }}>
                                        {{ __('6 Year') }}</option>
                                    <option value="6.5" {{ old('duration') == '6.5' ? 'selected' : '' }}>
                                        {{ __('6.5 Year') }}</option>
                                    <option value="7" {{ old('duration') == '7' ? 'selected' : '' }}>
                                        {{ __('7 Year') }}</option>
                                    <option value="7.5" {{ old('duration') == '7.5' ? 'selected' : '' }}>
                                        {{ __('7.5 Year') }}</option>
                                    <option value="8" {{ old('duration') == '8' ? 'selected' : '' }}>
                                        {{ __('8 Year') }}</option>
                                    <option value="8.5" {{ old('duration') == '8.5' ? 'selected' : '' }}>
                                        {{ __('8.5 Year') }}</option>
                                    <option value="9" {{ old('duration') == '9' ? 'selected' : '' }}>
                                        {{ __('9 Year') }}</option>
                                    <option value="9.5" {{ old('duration') == '9.5' ? 'selected' : '' }}>
                                        {{ __('9.5 Year') }}</option>
                                    <option value="10" {{ old('duration') == '10' ? 'selected' : '' }}>
                                        {{ __('10 Year') }}</option>
                                </select>
                                @include('alerts.feedback', ['field' => 'duration'])
                            </div>
                            <div class="form-group">
                                <label for="admin_url">{{ __('Login URL') }}<span class="text-danger">*</span></label>
                                <input type="url"
                                    class="form-control {{ $errors->has('admin_url') ? ' is-invalid' : '' }}"
                                    id="admin_url" name="admin_url" value="{{ old('admin_url') }}"
                                    placeholder="Enter login url">
                                @include('alerts.feedback', ['field' => 'admin_url'])
                            </div>
                            <div class="form-group">
                                <label for="username">{{ __('Username') }}</label>
                                <input type="text"
                                    class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}"
                                    id="username" name="username" value="{{ old('username') }}"
                                    placeholder="Enter username">
                                @include('alerts.feedback', ['field' => 'username'])
                            </div>
                            <div class="form-group">
                                <label for="email">{{ __('Email') }}<span class="text-danger">*</span></label>
                                <input type="email"
                                    class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" id="email"
                                    name="email" value="{{ old('email') }}" placeholder="Enter email">
                                @include('alerts.feedback', ['field' => 'email'])
                            </div>
                            <div class="form-group">
                                <label for="password">{{ __('Password') }}<span class="text-danger">*</span></label>
                                <input type="text"
                                    class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                    id="password" name="password" value="{{ old('password') }}"
                                    placeholder="Enter password">
                                @include('alerts.feedback', ['field' => 'password'])
                            </div>
                            <div class="form-group">
                                <label for="note">{{ __('Note') }}</label>
                                <textarea name="note" id="note" class="form-control" placeholder="Note...">{{ old('note') }}</textarea>
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
