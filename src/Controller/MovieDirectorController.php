<?php

namespace App\Controller;

use App\Entity\MovieDirector;
use App\Form\MovieDirectorType;
use App\Repository\MovieDirectorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/movie/director')]
final class MovieDirectorController extends AbstractController
{
    #[Route(name: 'app_movie_director_index', methods: ['GET'])]
    public function index(MovieDirectorRepository $movieDirectorRepository): Response
    {
        return $this->render('movie_director/index.html.twig', [
            'movie_directors' => $movieDirectorRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_movie_director_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $movieDirector = new MovieDirector();
        $form = $this->createForm(MovieDirectorType::class, $movieDirector);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($movieDirector);
            $entityManager->flush();

            return $this->redirectToRoute('app_movie_director_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('movie_director/new.html.twig', [
            'movie_director' => $movieDirector,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_movie_director_show', methods: ['GET'])]
    public function show(MovieDirector $movieDirector): Response
    {
        return $this->render('movie_director/show.html.twig', [
            'movie_director' => $movieDirector,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_movie_director_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MovieDirector $movieDirector, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MovieDirectorType::class, $movieDirector);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_movie_director_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('movie_director/edit.html.twig', [
            'movie_director' => $movieDirector,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_movie_director_delete', methods: ['POST'])]
    public function delete(Request $request, MovieDirector $movieDirector, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$movieDirector->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($movieDirector);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_movie_director_index', [], Response::HTTP_SEE_OTHER);
    }
}
