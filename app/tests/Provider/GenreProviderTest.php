<?php

namespace Provider;

use App\Entity\Genre;
use App\Entity\GenreList;
use App\Entity\MovieList;
use App\Provider\GenreProvider;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;

class GenreProviderTest extends AbstractProviderTest
{
    public function testGetTopRatedMoviesListFromApi()
    {
        $exception = null;
        try {
            $genreList = $this->movieDBWrapper->getMovieGenres();

            $this->assertJson($genreList);
            $this->assertStringContainsString('genres', $genreList);
        } catch (ExceptionInterface $exception) {}

        $this->assertNull($exception, 'Unable to get movies from api');
    }

    public function testGetMoviesByGenre()
    {
        $container = static::getContainer();

        /** @var GenreProvider $genreProvider */
        $genreProvider = $container->get(GenreProvider::class);

        $genreList = $genreProvider->getGenres();
        $this->assertInstanceOf(GenreList::class, $genreList);

        $genres = $genreList->getGenres();
        $this->assertNotEmpty($genres);

        $genre = $genres[rand(0, count($genres))];
        $this->assertInstanceOf(Genre::class, $genre);

        $movieList = $genreProvider->getMoviesByGenreId($genre->getId());
        $this->assertInstanceOf(MovieList::class, $movieList);
    }
}