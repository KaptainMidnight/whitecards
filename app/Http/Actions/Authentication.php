<?php

declare(strict_types=1);


namespace App\Http\Actions;

use App\Models\User;

class Authentication
{
    public function __invoke(array $credentials): ?string
    {
        if (!$user = $this->validateTelegramAuthorization($credentials)) {
            return null;
        }

        $userDecoded = json_decode($user['user'], true);
        $userModel = User::query()
            ->where('telegram_id', $userDecoded['id'])
            ->where('username', $userDecoded['username'])
            ->first();

        if (!$userModel->exists) {
            $userModel = User::query()->create($userDecoded);
        }

        return $userModel->createToken($credentials['hash'])?->plainTextToken;
    }

    /**
     * Проверяем личность и достоверность данных человека который отправил запрос на авторизацию
     *
     * @param array $credentials
     * @return bool|array
     * @link https://core.telegram.org/bots/webapps#validating-data-received-via-the-mini-app
     */
    private function validateTelegramAuthorization(array $credentials): bool|array
    {
        $checkHash = $credentials['hash'];
        $checked = $this->sortCredentials($credentials);
        $secretKey = hash('sha256', env('TELEGRAM_BOT_TOKEN'), true);
        $hash = hash_hmac('sha256', implode('\n', $checked), $secretKey);

        // Хэш не совпал, было какое-то стороннее вмешательство
        if (strcmp($hash, $checkHash)) {
            return false;
        }

        // Последняя авторизация была больше 24 часов назад
        if ((time() - $credentials['auth_date']) > 60 * 60 * 24) {
            return false;
        }

        return $credentials;
    }

    private function sortCredentials(array $credentials): array
    {
        $formattedCredentials = [];

        foreach ($credentials as $key => $value) {
            if ($key === 'hash') {
                continue;
            }

            $formattedCredentials[] = "$key=$value";
        }

        sort($formattedCredentials);

        return $formattedCredentials;
    }
}
