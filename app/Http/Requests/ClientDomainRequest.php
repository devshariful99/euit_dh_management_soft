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
            'domain_id' => 'nullable|exists:domains,id',
            'price' => 'required|numeric',
            'type' => 'required|numeric',
            'admin_url' => 'required|url',
            'username' => 'nullable',
            'email' => 'required|email',
            'password' => 'required',
            'purchase_date' => 'required|date|before_or_equal:today',
            'duration' => 'required|numeric',
            'note' => 'nullable',
        ];
    }
}
