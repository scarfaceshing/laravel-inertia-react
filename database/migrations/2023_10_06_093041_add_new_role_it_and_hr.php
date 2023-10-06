<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Role;

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
