<?php


namespace App\Controller;


use App\Entity\Book;
use App\Form\BooksFormType;
use App\Repository\GenreRepository;
use Symfony\Component\Form\FormBuilderInterface;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AdminBookController extends AbstractController {

    //
    /**
     * @Route ("/admin/books", name = "AdminBooks")
     */
    public function AdminBooks(BookRepository $bookRepository)
    {

        $books = $bookRepository->findAll();

        return $this->render("admin/AdminBooks.html.twig", [
            "books" => $books
        ]);
    }



    //
    /**
     * @Route ("/admin/books/delete/{id}", name = "AdminBooksDelete")
     */
    public function AdminBooksDelete(BookRepository $bookRepository, EntityManagerInterface $entityManager, $id)
    {
        $book = $bookRepository->find($id);

        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute("AdminBooks");
    }



    /**
     * @Route ("/admin/books/insert", name = "AdminBooksInsert")
     */
    public function AdminBooksInsert (Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger) {

        $book = new Book();

        $bookForm = $this->createForm(BooksFormType::class, $book);

        // Je prend les données de la requête  (classe Request) et je les envoies à mon formulaire
        $bookForm->handleRequest($request);

        if ($bookForm->isSubmitted() && $bookForm->isValid()) {

            $bookCoverFile = $bookForm->get('bookCover')->getData();

            if ($bookCoverFile){

                $originalCoverName = pathinfo($bookCoverFile->getClientOriginalName(), PATHINFO_FILENAME);

                $safeCoverName = $slugger->slug($originalCoverName);
                $uniqueCoverName = $safeCoverName . '-' . uniqid() . '.' . $bookCoverFile->guessExtension();

                try{
                    $bookCoverFile->move($this->getParameter('book_cover_directory'), $uniqueCoverName);
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }

                $book->setBookCover($uniqueCoverName);
            }





            $entityManager->persist($book);
            $entityManager->flush();

            $this->addFlash('success', 'Votre livre à été ajouté');
        }

        return $this->render("admin/AdminBooksInsert.html.twig",[
            "bookForm" => $bookForm->createView()
        ]);
    }


    /**
     * @Route("/admin/books/update/{id}", name = "AdminBooksUpdate")
     */
    public function AdminUpdateBook( Request $request, BookRepository $bookRepository, EntityManagerInterface $entityManager, $id) {
        $book = $bookRepository->find($id);

        $bookForm = $this->createForm(BooksFormType::class);

        $bookForm->handleRequest($request);

        if ($bookForm->isSubmitted() && $bookForm->isValid()) {
            $entityManager->persist($book);
            $entityManager->flush();
        };

        return $this->render("admin/AdminBooksUpdate.html.twig",[
            "bookForm" => $bookForm->createView()
        ]);
    }



    /**
     * @Route ("/admin/books/insertwithgenre", name = "AdminBooksInsertGenre")
     */
    public function AdminBooksInsertGenre (GenreRepository $genreRepository, EntityManagerInterface $entityManager) {
        $genre = $genreRepository->find(6);

        $book = new Book();

        $book->setTitle("Toto");
        $book->setNbPages(300);
        $book->setResume("Le temps et l'espzce temps");
        $book->setGenre($genre);

        $entityManager->persist($book);
        $entityManager->flush();

        return new Response('Livre ajouté');
    }


    /**
     * @Route ("/admin/books/genres", name = "BooksGenres")
     */
    public function BooksGenres (GenreRepository $genreRepository) {
        $genres = $genreRepository->findAll();


        return $this->render("admin/BooksGenre.html.twig", [
            "genres" => $genres
        ]);
    }


    /**
     * @Route ("/admin/books/genres/{id}", name = "BooksGenres2")
     */
    public function BooksGenres2 (GenreRepository $genreRepository, BookRepository $bookRepository, $id) {
        $genre = $genreRepository->find($id);


        return $this->render("admin/BooksGenre2.html.twig", [
            "genre" => $genre,
        ]);
    }

}
