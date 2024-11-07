<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolesAndUsersSeeder extends Seeder
{
    public function run()
    {
        // Создание ролей
        $adminRole = Role::create(['name' => 'admin']);
        $authorRole = Role::create(['name' => 'author']);

        // Создание пользователей и назначение ролей
        $user1 = User::factory()->create([
            'email' => 'admin@example.com',
        ]);
        $user1->assignRole('admin');

        $user2 = User::factory()->create([
            'email' => 'author@example.com',
        ]);
        $user2->assignRole('author');
    }
}
