<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthenticationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'query_id' => 'required|string',
            'user' => 'required|json',
            'auth_date' => 'required|integer|digits:10',
            'hash' => 'required|string|size:64',
        ];
    }
}
