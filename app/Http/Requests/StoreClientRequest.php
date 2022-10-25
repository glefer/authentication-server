<?php

namespace App\Http\Requests;

use App\Models\Realm;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property Realm $realm
 */
class StoreClientRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'bail', 'required', 'max:255',
                Rule::unique('clients')
                    ->where(fn ($query) => $query->where('realm_id', $this->realm->id)),
            ],
        ];
    }
}
