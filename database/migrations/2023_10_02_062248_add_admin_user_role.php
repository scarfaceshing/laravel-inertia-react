<?php

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $role = Role::create(['name' => Role::ADMINISTRATOR]);

        collect(Permission::ALL_PERMISSIONS)->each(function (string $permission = '') {
            Permission::create(['name' => $permission]);
        });

        $role->givePermissionTo(Permission::ALL_PERMISSIONS);
        $user = User::findOrFail(User::ADMINISTRATOR_ID);

        $user->assignRole(Role::ADMINISTRATOR);
        $user->givePermissionTo(Permission::ALL_PERMISSIONS);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $user = User::findOrFail(User::ADMINISTRATOR_ID);
        $role = Role::findByName(Role::ADMINISTRATOR);

        $user->revokePermissionTo(Permission::ALL_PERMISSIONS);
        $user->removeRole(Role::ADMINISTRATOR);
        $role->revokePermissionTo(Permission::ALL_PERMISSIONS);

        $role->whereIn('name', Permission::ALL_PERMISSIONS)->delete();
        Permission::whereIn('name', Permission::ALL_PERMISSIONS)->delete();

        $role->delete();
    }
};
