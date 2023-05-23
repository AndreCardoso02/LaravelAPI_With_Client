<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_list = Permission::create(['name'=>'users.list']);
        $user_show = Permission::create(['name'=>'users.show']);
        $user_create = Permission::create(['name'=>'users.create']);
        $user_update = Permission::create(['name'=>'users.update']);
        $user_delete = Permission::create(['name'=>'users.delete']);

        $admin_role = Role::create(['name' => 'admin']);
        $admin_role->givePermissionTo([
            $user_list,
            $user_show,
            $user_create,
            $user_update,
            $user_delete
        ]);

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin.ric@uan.com',
            'password' => bcrypt('admin')
        ]);

        $admin->assignRole($admin_role);
        $admin->givePermissionTo([
            $user_list,
            $user_show,
            $user_create,
            $user_update,
            $user_delete
        ]);

        $user_role = Role::create(['name' => 'user']);

        $user = User::create([
            'name' => 'User',
            'email' => 'user.ric@uan.com',
            'password' => bcrypt('user')
        ]);

        $user->assignRole($user_role);

        $user->givePermissionTo([
            $user_list
        ]);

        $user_role->givePermissionTo([
            $user_list
        ]);

    }
}
