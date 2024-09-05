@extends('admin.layouts.app', ['pageSlug' => 'payment'])

@section('title', 'Create Payment')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card m-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ __('Create Payment') }}</h3>
                    <div class="button_">
                        @include('admin.partials.button', [
                            'routeName' => 'payment.payment_list',
                            'className' => 'btn-outline-info',
                            'label' => 'Back',
                        ])
                    </div>

                </div>
                <div class="card-body">
                    <form action="{{ route('payment.payment_create') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="payment_for">{{ __('Payment For') }}</label>
                                    <select name="payment_for" id="payment_for" class="form-control">
                                        <option selected hidden value="">{{__('Select Payment For')}}</option>
                                        <option value="Hosting" {{(old('payment_for') =='Hosting') ? 'selected' : ''}}>{{__('Hosting')}}</option>
                                        <option value="Domain" {{(old('payment_for') =='Domain') ? 'selected' : ''}}>{{__('Domain')}}</option>
                                    </select>
                                    @include('alerts.feedback', ['field' => 'payment_for'])
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="hd_id" id="dh_label">{{ __('Hosting/Domain') }}</label>
                                    <select name="hd_id" id="hd_id" class="form-control" disabled>
                                        <option selected hidden value="">{{__('Select Hosting/Domain')}}</option>
                                    </select>
                                    @include('alerts.feedback', ['field' => 'hd_id'])
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label for="payment_type">{{ __('Payment Type') }}</label>
                                    <select name="payment_type" id="payment_type" class="form-control">
                                        <option selected hidden value="">{{__('Select Payment For')}}</option>
                                        <option value="First-payment" {{(old('payment_type') =='First-payment') ? 'selected' : ''}}>{{__('First-payment')}}</option>
                                        <option value="Renew-payment" {{(old('payment_type') =='Renew-payment') ? 'selected' : ''}}>{{__('Renew-payment')}}</option>
                                        <option value="Due-payment" {{(old('payment_type') =='Due-payment') ? 'selected' : ''}}>{{__('Due-payment')}}</option>
                                    </select>
                                    @include('alerts.feedback', ['field' => 'payment_type'])
                                </div>
    
                                <div class="form-group col-md-6">
                                    <label for="payment_date">{{ __('Payment Date') }}</label>
                                    <input type="date" name="payment_date" id="payment_date" class="form-control" value="{{old('payment_date')}}">
                                    @include('alerts.feedback', ['field' => 'payment_date'])
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="price">{{ __('Price') }}</label>
                                    <div class="input-group" role="group">
                                        <input type="text" name="price" placeholder="Enter price" id="price" class="form-control" value="{{old('price')}}">
                                        <span class="btn btn-sm btn-secondary disabled" style="line-height: 2">{{__('BDT')}}</span>
                                    </div>
                                    @include('alerts.feedback', ['field' => 'price'])
                                </div>
                                <div class="form-group col-md-6" id="is_duration">
                                    <label for="duration">{{ __('Duration') }}</label>
                                    <div class="input-group" role="group">
                                        <input type="text" name="duration" placeholder="Enter duration" id="duration" class="form-control" value="{{old('duration')}}">
                                        <select name="duration_type" class="form-control">
                                            <option selected hidden value="">{{__('Select type')}}</option>
                                            <option value="Year" {{(old('duration_type') =='Year') ? 'selected' : ''}}>{{__('Year')}}</option>
                                            <option value="Month" {{(old('duration_type') =='Month') ? 'selected' : ''}}>{{__('Month')}}</option>
                                        </select>
                                    </div>
                                    @include('alerts.feedback', ['field' => 'duration'])
                                    @include('alerts.feedback', ['field' => 'duration_type'])
                                </div>
                                <div class="form-group col-md-6" id="is_expiry_date" style="display: none;">
                                    <label for="expiry_date">{{ __('Expiry Date') }}</label>
                                    <input type="date" name="expiry_date" id="expiry_date" class="form-control" value="{{old('expiry_date')}}">
                                    @include('alerts.feedback', ['field' => 'expiry_date'])
                                </div>



                                <div class="form-group">
                                    <label for="file">{{ __('Upload') }}</label>
                                    <input type="file" name="file" id="file" class="form-control">
                                    @include('alerts.feedback', ['field' => 'file'])
                                </div>
                            </div>
                        </div>

                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
<script>
    $(document).ready(function() {
        $('#payment_for').on('change', function() {
            let payment_for = $(this).val();
            let url = ("{{ route('payment.get_hostings_or_domains.payment_list', ['payment_for']) }}");
            let _url = url.replace('payment_for', payment_for);
            $.ajax({
                url: _url,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                   let result = '';
                   $('#dh_label').html(payment_for);
                   result += `<option selected hidden value=''>Select ${payment_for}</option>`;
                   response.datas.forEach(function(data) {
                        result += `<option value='${data.id}'>${data.name}</option>`;
                    });
                    $('#hd_id').html(result); 
                    $('#hd_id').prop('disabled',false); 
                     
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        });
    });

    $(document).ready(function(){
        if($('#payment_type').val() === 'Due-payment'){
            $('#is_duration').hide();
            $('#is_expiry_date').show();
        }else{
            $('#is_duration').show();
            $('#is_expiry_date').hide();
        }
        $('#payment_type').on('change',function(){
            if($(this).val() === 'Due-payment'){
                $('#is_duration').hide();
                $('#is_expiry_date').show();
            }else{
                $('#is_duration').show();
                $('#is_expiry_date').hide();
            }
        });
    });
</script>
@endpush
