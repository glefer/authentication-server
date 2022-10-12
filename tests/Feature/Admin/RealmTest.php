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
        $respponse = $this->get('/admin/realms');
        $respponse->assertStatus(302);
        $respponse->assertRedirect('/login');
    }

    public function testRealmIndexCanBeRendered(): void
    {
        $user = User::factory()->create();
        $realms = Realm::factory(10)->create();

        $respponse = $this->actingAs($user)->get('/admin/realms');
        $respponse->assertStatus(200);
        $respponse->assertSee(array_column($realms->toArray(), 'name'));
    }

    public function testRealmCanBeDelete(): void
    {
        $user = User::factory()->create();
        $realm = Realm::factory()->create();
        $respponse = $this->actingAs($user)->delete('/admin/realms/'.$realm->id);
        $respponse->assertStatus(302);
        $this->assertSame(0, Realm::where('id', '=', $realm->id)->count());
    }
}
