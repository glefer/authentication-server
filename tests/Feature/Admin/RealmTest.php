<?php

namespace Tests\Feature\Admin;

use App\Models\Realm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RealmTest extends TestCase
{
    use RefreshDatabase;

    public function testRealmIndexCannotBeAccessWithoutAuthenticated(): void
    {
        $response = $this->get('/admin/realms');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function testRealmIndexCanBeRendered(): void
    {
        $user = User::factory()->create();
        $realms = Realm::factory(10)->create();

        $response = $this->actingAs($user)->get('/admin/realms');
        $response->assertOk();
        $response->assertSee(array_column($realms->toArray(), 'name'));
    }

    public function testRealmCanBeDelete(): void
    {
        $user = User::factory()->create();
        $realm = Realm::factory()->create();
        $response = $this->actingAs($user)->delete('/admin/realms/'.$realm->id);
        $response->assertStatus(302);
        $this->assertSame(0, Realm::where('id', '=', $realm->id)->count());
    }

    public function testRealmIndexCanBeShowed(): void
    {
        $user = User::factory()->create();
        $realm = Realm::factory()->create();

        $response = $this->actingAs($user)->get('/admin/realms/'.$realm->id);
        $response->assertOk();
        $response->assertSee($realm->name);
    }

    public function testRealmCreationPageCanBeRendered(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/realms/create');
        $response->assertOk();
    }

    public function testRealmCanBeCreated(): void
    {
        $user = User::factory()->create();

        $this->assertDatabaseCount(Realm::class, 0);
        $response = $this->actingAs($user)->json('POST', '/admin/realms', [
            'name' => 'My new realm',
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseCount(Realm::class, 1);
    }

    public function testRealmCannotBeCreatedWithInvalidRequest(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->json('POST', '/admin/realms', [
            'name' => str_repeat('a', 256),
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
    }

    public function testRealmCannotBeCreatedWithDuplicatedName(): void
    {
        $user = User::factory()->create();
        $realm = Realm::factory()->create();

        $response = $this->actingAs($user)->json('POST', '/admin/realms', [
            'name' => $realm->name,
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
    }

    public function testRealmEditionPageCanBeRendered(): void
    {
        $user = User::factory()->create();
        $realm = Realm::factory()->create();

        $response = $this->actingAs($user)->get(sprintf('/admin/realms/%s/edit', $realm->id));
        $response->assertStatus(200);
    }

    public function testRealmCanBeUpdated(): void
    {
        $user = User::factory()->create();
        $realm = Realm::factory()->create();

        $newName = $realm->name.time();
        $response = $this->actingAs($user)->json('PUT', sprintf('/admin/realms/%s', $realm->id), [
            'name' => $newName,
        ]);
        $response->assertStatus(302);
        $realm->refresh();
        $this->assertSame($realm->name, $newName);
    }
}
