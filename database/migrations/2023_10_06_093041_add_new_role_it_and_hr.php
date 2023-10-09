<?php

use App\Models\Role;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
 /**
  * Run the migrations.
  *
  * @return void
  */
 public function up()
 {
  //
  Role::create(['name' => Role::INFORMATION_TECHNOLOGY, 'description' => 'Information Technology']);
  Role::create(['name' => Role::HUMAN_RESOURCE, 'description' => 'Human Resource']);
 }

 /**
  * Reverse the migrations.
  *
  * @return void
  */
 public function down()
 {
  ROLE::findByName(Role::INFORMATION_TECHNOLOGY)->delete();
  ROLE::findByName(Role::HUMAN_RESOURCE)->delete();
 }
};
