<?php

namespace App\Handler;

use App\Entity\Video;

final class VideoHandler
{
    private array $videoHandlers = [];

    public function __construct($videoHandlers)
    {
        $this->videoHandlers = $videoHandlers;
    }

    public function getVideoUrl(Video $video): string
    {
        /** @var VideoHandlerInterface $videoHandler */
        foreach ($this->videoHandlers as $videoHandler){
            if ($video->getSite() === $videoHandler->getSite())
            {
                return $videoHandler->handle($video);
            }
        }

        return '';
    }
}