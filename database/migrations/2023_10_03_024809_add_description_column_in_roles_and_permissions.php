<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 private const USERS_DESCRIPTION = [
  [
   'name' => Permission::CAN_ACCESS_INDEX_USERS,
   'description' => 'Can access index users',
  ],
  [
   'name' => Permission::CAN_ACCESS_CREATE_USERS,
   'description' => 'Can access create users',
  ],
  [
   'name' => Permission::CAN_ACCESS_EDIT_USERS,
   'description' => 'Can access edit users',
  ],
  [
   'name' => Permission::CAN_STORE_USER,
   'description' => 'Can access store users',
  ],
  [
   'name' => Permission::CAN_UPDATE_USER,
   'description' => 'Can access update users',
  ],
  [
   'name' => Permission::CAN_DELETE_USERS,
   'description' => 'Can access delete users',
  ]
 ];

 private const DASHBOARD_DESCRIPTION = [
  [
   'name' => Permission::CAN_ACCESS_INDEX_DASHBOARD,
   'description' => 'Can access index dashboard',
  ],
 ];

 private const ROLES_DESCRIPTION = [
  [
   'name' => Permission::CAN_ACCESS_INDEX_ROLES,
   'description' => 'Can access index roles',
  ],
 ];

 private const PERMISSIONS_DESCRIPTION = [
  [
   'name' => Permission::CAN_ACCESS_INDEX_PERMISSIONS,
   'description' => 'Can access index permissions',
  ],
 ];


 /**
  * Run the migrations.
  *
  * @return void
  */
 public function up()
 {
  Schema::table('roles', function (Blueprint $table) {
   $table->string('description')->nullable();
  });

  Schema::table('permissions', function (Blueprint $table) {
   $table->string('description')->nullable();
  });

  Role::where('name', Role::ADMINISTRATOR)->update([
   'description' => 'Administrator',
  ]);

  collect(
   [
    ...self::USERS_DESCRIPTION,
    ...self::DASHBOARD_DESCRIPTION,
    ...self::ROLES_DESCRIPTION,
    ...self::PERMISSIONS_DESCRIPTION
   ]
  )->each(function ($item) {
   Permission::where('name', $item['name'])->update([
    'description' => $item['description'],
   ]);
  });
 }

 /**
  * Reverse the migrations.
  *
  * @return void
  */
 public function down()
 {
  Schema::table('roles', function (Blueprint $table) {
   $table->dropColumn('description');
  });

  Schema::table('permissions', function (Blueprint $table) {
   $table->dropColumn('description');
  });
 }
};
