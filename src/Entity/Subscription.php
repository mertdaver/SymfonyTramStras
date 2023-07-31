<?php

namespace App\Entity;

use App\Repository\SubscriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubscriptionRepository::class)]
class Subscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $currentPeriodStart = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $currentPeriodEnd = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\OneToMany(mappedBy: 'subscription', targetEntity: Invoice::class, orphanRemoval: true)]
    private Collection $invoices;

    #[ORM\Column(length: 255)]
    private ?string $stripeId = null;

    #[ORM\ManyToOne(inversedBy: 'subscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Plan $Plan = null;

    #[ORM\ManyToOne(inversedBy: 'subscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $User = null;

    public function __construct()
    {
        $this->invoices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCurrentPeriodStart(): ?\DateTimeInterface
    {
        return $this->currentPeriodStart;
    }

    public function setCurrentPeriodStart(\DateTimeInterface $currentPeriodStart): self
    {
        $this->currentPeriodStart = $currentPeriodStart;

        return $this;
    }

    public function getCurrentPeriodEnd(): ?\DateTimeInterface
    {
        return $this->currentPeriodEnd;
    }

    public function setCurrentPeriodEnd(\DateTimeInterface $currentPeriodEnd): self
    {
        $this->currentPeriodEnd = $currentPeriodEnd;

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return Collection<int, Invoice>
     */
    public function getInvoices(): Collection
    {
        return $this->invoices;
    }

    public function addInvoice(Invoice $invoice): self
    {
        if (!$this->invoices->contains($invoice)) {
            $this->invoices->add($invoice);
            $invoice->setSubscription($this);
        }

        return $this;
    }

    public function removeInvoice(Invoice $invoice): self
    {
        if ($this->invoices->removeElement($invoice)) {
            // set the owning side to null (unless already changed)
            if ($invoice->getSubscription() === $this) {
                $invoice->setSubscription(null);
            }
        }

        return $this;
    }

    public function getStripeId(): ?string
    {
        return $this->stripeId;
    }

    public function setStripeId(string $stripeId): self
    {
        $this->stripeId = $stripeId;

        return $this;
    }

    public function getPlan(): ?Plan
    {
        return $this->Plan;
    }

    public function setPlan(?Plan $Plan): self
    {
        $this->Plan = $Plan;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }
}
