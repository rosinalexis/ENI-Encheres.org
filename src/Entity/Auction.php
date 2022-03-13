<?php

namespace App\Entity;

use App\Repository\AuctionRepository;
use Doctrine\ORM\Mapping as ORM;

#[
    ORM\Entity(repositoryClass: AuctionRepository::class),
    ORM\Table(name: 'auctions')
]
class Auction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    private $bidDate;

    #[ORM\Column(type: 'float')]
    private $bidAmount;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'overbid')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\ManyToOne(targetEntity: Item::class, inversedBy: 'overbid')]
    #[ORM\JoinColumn(nullable: false)]
    private $item;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBidDate(): ?\DateTimeInterface
    {
        return $this->bidDate;
    }

    public function setBidDate(\DateTimeInterface $bidDate): self
    {
        $this->bidDate = $bidDate;

        return $this;
    }

    public function getBidAmount(): ?float
    {
        return $this->bidAmount;
    }

    public function setBidAmount(float $bidAmount): self
    {
        $this->bidAmount = $bidAmount;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function setItem(?Item $item): self
    {
        $this->item = $item;

        return $this;
    }
}
