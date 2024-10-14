@extends('admin.layouts.app', ['pageSlug' => 'ceh'])

@section('title', 'Renew Hosting')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card m-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ __('Renew Hosting') }}</h3>
                    <div class="button_">
                        @include('admin.partials.button', [
                            'routeName' => 'cm.ceh.ceh_list',
                            'className' => 'btn-outline-info',
                            'label' => 'Back',
                        ])
                    </div>

                </div>
                <div class="card-body">
                    <form action="{{ route('cm.ceh.ceh_renew', $hosting->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>{{ __('Client') }}<span class="text-danger">*</span></label>
                                    <input type="text" value="{{ $hosting->client->name }}" class="form-control"
                                        disabled>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>{{ __('Hosting') }}<span class="text-danger">*</span></label>
                                    <input type="text" value="{{ $hosting->hosting->name }}" class="form-control"
                                        disabled>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>{{ __('Storage') }}<span class="text-danger">*</span></label>
                                    <input type="text" name="storage" value="{{ old('storage') ?? $hosting->storage }}"
                                        class="form-control">
                                    @include('alerts.feedback', ['field' => 'storage'])
                                </div>
                                <div class="form-group col-md-6">
                                    <label>{{ __('Renew From') }}<span class="text-danger">*</span></label>
                                    <input type="date" name="renew_from" class="form-control"
                                        value="{{ $hosting->active_renew() ? $hosting->active_renew()->expire_date : $hosting->expire_date }}">
                                    @include('alerts.feedback', ['field' => 'renew_from'])
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="price">{{ __('Price Per Year') }}<span
                                            class="text-danger">*</span></label>
                                    <div class="input-group" role="group">
                                        <input type="text" name="price" placeholder="Enter price per year"
                                            id="price" class="form-control"
                                            value="{{ old('price') ?? $hosting->price }}">
                                        <select name="currency_id" class="form-control">
                                            <option selected hidden value="">{{ __('Select Currency') }}</option>
                                            @foreach ($currencies as $currency)
                                                <option value="{{ $currency->id }}"
                                                    {{ $hosting->currency_id == $currency->id ? 'selected' : '' }}>
                                                    {{ $currency->short_form }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @include('alerts.feedback', ['field' => 'price'])
                                    @include('alerts.feedback', ['field' => 'currency_id'])
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="duration">{{ __('Duration') }}<span class="text-danger">*</span></label>
                                    <select name="duration" id="duration"
                                        class="form-control {{ $errors->has('duration') ? ' is-invalid' : '' }}">
                                        <option selected hidden value="">{{ __('Select Duration') }}</option>
                                        <option value="0.5">{{ __('6 Month') }}</option>
                                        <option value="1">{{ __('1 Year') }}</option>
                                        <option value="1.5">{{ __('1.5 Year') }}</option>
                                        <option value="2">{{ __('2 Year') }}</option>
                                        <option value="2.5">{{ __('2.5 Year') }}</option>
                                        <option value="3">{{ __('3 Year') }}</option>
                                        <option value="3.5">{{ __('3.5 Year') }}</option>
                                        <option value="4">{{ __('4 Year') }}</option>
                                        <option value="4.5">{{ __('4.5 Year') }}</option>
                                        <option value="5">{{ __('5 Year') }}</option>
                                        <option value="5.5">{{ __('5.5 Year') }}</option>
                                        <option value="6">{{ __('6 Year') }}</option>
                                        <option value="6.5">{{ __('6.5 Year') }}</option>
                                        <option value="7">{{ __('7 Year') }}</option>
                                        <option value="7.5">{{ __('7.5 Year') }}</option>
                                        <option value="8">{{ __('8 Year') }}</option>
                                        <option value="8.5">{{ __('8.5 Year') }}</option>
                                        <option value="9">{{ __('9 Year') }}</option>
                                        <option value="9.5">{{ __('9.5 Year') }}</option>
                                        <option value="10">{{ __('10 Year') }}</option>
                                    </select>
                                    @include('alerts.feedback', ['field' => 'duration'])
                                </div>
                                <div class="form-group">
                                    <label for="file">{{ __('Upload') }}</label>
                                    <input type="file" name="file" id="file" class="form-control">
                                    @include('alerts.feedback', ['field' => 'file'])
                                </div>
                            </div>
                        </div>

                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary">{{ __('Renew') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
