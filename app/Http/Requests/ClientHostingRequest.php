<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientHostingRequest extends FormRequest
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
            'hosting_id' => 'required|exists:hostings,id',
            'price' => 'required|numeric',
            'storage' => 'required|string',
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
