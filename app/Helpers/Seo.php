<?php

namespace App\Helpers;

use CoffeeCode\Optimizer\Optimizer;

class Seo
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $image;

    /**
     * @var bool
     */
    private $follow;

    /**
     * @param string $title
     * @param string $description
     * @param string $url
     * @param string $image
     * @param boolean $follow
     * @return Seo
     */
    public static function set(string $title, string $description, string $url, string $image, bool $follow = true): Seo
    {
        $seo = new Seo();

        $seo->title = $title;
        $seo->description = $description;
        $seo->url = $url;
        $seo->image = $image;
        $seo->follow = $follow;

        return $seo;
    }

    /**
     * @return string
     */
    public function render(): string
    {
        return (new Optimizer())->optimize((config("app.name") . " - " . $this->title), $this->description, $this->url, $this->image, $this->follow)->render();
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }
}
