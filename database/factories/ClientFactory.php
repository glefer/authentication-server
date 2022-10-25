<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $faker = fake();

        return [
            'name' => $faker->company(),
            'clientId' => $faker->unique()->uuid(),
            'clientSecret' => bin2hex(random_bytes(32)),
        ];
    }
}
