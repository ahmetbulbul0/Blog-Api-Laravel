<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Rolleri oluştur
        $adminRole = Role::factory()->admin()->create();
        $authorRole = Role::factory()->author()->create();
        $visitorRole = Role::factory()->visitor()->create();

        // Admin kullanıcısı oluştur
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password')
        ]);
        $admin->roles()->attach($adminRole);

        // Yazar kullanıcısı oluştur
        $author = User::factory()->create([
            'name' => 'Author User',
            'email' => 'author@example.com',
            'password' => Hash::make('password')
        ]);
        $author->roles()->attach($authorRole);

        // Ziyaretçi kullanıcısı oluştur
        $visitor = User::factory()->create([
            'name' => 'Visitor User',
            'email' => 'visitor@example.com',
            'password' => Hash::make('password')
        ]);
        $visitor->roles()->attach($visitorRole);
    }
}
