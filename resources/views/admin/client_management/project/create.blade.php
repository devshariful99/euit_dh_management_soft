@extends('admin.layouts.app', ['pageSlug' => 'cp'])

@section('title', 'Create Project')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card m-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ __('Create Project') }}</h3>
                    <div class="button_">
                        @include('admin.partials.button', [
                            'routeName' => 'cm.cp.cp_list',
                            'className' => 'btn-outline-info',
                            'label' => 'Back',
                        ])
                    </div>

                </div>
                <div class="card-body">
                    <form action="{{ route('cm.cp.cp_create') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="name">{{ __('Project Name') }}<span class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" id="name"
                                        name="name" value="{{ old('name') }}" placeholder="Enter name">
                                    @include('alerts.feedback', ['field' => 'name'])
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="url">{{ __('Project URL') }}</label>
                                    <input type="url"
                                        class="form-control {{ $errors->has('url') ? ' is-invalid' : '' }}" id="url"
                                        name="url" value="{{ old('url') }}" placeholder="Enter url">
                                    @include('alerts.feedback', ['field' => 'url'])
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="client">{{ __('Client') }}<span class="text-danger">*</span></label>
                                    <select name="client" id="client" class="form-control">
                                        <option value="" selected hidden>{{ __('Select Client') }}</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}"
                                                {{ old('client') == $client->id ? 'selected' : '' }}>{{ $client->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @include('alerts.feedback', ['field' => 'client'])
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="hosting">{{ __('Hosting') }}</label>
                                    <select name="hosting" id="hosting" class="form-control" disabled>
                                        <option value="" selected>{{ __('Select Hosting') }}</option>
                                    </select>
                                    @include('alerts.feedback', ['field' => 'hosting'])
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="domain">{{ __('Domain') }}</label>
                                    <select name="domain" id="domain" class="form-control" disabled>
                                        <option value="" selected>{{ __('Select Domain') }}</option>
                                    </select>
                                    @include('alerts.feedback', ['field' => 'domain'])
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="note">{{ __('Project Note') }}</label>
                                    <textarea name="note" id="note" class="form-control" placeholder="Note...">{{ old('note') }}</textarea>
                                    @include('alerts.feedback', ['field' => 'note'])
                                </div>

                            </div>
                            {{-- <div class="credentials">
                                <div class="credential_item">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>{{ __('Credentials-01') }}</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="title">{{ __('Title') }}<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="title"
                                                        name="credentials[1][name]" value="{{ old('credentials.1.name') }}"
                                                        placeholder="Enter title">
                                                    @include('alerts.feedback', [
                                                        'field' => 'credentials.1.name',
                                                    ])
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="credential_url">{{ __('URL') }}</label>
                                                    <input type="url" class="form-control" id="credential_url"
                                                        name="credentials[1][url]" value="{{ old('credentials.1.url') }}"
                                                        placeholder="Enter url">
                                                    @include('alerts.feedback', [
                                                        'field' => 'credentials.1.url',
                                                    ])
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="credential_email">{{ __('Email') }}</label>
                                                    <input type="email" class="form-control" id="credential_email"
                                                        name="credentials[1][email]"
                                                        value="{{ old('credentials.1.email') }}" placeholder="Enter email">
                                                    @include('alerts.feedback', [
                                                        'field' => 'credentials.1.email',
                                                    ])
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="credential_username">{{ __('Username') }}</label>
                                                    <input type="text" class="form-control" id="credential_username"
                                                        name="credentials[1][username]"
                                                        value="{{ old('credentials.1.username') }}"
                                                        placeholder="Enter username">
                                                    @include('alerts.feedback', [
                                                        'field' => 'credentials.1.username',
                                                    ])
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="credential_password">{{ __('Password') }}<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="credential_password"
                                                        name="credentials[1][password]"
                                                        value="{{ old('credentials.1.password') }}"
                                                        placeholder="Enter password">
                                                    @include('alerts.feedback', [
                                                        'field' => 'credentials.1.password',
                                                    ])
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="credential_note">{{ __('Credential Note') }}<span
                                                            class="text-danger">*</span></label>
                                                    <textarea name="credentials[1][note]" id="credential_note" class="form-control" placeholder="Enter note">{{ old('credentials.1.note') }}</textarea>
                                                    @include('alerts.feedback', [
                                                        'field' => 'credentials.1.note',
                                                    ])
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div> --}}
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
        function get_hd(element) {
            let client_id = element.val();
            let _url = "{{ route('cm.cp.hd.cp_list', ['client_id' => ':client_id']) }}"
            _url = _url.replace(':client_id', client_id);
            let existing_domain = `{{ old('domain') }}`;
            let existing_hosting = `{{ old('hosting') }}`;
            if (client_id != '' && client_id != null) {
                $.ajax({
                    url: _url,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $.each(data.hostings, function(index, hosting) {
                            $('#hosting').append(
                                `<option value='${hosting.id}' ${hosting.id == existing_hosting ? 'selected' : ''}>${hosting.hosting.name}</option>`
                            );
                        });
                        $.each(data.domains, function(index, domain) {
                            $('#domain').append(
                                `<option value='${domain.id}' ${domain.id == existing_domain ? 'selected' : ''}>${domain.domain_name}</option>`
                            );
                        });
                        $('#hosting').prop('disabled', false)
                        $('#domain').prop('disabled', false)


                    }
                });
            } else {
                $('#hosting').html(
                    `<option value='' selected>Select Hosting</option>`
                );
                $('#domain').html(
                    `<option value='' selected>Select Domain</option>`
                );
            }
        }
        $(document).ready(function() {
            $('#client').on('change', function() {
                get_hd($(this));
            });
            get_hd($('#client'));
        });
    </script>
@endpush
