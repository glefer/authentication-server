<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SanctumTest extends TestCase
{
    public function testApiRateLimiterCorrectlyApplicated(): void
    {
        Sanctum::actingAs(User::factory()->create());
        for ($i = 0; $i < RouteServiceProvider::API_MAXATTEMPTS; ++$i) {
            $this->json('get', 'api/user')->assertStatus(200);
        }
        $this->json('get', 'api/user')->assertStatus(429);
    }
}
