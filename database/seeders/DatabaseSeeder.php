<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /*$user = User::create([
            'firstname' => 'Max',
            'name' => 'Ellis',
            'email' => 'max@free.fr',
            'password' => bcrypt('password'),
        ]);*/

        // $this->call([ShieldSeeder::class]);
        $this->call([BackupPermissionSeeder::class]);

        // $user->assignRole('super_admin');
    }
}
