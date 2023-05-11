<?php
namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ApiResource()
 *
 * @ORM\MappedSuperclass()
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 */
class Image extends File
{
    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Book", inversedBy="image")
     * @ORM\JoinColumn(nullable=true)
     */
    private $book;

    /**
     * @return mixed
     */
    public function getBook()
    {
        return $this->book;
    }
    /**
     * @param mixed $book
     *
     * @return Image
     */
    public function setBook($book)
    {
        $this->book = $book;
        return $this;
    }
}