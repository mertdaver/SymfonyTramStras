<?php

namespace App\Entity;

use App\Repository\InvoiceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InvoiceRepository::class)]
class Invoice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $stripeId = null;

    #[ORM\ManyToOne(inversedBy: 'invoices')]
    #[ORM\JoinColumn(nullable: false)]
    private ?subscription $subscription = null;

    #[ORM\Column]
    private ?float $amountPaid = null;

    #[ORM\Column]
    private ?int $number = null;

    #[ORM\Column(length: 255, nullable: false)]
    private ?string $hostedInvoiceUrl = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubscription(): ?subscription
    {
        return $this->subscription;
    }

    public function setSubscription(?subscription $subscription): self
    {
        $this->subscription = $subscription;

        return $this;
    }

    public function getAmountPaid(): ?float
    {
        return $this->amountPaid;
    }

    public function setAmountPaid(float $amountPaid): self
    {
        $this->amountPaid = $amountPaid;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getHostedInvoiceUrl(): ?string
    {
        return $this->hostedInvoiceUrl;
    }

    public function setHostedInvoiceUrl(?string $hostedInvoiceUrl): self
    {
        $this->hostedInvoiceUrl = $hostedInvoiceUrl;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

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
}
