<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AddBasicRolesAndPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $admin = User::factory()->create(['email' => 'sys@admin.com']);

        $role = Role::create(['name' => 'admin']);

        $admin->assignRole($role);

        $permissions = collect([
            ['name' => 'list users'],
            ['name' => 'add users'],
            ['name' => 'update users'],
            ['name' => 'delete users'],
            ['name' => 'list roles'],
            ['name' => 'add roles'],
            ['name' => 'update roles'],
            ['name' => 'delete roles'],
            ['name' => 'list permission'],
            ['name' => 'add permission'],
            ['name' => 'update permission'],
            ['name' => 'delete permission'],
        ]);

        $permissions->each(function ($permissionData) use ($role) {
            $permission = Permission::create($permissionData);

            $role->givePermissionTo($permission->name);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        User::query()->delete();
        Role::query()->delete();
        Permission::query()->delete();
    }
}
