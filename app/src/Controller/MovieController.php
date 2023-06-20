<?php

namespace App\Controller;

use App\Provider\MovieProvider;
use App\Wrapper\TheMovieDBWrapper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;

class MovieController extends AbstractController
{
    public function details(int $movieId, MovieProvider $movieProvider): Response
    {
        return $this->render('_movie_modal_content.html.twig',
            [
                'movie' => $movieProvider->getMovieDetails($movieId),
            ]
        );
    }

    public function search(Request $request, TheMovieDBWrapper $movieDBWrapper): JsonResponse
    {
        try {
           $result =  $movieDBWrapper->searchMovie($request->query->get('query' , ''));

           return new JsonResponse($result, Response::HTTP_OK);
        } catch (ExceptionInterface $e) {
            return new JsonResponse([], Response::HTTP_BAD_REQUEST);
        }
    }
}