<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Author;
use App\Repository\BookRepository;
use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {

    /**
     * @Route ("/home", name = "home")
     */
    public function home (BookRepository $bookRepository, AuthorRepository $authorRepository) {

        $books = $bookRepository->findBy([], null, 3);
        $authors = $authorRepository->findBy([], null, 3);
        return $this->render("home.html.twig", [
            "authors" => $authors,
            "books" => $books
        ]);
    }



}