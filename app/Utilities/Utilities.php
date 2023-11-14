<?php

declare(strict_types=1);

namespace App\Utilities;

class Utilities
{
    public static function extractImageData($uploaded_image) {
        return [
            'file_name' => $uploaded_image->getClientOriginalName(),
            'file_extension' => $uploaded_image->getClientOriginalExtension(),
            'file_real_path' => $uploaded_image->getRealPath(),
            'file_size' => $uploaded_image->getSize(),
            'file_mimes_type' => $uploaded_image->getMimeType()
        ];
    }
}
