<?php

namespace App\Provider;

use App\Entity\GenreList;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;

class GenreProvider extends AbstractProvider
{
    /**
     * @return GenreList|null
     */
    public function getGenres(): ?GenreList
    {
        $cacheKey = 'genre_movies_list';
        $cacheItem = $this->cache->getItem($cacheKey);

        if (!$cacheItem->isHit()) {
            try {
                $result = $this->movieDBWrapper->getMovieGenres();
                $cacheItem->set($result);
                $cacheItem->expiresAfter($this->getCacheExpireAfter());
                $this->cache->save($cacheItem);
            } catch (ExceptionInterface $e)
            {
                return null;
            }
        } else {
            $result = $cacheItem->get();
        }

        return $this->serializer->deserialize($result, GenreList::class, 'json');
    }
}