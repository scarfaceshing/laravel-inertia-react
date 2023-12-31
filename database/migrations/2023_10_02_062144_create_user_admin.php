<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
 /**
  * Run the migrations.
  *
  * @return void
  */
 public function up()
 {
  User::create([
      'id' => User::ADMINISTRATOR_ID,
      'username' => 'admin',
      'email' => 'admin@system.com',
      'password' => Hash::make('password'),
  ]);
 }

 /**
  * Reverse the migrations.
  *
  * @return void
  */
 public function down()
 {
  User::findOrFail(User::ADMINISTRATOR_ID)->delete();
 }
};
