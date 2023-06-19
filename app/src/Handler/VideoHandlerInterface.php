<?php

namespace App\Handler;

use App\Entity\Video;

interface VideoHandlerInterface
{
    public function handle(Video $video): string;
    public function getSite(): string;
}