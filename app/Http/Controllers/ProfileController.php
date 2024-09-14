<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(): ?Authenticatable
    {
        return auth()->user();
    }

    public function show(string $id)
    {
        return User::query()->findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id): array
    {
        $user = User::query()->findOrFail($id);

        if (auth()->id() !== $user->id) {
            abort(403, 'У вас нет прав для удаления этого профиля');
        }

        return [
            'status' => $user->delete(),
        ];
    }
}
