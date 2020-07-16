<?php


namespace App\Controller;


use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminBookController extends AbstractController {

    //
    /**
     * @Route ("/admin/books", name = "AdminBooks")
     */
    public function AdminBooks(BookRepository $bookRepository)
    {

        $books = $bookRepository->findAll();

        return $this->render("AdminBooks.html.twig", [
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

}
