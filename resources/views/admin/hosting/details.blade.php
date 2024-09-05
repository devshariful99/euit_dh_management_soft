@extends('admin.layouts.app', ['pageSlug' => 'hosting'])

@section('title', 'Hosting Details')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card m-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ __('Hosting Details') }}</h3>
                    <div class="button_ ms-auto">
                        @include('admin.partials.button', [
                            'routeName' => 'hosting.hosting_list',
                            'className' => 'btn-outline-info',
                            'label' => 'Back',
                        ])
                    </div>

                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th>{{__('Hosting Name')}}</th>
                                <th>:</th>
                                <td>{{$hosting->name}}</td>
                            </tr>
                            <tr>
                                <th>{{__('Company Name')}}</th>
                                <th>:</th>
                                <td>{{$hosting->company->name}}</td>
                            </tr>
                            <tr>
                                <th>{{__('Login URL')}}</th>
                                <th>:</th>
                                <td><a target="_blank" class="btn btn-sm btn-primary" href="{{$hosting->admin_url}}">{{__('Log In')}}</a></td>
                            </tr>
                            <tr>
                                <th>{{__('Username')}}</th>
                                <th>:</th>
                                <td>{{$hosting->username ?? '--'}}</td>
                            </tr>
                            <tr>
                                <th>{{__('Email')}}</th>
                                <th>:</th>
                                <td>{{$hosting->email}}</td>
                            </tr>
                            <tr>
                                <th>{{__('Password')}}</th>
                                <th>:</th>
                                <td>{{$hosting->password}}</td>
                            </tr>
                            <tr>
                                <th>{{__('Purchase Date')}}</th>
                                <th>:</th>
                                <td>{{$hosting->purchase_date ?timeFormate($hosting->purchase_date) : '--'}}</td>
                            </tr>
                            <tr>
                                <th>{{__('Renew Status')}}</th>
                                <th>:</th>
                                <td><span class="badge {{$hosting->renew_data ? 'badge-success' : 'badge-warning'}}">{{$hosting->renew_data ? 'Yes' : 'No'}}</span></td>
                            </tr>
                            <tr>
                                <th>{{__('Renew Date')}}</th>
                                <th>:</th>
                                <td>{{$hosting->renew_date ?timeFormate($hosting->renew_date) : '--'}}</td>
                            </tr>
                            <tr>
                                <th>{{__('Expiry Date')}}</th>
                                <th>:</th>
                                <td>{{$hosting->expire_date ?timeFormate($hosting->expire_date) : '--'}}</td>
                            </tr>
                            <tr>
                                <th>{{__('Status')}}</th>
                                <th>:</th>
                                <td><span class="{{ $hosting->getStatusBadgeClass() }}">{{ $hosting->getStatus() }}</span></td>
                            </tr>
                            <tr>
                                <th>{{__('Note')}}</th>
                                <th>:</th>
                                <td>{{$hosting->note}}</td>
                            </tr>
                            <tr>
                                <th>{{__('Created By')}}</th>
                                <th>:</th>
                                <td>{{$hosting->created_user_name()}}</td>
                            </tr>
                            <tr>
                                <th>{{__('Created Date')}}</th>
                                <th>:</th>
                                <td>{{$hosting->created_date()}}</td>
                            </tr>
                            <tr>
                                <th>{{__('Updated By')}}</th>
                                <th>:</th>
                                <td>{{$hosting->updated_user_name()}}</td>
                            </tr>
                            <tr>
                                <th>{{__('Updated At')}}</th>
                                <th>:</th>
                                <td>{{$hosting->updated_date()}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{-- Hosting Payments  --}}
        <div class="col-12">
            <div class="card m-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ __($hosting->name.' Payments') }}</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Payment Type') }}</th>
                                <th>{{ __('Payment Date') }}</th>
                                <th>{{ __('Price') }}</th>
                                <th>{{ __('Created By') }}</th>
                                <th>{{ __('Created Date') }}</th>
                                <th class="text-center">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td> {{ $payment->payment_type }} </td>
                                    <td> {{ timeFormate($payment->payment_date) }} </td>
                                    <td> {{ number_format($payment->price,2) }} </td>
                                    <td>{{ $payment->created_user_name()}}</td>
                                    <td>{{ $payment->created_date()}}</td>
                                    <td class="text-center align-middle">
                                        @include('admin.partials.action_buttons', [
                                            'menuItems' => [
                                                [
                                                    'routeName' => 'javascript:void(0)',
                                                    'iconClass' => 'fa-regular fa-eye',
                                                    'className' => 'btn btn-primary view1',
                                                    'data-id' => $payment->id,
                                                    'title' => 'Details',
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
        {{-- Hosting Payments  --}}
        {{-- Total Domains  --}}
        <div class="col-12">
            <div class="card m-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ __('Total Domains -') }} <strong class="text-primary">({{$hosting->domains->count()}})</strong></h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Hosting') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Company') }}</th>
                                <th>{{ __('Username') }}</th>
                                <th>{{ __('Login URL') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Password') }}</th>
                                <th>{{ __('Website') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Created By') }}</th>
                                <th class="text-center">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hosting->domains as $domain)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td>{{ $domain->hosting->name ?? '--' }}</td>
                                    <td>{{ $domain->name }}</td>
                                    <td>{{ $domain->company->name }}</td>
                                    <td>{{ $domain->username ?? '--' }}</td>
                                    <td><a target="_blank" href="{{$domain->admin_url}}">{{removeHttpProtocol($domain->admin_url)}}</a></td>
                                    <td>{{ $domain->email }}</td>
                                    <td>{{ $domain->password }}</td>
                                    <td><span class="{{ $domain->getStatusBadgeClass() }}">{{ $domain->getStatus() }}</span>
                                    </td>
                                    <td><span class="{{ $domain->getDevelopedStatusBadgeClass() }}">{{ $domain->getDevelopedStatus() }}</span>
                                    </td>
                                    <td>{{ $domain->created_user_name()}}</td>
                                    <td class="text-center align-middle">
                                        @include('admin.partials.action_buttons', [
                                            'menuItems' => [
                                                [
                                                    'routeName' => 'javascript:void(0)',
                                                    'iconClass' => 'fa-regular fa-eye',
                                                    'className' => 'btn btn-primary view2',
                                                    'data-id' => $domain->id,
                                                    'title' => 'Details',
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
        {{-- Total Domains  --}}
    </div>
    {{-- Payment Details Modal  --}}
    <div class="modal payment_modal_view fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Payment Details') }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body payment_modal_data">
                </div>
            </div>
        </div>
    </div>
    {{-- Domain Details Modal  --}}
    <div class="modal domain_modal_view fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Domain Details') }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body domain_modal_data">
                </div>
            </div>
        </div>
    </div>
@endsection
@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4, 5]])

@push('js')
    <script>

        // Payment Details AJAX 
        $(document).ready(function() {
            $('.view1').on('click', function() {
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
                                        <td>${data.price} Tk</td>
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
                        $('.payment_modal_data').html(result);
                        $('.payment_modal_view').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching admin data:', error);
                    }
                });
            });
        });

        // Domain Details AJAX 
        $(document).ready(function() {
            $('.view2').on('click', function() {
                let id = $(this).data('id');
                let url = ("{{ route('domain.view.domain_list', ['id']) }}");
                let _url = url.replace('id', id);
                $.ajax({
                    url: _url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        let status = data.status = 1 ? 'Active' : 'Deactive';
                        let statusClass = data.status = 1 ? 'badge-success' :
                            'badge-warning';
                        let developedStatus = data.is_developed == 1 ? 'Developed' : 'Not Developed';
                        let developedStatusClass = data.is_developed == 1 ? 'badge-info' :
                            'badge-warning';
                        let renew_status = (data.renew_date !== '--') ? 'Yes' : 'No';
                        let renew_statusClass = (data.renew_date !== '--') ? 'badge-success' :
                            'badge-warning';
                        var result = `
                                <table class="table table-striped">
                                    <tr>
                                        <th class="text-nowrap">Hosting</th>
                                        <th>:</th>
                                        <td>${data.hosting ? data.hosting.name : '--'}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Name</th>
                                        <th>:</th>
                                        <td>${data.name}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Company</th>
                                        <th>:</th>
                                        <td>${data.company.name}</td>
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
                                        <td><span class="badge ${renew_statusClass}">${renew_status}</span></td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Renew Date</th>
                                        <th>:</th>
                                        <td>${data.renew_date}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Expire Date</th>
                                        <th>:</th>
                                        <td>${data.expire_date}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Website</th>
                                        <th>:</th>
                                        <td><span class="badge ${developedStatusClass}">${developedStatus}</span></td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Status</th>
                                        <th>:</th>
                                        <td><span class="badge ${statusClass}">${status}</span></td>
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
                        $('.domain_modal_data').html(result);
                        $('.domain_modal_view').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching admin data:', error);
                    }
                });
            });
        });


        
    </script>
@endpush
