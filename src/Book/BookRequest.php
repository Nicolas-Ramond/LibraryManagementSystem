<?php

namespace App\Book;

use App\Entity\Book;
use App\Entity\User;
use Symfony\Component\Asset\Packages;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

class BookRequest
{
    private $id;

    /**
     * @Assert\NotBlank(message="asserts.book.title.notblank")
     * @Assert\Length(
     *     max=255,
     *     maxMessage="Votre titre est trop long. Pas plus de {{ limit }} caractères."
     * )
     */
    private $title;
    private $slug;

    /**
     * @Assert\NotBlank(message="asserts.book.content.notblank")
     */
    private $content;

    /**
     * @Assert\Image(mimeTypesMessage="asserts.book.image.mimetype",
     *     maxSize="2M", maxSizeMessage="asserts.book.image.maxsize")
     */
    private $featuredImage;


    /**
     * @Assert\NotNull(message="asserts.book.category.notnull")
     */
    private $category;
    private $user;
    private $status;

    /**
     * BookRequest constructor.
     * @param $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->createdDate = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
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
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getFeaturedImage()
    {
        return $this->featuredImage;
    }

    /**
     * @param mixed $featuredImage
     */
    public function setFeaturedImage($featuredImage)
    {
        $this->featuredImage = $featuredImage;
    }

    /**
     * @return mixed
     */
    public function getSpecial()
    {
        return $this->special;
    }

    /**
     * @param mixed $special
     */
    public function setSpecial($special)
    {
        $this->special = $special;
    }

    /**
     * @return mixed
     */
    public function getSpotlight()
    {
        return $this->spotlight;
    }

    /**
     * @param mixed $spotlight
     */
    public function setSpotlight($spotlight)
    {
        $this->spotlight = $spotlight;
    }

    /**
     * @return mixed
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * @param mixed $createdDate
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @param mixed $imageUrl
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Créer un BookRequest depuis un Book de Entity
     * @param Book $book
     * @param Packages $packages
     * @param string $assetsDirectory
     * @return BookRequest
     * @internal param Package|Packages $package
     * @internal param $assetsDirectory
     * @internal param Package $package
     */
    public static function createFromBook(Book $book, Packages $packages, string $assetsDirectory): self
    {
        $ar = new self($book->getUser());
        $ar->id = $book->getId();
        $ar->title = $book->getTitle();
        $ar->slug = $book->getSlug();
        $ar->content = $book->getContent();
        $ar->featuredImage = new File($assetsDirectory . '/' . $book->getFeaturedImage());
        $ar->imageUrl = $packages->getUrl('images/product/'. $book->getFeaturedImage());
        $ar->special = $book->getSpecial();
        $ar->spotlight = $book->getSpotlight();
        $ar->createdDate = $book->getCreatedDate();
        $ar->category = $book->getCategory();

        return $ar;
    }
}
