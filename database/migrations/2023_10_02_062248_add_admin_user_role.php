<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;

return new class extends Migration
{
    private const USER_PERMISSIONS = [
        'can_view_users',
        'can_add_users',
        'can_edit_users',
        'can_delete_users'
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $role = Role::create(['name' => Role::ADMINISTRATOR]);

        collect(self::USER_PERMISSIONS)->each( function (string $permission = '') use ($role) { 
            Permission::create(['name' => $permission]); 
        });

        $role->givePermissionTo(self::USER_PERMISSIONS);
        $user = User::findOrFail(User::ADMINISTRATOR_ID);

        $user->assignRole(Role::ADMINISTRATOR);
        $user->givePermissionTo(self::USER_PERMISSIONS);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $user = User::findOrFail(User::ADMINISTRATOR_ID);
        $role = Role::findByName(Role::ADMINISTRATOR);

        $user->revokePermissionTo(self::USER_PERMISSIONS);
        $user->removeRole(Role::ADMINISTRATOR);
        $role->revokePermissionTo(self::USER_PERMISSIONS);
       
        $role->whereIn('name', self::USER_PERMISSIONS)->delete();
        Permission::whereIn('name', self::USER_PERMISSIONS)->delete();

        $role->delete();
    }
};
