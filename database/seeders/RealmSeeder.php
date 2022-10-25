<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Realm;
use Illuminate\Database\Seeder;

class RealmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Realm::factory(1000)
            ->has(Client::factory(3))
            ->create();
    }
}
