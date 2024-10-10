@extends('admin.layouts.app', ['pageSlug' => 'currency'])

@section('title', 'Create Currency')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card m-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ __('Create Currency') }}</h3>
                    <div class="button_">
                        @include('admin.partials.button', [
                            'routeName' => 'currency.currency_list',
                            'className' => 'btn-outline-info',
                            'label' => 'Back',
                        ])
                    </div>

                </div>
                <div class="card-body">
                    <form action="{{ route('currency.currency_create') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">{{ __('Name') }}<span class="text-danger">*</span></label>
                                <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                    id="name" name="name" value="{{ old('name') }}"
                                    placeholder="Enter currency name">
                                @include('alerts.feedback', ['field' => 'name'])
                            </div>
                            <div class="form-group">
                                <label for="short_form">{{ __('Short Form') }}<span class="text-danger">*</span></label>
                                <input type="text"
                                    class="form-control {{ $errors->has('short_form') ? ' is-invalid' : '' }}"
                                    id="short_form" name="short_form" value="{{ old('short_form') }}"
                                    placeholder="Enter currency short form">
                                @include('alerts.feedback', ['field' => 'short_form'])
                            </div>
                            <div class="form-group">
                                <label for="icon">{{ __('Icon Code') }}<span class="text-danger">*</span></label>
                                <input type="text" class="form-control {{ $errors->has('icon') ? ' is-invalid' : '' }}"
                                    id="icon" name="icon" value="{{ old('icon') }}"
                                    placeholder="Enter icon code">
                                <small>You can get the HEX icon code from here: <a
                                        href="https://www.toptal.com/designers/htmlarrows/currency/" target="_blank">Click
                                        Here</a></small>
                                @include('alerts.feedback', ['field' => 'icon'])
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
