@extends('admin.layouts.app', ['pageSlug' => 'ceh'])

@section('title', 'Client Expire Hosting List')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card m-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ __('Client Expire Hosting List') }}</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Client') }}</th>
                                <th>{{ __('Hosting') }}</th>
                                <th>{{ __('Storage') }}</th>
                                <th>{{ __('Purchase Price') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Purchase Date') }}</th>
                                <th>{{ __('Expired Date') }}</th>
                                <th>{{ __('Created By') }}</th>
                                <th class="text-center">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($client_hostings as $hosting)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td>{{ $hosting->client->name }}</td>
                                    <td>{{ $hosting->hosting->name }}</td>
                                    <td>{{ $hosting->storage }}</td>
                                    <td>{{ number_format($hosting->price, 2) }}{!! optional($hosting->currency)->icon !!}</td>
                                    <td><span
                                            class="{{ $hosting->getStatusBadgeClass() }}">{{ $hosting->getStatus() }}</span>
                                    </td>
                                    <td>{{ timeFormate($hosting->purchase_date) }}</td>
                                    <td>{{ timeFormate($hosting->active_renew() ? $hosting->active_renew()->expire_date : $hosting->expire_date) }}</td>
                                    <td>{{ $hosting->created_user_name() }}</td>
                                    <td class="text-center align-middle">
                                        @include('admin.partials.action_buttons', [
                                            'menuItems' => [
                                                [
                                                    'routeName' => 'javascript:void(0)',
                                                    'iconClass' => 'fa-regular fa-eye',
                                                    'className' => 'btn btn-primary view',
                                                    'data-id' => $hosting->id,
                                                    'title' => 'Details',
                                                ],
                                                [
                                                    'routeName' => 'javascript:void(0)',
                                                    'data-id' => $hosting->id,
                                                    'iconClass' => 'fa-solid fa-file-invoice ',
                                                    'className' => 'btn btn-success invoice_view',
                                                    'title' => 'Invoice',
                                                ],
                                                [
                                                    'routeName' => 'cm.renew.renew_list',
                                                    'params' => ['type' => 'Hosting', 'id' => $hosting->id],
                                                    'iconClass' => 'fa-solid fa-arrow-right',
                                                    'className' => 'btn btn-info',
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
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Client Expire Hosting Details') }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal_data">
                </div>
            </div>
        </div>
    </div>
    {{-- Invoice Modal  --}}
    <div class="modal invoice_modal fade" id="exampleModal1" tabindex="-1" role="dialog"
        aria-labelledby="exampleModal1Label" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModal1Label">{{ __('Client Expire Domain Details') }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body invoice_modal_data">
                    <form action="{{ route('cm.ceh.data.ceh_invoice') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="ceh_id" value="">
                        <div class="form-group">
                            <label>Renewal Date<span class="text-danger">*</span></label>
                            <input type="date" name="renewal_date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Duration<span class="text-danger">*</span></label>
                            <select name="duration" class="form-control" required>
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
                        </div>
                        <div class="form-group">
                            <label>Storage<span class="text-danger">*</span></label>
                            <input type="text" name="storage" placeholder="Enter storage ex: 5GB" class="form-control"
                                required>
                        </div>

                        <div class="form-group">
                            <label>Price Per Year<span class="text-danger">*</span></label>
                            <input type="text" name="price" placeholder="Enter Price Per Year" class="form-control"
                                required>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4, 5, 6, 7, 8]])
@push('js')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.invoice_view', function() {
                let id = $(this).data('id');
                $('#ceh_id').val(id);
                $('.invoice_modal').modal('show');

            });
            $(document).on('click', '.view', function() {
                let id = $(this).data('id');
                let url = ("{{ route('cm.ceh.details.ceh_list', ['id']) }}");
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
                                        <th class="text-nowrap">Hosting</th>
                                        <th>:</th>
                                        <td>${data.hosting.name}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Storage</th>
                                        <th>:</th>
                                        <td>${data.storage}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Purchase Price</th>
                                        <th>:</th>
                                        <td>${data.price}${data.icon}</td>
                                    </tr>
                                     <tr>
                                        <th class="text-nowrap">Status</th>
                                        <th>:</th>
                                        <td><span class="badge ${data.statusBg}">${data.statusTitle}</span></td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Login URL</th>
                                        <th>:</th>
                                        <td><a target="_blank" href="${data.admin_url}">${data.admin_url}</a></td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Username</th>
                                        <th>:</th>
                                        <td>
                                            <span id="username">${data.username}</span>
                                            <a href="javascript:void(0)" title="Copy" class="copy-btn text-info p-2 fs-5"
                                            data-clipboard-target="#username">
                                                <i class="fas fa-copy"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Email</th>
                                        <th>:</th>
                                        <td>
                                            <span id="email">${data.email}</span>
                                            <a href="javascript:void(0)" title="Copy" class="copy-btn text-info p-2 fs-5"
                                            data-clipboard-target="#email">
                                                <i class="fas fa-copy"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Password</th>
                                        <th>:</th>
                                        <td>
                                            <span id="password">${data.password}</span>
                                            <a href="javascript:void(0)" title="Copy" class="copy-btn text-info p-2 fs-5"
                                            data-clipboard-target="#password">
                                                <i class="fas fa-copy"></i>
                                            </a>
                                        </td>
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
