<?php

namespace App\Http\Requests;

use App\Models\Realm;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRealmRequest extends FormRequest
{
    public function rules(): array
    {
        /** @var Realm $realm */
        $realm = $this->realm;

        return [
            'name' => "bail|required|unique:realms,name,{$realm->id}|max:255",
        ];
    }
}
