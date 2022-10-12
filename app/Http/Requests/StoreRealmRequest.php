<?php

namespace App\Http\Requests;

use App\Models\Realm;
use Illuminate\Foundation\Http\FormRequest;

class StoreRealmRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        /** @var Realm $realm */
        $realm = $this->realm;

        return [
            'name' => "bail|required|unique:realms,name,{$realm->id}|max:255",
        ];
    }
}
