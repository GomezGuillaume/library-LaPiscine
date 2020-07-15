<?php


namespace App\Controller;

use App\Entity\Book;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class BooksController extends AbstractController {


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
     * @Route("/books/search/resume", name = "BooksSearchResume")"
     */
    public function BookSearchResume (BookRepository $bookRepository, Request $request) {
        $bookRepository->findByWordsInResume();


        $word = $request->query->get('search');

        $books = [];

        if (!empty($word)) {
            $books = $bookRepository->findByWordsInResume($word);
        }


        return $this->render('booksSearch.html.twig', [
            'books' => $books
        ]);
    }

}