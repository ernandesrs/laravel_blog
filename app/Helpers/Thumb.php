<?php

namespace App\Helpers;

use CoffeeCode\Cropper\Cropper;

class Thumb
{
    private const path = "/app/public/thumbs";

    /**
     * @param string $imagePath
     * @param integer $width
     * @param integer|null $height
     * @return string|null
     */
    public static function make(string $imagePath, int $width, ?int $height = null): ?string
    {
        $cropper = new \CoffeeCode\Cropper\Cropper(storage_path(self::path));

        $thumbPath = $cropper->make($imagePath, $width, $height);
        if($thumbPath)
            $pathPath = str_replace(storage_path("/app/public/"), "", $thumbPath);

        return $pathPath;
    }

    /**
     * @param string|null $imagePath
     * @return void
     */
    public static function clear(?string $imagePath = null): void
    {
        (new Cropper(storage_path(self::path)))->flush($imagePath);
        return;
    }
}
