<?php

namespace Tests\Feature\Api;

use App\Models\Realm;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class OpenIdApiTest extends TestCase
{
    /**
     * Check than well known api complains standard.
     *
     * @see https://openid.net/specs/openid-connect-discovery-1_0.html#ProviderMetadata
     */
    public function testWellKnownApiMetadataIsValid(): void
    {
        $realm = Realm::factory()->create();
        $response = $this->get(route('openid.well_known', ['realm' => $realm]));

        $response->assertStatus(200)
            ->assertJson(
                fn (AssertableJson $json) => $json->hasAll([
                    'issuer',
                    'authorization_endpoint',
                    'token_endpoint',
                    'userinfo_endpoint',
                    'response_types_supported',
                    'subject_types_supported',
                    'id_token_signing_alg_values_supported',
                ])
                    ->where('subject_types_supported', ['public', 'pairwise'])
                    ->whereContains('id_token_signing_alg_values_supported', 'RS256')
            );
    }

    public function testWellKnownApiMetadataGiveValidEndpoints(): void
    {
        $realm = Realm::factory()->create();
        $response = $this->get(route('openid.well_known', ['realm' => $realm]));

        /** @var array<mixed> $json */
        $json = $response->json();

        foreach (['authorization_endpoint', 'token_endpoint', 'userinfo_endpoint'] as $path) {
            /** @var string $endpoint */
            $endpoint = $json[$path];
            $this->get($endpoint)->assertStatus(200);
        }
    }
}
