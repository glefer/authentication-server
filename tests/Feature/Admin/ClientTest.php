<?php

namespace Tests\Feature\Admin;

use App\Models\Client;
use App\Models\Realm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use RefreshDatabase;

    public function testClientIndexCannotBeAccessWithoutAuthenticated(): void
    {
        $realm = Realm::factory()->create();
        $response = $this->get("/admin/realms/$realm->id/clients");
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function testClientIndexCanBeRendered(): void
    {
        $user = User::factory()->create();
        $realm = Realm::factory()
            ->has(Client::factory(3))
            ->create();
        $response = $this->actingAs($user)->get("/admin/realms/$realm->id/clients");
        $response->assertOk();
        $response->assertSee(array_column($realm->clients()->get()->toArray(), 'name'));
    }

    public function testClientCanBeDelete(): void
    {
        $user = User::factory()->create();
        $realm = Realm::factory()
            ->has(Client::factory())
            ->create();

        $this->actingAs($user)->delete('/admin/realms/'.$realm->id.'/clients/'.$realm->clients()->firstOrNew()->id);

        $this->assertSame(0, $realm->clients()->count());
    }

    public function testClientCanBeShowed(): void
    {
        $user = User::factory()->create();
        $realm = Realm::factory()
            ->has(Client::factory())
            ->create();

        $client = $realm->clients()->firstOrNew();
        $response = $this->actingAs($user)->get('/admin/realms/'.$realm->id.'/clients/'.$client->id);
        $response->assertOk();
        $response->assertSee([$client->name, $client->clientId]);
    }

    public function testClientCreationPageCanBeRendered(): void
    {
        $user = User::factory()->create();
        $realm = Realm::factory()->create();
        $response = $this->actingAs($user)->get('/admin/realms/'.$realm->id.'/clients/create');
        $response->assertOk();
    }

    public function testClientCanBeCreated(): void
    {
        $user = User::factory()->create();
        $realm = Realm::factory()->create();
        $response = $this->actingAs($user)->postJson('/admin/realms/'.$realm->id.'/clients', [
            'name' => 'client'.time(),
        ]);

        $response->assertRedirect('/admin/realms/'.$realm->id.'/clients');
        $this->assertDatabaseCount('clients', 1);
    }

    public function testRealmCannotBeCreatedWithInvalidRequest(): void
    {
        $user = User::factory()->create();
        $realm = Realm::factory()->create();
        $response = $this->actingAs($user)->postJson('/admin/realms/'.$realm->id.'/clients', [
            'name' => str_repeat('a', 256),
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
    }

    public function testClientEditPageCanBeRendered(): void
    {
        $user = User::factory()->create();
        $realm = Realm::factory()
            ->has(Client::factory())
            ->create();

        $client = $realm->clients()->firstOrNew();
        $response = $this->actingAs($user)->get('/admin/realms/'.$realm->id.'/clients/'.$client->id.'/edit');
        $response->assertOk();
        $response->assertSee([$client->name]);
    }

    public function testClientCanBeEdited(): void
    {
        $user = User::factory()->create();
        $realm = Realm::factory()
            ->has(Client::factory())
            ->create();
        $client = $realm->clients()->firstOrNew();

        $newName = 'name'.time();
        $response = $this->actingAs($user)->putJson('/admin/realms/'.$realm->id.'/clients/'.$client->id, [
            'name' => $newName,
        ]);

        $response->assertRedirect('/admin/realms/'.$realm->id.'/clients');
        $client->refresh();
        $this->assertSame($newName, $client->name);
    }

    public function testRealmCannotBeUpdatedWithInvalidRequest(): void
    {
        $user = User::factory()->create();
        $realm = Realm::factory()
            ->has(Client::factory())
            ->create();
        $client = $realm->clients()->firstOrNew();

        $response = $this->actingAs($user)->putJson('/admin/realms/'.$realm->id.'/clients/'.$client->id, [
            'name' => str_repeat('a', 256),
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
    }
}
