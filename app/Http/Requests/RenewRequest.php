<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RenewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'price' => 'required|numeric',
            'renew_date' => 'required|date|before_or_equal:today',
            'renew_for' => 'required|in:"Hosting","Domain"',
            'duration' => 'required|numeric',
            'hd_id' => 'required',
        ];
    }
}
