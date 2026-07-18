<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@isla.com.au')],
            [
                'name'     => 'Isla Admin',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'password')),
            ]
        );

        $this->command->info('✓ Admin: '.env('ADMIN_EMAIL', 'admin@isla.com.au').' / '.env('ADMIN_PASSWORD', 'password'));
    }
}
