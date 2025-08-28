<?php

namespace App\Controller;

use App\Entity\MovieGenre;
use App\Form\MovieGenreType;
use App\Repository\MovieGenreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/genre')]
final class MovieGenreController extends AbstractController
{
    #[Route(name: 'app_movie_genre_index', methods: ['GET'])]
    public function index(MovieGenreRepository $movieGenreRepository): Response
    {
        return $this->render('movie_genre/index.html.twig', [
            'movie_genres' => $movieGenreRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_movie_genre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $movieGenre = new MovieGenre();
        $form = $this->createForm(MovieGenreType::class, $movieGenre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($movieGenre);
            $entityManager->flush();

            return $this->redirectToRoute('app_movie_genre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('movie_genre/new.html.twig', [
            'movie_genre' => $movieGenre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_movie_genre_show', methods: ['GET'])]
    public function show(MovieGenre $movieGenre): Response
    {
        return $this->render('movie_genre/show.html.twig', [
            'movie_genre' => $movieGenre,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_movie_genre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MovieGenre $movieGenre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MovieGenreType::class, $movieGenre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_movie_genre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('movie_genre/edit.html.twig', [
            'movie_genre' => $movieGenre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_movie_genre_delete', methods: ['POST'])]
    public function delete(Request $request, MovieGenre $movieGenre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$movieGenre->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($movieGenre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_movie_genre_index', [], Response::HTTP_SEE_OTHER);
    }
}
