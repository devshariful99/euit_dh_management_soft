<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientDomainRequest extends FormRequest
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
            'hosting_id' => 'nullable|exists:hostings,id',
            'company_id' => 'nullable|exists:companies,id',
            'price' => 'required|sometimes|numeric',
            'type' => 'required|numeric',
            'purchase_type' => 'required|numeric',
            'admin_url' => 'required|sometimes|url',
            'username' => 'nullable',
            'email' => 'required|sometimes|email',
            'password' => 'required|sometimes',
            'purchase_date' => 'required|sometimes|date|before_or_equal:today',
            'duration' => 'required|sometimes|numeric',
            'note' => 'nullable',
            'currency_id' => 'required|sometimes|exists:currencies,id',
        ];
    }
}