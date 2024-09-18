@extends('admin.layouts.app', ['pageSlug' => 'renew'])

@section('title', 'Client Renew List')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card m-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ __('Client Renew List') }}</h3>
                    <div class="button_ ms-auto">
                        @include('admin.partials.button', [
                            'routeName' => 'cm.renew.renew_create',
                            'className' => 'btn-outline-info',
                            'label' => 'Renew domain/hosting',
                        ])
                    </div>

                </div>
                <div class="card-body">
                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Renew For') }}</th>
                                <th>{{ __('Domain/Hosting') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Renew Date') }}</th>
                                <th>{{ __('Price') }}</th>
                                <th>{{ __('Duration') }}</th>
                                <th>{{ __('Created By') }}</th>
                                <th class="text-center">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($renewals as $renew)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td> {{ $renew->renew_for }} </td>
                                    <td>
                                        @if ($renew->renew_for == 'Domain')
                                            {{ $renew->hd ? $renew->hd->domain_name : '' }}
                                        @else
                                            {{ $renew->hd ? $renew->hd->hosting->name . '(' . $renew->hd->storage . ')' : '' }}
                                        @endif
                                        {{ " ($renew->renew_for)" }}
                                    </td>
                                    <td> <span class="{{ $renew->getStatusBadgeClass() }}">{{ $renew->getStatus() }}</span>
                                    </td>
                                    <td> {{ timeFormate($renew->renew_date) }} </td>
                                    <td> {{ number_format($renew->price, 2) }} </td>
                                    <td> {{ $renew->duration . ' Year' }} </td>
                                    <td>{{ $renew->created_user_name() }}</td>
                                    <td class="text-center align-middle">
                                        @include('admin.partials.action_buttons', [
                                            'menuItems' => [
                                                [
                                                    'routeName' => 'javascript:void(0)',
                                                    'iconClass' => 'fa-regular fa-eye',
                                                    'className' => 'btn btn-primary view',
                                                    'data-id' => $renew->id,
                                                    'title' => 'Details',
                                                ],
                                                [
                                                    'routeName' => 'cm.renew.renew_edit',
                                                    'params' => [$renew->id],
                                                    'iconClass' => 'fa-regular fa-pen-to-square',
                                                    'className' => 'btn btn-info',
                                                    'title' => 'Edit',
                                                ],
                                        
                                                [
                                                    'routeName' => 'cm.renew.renew_delete',
                                                    'params' => [$renew->id],
                                                    'iconClass' => 'fa-regular fa-trash-can',
                                                    'className' => 'btn btn-danger',
                                                    'title' => 'Delete',
                                                    'delete' => true,
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

    {{-- Payment Details Modal  --}}
    <div class="modal view_modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Renew Details') }}</h5>
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
@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4, 5, 6]])
@push('js')
    <script>
        $(document).ready(function() {
            $('.view').on('click', function() {
                let id = $(this).data('id');
                let url = ("{{ route('cm.renew.details.renew_list', ['id']) }}");
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
                                        <th class="text-nowrap">Renew For</th>
                                        <th>:</th>
                                        <td>${data.renew_for}</td>
                                    </tr>`;
                        if (data.renew_for == 'Domain') {
                            result +=
                                `<tr>
                                    <th class="text-nowrap">${data.renew_for}</th>
                                    <th>:</th>
                                    <td>${data.hd.domain_name}</td>
                                </tr>`;
                        } else {
                            result +=
                                `<tr>
                                    <th class="text-nowrap">${data.renew_for}</th>
                                    <th>:</th>
                                    <td>${data.hd.hosting.name} (${data.hd.storage})</td>
                                </tr>`;
                        }
                        result += `
                                    <tr>
                                        <th class="text-nowrap">Price</th>
                                        <th>:</th>
                                        <td>${data.price} Tk</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Status</th>
                                        <th>:</th>
                                        <td><span class="${data.statusBg}">${data.statusTitle}</span></td>
                                    </tr>

                                    <tr>
                                        <th class="text-nowrap">Renew Date</th>
                                        <th>:</th>
                                        <td>${data.renew_date}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Renew From</th>
                                        <th>:</th>
                                        <td>${data.renew_from}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Duration</th>
                                        <th>:</th>
                                        <td>${data.duration} Year</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Expiry Date</th>
                                        <th>:</th>
                                        <td>${data.expire_date}</td>
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
                        console.error('Error fetching renew data:', error);
                    }
                });
            });
        });
    </script>
@endpush
