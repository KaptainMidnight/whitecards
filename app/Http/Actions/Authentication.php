<?php

declare(strict_types=1);


namespace App\Http\Actions;

use App\Models\User;

class Authentication
{
    public function __invoke(array $credentials): ?string
    {
        $user = User::query()
            ->where('username', $credentials['username'])
            ->where('telegram_id', $credentials['id'])
            ->first();

        if (!$user->exists) {
            $user = User::query()->create($credentials);
        }

        return $user->createToken($credentials['username'])?->plainTextToken;
    }
}
