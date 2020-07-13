<?php


namespace App\Controller;

use App\Entity\Book;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
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

        dump($authors); die;
    }



    /**
     * @Route ("/author/{id}", name = "author_2")
     */
    public function Author2 (AuthorRepository $authorRepository, $id) {
        $author = $authorRepository->find($id);
        return $this->render("Author2.html.twig", [
            "author" => $author
        ]);

    }



    /* Symfony m'instancie la classe $bookRepository, avec l'autowire.
        Le bookRepository, est la classe qui permet de faire des requêtes dans la table books */
    /**
     * @Route ("/books", name = "books")
     */
    public function books (BookRepository $bookRepository) {
        $books = $bookRepository->findAll();
        return $this->render("books.html.twig", [
            "books" => $books
        ]);
    }


    /**
     * @Route ("/book/{id}", name = "book")
     */
    public function book2 (BookRepository $bookRepository, $id) {
        $book = $bookRepository->find($id);
        return $this->render("book.html.twig", [
            "book" => $book
        ]);

    }




    /* J'ai crée une route booksGenre, dans laquelle il y a le genre en wildcard, ce qui permet de rentrer directement
        le genre dans l'URL du navigateur   */
    /**
     * @Route ("/books/genre/{genre}", name = "booksGenre")
     */
    public function BookGenre (BookRepository $bookRepository, $genre) {

        $books = $bookRepository->findBy(["genre" => $genre]);

        return $this->render("booksGenre.html.twig", [
            "books" => $books,
            "genre" => $genre
        ]);
    }

    /**
     * @Route("/books/search/resume", name = "BooksSearchResume)"
     */
    public function BookSearchResume (BookRepository $bookRepository) {
        $bookRepository->findByWordsInResume();
    }

}