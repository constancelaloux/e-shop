<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
//use Symfony\Component\Validator\Mapping\ClassMetadata;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "le nom du produit est obligatoire!")]
    #[Assert\Length(min: 3, max: 255, minMessage:'Le nom du produit doit avoir au moins 3 charactéres')]
    private ?string $name = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "le prix du produit est obligatoire!")]
    private ?int $price = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Category $category = null;

    #[ORM\Column(length: 255, nullable: false)]
    #[Assert\NotBlank(message: "la photo principale est obligatoire!")]
    #[Assert\Url(message: "la photo principale doit étre une url valide!")]
    private ?string $mainPicture = '';

    #[ORM\Column(type: Types::TEXT, nullable: false)]
    #[Assert\NotBlank(message: "la description courte est obligatoire!")]
    #[Assert\Length(min: 20, max: 100 , minMessage: "la description courte doit quand meme faire au moins 20 caractéres!")]
    private ?string $shortDescription = '';

    /*public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('name', [
            new Assert\NotBlank(['message' => 'Le nom du produit est obligatoire']),
            new Assert\Length(['min' => 3, 'max' => 255, 'minMessage' => 'Le nom du produit doit contenir au moins 3 caractéres'])
        ]);

        $metadata->addPropertyConstraint('price', new Assert\NotBlank(['message' => 'Le prix du produit est obligatoire']));
    }*/
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

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

    public function getMainPicture(): ?string
    {
        return $this->mainPicture;
    }

    public function setMainPicture(?string $mainPicture): self
    {
        $this->mainPicture = $mainPicture;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(?string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }
}
