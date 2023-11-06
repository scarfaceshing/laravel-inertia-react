<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Department;
use App\Models\Position;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        collect(Department::ALL_DEPARTMENTS)->each(fn ($department) => Department::create([
            'name' => $department,
            'description' => null
        ]));

        collect(Position::ALL_POSITIONS)->each(fn ($position) => Position::create([
            'name' => $position,
            'description' => null
        ]));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        collect(Department::ALL_DEPARTMENTS)->each(fn ($department) => Department::where(['name' => $department])->delete());
        collect(Position::ALL_POSITIONS)->each(fn ($position) => Position::where(['name' => $position])->delete());
    }
};
