<?php


namespace App\Controller;


use App\Entity\Book;
use App\Form\BooksFormType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
    public function AdminBooksInsert (Request $request, EntityManagerInterface $entityManager) {

        $book = new Book();

        $bookForm = $this->createForm(BooksFormType::class, $book);

        // Je prend les données de la requête  (classe Request) et je les envoies à mon formulaire
        $bookForm->handleRequest($request);

        if ($bookForm->isSubmitted() && $bookForm->isValid()) {
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

}
