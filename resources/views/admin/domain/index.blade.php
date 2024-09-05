@extends('admin.layouts.app', ['pageSlug' => 'domain'])

@section('title', 'Domain List')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card m-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ __('Domain List') }}</h3>
                    <div class="button_ ms-auto">
                        @include('admin.partials.button', [
                            'routeName' => 'domain.domain_create',
                            'className' => 'btn-outline-info',
                            'label' => 'Add new domain',
                        ])
                    </div>

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
                            @foreach ($domains as $domain)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td>{{ $domain->hosting->name ?? '--' }}</td>
                                    <td>{{ $domain->name }}</td>
                                    <td>{{ $domain->company->name }}</td>
                                    <td>{{ $domain->username ?? '--' }}</td>
                                    <td><a target="_blank" class="btn btn-sm btn-primary" href="{{$domain->admin_url}}">{{__('Log In')}}</a></td>
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
                                                    'routeName' => 'domain.details.domain_list',
                                                    'params' => [$domain->id],
                                                    'iconClass' => 'fa-regular fa-eye',
                                                    'className' => 'btn btn-primary view',
                                                    'title' => 'Details',
                                                ],
                                                [
                                                    'routeName' => 'domain.domain_edit',
                                                    'params' => [$domain->id],
                                                    'iconClass' => 'fa-regular fa-pen-to-square',
                                                    'className' => 'btn btn-info',
                                                    'title' => 'Edit',
                                                ],
                                                
                                                [
                                                    'routeName' => 'domain.domain_delete',
                                                    'params' => [$domain->id],
                                                    'iconClass' => 'fa-regular fa-trash-can',
                                                    'className' => 'btn btn-danger',
                                                    'title' => 'Delete',
                                                    'delete' => true,
                                                ],
                                                [
                                                    'routeName' => 'domain.developed.domain_edit',
                                                    'params' => [$domain->id],
                                                    'iconClass' => $domain->getDevelopedStatusIcon(),
                                                    'className' => $domain->getDevelopedStatusClass(),
                                                    'title' => $domain->getDevelopedStatusTitle(),
                                                ],
                                                [
                                                    'routeName' => 'domain.status.domain_edit',
                                                    'params' => [$domain->id],
                                                    'iconClass' => 'fa-solid fa-power-off',
                                                    'className' => $domain->getStatusClass(),
                                                    'title' => $domain->getStatusTitle(),
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

    {{-- Domain Details Modal  --}}
    {{-- <div class="modal view_modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Domain Details') }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal_data">
                </div>
            </div>
        </div>
    </div> --}}
@endsection
@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]])
{{-- @push('js')
    <script>
        $(document).ready(function() {
            $('.view').on('click', function() {
                let id = $(this).data('id');
                let url = ("{{ route('domain.details.domain_list', ['id']) }}");
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
@endpush --}}
