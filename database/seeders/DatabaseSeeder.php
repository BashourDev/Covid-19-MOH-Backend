<?php

namespace Database\Seeders;

use App\Models\Province;
use App\Models\ProvincialAdmin;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::create([
            'name' => 'admin',
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'role' => 0
        ]);

        $province = Province::create([
            'name' => 'homs'
        ]);

        ProvincialAdmin::query()->create([
            'name' => 'prov admin',
            'username' => 'provadmin',
            'password' => bcrypt('provadmin'),
            'role' => 3,
            'province_id' => $province->id
        ]);
    }
}
