<?php

namespace App\Controller;

use App\Provider\MovieProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MovieController extends AbstractController
{
    public function details(int $movieId, MovieProvider $movieProvider)
    {
        return $this->render('_movie_modal_content.html.twig',
            [
                'movie' => $movieProvider->getMovieDetails($movieId),
            ]
        );
    }
}