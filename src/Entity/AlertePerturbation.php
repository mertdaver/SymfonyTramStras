<?php

namespace App\Entity;

use App\Repository\AlertePerturbationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AlertePerturbationRepository::class)]
class AlertePerturbation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $alerteDate = null;

    #[ORM\Column(length: 255)]
    private ?string $arret = null;

    #[ORM\Column(length: 255)]
    private ?string $ligne = null;

    #[ORM\Column]
    private ?bool $deuxSens = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAlerteDate(): ?\DateTimeInterface
    {
        return $this->alerteDate;
    }

    public function setAlerteDate(\DateTimeInterface $alerteDate): self
    {
        $this->alerteDate = $alerteDate;

        return $this;
    }

    public function getArret(): ?string
    {
        return $this->arret;
    }

    public function setArret(string $arret): self
    {
        $this->arret = $arret;

        return $this;
    }

    public function getLigne(): ?string
    {
        return $this->ligne;
    }

    public function setLigne(string $ligne): self
    {
        $this->ligne = $ligne;

        return $this;
    }

    public function isDeuxSens(): ?bool
    {
        return $this->deuxSens;
    }

    public function setDeuxSens(bool $deuxSens): self
    {
        $this->deuxSens = $deuxSens;

        return $this;
    }
}
