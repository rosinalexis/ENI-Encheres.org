<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[
    ORM\Entity(repositoryClass: ItemRepository::class),
    ORM\Table(name: 'items')
]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\Column(type: 'datetime_immutable')]
    private $bidStartedAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private $bidEndedAt;

    #[ORM\Column(type: 'float')]
    private $openingBid;

    #[ORM\Column(type: 'float', nullable: true)]
    private $salePrice;

    #[ORM\Column(type: 'string', length: 255)]
    private $status;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'items')]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private $category;

    #[ORM\OneToOne(targetEntity: Pickup::class, cascade: ['persist', 'remove'])]
    private $pickupPoint;

    #[ORM\OneToMany(mappedBy: 'item', targetEntity: Auction::class, orphanRemoval: true)]
    private $overbid;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'sellItems')]
    #[ORM\JoinColumn(nullable: false)]
    private $soldBy;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'buyItems')]
    private $boughtBy;

    public function __construct()
    {
        $this->overbid = new ArrayCollection();
    }

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

    public function getBidStartedAt(): ?\DateTimeImmutable
    {
        return $this->bidStartedAt;
    }

    public function setBidStartedAt(\DateTimeImmutable $bidStartedAt): self
    {
        $this->bidStartedAt = $bidStartedAt;

        return $this;
    }

    public function getBidEndedAt(): ?\DateTimeImmutable
    {
        return $this->bidEndedAt;
    }

    public function setBidEndedAt(\DateTimeImmutable $bidEndedAt): self
    {
        $this->bidEndedAt = $bidEndedAt;

        return $this;
    }

    public function getOpeningBid(): ?float
    {
        return $this->openingBid;
    }

    public function setOpeningBid(float $openingBid): self
    {
        $this->openingBid = $openingBid;

        return $this;
    }

    public function getSalePrice(): ?float
    {
        return $this->salePrice;
    }

    public function setSalePrice(?float $salePrice): self
    {
        $this->salePrice = $salePrice;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

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

    public function getPickupPoint(): ?Pickup
    {
        return $this->pickupPoint;
    }

    public function setPickupPoint(?Pickup $pickupPoint): self
    {
        $this->pickupPoint = $pickupPoint;

        return $this;
    }

    /**
     * @return Collection<int, Auction>
     */
    public function getOverbid(): Collection
    {
        return $this->overbid;
    }

    public function addOverbid(Auction $overbid): self
    {
        if (!$this->overbid->contains($overbid)) {
            $this->overbid[] = $overbid;
            $overbid->setItem($this);
        }

        return $this;
    }

    public function removeOverbid(Auction $overbid): self
    {
        if ($this->overbid->removeElement($overbid)) {
            // set the owning side to null (unless already changed)
            if ($overbid->getItem() === $this) {
                $overbid->setItem(null);
            }
        }

        return $this;
    }

    public function getSoldBy(): ?User
    {
        return $this->soldBy;
    }

    public function setSoldBy(?User $soldBy): self
    {
        $this->soldBy = $soldBy;

        return $this;
    }

    public function getBoughtBy(): ?User
    {
        return $this->boughtBy;
    }

    public function setBoughtBy(?User $boughtBy): self
    {
        $this->boughtBy = $boughtBy;

        return $this;
    }
}
