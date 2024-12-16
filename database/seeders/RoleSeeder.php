<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_admin = Role::create(['name' => 'admin']);
        $role_user = Role::create(['name' => 'user']);

        $permission_create_game = Permission::create(['name' => 'create games']);
        $permission_read_game = Permission::create(['name' => 'read games']);
        $permission_update_game = Permission::create(['name' => 'update games']);
        $permission_delete_game = Permission::create(['name' => 'delete games']);

        $permission_create_genre = Permission::create(['name' => 'create genres']);
        $permission_read_genre = Permission::create(['name' => 'read genres']);
        $permission_update_genre = Permission::create(['name' => 'update genres']);
        $permission_delete_genre = Permission::create(['name' => 'delete genres']);

        $permission_create_creator = Permission::create(['name' => 'create creators']);
        $permission_read_creator = Permission::create(['name' => 'read creators']);
        $permission_update_creator = Permission::create(['name' => 'update creators']);
        $permission_delete_creator = Permission::create(['name' => 'delete creators']);

        $permissions_admin = [$permission_create_game, $permission_read_game, $permission_update_game,
                             $permission_delete_game, $permission_create_genre, $permission_read_genre, 
                             $permission_update_genre, $permission_delete_genre, $permission_create_creator,
                             $permission_read_creator, $permission_update_creator, $permission_delete_creator];

        $permissions_user = [$permission_read_game, $permission_read_genre, $permission_read_creator];

        $role_admin->syncPermissions($permissions_admin);
        $role_user->syncPermissions($permissions_user);

        //$role_user->givePermissionTo(); Así es como se pasa un rol de forma individual
    }
}
