<?php


namespace App\Controller;

use App\Entity\Book;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController {

    /**
     * @Route("/authors", name="authorslist")
     */
    // je demande à Symfony de m'instancier la classe AuthorRepository
    // avec le mécanisme d'Autowire (je passe en paramètre de la méthode
    // la classe voulue suivie d'une variable dans laquelle je veux que Symfony m'instancie ma classe
    // l'authorRepository est la classe qui permet de faire des requêtes SELECT
    // dans la table authors
    public function AuthorsList(AuthorRepository $authorRepository)
    {

        // j'utilise l'authorRepository et la méthode findAll() pour récupérer tous les éléments
        // de ma table authors
        $authors = $authorRepository->findAll();
            return $this->render("authors.html.twig", [
                "authors" => $authors
                ]);
    }



    /**
     * @Route ("/author/{id}", name = "author2")
     */
    public function Author2 (AuthorRepository $authorRepository, $id) {
        $author = $authorRepository->find($id);
        return $this->render("author2.html.twig", [
            "author" => $author
        ]);

    }

}