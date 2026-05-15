<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $client = $this->route('client');

        return [
            'name' => ['required', 'string', 'max:255'],

            'document' => [
                'required',
                'string',
                'max:18',
                Rule::unique('clients', 'document')
                    ->ignore($client),
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('clients', 'email')
                    ->ignore($client),
            ],

            'status' => [
                'required',
                'in:active,inactive',
            ],
        ];
    }
}
