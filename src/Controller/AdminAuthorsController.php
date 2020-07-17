<?php


namespace App\Controller;


use App\Form\AuthorsFormType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\DocBlock\Tags\Author;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class AdminAuthorsController extends AbstractController
{
    /**
     * @Route ("/admin/authors", name = "AdminAuthors")
     */
    public function AdminAuthors (AuthorRepository $authorRepository)
    {
        $authors = $authorRepository->findAll();

        return $this->render("admin/AdminAuthors.html.twig",[
            "authors" => $authors
        ]);
    }

    /**
     * @Route ("/admin/authors/delete/{id}", name = "AdminAuthorsDelete")
     */
    public function AdminAuthorsDelete (AuthorRepository $authorRepository, EntityManagerInterface $entityManager, $id)
    {
        $author = $authorRepository->find($id);

        $entityManager->remove($author);
        $entityManager->flush();

        return $this->redirectToRoute(AdminAuthors);

    }


    /**
     * @Route ("/admin/authors/insert", name = "AdminAuthorsInsert")
     */
    public function AdminAuthorInsert (Request $request, EntityManagerInterface $entityManager) {

        $author = new \App\Entity\Author();

        $authorForm = $this->createForm(AuthorsFormType::class, $author);

        $authorForm->handleRequest($request);

        if ($authorForm->isSubmitted() && $authorForm->isValid()) {
            $entityManager->persist($author);
            $entityManager->flush();
        };

        return $this->render("admin/AdminAuthorsInsert.html.twig", [
            "authorForm" =>  $authorForm->createView()
        ]);
    }


    /**
     * @Route ("/admin/authors/update/{id}", name = "AdminAuthorsUpdate")
     */
    public function AdminAuthorsUpdate (Request $request, AuthorRepository $authorRepository, EntityManagerInterface $entityManager, $id) {
        $author = $authorRepository->find($id);

        $authorForm = $this->createForm(AuthorsFormType::class);

        $authorForm->handleRequest($request);

        if ($authorForm->isSubmitted() && $authorForm->isValid()) {
            $entityManager->persist($author);
            $entityManager->flush();
        }

        return $this->render("admin/AdminAuthorsUpdate.html.twig",[
            "authorForm" => $authorForm->createView()
        ]);
    }
}