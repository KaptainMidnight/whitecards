<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Actions\Authentication;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthenticationRequest;

class AuthenticationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(AuthenticationRequest $request, Authentication $authentication): array
    {
        return [
            'access_token' => $authentication($request->validated()),
            'token_type' => 'Bearer',
        ];
    }
}
