<?php

namespace App\Controller;

use App\Provider\GenreProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GenreController extends AbstractController
{
    public function movies(Request $request, string $genreName, int $genreId, GenreProvider $genreProvider): Response
    {
        $page = $request->query->get('page', 1);
        $movieList = $genreProvider->getMoviesByGenreId($genreId, $page);

        return $this->render('movies_by_genre.html.twig', [
            'genreName' => $genreName,
            'genreId' => $genreId,
            'page' => $page,
            'totalPages' => $movieList->getTotalPages(),
            'movieList' => $movieList->getResults(),
        ]);
    }
}