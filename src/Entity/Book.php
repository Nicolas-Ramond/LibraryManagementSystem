<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 *
 * @ORM\Entity(repositoryClass="App\Repository\BookRepository")
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
     * @ORM\Column(type="string", length=255)
     */
    private $isbn;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $resume;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $pageNumber;

    /**
     * @ORM\Column(type="object", nullable=true)
     */
    private $cover;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Author", inversedBy="books")
     */
    private $author;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Author", inversedBy="contributedBooks")
     * @ORM\JoinTable(name="book_author")
     */
    private $authors;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PBook", mappedBy="book", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $pBooks;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\EBook", mappedBy="book", cascade={"persist", "remove"})
     */
    private $eBook;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SubCategory", inversedBy="books")
     * @ORM\JoinColumn(nullable=false)
     */
    private $subCategory;

    /**
     * @ORM\OneToOne(
     *     targetEntity="App\Entity\Image",
     *     mappedBy="book",
     *     cascade={"persist", "remove"}
     *     )
//     * @ORM\JoinColumn(name="image_id", referencedColumnName="id")
     */
    private $image;

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getSubCategory()
    {
        return $this->subCategory;
    }

    /**
     * @param mixed $subCategory
     */
    public function setSubCategory($subCategory): void
    {
        $this->subCategory = $subCategory;
    }

    public function __construct()
    {
        $this->pBooks = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): self
    {
        $this->isbn = $isbn;

        return $this;
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

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(?string $resume): self
    {
        $this->resume = $resume;

        return $this;
    }

    public function getPageNumber(): ?int
    {
        return $this->pageNumber;
    }

    public function setPageNumber(?int $pageNumber): self
    {
        $this->pageNumber = $pageNumber;

        return $this;
    }

    public function getCover()
    {
        return $this->cover;
    }

    public function setCover($cover): self
    {
        $this->cover = $cover;

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

    public function getAuthors(): ?array
    {
        return $this->authors;
    }

    public function setAuthors(?array $authors): self
    {
        $this->authors = $authors;

        return $this;
    }

    public function getPBook(): ?PBook
    {
        return $this->pBook;
    }

    public function setPBook(PBook $pBook): self
    {
        $this->pBook = $pBook;

        // set the owning side of the relation if necessary
        if ($this !== $pBook->getBook()) {
            $pBook->setBook($this);
        }

        return $this;
    }

    /**
     * @return Collection|PBook[]
     */
    public function getPBooks(): Collection
    {
        return $this->pBooks;
    }

    public function addPBook(PBook $pBook): self
    {
        if (!$this->pBooks->contains($pBook)) {
            $this->pBooks[] = $pBook;
            $pBook->setBook($this);
        }

        return $this;
    }

    public function removePBook(PBook $pBook): self
    {
        if ($this->pBooks->contains($pBook)) {
            $this->pBooks->removeElement($pBook);
            // set the owning side to null (unless already changed)
            if ($pBook->getBook() === $this) {
                $pBook->setBook(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEBook()
    {
        return $this->eBook;
    }

    /**
     * @param mixed $eBook
     */
    public function setEBook($eBook): void
    {
        $this->eBook = $eBook;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @param mixed $pBooks
     */
    public function setPBooks($pBooks): void
    {
        $this->pBooks = $pBooks;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug): void
    {
        $this->slug = $slug;
    }

    public function addAuthor(Author $author)
    {
        $this->authors[] = $author;

        return $this;
    }
}
