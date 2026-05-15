<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],

            'document' => [
                'required',
                'string',
                'max:18',
                'unique:clients,document',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:clients,email',
            ],

            'status' => [
                'required',
                'in:active,inactive',
            ],
        ];
    }
}
