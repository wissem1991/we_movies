<?php

namespace App\Handler;

use App\Entity\Video;

class YoutubeHandler implements VideoHandlerInterface
{
    private const SITE = 'YouTube';

    public function handle(Video $video): string
    {
        return "https://www.youtube.com/embed/" . $video->getKey();
    }

    public function getSite(): string
    {
        return self::SITE;
    }
}