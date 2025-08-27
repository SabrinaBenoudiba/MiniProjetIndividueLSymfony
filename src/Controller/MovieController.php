<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

final class MovieController extends AbstractController
{
    #[Route('/movie', name: 'app_movie')]
    public function index(): Response
    {
        return $this->render('movie/index.html.twig', [
            'controller_name' => 'MovieController',
        ]);
    }

    #region New
    #[Route('/movie/new', name: 'app_movie_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $movie = new Movie();
        $form = $this->createForm(MovieType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($movie);
            $em->flush();

            // Redirige après création
            return $this->redirectToRoute('app_movie');
        }

        return $this->render('movie/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #endregion New

    #region Show
    #[Route('/{id}/movie', name: 'app_movie_show', methods: ['GET'])]
    public function show(Movie $movie): Response
    {
    return $this->render('movie/show.html.twig', [
        'movie' => $movie,
    ]);
    }
    #endregion Show


}
