<?php

namespace App\Http\Requests;

use App\Models\Client;
use App\Models\Realm;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property Realm  $realm
 * @property Client $client
 */
class UpdateClientRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'bail', 'required', 'max:255',
                Rule::unique('clients')
                    ->where(
                        fn ($query) => $query->where('realm_id', $this->realm->id)
                            ->where('id', '<>', $this->client->id)
                    ),
            ],
        ];
    }
}
