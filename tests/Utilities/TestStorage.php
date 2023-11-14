<?php

namespace Tests\Utilities;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class TestStorage
{
    private const STORAGE_NAME = 'avatar';

    public static function generateFakeImage(?string $file_name = '', ?string $extension = '', ?int $width = 0, ?int $height = 0, ?int $size = 0)
    {
        Storage::fake(self::STORAGE_NAME);
        $file_name .= '.' . $extension;
        $file = UploadedFile::fake()->image($file_name, $width, $height)->size($size);
        return $file;
    }
}
