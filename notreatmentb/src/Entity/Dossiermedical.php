<?php

namespace App\Entity;

use App\Repository\DossiermedicalRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DossiermedicalRepository::class)]
class Dossiermedical
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $groupesang = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Patient $patient = null;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGroupesang(): ?string
    {
        return $this->groupesang;
    }

    public function setGroupesang(string $groupesang): static
    {
        $this->groupesang = $groupesang;

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): static
    {
        $this->patient = $patient;

        return $this;
    }

   
}
