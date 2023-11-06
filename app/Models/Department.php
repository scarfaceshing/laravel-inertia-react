<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public const HUMAN_RESOURCE = 'human_resource';
    public const INFORMATION_TECHNOLOGY = 'information_technology';
    public const SOFTWARE_DEVELOPER = 'software_developer';

    public const ALL_DEPARTMENTS = [
        self::HUMAN_RESOURCE,
        self::INFORMATION_TECHNOLOGY,
        self::SOFTWARE_DEVELOPER
    ];
}
