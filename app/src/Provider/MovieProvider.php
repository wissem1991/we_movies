<?php

namespace App\Provider;

use App\Entity\Movie;
use App\Entity\MovieList;
use App\Wrapper\TheMovieDBWrapper;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;

class MovieProvider extends AbstractProvider
{
    public function __construct(
        TheMovieDBWrapper          $movieDBWrapper,
        SerializerInterface        $serializer,
        AdapterInterface $cache,
        private VideoProvider      $videoProvider
    ){
        parent::__construct($movieDBWrapper, $serializer, $cache);
    }

    /**
     * @param Movie[] $movieList
     * @return Movie
     */
    public function getBestMovieInList(array &$movieList): Movie
    {
        /** @var Movie $bestMovie */
        $bestMovie = array_shift($movieList);
        $bestMovie->setVideo($this->videoProvider->getVideoById($bestMovie->getId()));

        return $bestMovie;
    }

    public function getTopRatedMoviesList(int $page = 1): ?MovieList
    {
        $cacheKey = sprintf('top_rated_movies_%s', $page);
        $cacheItem = $this->cache->getItem($cacheKey);

        if (!$cacheItem->isHit()) {
            try {
                $result = $this->movieDBWrapper->getTopRatedMoviesList($page);
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

        return $this->serializer->deserialize($result, MovieList::class, 'json');
    }

    public function getMovieDetails(int $movieId): ?Movie
    {
        $cacheKey = sprintf('movie_details_%s', $movieId);
        $cacheItem = $this->cache->getItem($cacheKey);

        if (!$cacheItem->isHit()) {
            try {
                $movie = $this->serializer->deserialize($this->movieDBWrapper->getMovieDetails($movieId), Movie::class, 'json');
                $movie?->setVideo($this->videoProvider->getVideoById($movie->getId()));

                $encoders = [new JsonEncoder()];
                $normalizers = [new ObjectNormalizer()];

                $serializer = new Serializer($normalizers, $encoders);
                $cacheItem->set($serializer->serialize($movie, 'json'));
                $cacheItem->expiresAfter($this->getCacheExpireAfter());
                $this->cache->save($cacheItem);

                return  $movie;
            } catch (ExceptionInterface $e)
            {
                return null;
            }
        }

        return $this->serializer->deserialize( $cacheItem->get(), Movie::class, 'json');
    }
}