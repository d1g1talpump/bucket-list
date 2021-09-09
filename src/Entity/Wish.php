<?php

namespace App\Entity;

use App\Repository\WishRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=WishRepository::class)
 */
class Wish
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message = "Your wish needs a title, it could be just a brief description of you wish")
     * @Assert\Length(min="5", max="250", maxMessage="This should be less that 250 character", minMessage="This should be longer that 5 characters")
     * @ORM\Column(type="string", length=250)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @Assert\Length (min="3", max="50", maxMessage="This should be less that 50 character", minMessage="This should be longer that 3 characters")
     * @ORM\Column(type="string", length=50)
     */
    private $author;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublished;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreated;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="wish")
     */
    private $category;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
