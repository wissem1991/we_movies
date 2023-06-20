<?php

namespace App\Controller;

use App\Provider\GenreProvider;
use App\Provider\MovieProvider;
use App\Provider\VideoProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    public function home(
        Request           $request,
        GenreProvider     $genreProvider,
        MovieProvider     $movieProvider,
        VideoProvider     $videoMovieProvider,
    ): Response {
        $page = $request->query->get('page', 1);
        $allMovies = $movieProvider->getTopRatedMoviesList($page);
        $allMoviesList = [];
        $bestMovie = null;
        $totalPages = 0;

        if (null !== $allMovies) {
            $allMoviesList = $allMovies->getResults();
            $bestMovie = $movieProvider->getBestMovieInList($allMoviesList);
        }

        return $this->render('index.html.twig', [
            'genreList' => $genreProvider->getGenres(),
            'page' => $page,
            'totalPages' => $totalPages,
            'movieList' => $allMoviesList,
            'bestMovie' => $bestMovie,
        ]);
    }
}