<?php

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
 private const ALL_PERMISSIONS = [
     ...Permission::USER_PERMISSIONS,
     Permission::CAN_VIEW_ROLES,
     Permission::CAN_VIEW_PERMISSIONS,
     Permission::CAN_VIEW_DASHBOARD,
 ];

 /**
  * Run the migrations.
  */
 public function up(): void
 {
  $role = Role::create(['name' => Role::ADMINISTRATOR]);

  collect(self::ALL_PERMISSIONS)->each(function (string $permission = '') {
   Permission::create(['name' => $permission]);
  });

  $role->givePermissionTo(self::ALL_PERMISSIONS);
  $user = User::findOrFail(User::ADMINISTRATOR_ID);

  $user->assignRole(Role::ADMINISTRATOR);
  $user->givePermissionTo(self::ALL_PERMISSIONS);
 }

 /**
  * Reverse the migrations.
  */
 public function down(): void
 {
  $user = User::findOrFail(User::ADMINISTRATOR_ID);
  $role = Role::findByName(Role::ADMINISTRATOR);

  $user->revokePermissionTo(self::ALL_PERMISSIONS);
  $user->removeRole(Role::ADMINISTRATOR);
  $role->revokePermissionTo(self::ALL_PERMISSIONS);

  $role->whereIn('name', self::ALL_PERMISSIONS)->delete();
  Permission::whereIn('name', self::ALL_PERMISSIONS)->delete();

  $role->delete();
 }
};
