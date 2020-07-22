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

        $books = $bookRepository->findAll();
        $authors = $authorRepository->findAll();
        return $this->render("home.html.twig", [
            "authors" => $authors,
            "books" => $books
        ]);
    }



}