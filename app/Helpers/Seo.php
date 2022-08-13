<?php

namespace App\Helpers;

use CoffeeCode\Optimizer\Optimizer;

class Seo
{
    /**
     * @param string $title
     * @param string $description
     * @param string $url
     * @param string $image
     * @param boolean $follow
     * @return string
     */
    public static function render(string $title, string $description, string $url, string $image, bool $follow = true): string
    {
        return (new Optimizer())->optimize($title, $description, $url, $image, $follow)->render();
    }
}
