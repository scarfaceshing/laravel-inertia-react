<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 private const DESCRIPTION = [
     [
         'name' => Permission::CAN_VIEW_USERS,
         'description' => 'Can view users',
     ],
     [
         'name' => Permission::CAN_ADD_USERS,
         'description' => 'Can add users',
     ],
     [
         'name' => Permission::CAN_EDIT_USERS,
         'description' => 'Can edit users',
     ],
     [
         'name' => Permission::CAN_DELETE_USERS,
         'description' => 'Can delete users',
     ],
     [
         'name' => Permission::CAN_VIEW_DASHBOARD,
         'description' => 'Can view dashboard',
     ],
     [
         'name' => Permission::CAN_VIEW_ROLES,
         'description' => 'Can view roles',
     ],
     [
         'name' => Permission::CAN_VIEW_PERMISSIONS,
         'description' => 'Can view permission',
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

  collect(self::DESCRIPTION)->each(function ($item) {
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
