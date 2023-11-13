<?php

namespace Tests\Utilities;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class TestStorage
{
    private $file;
    private $name;

    public function __construct()
    {
        $this->name = Str::random(10);
    }

    public function generateFakeImage()
    {
        Storage::fake($this->name);
        $this->file = UploadedFile::fake();
        return $this;
    }

    public function resolution(?int $width = 100, ?int $height = 100)
    {
        $this->file->image($this->name, $width, $height);
        return $this;
    }
}
