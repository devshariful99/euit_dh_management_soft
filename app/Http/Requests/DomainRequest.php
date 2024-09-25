<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DomainRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_id' => 'required|exists:companies,id',
            'hosting_id' => 'nullable|exists:hostings,id',
            'name' => 'required',
            'admin_url' => 'required|url',
            'username' => 'nullable',
            'email' => 'required|email',
            'password' => 'required',
            'purchase_date' => 'nullable|date|before_or_equal:today',
            'expire_date' => 'nullable|date',
            'renew_date' => 'nullable|date|before_or_equal:today',
            'note' => 'nullable',
        ];
    }
}
