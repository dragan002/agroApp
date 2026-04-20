<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'draganvujic29@gmail.com'],
            [
                'name'     => 'Dragan Vujić',
                'password' => bcrypt('1234'),
                'role'     => 'admin',
                'phone'    => null,
            ]
        );
    }
}
