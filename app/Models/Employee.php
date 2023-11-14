<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_number',
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
        'birth_date',
        'address',
        'hired_date',
        'regularization',
        'department',
        'position',
        'gender',
        'civil_status',
        'employee_status',
    ];

    public function phone(): HasMany
    {
        return $this->hasMany(Phone::class);
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
