@extends('admin.layouts.app', ['pageSlug' => 'hosting'])

@section('title', 'Edit Hosting')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card m-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ __('Edit Hosting') }}</h3>
                    <div class="button_">
                        @include('admin.partials.button', [
                            'routeName' => 'hosting.hosting_list',
                            'className' => 'btn-outline-info',
                            'label' => 'Back',
                        ])
                    </div>

                </div>
                <div class="card-body">
                    <form action="{{ route('hosting.hosting_edit',$hosting->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">{{ __('Name') }}</label>
                                <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                    id="name" name="name" value="{{ $hosting->name }}" placeholder="Enter name">
                                @include('alerts.feedback', ['field' => 'name'])
                            </div>
                            <div class="form-group">
                                <label for="company_id">{{ __('Company') }}</label>
                                <select name="company_id" id="company_id" class="form-control">
                                    <option selected hidden value="">{{__('Select Company')}}</option>
                                    @foreach ($companies as $company)
                                        <option value="{{$company->id}}" {{($hosting->company_id == $company->id) ? 'selected' : ''}}>{{$company->name}}</option>
                                    @endforeach
                                </select>
                                @include('alerts.feedback', ['field' => 'company_id'])
                            </div>
                            <div class="form-group">
                                <label for="admin_url">{{ __('Login URL') }}</label>
                                <input type="url" class="form-control {{ $errors->has('admin_url') ? ' is-invalid' : '' }}"
                                    id="admin_url" name="admin_url" value="{{ $hosting->admin_url }}" placeholder="Enter admin url">
                                @include('alerts.feedback', ['field' => 'admin_url'])
                            </div>
                            <div class="form-group">
                                <label for="username">{{ __('Username') }}</label>
                                <input type="text" class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}"
                                    id="username" name="username" value="{{ $hosting->username }}" placeholder="Enter username">
                                @include('alerts.feedback', ['field' => 'username'])
                            </div>
                            <div class="form-group">
                                <label for="email">{{ __('Email') }}</label>
                                <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                    id="email" name="email" value="{{ $hosting->email }}" placeholder="Enter email">
                                @include('alerts.feedback', ['field' => 'email'])
                            </div>
                            <div class="form-group">
                                <label for="password">{{ __('Password') }}</label>
                                <input type="text" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                    id="password" name="password" value="{{ $hosting->password }}" placeholder="Enter password">
                                @include('alerts.feedback', ['field' => 'password'])
                            </div>
                            <div class="form-group">
                                <label for="note">{{ __('Note') }}</label>
                                <textarea name="note" id="note" class="form-control" placeholder="Note...">{{$hosting->note}}</textarea>
                                @include('alerts.feedback', ['field' => 'note'])
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
