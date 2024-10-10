@extends('admin.layouts.app', ['pageSlug' => 'renew'])

@section('title', 'Edit Renew Domain/Hosting')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card m-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ __('Edit Renew Domain/Hosting') }}</h3>
                    <div class="button_">
                        @include('admin.partials.button', [
                            'routeName' => 'cm.renew.renew_list',
                            'className' => 'btn-outline-info',
                            'label' => 'Back',
                        ])
                    </div>

                </div>
                <div class="card-body">
                    <form action="{{ route('cm.renew.renew_edit', $renew->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="client_id">{{ __('Client') }}<span class="text-danger">*</span></label>
                                    <select name="client_id" id="client_id" class="form-control">
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}"
                                                {{ $renew->client_id == $client->id ? 'selected' : '' }}>
                                                {{ $client->name }}</option>
                                        @endforeach
                                    </select>
                                    @include('alerts.feedback', ['field' => 'client_id'])
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="renew_for">{{ __('Renew For') }}<span class="text-danger">*</span></label>
                                    <select name="renew_for" id="renew_for" class="form-control">
                                        <option value="Hosting" {{ $renew->renew_for == 'Hosting' ? 'selected' : '' }}>
                                            {{ __('Hosting') }}</option>
                                        <option value="Domain" {{ $renew->renew_for == 'Domain' ? 'selected' : '' }}>
                                            {{ __('Domain') }}</option>
                                    </select>
                                    @include('alerts.feedback', ['field' => 'renew_for'])
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="hd_id"><span id="dh_label">{{ __($renew->renew_for) }}</span><span
                                            class="text-danger">*</span></label>
                                    <select name="hd_id" id="hd_id" class="form-control">
                                        @foreach ($hds as $hd)
                                            <option value="{{ $hd->id }}"
                                                {{ $renew->hd_id == $hd->id ? 'selected' : '' }}>
                                                @if ($renew->renew_for == 'Hosting')
                                                    {{ $hd->hosting->name . ' (' . $hd->storage . ')' }}
                                                @else
                                                    {{ $hd->domain_name }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @include('alerts.feedback', ['field' => 'hd_id'])
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="renew_date">{{ __('Renew Date') }}<span
                                            class="text-danger">*</span></label>
                                    <input type="date" name="renew_date" id="renew_date" class="form-control"
                                        value="{{ $renew->renew_date }}">
                                    @include('alerts.feedback', ['field' => 'renew_date'])
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="price">{{ __('Price') }}<span class="text-danger">*</span></label>
                                    <div class="input-group" role="group">
                                        <input type="text" name="price" placeholder="Enter price" id="price"
                                            class="form-control" value="{{ $renew->price }}">
                                        <select name="currency_id" class="form-control">
                                            <option selected hidden value="">{{ __('Select Currency') }}</option>
                                            @foreach ($currencies as $currency)
                                                <option value="{{ $currency->id }}"
                                                    {{ $renew->currency_id == $currency->id ? 'selected' : '' }}>
                                                    {{ $currency->short_form }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @include('alerts.feedback', ['field' => 'price'])
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="duration">{{ __('Duration') }}<span class="text-danger">*</span></label>
                                    <select name="duration" id="duration"
                                        class="form-control {{ $errors->has('duration') ? ' is-invalid' : '' }}">
                                        <option value="0.5" {{ $renew->duration == '0.5' ? 'selected' : '' }}>
                                            {{ __('6 Month') }}</option>
                                        <option value="1" {{ $renew->duration == '1' ? 'selected' : '' }}>
                                            {{ __('1 Year') }}</option>
                                        <option value="1.5" {{ $renew->duration == '1.5' ? 'selected' : '' }}>
                                            {{ __('1.5 Year') }}</option>
                                        <option value="2" {{ $renew->duration == '2' ? 'selected' : '' }}>
                                            {{ __('2 Year') }}</option>
                                        <option value="2.5" {{ $renew->duration == '2.5' ? 'selected' : '' }}>
                                            {{ __('2.5 Year') }}</option>
                                        <option value="3" {{ $renew->duration == '3' ? 'selected' : '' }}>
                                            {{ __('3 Year') }}</option>
                                        <option value="3.5" {{ $renew->duration == '3.5' ? 'selected' : '' }}>
                                            {{ __('3.5 Year') }}</option>
                                        <option value="4" {{ $renew->duration == '4' ? 'selected' : '' }}>
                                            {{ __('4 Year') }}</option>
                                        <option value="4.5" {{ $renew->duration == '4.5' ? 'selected' : '' }}>
                                            {{ __('4.5 Year') }}</option>
                                        <option value="5" {{ $renew->duration == '5' ? 'selected' : '' }}>
                                            {{ __('5 Year') }}</option>
                                        <option value="5.5" {{ $renew->duration == '5.5' ? 'selected' : '' }}>
                                            {{ __('5.5 Year') }}</option>
                                        <option value="6" {{ $renew->duration == '6' ? 'selected' : '' }}>
                                            {{ __('6 Year') }}</option>
                                        <option value="6.5" {{ $renew->duration == '6.5' ? 'selected' : '' }}>
                                            {{ __('6.5 Year') }}</option>
                                        <option value="7" {{ $renew->duration == '7' ? 'selected' : '' }}>
                                            {{ __('7 Year') }}</option>
                                        <option value="7.5" {{ $renew->duration == '7.5' ? 'selected' : '' }}>
                                            {{ __('7.5 Year') }}</option>
                                        <option value="8" {{ $renew->duration == '8' ? 'selected' : '' }}>
                                            {{ __('8 Year') }}</option>
                                        <option value="8.5" {{ $renew->duration == '8.5' ? 'selected' : '' }}>
                                            {{ __('8.5 Year') }}</option>
                                        <option value="9" {{ $renew->duration == '9' ? 'selected' : '' }}>
                                            {{ __('9 Year') }}</option>
                                        <option value="9.5" {{ $renew->duration == '9.5' ? 'selected' : '' }}>
                                            {{ __('9.5 Year') }}</option>
                                        <option value="10" {{ $renew->duration == '10' ? 'selected' : '' }}>
                                            {{ __('10 Year') }}</option>
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
