@extends('admin.layouts.app', ['pageSlug' => 'payment'])

@section('title', 'Payment List')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card m-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ __('Payment List') }}</h3>
                    <div class="button_ ms-auto">
                        @include('admin.partials.button', [
                            'routeName' => 'payment.payment_create',
                            'className' => 'btn-outline-info',
                            'label' => 'Add new payment',
                        ])
                    </div>

                </div>
                <div class="card-body">
                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Payment For') }}</th>
                                <th>{{ __('Domain/Hosting') }}</th>
                                <th>{{ __('Payment Type') }}</th>
                                <th>{{ __('Payment Date') }}</th>
                                <th>{{ __('Price') }}</th>
                                <th>{{ __('Created By') }}</th>
                                <th class="text-center">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td> {{ $payment->payment_for }} </td>
                                    <td> {{ $payment->domain_or_hosting_name() }} </td>
                                    <td> {{ $payment->payment_type }} </td>
                                    <td> {{ timeFormate($payment->payment_date) }} </td>
                                    <td> {{ number_format($payment->price, 2) }}{!! optional($payment->currency)->icon !!}
                                    </td>
                                    <td>{{ $payment->created_user_name() }}</td>
                                    <td class="text-center align-middle">
                                        @include('admin.partials.action_buttons', [
                                            'menuItems' => [
                                                [
                                                    'routeName' => 'javascript:void(0)',
                                                    'iconClass' => 'fa-regular fa-eye',
                                                    'className' => 'btn btn-primary view',
                                                    'data-id' => $payment->id,
                                                    'title' => 'Details',
                                                ],
                                                [
                                                    'routeName' => 'payment.payment_edit',
                                                    'params' => [$payment->id],
                                                    'iconClass' => 'fa-regular fa-pen-to-square',
                                                    'className' => 'btn btn-info',
                                                    'title' => 'Edit',
                                                ],

                                                [
                                                    'routeName' => 'payment.payment_delete',
                                                    'params' => [$payment->id],
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
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Payment Details') }}</h5>
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
            $(document).on('click', '.view', function() {
                let id = $(this).data('id');
                let url = ("{{ route('payment.details.payment_list', ['id']) }}");
                let _url = url.replace('id', id);
                $.ajax({
                    url: _url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var result = `
                                <table class="table table-striped">
                                    <tr>
                                        <th class="text-nowrap">Payment For</th>
                                        <th>:</th>
                                        <td>${data.payment_for}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">${data.payment_for}</th>
                                        <th>:</th>
                                        <td>${data.hd.name} (${data.payment_for})</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Payment Type</th>
                                        <th>:</th>
                                        <td>${data.payment_type}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Payment Date</th>
                                        <th>:</th>
                                        <td>${data.payment_date}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Price</th>
                                        <th>:</th>
                                        <td>${data.price}${data.icon} </td>
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
