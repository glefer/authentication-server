<?php

namespace App\Http\Controllers\OpenId;

use App\Http\Controllers\Controller;
use App\Models\Realm;
use Illuminate\Http\JsonResponse;

class OpenIdController extends Controller
{
    public function issuer(Realm $realm): JsonResponse
    {
        return response()->json([
            'realm' => $realm->id,
        ]);
    }

    public function wellKnown(Realm $realm): JsonResponse
    {
        return response()->json([
            'issuer' => route('openid.realm_issuer', ['realm' => $realm]),
            'authorization_endpoint' => route('openid.auth', ['realm' => $realm]),
            'token_endpoint' => route('openid.token', ['realm' => $realm]),
            'userinfo_endpoint' => route('openid.userinfo', ['realm' => $realm]),
            'response_types_supported' => ['code'],
            'subject_types_supported' => ['public', 'pairwise'],
            'id_token_signing_alg_values_supported' => ['RS256'],
        ]);
    }
}
