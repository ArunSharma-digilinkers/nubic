<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(['email' => 'admin@nubic.test'], [
            'name' => 'Admin',
            'password' => 'password',
        ]);

        $this->call(CatalogueSeeder::class);
    }
}
