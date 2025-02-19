<?php

namespace Database\Seeders;

use App\Models\Admin\V1\Brand;
use App\Models\Admin\V1\Category;
use App\Models\Admin\V1\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\Admin\V1\CategorySeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        Brand::factory(10)->create();
        Category::factory(10)->create();
        Product::factory(10)->create();

        User::factory()->create([
            'name' => 'User',
            'email' => 'user@test.com',
            'password' => Hash::make('12345678'),
            'utype' => 'USER',
            'mobile' => '12345678901',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('12345678'),
            'utype' => 'ADMIN',
            'mobile' => '12345678902',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
