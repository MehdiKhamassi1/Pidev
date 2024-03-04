<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\ConsultationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConsultationRepository::class)]
class Consultation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Patient::class)]
#[ORM\JoinColumn(name: 'patient_id', referencedColumnName: 'id')]
private ?Patient $patient = null;
    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Docteur $Docteur = null;

    #[ORM\ManyToOne(inversedBy: 'consultations')]
    private ?Dossiermedical $dossiermedical = null;

    #[ORM\Column(type: 'date')] 
    #[Assert\NotNull(message:"La date ne peut pas être vide")]
    #[Assert\GreaterThanOrEqual(value: "today", message: "La date doit être ultérieure à aujourd'hui")]
    private ?\DateTimeInterface $date_consultation  = null ;

    #[ORM\Column(length: 255)]
    #[Assert\Regex(
        pattern:"/^[a-zA-Z0-9._%+-]+@gmail\.com$/",
      message:"The email must be in the format example@gmail.com."
      )]
    private ?string $email = null;

   
    public function getId(): ?int
    {
        return $this->id;
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

    public function getDocteur(): ?Docteur
    {
        return $this->Docteur;
    }

    public function setDocteur(?Docteur $Docteur): static
    {
        $this->Docteur = $Docteur;

        return $this;
    }

    public function getDossiermedical(): ?Dossiermedical
    {
        return $this->dossiermedical;
    }

    public function setDossiermedical(?Dossiermedical $dossiermedical): static
    {
        $this->dossiermedical = $dossiermedical;

        return $this;
    }


    public function getDateConsultation(): ?\DateTimeInterface
    {
        return $this->date_consultation;
    }

    public function setDateConsultation(?\DateTimeInterface $date_consultation): self
    {
        $this->date_consultation = $date_consultation;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

  
}
