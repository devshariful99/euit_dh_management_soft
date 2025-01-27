<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
            'name' => 'required|string|min:4',
            'address' => 'required|string',
            'company_name' => 'nullable|string',
            'note' => 'nullable|string',
        ]
            +
            ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store(): array
    {
        return [
            'email' => 'required|unique:clients,email',
            'phone' => 'nullable|unique:clients,phone',
            'password' => 'required|min:6|confirmed',
        ];
    }

    protected function update(): array
    {
        return [
            'email' => 'required|unique:clients,email,' . $this->route('id'),
            'phone' => 'nullable|unique:clients,phone,' . $this->route('id'),
            'password' => 'nullable|min:6|confirmed',
        ];
    }
}