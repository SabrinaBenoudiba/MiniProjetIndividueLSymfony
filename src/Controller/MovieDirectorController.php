<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MovieDirectorController extends AbstractController
{
    #[Route('/movie/director', name: 'app_movie_director')]
    public function index(): Response
    {
        return $this->render('movie_director/index.html.twig', [
            'controller_name' => 'MovieDirectorController',
        ]);
    }
}
