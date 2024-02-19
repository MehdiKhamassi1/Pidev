<?php

namespace App\Entity;

use App\Repository\RendezvouzRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RendezvouzRepository::class)]
class Rendezvouz
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $daterdv = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Patient $Patient = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Docteur $Docteur = null;

    #[ORM\ManyToOne(inversedBy: 'rendezvouzs')]
    private ?Local $local = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDaterdv(): ?string
    {
        return $this->daterdv;
    }

    public function setDaterdv(string $daterdv): static
    {
        $this->daterdv = $daterdv;

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->Patient;
    }

    public function setPatient(?Patient $Patient): static
    {
        $this->Patient = $Patient;

        return $this;
    }

    public function getDocteur(): ?Docteur
    {
        return $this->Docteur;
    }

    public function setDocteur(?Docteur $Docteur): static
    {
        $this->Docteur = $Docteur;

        return $this;
    }

    public function getLocal(): ?Local
    {
        return $this->local;
    }

    public function setLocal(?Local $local): static
    {
        $this->local = $local;

        return $this;
    }
}
