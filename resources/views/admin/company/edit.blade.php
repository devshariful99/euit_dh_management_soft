@extends('admin.layouts.app', ['pageSlug' => 'company'])

@section('title', 'Edit Company')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card m-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ __('Edit Company') }}</h3>
                    <div class="button_">
                        @include('admin.partials.button', [
                            'routeName' => 'company.company_list',
                            'className' => 'btn-outline-info',
                            'label' => 'Back',
                        ])
                    </div>

                </div>
                <div class="card-body">
                    <form action="{{ route('company.company_edit',$company->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">{{ __('Name') }}</label>
                                <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                    id="name" name="name" value="{{ $company->name }}" placeholder="Enter name">
                                @include('alerts.feedback', ['field' => 'name'])
                            </div>
                            <div class="form-group">
                                <label for="website_url">{{ __('Website URL') }}</label>
                                <input type="url" class="form-control {{ $errors->has('website_url') ? ' is-invalid' : '' }}"
                                    id="website_url" name="website_url" value="{{ $company->website_url }}" placeholder="Enter website url">
                                @include('alerts.feedback', ['field' => 'website_url'])
                            </div>
                            <div class="form-group">
                                <label for="note">{{ __('Note') }}</label>
                                <textarea name="note" id="note" class="form-control" placeholder="Note...">{{$company->note}}</textarea>
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
