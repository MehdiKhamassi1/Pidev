<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
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
    #[Assert\NotEqualTo(
        value:"------",
       message:"Le champ groupe sanguin ne peut pas etre vide"
    )]
    private ?string $groupesang = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Patient $patient = null;

    #[ORM\Column(length: 255)]   
    #[Assert\NotBlank(message: 'Le contenu ne peut pas être vide')]
    private ?string $maladie_chronique = null;
    

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'Le contenu ne peut pas etre vide')]
    private ?string $resultat_analyse = null;

    

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

    public function __toString()
    {
        return $this->getId();
    }

    public function getMaladieChronique(): ?string
    {
        return $this->maladie_chronique;
    }

    public function setMaladieChronique(string $maladie_chronique): static
    {
        $this->maladie_chronique = $maladie_chronique;

        return $this;
    }

    public function getResultatAnalyse(): ?string
    {
        return $this->resultat_analyse;
    }

    public function setResultatAnalyse(string $resultat_analyse): static
    {
        $this->resultat_analyse = $resultat_analyse;

        return $this;
    }
   
}
