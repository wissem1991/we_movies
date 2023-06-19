<?php

namespace App\Handler;

use App\Entity\Video;

class VimeoHandler implements VideoHandlerInterface
{
    private const SITE = 'Vimeo';

    public function handle(Video $video): string
    {
       return "https://player.vimeo.com/video/" . $video->getKey();
    }

    public function getSite(): string
    {
        return self::SITE;
    }
}