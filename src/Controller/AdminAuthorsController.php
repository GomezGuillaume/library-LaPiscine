<?php


namespace App\Controller;


use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminAuthorsController extends AbstractController
{
    /**
     * @Route ("/admin/authors", name = "AdminAuthors")
     */
    public function AdminAuthors (AuthorRepository $authorRepository)
    {
        $authors = $authorRepository->findAll();

        return $this->render("AdminAuthors.html.twig",[
            "authors" => $authors
        ]);
    }

    /**
     * @Route ("/admin/authors/delete/{id}", name = "AdminAuthorsDelete")
     */
    public function AdminAuthorsDelete (AuthorRepository $authorRepository, EntityManagerInterface $entityManager)
    {
        $author = $authorRepository->find($id);

        $entityManager->remove($author);
        $entityManager->flush();

        return $this->redirectToRoute(AdminAuthors);

    }
}