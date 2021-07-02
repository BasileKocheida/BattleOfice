<?php

namespace App\Entity;

use App\Repository\PaymentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PaymentRepository::class)
 */
class Payment
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
    private $ref_commande;

   
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adress_client;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="payments")
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $product;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mode_payment;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $amount;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=DeliveryAdress::class, inversedBy="payments")
     */
    private $delivery;

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRefCommande(): ?string
    {
        return $this->ref_commande;
    }

    public function setRefCommande(string $ref_commande): self
    {
        $this->ref_commande = $ref_commande;

        return $this;
    }


    public function getAdressClient(): ?string
    {
        return $this->adress_client;
    }

    public function setAdressClient(string $adress_client): self
    {
        $this->adress_client = $adress_client;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

   
    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }
   

    public function getModePayment(): ?string
    {
        return $this->mode_payment;
    }

    public function setModePayment(string $mode_payment): self
    {
        $this->mode_payment = $mode_payment;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDelivery(): ?DeliveryAdress
    {
        return $this->delivery;
    }

    public function setDelivery(?DeliveryAdress $delivery): self
    {
        $this->delivery = $delivery;

        return $this;
    }
}
