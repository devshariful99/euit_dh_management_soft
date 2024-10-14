@extends('admin.layouts.app', ['pageSlug' => 'dashboard'])
@section('title', 'Admin Dashboard')
@push('css')
    <style>
        .dashboard_wrap {
            height: 69vh;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row row-cols-5">
            <div class="col">

                <div class="small-box bg-success bg-gradient">
                    <div class="inner">
                        <h3>{{ $companies->count() }}</h3>
                        <p>{{ __('Total Companies') }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route('company.company_list') }}" class="small-box-footer">{{ __('More info') }} <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col">

                <div class="small-box bg-info bg-gradient">
                    <div class="inner">
                        <h3>{{ $hostings->count() }}</h3>
                        <p>{{ __('Total Hostings') }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route('hosting.hosting_list') }}" class="small-box-footer">{{ __('More info') }} <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col">
                <div class="small-box bg-primary bg-gradient">
                    <div class="inner">
                        <h3>{{ $clients->count() }}</h3>
                        <p>{{ __('Total Clients') }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route('cm.client.client_list') }}" class="small-box-footer">{{ __('More info') }} <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col">

                <div class="small-box bg-warning bg-gradient">
                    <div class="inner">
                        <h3>{{ $client_hostings->where('status', 1)->count() }}</h3>
                        <p>{{ __('Client Active Hostings') }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route('cm.ch.ch_list', ['status' => 1]) }}" class="small-box-footer">{{ __('More info') }}
                        <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col">

                <div class="small-box bg-danger bg-gradient">
                    <div class="inner">
                        <h3>{{ $client_hostings->where('status', 0)->count() }}</h3>
                        <p>{{ __('Client Deactive Hostings') }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{ route('cm.ch.ch_list', ['status' => 0]) }}" class="small-box-footer">{{ __('More info') }}
                        <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>


        </div>
        <div class="row row-cols-5">


            <div class="col">

                <div class="small-box bg-info bg-gradient">
                    <div class="inner">
                        <h3>{{ $client_domains->where('status', 1)->count() }}</h3>
                        <p>{{ __('Client Active Domains') }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{ route('cm.cd.cd_list', ['status' => 1]) }}" class="small-box-footer">{{ __('More info') }}
                        <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col">

                <div class="small-box bg-primary bg-gradient">
                    <div class="inner">
                        <h3>{{ $client_domains->where('status', 0)->count() }}</h3>
                        <p>{{ __('Client Deactive Domains') }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="{{ route('cm.cd.cd_list', ['status' => 0]) }}" class="small-box-footer">{{ __('More info') }}
                        <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col">
                <div class="small-box bg-warning bg-gradient">
                    <div class="inner">
                        <h3>{{ $expired_hostings->count() }}</h3>
                        <p>{{ __('Client Expired Hostings') }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="{{ route('cm.ceh.ceh_list') }}" class="small-box-footer">{{ __('More info') }} <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col">
                <div class="small-box bg-danger bg-gradient">
                    <div class="inner">
                        <h3>{{ $expired_domains->count() }}</h3>
                        <p>{{ __('Client Expired Domains') }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="{{ route('cm.ced.ced_list') }}" class="small-box-footer">{{ __('More info') }} <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col">
                <div class="small-box bg-success bg-gradient">
                    <div class="inner">
                        <h3>{{ $client_domains->where('is_developed', 1)->count() }}</h3>
                        <p>{{ __('Active Websites') }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{ route('cm.cd.cd_list', ['is_developed' => 1]) }}"
                        class="small-box-footer">{{ __('More info') }} <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col">
                <div class="small-box bg-primary bg-gradient">
                    <div class="inner">
                        <h3>{{ $client_domains->where('is_developed', 0)->count() }}</h3>
                        <p>{{ __('Empty Websites') }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="{{ route('cm.cd.cd_list', ['is_developed' => 1]) }}"
                        class="small-box-footer">{{ __('More info') }} <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
@endsection
