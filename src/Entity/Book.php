<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookRepository", repositoryClass=BookRepository::class)
 */
class Book
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=75)
     * @Assert\NotBlank(message = "Merci de remplir le titre !")
     */
    private $title;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message = "Merci de remplir le nombre de pages !")
     */
    private $NbPages;


    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\NotBlank(message = "Merci de remplir le résumé !")
     */
    private $resume;

    /**
     * @ORM\ManyToOne(targetEntity=Genre::class, inversedBy="books")
     * @ORM\JoinColumn(nullable=false)
     */
    private $genre;

    /**
     * @ORM\ManyToOne(targetEntity=Author::class, inversedBy="books")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;


    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $bookCover;




    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getNbPages(): ?int
    {
        return $this->NbPages;
    }

    public function setNbPages(int $NbPages): self
    {
        $this->NbPages = $NbPages;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getResume()
    {
        return $this->resume;
    }

    /**
     * @param mixed $resume
     */
    public function setResume($resume): void
    {
        $this->resume = $resume;
    }

    public function getGenre(): ?Genre
    {
        return $this->genre;
    }

    public function setGenre(?Genre $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBookCover()
    {
        return $this->bookCover;
    }

    /**
     * @param mixed $bookCover
     */
    public function setBookCover($bookCover): void
    {
        $this->bookCover = $bookCover;
    }



}
