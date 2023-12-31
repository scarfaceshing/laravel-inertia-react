<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Constants\Constants;

return new class extends Migration
{
  private const COLUMNS = [
    [
      'column_name' => 'employee_number',
      'data_type' => 'string',
      'default' => 'nullable'
    ],
    [
      'column_name' => 'first_name',
      'data_type' => 'string',
      'default' => 'nullable'
    ],
    [
      'column_name' => 'middle_name',
      'data_type' => 'string',
      'default' => 'nullable'
    ],
    [
      'column_name' => 'last_name',
      'data_type' => 'string',
      'default' => 'nullable'
    ],
    [
      'column_name' => 'birth_date',
      'data_type' => 'date',
      'default' => 'nullable'
    ],
    [
      'column_name' => 'hired_date',
      'data_type' => 'date',
      'default' => 'nullable'
    ],
    [
      'column_name' => 'regularization',
      'data_type' => 'enum',
      'value' => Constants::REGULARIZATION,
      'default' => 'probitionary'
    ],
    [
      'column_name' => 'department',
      'data_type' => 'string',
      'default' => 'nullable'
    ],
    [
      'column_name' => 'position',
      'data_type' => 'string',
      'default' => 'nullable'
    ],
    [
      'column_name' => 'sex',
      'data_type' => 'enum',
      'value' => Constants::SEX,
      'default' => 'male'
    ],
    [
      'column_name' => 'civil_status',
      'data_type' => 'enum',
      'value' => Constants::CIVIL_STATUS,
      'default' => 'single'
    ],
    [
      'column_name' => 'is_active',
      'data_type' => 'boolean',
      'default' => false
    ],
  ];

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('employees', function (Blueprint $table) {
      $table->id();
      foreach (self::COLUMNS as $column) {
        $this->createColumn($table, $column);
      }
      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('employees');
  }

  private function createColumn($table, $column)
  {
    switch ($column['data_type']) {
      case 'string':
        if ($column['default'] === 'nullable') {
          $table->string($column['column_name'])->nullable();
        } else {
          $table->string($column['column_name']);
        }
        break;
      case 'date':
        if ($column['default'] === 'nullable') {
          $table->date($column['column_name'])->nullable();
        } else {
          $table->date($column['column_name']);
        }
        break;
      case 'enum':
        if ($column['default'] === 'nullable') {
          $table->enum($column['column_name'], $column['value'])->default($column['default']);
        } else {
          $table->enum($column['column_name'], $column['value']);
        }
        break;
      case 'boolean':
        if ($column['default'] === 'nullable') {
          $table->boolean($column['column_name'], $column['value'])->default($column['default']);
        } else {
          $table->boolean($column['column_name']);
        }
        break;
    }
  }
};
