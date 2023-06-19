<?php

namespace App\Wrapper;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class TheMovieDBWrapper
{
    public function __construct(private HttpClientInterface $theMovieDbClient){}

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getMovieGenres(): string
    {
        return $this->handleGetRequest('3/genre/movie/list');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getMovieDetails(int $idMovie): string
    {
        return $this->handleGetRequest('3/movie/' . $idMovie);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getTopRatedMoviesList(int $page = 1): string
    {
        return $this->handleGetRequest('3/movie/top_rated?page='. $page);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getVideosByMovieId(int $movieId): string
    {
        return $this->handleGetRequest(sprintf('3/movie/%s/videos', $movieId));
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    private function handleGetRequest(string $uri): string
    {
        $response = $this->theMovieDbClient->request('GET', $uri);

        if (200 == $response->getStatusCode()) {
            return $response->getContent();
        }

        return "";
    }
}