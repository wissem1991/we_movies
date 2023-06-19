<?php

namespace App\Provider;

use App\Entity\Video;
use App\Entity\VideoList;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;

class VideoProvider extends AbstractProvider
{
    public function getVideoById(int $movieId): ?Video
    {
        $videos = $this->getVideosByMovieId($movieId);
        if (null !== $videos && !empty($videos->getResults())) {
            return $videos->getResults()[0];
        }

        return null;
    }

    private function getVideosByMovieId(int $movieId): ?VideoList
    {
        try {
            return $this->serializer->deserialize($this->movieDBWrapper->getVideosByMovieId($movieId), VideoList::class, 'json');
        } catch (ExceptionInterface $e)
        {
            return null;
        }
    }
}