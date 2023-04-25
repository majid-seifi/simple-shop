<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $createProduct = Permission::create(['name' => 'Create product']);
        $readProduct = Permission::create(['name' => 'Read product']);
        $updateProduct = Permission::create(['name' => 'Update product']);
        $deleteProduct = Permission::create(['name' => 'Delete product']);
        $bookmarkProduct = Permission::create(['name' => 'Bookmark product']);

        $adminRole = Role::create(['name' => 'Administrator']);
        $adminRole->syncPermissions([$createProduct, $readProduct, $updateProduct, $deleteProduct]);

        $userRole = Role::create(['name' => 'User']);
        $userRole->syncPermissions([$readProduct, $bookmarkProduct]);


        // admin example
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@example.test',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('Administrator');
        // user example
        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'name' => "user #$i",
                'email' => "user$i@example.test",
                'password' => Hash::make('user123'),
                'email_verified_at' => now(),
            ]);
            $user->assignRole('User');
        }

        Product::factory()->count(50)->create();
    }
}
