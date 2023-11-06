<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public const HR_MANAGER = 'hr_manager';
    public const HR_SPECIALIST = 'hr_specialist';

    public const ICT_MANAGER = 'ict_manager';

    public const FULLSTACK_WEB_DEVELOPER = 'fullstack_web_developer';

    public const ALL_POSITIONS = [
        self::HR_MANAGER,
        self::HR_SPECIALIST,
        self::ICT_MANAGER,
        self::FULLSTACK_WEB_DEVELOPER
    ];
}
