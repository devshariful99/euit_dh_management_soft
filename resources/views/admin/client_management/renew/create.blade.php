@extends('admin.layouts.app', ['pageSlug' => 'renew'])

@section('title', 'Renew Domain/Hosting')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card m-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ __('Renew Domain/Hosting') }}</h3>
                    <div class="button_">
                        @include('admin.partials.button', [
                            'routeName' => 'cm.renew.renew_list',
                            'className' => 'btn-outline-info',
                            'label' => 'Back',
                        ])
                    </div>

                </div>
                <div class="card-body">
                    <form action="{{ route('cm.renew.renew_create') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="client_id">{{ __('Client') }}<span class="text-danger">*</span></label>
                                    <select name="client_id" id="client_id" class="form-control">
                                        <option selected hidden value=" ">{{ __('Select Client') }}</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}"
                                                {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                                {{ $client->name }}</option>
                                        @endforeach
                                    </select>
                                    @include('alerts.feedback', ['field' => 'client_id'])
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="renew_for">{{ __('Renew For') }}<span class="text-danger">*</span></label>
                                    <select name="renew_for" id="renew_for" class="form-control" disabled>
                                        <option selected hidden value="">{{ __('Select Payment For') }}</option>
                                        <option value="Hosting" {{ old('renew_for') == 'Hosting' ? 'selected' : '' }}>
                                            {{ __('Hosting') }}</option>
                                        <option value="Domain" {{ old('renew_for') == 'Domain' ? 'selected' : '' }}>
                                            {{ __('Domain') }}</option>
                                    </select>
                                    @include('alerts.feedback', ['field' => 'renew_for'])
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="hd_id"><span id="dh_label">{{ __('Hosting/Domain') }}</span><span
                                            class="text-danger">*</span></label>
                                    <select name="hd_id" id="hd_id" class="form-control" disabled>
                                        <option selected hidden value="">{{ __('Select Hosting/Domain') }}</option>
                                    </select>
                                    @include('alerts.feedback', ['field' => 'hd_id'])
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="renew_date">{{ __('Renew Date') }}<span
                                            class="text-danger">*</span></label>
                                    <input type="date" name="renew_date" id="renew_date" class="form-control"
                                        value="{{ old('renew_date') }}">
                                    @include('alerts.feedback', ['field' => 'renew_date'])
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="price">{{ __('Price') }}<span class="text-danger">*</span></label>
                                    <div class="input-group" role="group">
                                        <input type="text" name="price" placeholder="Enter price" id="price"
                                            class="form-control" value="{{ old('price') }}">
                                        <span class="btn btn-sm btn-secondary disabled"
                                            style="line-height: 2">{{ __('BDT') }}</span>
                                    </div>
                                    @include('alerts.feedback', ['field' => 'price'])
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
                            <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        function activeRenewFor(client) {
            if (client === ' ' || client === null) {
                $('#renew_for').prop('disabled', true);
            } else {
                $('#renew_for').prop('disabled', false);
            }
        }
        $(document).ready(function() {
            $('#client_id').on('change', function() {
                let client = $(this).val();
                activeRenewFor($(this).val());

            });
            activeRenewFor($('#client_id').val());
        });

        $(document).ready(function() {
            $('#renew_for').on('change', function() {
                let renew_for = $(this).val();
                let client_id = $('#client_id').val();
                let url = (
                    "{{ route('cm.renew.get_hostings_or_domains.renew_list', ['renew_for' => '_renew', 'client_id' => '_client']) }}"
                );
                let _url = url.replace('_renew', renew_for);
                let __url = _url.replace('_client', client_id);
                __url = __url.replace(/&amp;/g, "&")
                $.ajax({
                    url: __url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        let result = '';
                        $('#dh_label').html(renew_for);
                        result +=
                            `<option selected hidden value=''>Select ${renew_for}</option>`;
                        response.datas.forEach(function(data) {
                            if (renew_for == 'Domain') {
                                result +=
                                    `<option value='${data.id}'>${data.domain_name}</option>`;
                            } else {
                                result +=
                                    `<option value='${data.id}'>${data.hosting.name}(${data.storage})</option>`;
                            }

                        });
                        $('#hd_id').html(result);
                        $('#hd_id').prop('disabled', false);

                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data:', error);
                    }
                });
            });
        });
    </script>
@endpush
