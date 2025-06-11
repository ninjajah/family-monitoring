<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /*        $permissions = [
                    'create-user',
                    'edit-user',
                    'delete-user',
                ];

                foreach ($permissions as $permission) {
                    Permission::create(['name' => $permission]);
                }

                $admin = Role::create(['name' => 'admin']);
                $admin->givePermissionTo($permissions);

                Role::create(['name' => 'user']);*/

        $this->call([
            EventTypesSeeder::class,
            FamilyTypesSeeder::class,
        ]);
    }
}
