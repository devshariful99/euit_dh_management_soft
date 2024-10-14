<div class="modal invoice_modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModal1Label"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModal1Label">{{ __('Get renewal invoice') }}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body invoice_modal_data">
                <form action="{{ route('cm.ced.data.ced_invoice') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="ced_id" value="">
                    <div class="form-group">
                        <label>Renew From<span class="text-danger">*</span></label>
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
                        <label>Price Per Year<span class="text-danger">*</span></label>
                        <input type="text" name="price" placeholder="Enter Price Per Year" class="form-control"
                            required>
                    </div>
                    <button type="submit" class="btn btn-primary float-end">{{ __('Submit') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
