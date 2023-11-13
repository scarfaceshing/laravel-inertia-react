<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name',
        'extension',
        'path'
    ];

    public function imageable()
    {
        return $this->morphTo();
    }
}
