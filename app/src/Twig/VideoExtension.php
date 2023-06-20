<?php

namespace App\Twig;

use App\Entity\Video;
use App\Handler\VideoHandler;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class VideoExtension extends AbstractExtension
{
    public function __construct(private VideoHandler $videoHandler){}

    public function getFunctions(): array
    {
        return [
            new TwigFunction('resolve_video', [$this, 'resolveVideo']),
        ];
    }

    /**
     * @param Video $video
     * @return string
     */
    public function resolveVideo(Video $video): string
    {
        return $this->videoHandler->getVideoUrl($video);
    }
}