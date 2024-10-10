<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'payment_for' => 'required|in:"Hosting","Domain"',
            'payment_type' => 'required|in:"First-payment","Renew-payment","Due-payment"',
            'payment_date' => 'required|date|before_or_equal:today',
            'expiry_date' => 'nullable|date',
            'price' => 'required|numeric|min:0',
            'duration' => 'nullable|numeric|min:1',
            'hd_id' => 'required',
            'currency_id' => 'required|exists:currencies,id',


        ];
    }
}
