<?php

namespace Provider;

use App\Entity\Movie;
use App\Entity\MovieList;
use App\Provider\MovieProvider;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;

class MovieProviderTest extends AbstractProviderTest
{
    public function testGetTopRatedMoviesListFromApi()
    {
        $exception = null;
        try {
            $movieList = $this->movieDBWrapper->getTopRatedMoviesList();

            $this->assertJson($movieList);
            $this->assertStringContainsString('results', $movieList);
        } catch (ExceptionInterface $exception) {}

        $this->assertNull($exception, 'Unable to get movies from api');
    }

    public function testGetMovieDetails()
    {
        $container = static::getContainer();

        /** @var MovieProvider $movieProvider */
        $movieProvider = $container->get(MovieProvider::class);

        $movieList = $movieProvider->getTopRatedMoviesList();
        $this->assertInstanceOf(MovieList::class, $movieList);

        $movies = $movieList->getResults();
        $this->assertNotEmpty($movies);

        $movie = $movies[rand(0, count($movies))];
        $this->assertInstanceOf(Movie::class, $movie);


        $movieDetails = $movieProvider->getMovieDetails($movie->getId());
        $this->assertInstanceOf(Movie::class, $movieDetails);
    }
}