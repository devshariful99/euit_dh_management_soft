@extends('admin.layouts.app', ['pageSlug' => 'cd'])

@section('title', 'Client Domain List')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card m-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ __('Client Domain List') }}</h3>
                    <div class="button_ ms-auto">
                        @include('admin.partials.button', [
                            'routeName' => 'cm.cd.cd_create',
                            'className' => 'btn-outline-info',
                            'label' => 'Add new client domain',
                        ])
                    </div>

                </div>
                <div class="card-body">
                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Client') }}</th>
                                <th>{{ __('Hosting') }}</th>
                                <th>{{ __('Domain Name') }}</th>
                                <th>{{ __('Type') }}</th>
                                <th>{{ __('Purchase Price') }}</th>
                                <th>{{ __('Website') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Purchase Date') }}</th>
                                <th>{{ __('Created By') }}</th>
                                <th>{{ __('Creation Date') }}</th>
                                <th class="text-center">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($client_domains as $domain)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td>{{ $domain->client->name }}</td>
                                    <td>{{ $domain->hosting->name }}</td>
                                    <td>{{ $domain->domain_name }}</td>
                                    <td>{{ Str::ucfirst(str_replace('-', ' ', $domain->type())) }}</td>
                                    <td>{{ number_format($domain->price, 2) . ' USD' }}</td>
                                    <td><span
                                            class="{{ $domain->getStatusBadgeClass() }}">{{ $domain->getStatus() }}</span>
                                    </td>
                                    <td><span
                                            class="{{ $domain->getDevelopedStatusBadgeClass() }}">{{ $domain->getDevelopedStatus() }}</span>
                                    </td>
                                    <td>{{ timeFormate($domain->purchase_date) }}</td>
                                    <td>{{ $domain->created_user_name() }}</td>
                                    <td>{{ $domain->created_date() }}</td>
                                    <td class="text-center align-middle">
                                        @include('admin.partials.action_buttons', [
                                            'menuItems' => [
                                                [
                                                    'routeName' => 'javascript:void(0)',
                                                    'iconClass' => 'fa-regular fa-eye',
                                                    'className' => 'btn btn-primary view',
                                                    'data-id' => $domain->id,
                                                    'title' => 'Details',
                                                ],
                                                [
                                                    'routeName' => 'cm.cd.cd_edit',
                                                    'params' => [$domain->id],
                                                    'iconClass' => 'fa-regular fa-pen-to-square',
                                                    'className' => 'btn btn-info',
                                                    'title' => 'Edit',
                                                ],

                                                [
                                                    'routeName' => 'cm.cd.cd_delete',
                                                    'params' => [$domain->id],
                                                    'iconClass' => 'fa-regular fa-trash-can',
                                                    'className' => 'btn btn-danger',
                                                    'title' => 'Delete',
                                                    'delete' => true,
                                                ],
                                                [
                                                    'routeName' => 'cm.cd.developed.cd_edit',
                                                    'params' => [$domain->id],
                                                    'iconClass' => $domain->getDevelopedStatusIcon(),
                                                    'className' => $domain->getDevelopedStatusClass(),
                                                    'title' => $domain->getDevelopedStatusTitle(),
                                                ],
                                                [
                                                    'routeName' => 'cm.cd.status.cd_edit',
                                                    'params' => [$domain->id],
                                                    'iconClass' => 'fa-solid fa-power-off',
                                                    'className' => $domain->getStatusClass(),
                                                    'title' => $domain->getStatusTitle(),
                                                ],
                                                [
                                                    'routeName' => 'cm.renew.renew_list',
                                                    'params' => ['type' => 'Domain', 'id' => $domain->id],
                                                    'iconClass' => 'fa-solid fa-arrow-right',
                                                    'className' => 'btn btn-primary',
                                                    'title' => 'Renewals',
                                                ],
                                            ],
                                        ])
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Admin Details Modal  --}}
    <div class="modal view_modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Client Domain Details') }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal_data">
                </div>
            </div>
        </div>
    </div>
@endsection
@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]])
@push('js')
    <script>
        $(document).ready(function() {
            $('.view').on('click', function() {
                let id = $(this).data('id');
                let url = ("{{ route('cm.cd.details.cd_list', ['id']) }}");
                let _url = url.replace('id', id);
                $.ajax({
                    url: _url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var result = `
                                <table class="table table-striped">
                                    <tr>
                                        <th class="text-nowrap">Client</th>
                                        <th>:</th>
                                        <td>${data.client.name}</td>
                                    </tr>
                                     <tr>
                                        <th class="text-nowrap">Domain Name</th>
                                        <th>:</th>
                                        <td>${data.domain_name}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Company</th>
                                        <th>:</th>
                                        <td>${data.company.name}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Hosting</th>
                                        <th>:</th>
                                        <td>${data.hosting ? data.hosting.name : "NULL"}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Type</th>
                                        <th>:</th>
                                        <td>${data.type}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Purchase Price</th>
                                        <th>:</th>
                                        <td>${data.price} USD</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Login URL</th>
                                        <th>:</th>
                                        <td><a target="_blank" href="${data.admin_url}">${data.admin_url}</a></td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Username</th>
                                        <th>:</th>
                                        <td>${data.username}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Email</th>
                                        <th>:</th>
                                        <td>${data.email}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Password</th>
                                        <th>:</th>
                                        <td>${data.password}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Purchase Date</th>
                                        <th>:</th>
                                        <td>${data.purchase_date}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Renew Status</th>
                                        <th>:</th>
                                        <td><span class="badge ${data.renew_statusClass}">${data.renew_status}</span></td>
                                    </tr>`;
                        if (data.renew_status === 'Yes') {
                            result += `
                                    <tr>
                                        <th class="text-nowrap">Renew Date</th>
                                        <th>:</th>
                                        <td>${data.renew_date}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Renew From</th>
                                        <th>:</th>
                                        <td>${data.renew_from}</td>
                                    </tr>`;
                        }


                        result += `<tr>
                                        <th class="text-nowrap">Duration</th>
                                        <th>:</th>
                                        <td>${data.duration} Year</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Expire Date</th>
                                        <th>:</th>
                                        <td>${data.expire_date}</td>
                                    </tr>

                                    <tr>
                                        <th class="text-nowrap">Note</th>
                                        <th>:</th>
                                        <td>${data.note}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Website</th>
                                        <th>:</th>
                                        <td><span class="badge ${data.statusBg}">${data.statusTitle}</span></td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Status</th>
                                        <th>:</th>
                                        <td><span class="badge ${data.isDevelopedBadge}">${data.isDeveloped}</span></td>
                                    </tr>

                                    <tr>
                                        <th class="text-nowrap">Created At</th>
                                        <th>:</th>
                                        <td>${data.creating_time}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Created By</th>
                                        <th>:</th>
                                        <td>${data.created_by}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Updated At</th>
                                        <th>:</th>
                                        <td>${data.updating_time}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Updated By</th>
                                        <th>:</th>
                                        <td>${data.updated_by}</td>
                                    </tr>
                                </table>
                                `;
                        $('.modal_data').html(result);
                        $('.view_modal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching admin data:', error);
                    }
                });
            });
        });
    </script>
@endpush
