<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use App\Models\User;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        Permission::create(['name' => 'test']);
        Permission::create(['name' => 'admin']);

        // Create roles
        $user = Role::create(['name' => 'User'])
            ->givePermissionTo('test');

        $superAdmin = Role::create(['name' => 'SuperAdmin'])
            ->givePermissionTo(Permission::all());

        // Create users
        $userU = User::factory()->create([
            'username' => 'Normal user',
            'email' => 'test@example.com',
        ]);

        $userSA = User::factory()->create([
            'username' => 'SuperAdmin User',
            'email' => 'superadmin@example.com',
        ]);

        // Assign roles
        $userU->assignRole($user);

        $userSA->assignRole($superAdmin);
    }
}
