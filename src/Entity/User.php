<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`users`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'string', length: 255)]
    private $nickName;

    #[ORM\Column(type: 'string', length: 255)]
    private $lastName;

    #[ORM\Column(type: 'string', length: 255)]
    private $firstName;

    #[ORM\Column(type: 'string', length: 255)]
    private $phoneNumber;

    #[ORM\Column(type: 'string', length: 255)]
    private $street;

    #[ORM\Column(type: 'integer')]
    private $postcode;

    #[ORM\Column(type: 'string', length: 255)]
    private $city;

    #[ORM\Column(type: 'integer')]
    private $credit;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Auction::class, orphanRemoval: true)]
    private $overbid;

    #[ORM\OneToMany(mappedBy: 'soldBy', targetEntity: item::class)]
    private $sellItems;

    #[ORM\OneToMany(mappedBy: 'boughtBy', targetEntity: Item::class)]
    private $buyItems;

    public function __construct()
    {
        $this->overbid = new ArrayCollection();
        $this->sellItems = new ArrayCollection();
        $this->buyItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNickName(): ?string
    {
        return $this->nickName;
    }

    public function setNickName(string $nickName): self
    {
        $this->nickName = $nickName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getPostcode(): ?int
    {
        return $this->postcode;
    }

    public function setPostcode(int $postcode): self
    {
        $this->postcode = $postcode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCredit(): ?int
    {
        return $this->credit;
    }

    public function setCredit(int $credit): self
    {
        $this->credit = $credit;

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
            $overbid->setUser($this);
        }

        return $this;
    }

    public function removeOverbid(Auction $overbid): self
    {
        if ($this->overbid->removeElement($overbid)) {
            // set the owning side to null (unless already changed)
            if ($overbid->getUser() === $this) {
                $overbid->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, item>
     */
    public function getSell(): Collection
    {
        return $this->sell;
    }

    public function addSellItem(item $sellItem): self
    {
        if (!$this->sellItems->contains($sellItem)) {
            $this->sellItems[] = $sellItem;
            $sellItem->setSoldBy($this);
        }

        return $this;
    }

    public function removeSellItem(item $sellItem): self
    {
        if ($this->sellItems->removeElement($sellItem)) {
            // set the owning side to null (unless already changed)
            if ($sellItem->getSoldBy() === $this) {
                $sellItem->setSoldBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Item>
     */
    public function getBuyItems(): Collection
    {
        return $this->buyItems;
    }

    public function addBuyItem(Item $buyItem): self
    {
        if (!$this->buyItems->contains($buyItem)) {
            $this->buyItems[] = $buyItem;
            $buyItem->setBoughtBy($this);
        }

        return $this;
    }

    public function removeBuyItem(Item $buyItem): self
    {
        if ($this->buyItems->removeElement($buyItem)) {
            // set the owning side to null (unless already changed)
            if ($buyItem->getBoughtBy() === $this) {
                $buyItem->setBoughtBy(null);
            }
        }

        return $this;
    }
}
