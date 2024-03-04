<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\DonRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DonRepository::class)]
class Don
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[ORM\ManyToOne(inversedBy: 'dons',cascade: ['remove'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotEqualTo(
             value:"------",
            message:"Le champ type ne peut pas etre vide"
         )]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'La description ne peut pas etre vide')]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'dons')]
    #[Assert\NotBlank(message:'Il faut choisir au moins une organisation')]
    private ?Organisation $Organisation = null;



    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'L email ne peut pas etre vide')]
    #[Assert\Regex(
            pattern:"/^[^@]+@[^@]+\.[^@]+$/",
            message:"L'email '{{ value }}' n'est pas valide. Le format attendu est 'user@example.com'"
        )]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'Le nom ne peut pas etre vide')]
    #[Assert\Regex(
          pattern:"/^[^\d]*$/",
          message:"Le nom ne peut pas contenir des chiffres"
      )]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'Le prenom ne peut pas etre vide')]
    #[Assert\Regex(
          pattern:"/^[^\d]*$/",
          message:"Le prenom ne peut pas contenir des chiffres"
      )]
    private ?string $prenom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Regex(
        pattern:"/^\d+(\.\d{1,2})?$/",
        message:"Le champ montant doit être une valeur monétaire valide."
    )]
    private ?int $montant = null;

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getOrganisation(): ?Organisation
    {
        return $this->Organisation;
    }

    public function setOrganisation(?Organisation $Organisation): static
    {
        $this->Organisation = $Organisation;

        return $this;
    }


    public function __toString()
    {
        return $this->getID();
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(?int $montant): static
    {
        $this->montant = $montant;

        return $this;
    }



}
