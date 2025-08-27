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

    #region New & Edit
    #[Route('/movie/edit/{id}', name: 'app_movie_edit')]
    #[Route('/movie/new', name: 'app_movie_new')]
    public function new(?Movie $movie, Request $request, EntityManagerInterface $em): Response
    {
        // On prépare le message flash qui nous servira plus tard : soit une modification, soit un ajout en fonction de la valeur de notre object projet. En effet s'il est initialisé c'est qu'on a passé l'id d'un projet existant : c'est une modification. sinon l'objet est null : c'est un ajout
        $status = isset($movie) ? "modifié" : "ajouté";

        // Même logique ici pour le titre de la page : 
        $title = isset($movie) ? "Modifier projet : ". $movie->getMovieTitle() : "Ajouter un projet";
        $movie = $movie ?? new Movie();

        $form = $this->createForm(MovieType::class, $movie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em->persist($movie);
            $em->flush();

            // Redirige après création
            // return $this->redirectToRoute('app_movie');
            
            $this->addFlash('success', 'Movie'. $status . ' !');  
            return $this->redirectToRoute('app_movie_show', ['id' => $movie->getId()]);
        }
        
        return $this->render('movie/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #endregion New & Edit

    #region Show
    #[Route('/movie/{id}', name: 'app_movie_show', methods: ['GET'])]
    public function show(Movie $movie): Response
    {
    return $this->render('movie/show.html.twig', [
        'movie' => $movie,
    ]);
    }
    #endregion Show

    #region DELETE
    #[Route('/movie/{id}', name: 'app_movie_delete')]
    public function delete(Request $request, Movie $movie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$movie->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($movie);
            $entityManager->flush();

            $this->addFlash('danger', "Le produit a bien été supprimé");
        }

        return $this->redirectToRoute('app_movie', [], Response::HTTP_SEE_OTHER);
    }
    #endregion DELETE

}
