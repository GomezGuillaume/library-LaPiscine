<?php


namespace App\Controller;

use App\Entity\Book;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class BooksController extends AbstractController {


    /* Symfony m'instancie la classe $bookRepository, avec l'autowire.
       Le bookRepository, est la classe qui permet de faire des requêtes
        dans la table books */
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



    /* J'ai crée une route booksGenre,
        dans laquelle il y a le genre en wildcard,
        ce qui permet de rentrer directement
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

        $word = $request->query->get('search');

        $bookRepository->findByWordsInResume($word);

        $books = [];

        if (!empty($word)) {
            $books = $bookRepository->findByWordsInResume($word);
        }


        return $this->render('booksSearch.html.twig', [
            'books' => $books
        ]);
    }


    /**
     * @Route ("books/insert", name = "booksInsert")
     */
    public function insertBook (EntityManagerInterface $entityManager) {

        // Les entiés font le lien avec les tables
        // donc pour créer un enregistrement dans ma table book, je crée une nouvelle instance de l'entité Book
        $book = new Book();

        // Je lui donne les valeurs des colonnes avec les setters
        $book->setTitle("L'histoire du temps et de l'espace temps");
        $book->setGenre("Astrophycal");
        $book->setNbPages(300);
        $book->setResume("Notre temps possède 4 dimensions. Mais peut-être qu'une autre dimension en possède plus");

        $entityManager->persist($book);
        $entityManager->flush();
    }

}