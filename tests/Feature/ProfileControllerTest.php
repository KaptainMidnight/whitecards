<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('возвращает аутентифицированного пользователя', function () {
    Sanctum::actingAs($this->user);

    $response = $this->getJson('/api/profile');

    $response->assertOk()
        ->assertJson($this->user->toArray());
});

it('возвращает 401, если пользователь не аутентифицирован', function () {
    $response = $this->getJson('/api/profile');

    $response->assertUnauthorized();
});

it('показывает профиль пользователя по id', function () {
    Sanctum::actingAs($this->user);
    $response = $this->getJson("/api/profile/{$this->user->id}");

    $response->assertOk()
        ->assertJson($this->user->toArray());
});

it('возвращает 404, если пользователь не найден', function () {
    Sanctum::actingAs($this->user);
    $response = $this->getJson('/api/profile/999');

    $response->assertNotFound();
});

it('удаляет профиль пользователя', function () {
    Sanctum::actingAs($this->user);

    $response = $this->deleteJson("/api/profile/{$this->user->id}");

    $response->assertOk()
        ->assertJson(['status' => true]);

    $this->assertDatabaseMissing('users', ['id' => $this->user->id]);
});

it('возвращает 403, если пользователь пытается удалить чужой профиль', function () {
    $anotherUser = User::factory()->create();
    Sanctum::actingAs($this->user);

    $response = $this->deleteJson("/api/profile/{$anotherUser->id}");

    $response->assertForbidden();
});
