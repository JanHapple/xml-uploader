<?php

namespace App\Entity;

use App\Repository\XmlDataRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: XmlDataRepository::class)]
class XmlData
{
    #[ORM\Id]
    #[ORM\Column]
    private ?int $entity_id = null;

    #[ORM\Column(length: 255)]
    private ?string $CategoryName = null;

    #[ORM\Column]
    private ?string $sku = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $shortdesc = null;

    #[ORM\Column]
    private ?string $price = null;

    #[ORM\Column(length: 255)]
    private ?string $link = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    private ?string $Brand = null;

    #[ORM\Column]
    private ?string $Rating = null;

    #[ORM\Column(length: 255)]
    private ?string $CaffeineType = null;

    #[ORM\Column]
    private ?string $Count = null;

    #[ORM\Column(length: 255)]
    private ?string $Flavored = null;

    #[ORM\Column(length: 255)]
    private ?string $Seasonal = null;

    #[ORM\Column(length: 255)]
    private ?string $Instock = null;

    #[ORM\Column]
    private ?string $Facebook = null;

    #[ORM\Column]
    private ?string $IsCup = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntityId(): ?string
    {
        return $this->entity_id;
    }

    public function setEntityId(string $entity_id): static
    {
        $this->entity_id = $entity_id;

        return $this;
    }

    public function getCategoryName(): ?string
    {
        return $this->CategoryName;
    }

    public function setCategoryName(string $CategoryName): static
    {
        $this->CategoryName = $CategoryName;

        return $this;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(string $sku): static
    {
        $this->sku = $sku;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getShortdesc(): ?string
    {
        return $this->shortdesc;
    }

    public function setShortdesc(?string $shortdesc): static
    {
        $this->shortdesc = $shortdesc;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): static
    {
        $this->link = $link;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->Brand;
    }

    public function setBrand(string $Brand): static
    {
        $this->Brand = $Brand;

        return $this;
    }

    public function getRating(): ?string
    {
        return $this->Rating;
    }

    public function setRating(string $Rating): static
    {
        $this->Rating = $Rating;

        return $this;
    }

    public function getCaffeineType(): ?string
    {
        return $this->CaffeineType;
    }

    public function setCaffeineType(string $CaffeineType): static
    {
        $this->CaffeineType = $CaffeineType;

        return $this;
    }

    public function getCount(): ?string
    {
        return $this->Count;
    }

    public function setCount(string $Count): static
    {
        $this->Count = $Count;

        return $this;
    }

    public function getFlavored(): ?string
    {
        return $this->Flavored;
    }

    public function setFlavored(string $Flavored): static
    {
        $this->Flavored = $Flavored;

        return $this;
    }

    public function getSeasonal(): ?string
    {
        return $this->Seasonal;
    }

    public function setSeasonal(string $Seasonal): static
    {
        $this->Seasonal = $Seasonal;

        return $this;
    }

    public function getInstock(): ?string
    {
        return $this->Instock;
    }

    public function setInstock(string $Instock): static
    {
        $this->Instock = $Instock;

        return $this;
    }

    public function getFacebook(): ?string
    {
        return $this->Facebook;
    }

    public function setFacebook(string $Facebook): static
    {
        $this->Facebook = $Facebook;

        return $this;
    }

    public function getIsCup(): ?string
    {
        return $this->IsCup;
    }

    public function setIsCup(string $IsCup): static
    {
        $this->IsCup = $IsCup;

        return $this;
    }
}
