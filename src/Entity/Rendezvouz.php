<?php

namespace App\Entity;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\RendezvouzRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;




#[ORM\Entity(repositoryClass: RendezvouzRepository::class)]
class Rendezvouz
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[ORM\OneToMany(mappedBy: 'Rendezvouz', targetEntity: Local::class, cascade: ['remove'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
#[Assert\NotBlank(message: 'La date ne peut pas être vide')]
#[Assert\GreaterThanOrEqual(value: "today", message: "La date doit être ultérieure à aujourd'hui")]
private ?DateTimeInterface $daterdv = null;

/**
 * @Assert\Callback
 */
public function validateHeureRdv(ExecutionContextInterface $context)
{
    $heureRdv = $this->daterdv->format('H:i');
    if ($heureRdv < '08:00' || $heureRdv > '18:00') {
        $context->buildViolation('Le rendez-vous doit être pris entre 08h00 et 18h00')
            ->atPath('daterdv')
            ->addViolation();
    }
}
    
    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Patient $Patient = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Docteur $Docteur = null;

    #[Assert\NotBlank(message: 'Il faut choisir un local')]
#[ORM\ManyToOne(inversedBy: 'rendezvouzs')]
private ?Local $local = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\ManyToOne(inversedBy: 'rendezvouz')]
    private ?User $user = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDaterdv(): ?\DateTimeInterface
    {
        return $this->daterdv;
    }

    public function setDaterdv(\DateTimeInterface $daterdv): static
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }
    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
