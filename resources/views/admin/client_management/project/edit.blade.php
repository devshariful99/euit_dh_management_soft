@extends('admin.layouts.app', ['pageSlug' => 'cp'])

@section('title', 'Edit Project')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card m-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ __('Edit Project') }}</h3>
                    <div class="button_">
                        @include('admin.partials.button', [
                            'routeName' => 'cm.cp.cp_list',
                            'className' => 'btn-outline-info',
                            'label' => 'Back',
                        ])
                    </div>

                </div>
                <div class="card-body">
                    <form action="{{ route('cm.cp.cp_edit', $project->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="name">{{ __('Project Name') }}<span class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" id="name"
                                        name="name" value="{{ $project->name }}" placeholder="Enter name">
                                    @include('alerts.feedback', ['field' => 'name'])
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="url">{{ __('Project URL') }}</label>
                                    <input type="url"
                                        class="form-control {{ $errors->has('url') ? ' is-invalid' : '' }}" id="url"
                                        name="url" value="{{ $project->url }}" placeholder="Enter url">
                                    @include('alerts.feedback', ['field' => 'url'])
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="client">{{ __('Client') }}<span class="text-danger">*</span></label>
                                    <select name="client" id="client" class="form-control">
                                        <option value="" selected hidden>{{ __('Select Client') }}</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}"
                                                {{ $project->client_id == $client->id ? 'selected' : '' }}>
                                                {{ $client->name }}
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
                                    <textarea name="note" id="note" class="form-control" placeholder="Note...">{{ $project->note }}</textarea>
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
        function get_hd(element) {
            let client_id = element.val();
            let _url = "{{ route('cm.cp.hd.cp_list', ['client_id' => ':client_id']) }}"
            _url = _url.replace(':client_id', client_id);
            let existing_domain = `{{ $project->domain_id }}`;
            let existing_hosting = `{{ $project->hosting_id }}`;
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
