<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $img;

   

    /**
     * @ORM\Column(type="integer")
     */
    private $price_promo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $text_promo;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): self
    {
        $this->img = $img;

        return $this;
    }

    

    public function getPricePromo(): ?int
    {
        return $this->price_promo;
    }

    public function setPricePromo(int $price_promo): self
    {
        $this->price_promo = $price_promo;

        return $this;
    }

    public function getTextPromo(): ?string
    {
        return $this->text_promo;
    }

    public function setTextPromo(string $text_promo): self
    {
        $this->text_promo = $text_promo;

        return $this;
    }
}
