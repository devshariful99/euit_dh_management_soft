@extends('client.layouts.app', ['pageSlug' => 'dashboard'])
@section('title', 'Client Dashboard')
@push('css')
    <style>
        .dashboard_wrap {
            height: 69vh;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-4">

                <div class="small-box bg-info bg-gradient">
                    <div class="inner">
                        <h3>{{ $client->hostings->count() }}</h3>
                        <p>{{ __('Total Hostings') }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="" class="small-box-footer">{{ __('More info') }} <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-4">
                <div class="small-box bg-warning bg-gradient">
                    <div class="inner">
                        <h3>{{ $client->domains->count() }}</h3>
                        <p>{{ __('Total Domains') }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="" class="small-box-footer">{{ __('More info') }}
                        <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-4">
                <div class="small-box bg-warning bg-gradient">
                    <div class="inner">
                        <h3>{{ $client->renews->count() }}</h3>
                        <p>{{ __('Total Renews') }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="" class="small-box-footer">{{ __('More info') }}
                        <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
@endsection
