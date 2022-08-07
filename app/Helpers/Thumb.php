<?php

namespace App\Helpers;

use CoffeeCode\Cropper\Cropper;
use Illuminate\Support\Facades\Storage;

class Thumb
{
    private const path = "public/thumbs";

    /**
     * @param string $imagePath caminho completo até à imagem
     * @param integer $width
     * @param integer|null $height
     * @return string|null
     */
    public static function make(string $imagePath, int $width, ?int $height = null): ?string
    {
        $cropper = new \CoffeeCode\Cropper\Cropper(Storage::path(self::path));

        $thumbPath = $cropper->make($imagePath, $width, $height);
        if ($thumbPath)
            $pathPath = str_replace(Storage::path("public/"), "", $thumbPath);

        return $pathPath;
    }

    /**
     * @param string|null $imagePath
     * @return void
     */
    public static function clear(?string $imagePath = null): void
    {
        (new Cropper(Storage::path(self::path)))->flush($imagePath);
        return;
    }
}
