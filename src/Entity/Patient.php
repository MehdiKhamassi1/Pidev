<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: PatientRepository::class)]


class Patient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le contenu ne peut pas être vide')]
    #[Assert\Regex(
        pattern: '/^[a-zA-ZÀ-ÿ\s]+$/',
        message: 'Le nom ne peut contenir que des lettres.'
    )]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Le nom ne peut pas dépasser {{ limit }} caractères.'
    )]    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le contenu ne peut pas être vide')]
    #[Assert\Regex(
        pattern: '/^[a-zA-ZÀ-ÿ\s]+$/',
        message: 'Le nom ne peut contenir que des lettres.'
    )]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Le nom ne peut pas dépasser {{ limit }} caractères.'
    )]     
    private ?string $prenom = null;

   
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'L email ne peut pas etre vide')]
    #[Assert\Regex(
            pattern:"/^[^@]+@[^@]+.[^@]+$/",
            message:"L'email '{{ value }}' n'est pas valide. Le format attendu est 'user@example.com'"
        )]    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\Regex(
        pattern:"/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W)/",
        message:"Le mot de passe doit contenir au moins un chiffre, une lettre majuscule, une lettre minuscule et un symbole."
    )]  
    private ?string $mdp = null;

  
    #[ORM\Column]
    #[Assert\NotBlank(message:'Ce champ ne peut pas etre vide')]
    #[Assert\Regex(
            pattern:"/^\d{8}$/",
            message:"Le numéro doit être composé exactement de 8 chiffres"
         )]
    private ?int $numtel = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Le contenu ne peut pas être vide')]
#[Assert\Type(type: 'integer', message: 'L\'âge doit être un nombre entier.')]
#[Assert\Range(
    min: 18,
    max: 100,
    notInRangeMessage: 'L\'âge doit être entre {{ min }} et {{ max }} ans.'
)]
    private ?int $age = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'Le contenu ne peut pas etre vide')]
    private ?string $gender = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $profileImage = null;

    
    
    public function getId(): ?int
    {
        return $this->id;
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

    

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): static
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getNumtel(): ?int
    {
        return $this->numtel;
    }

    public function setNumtel(int $numtel): static
    {
        $this->numtel = $numtel;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): static
    {
        $this->gender = $gender;

        return $this;
    }
   public function getprofileImage(): ?string
    {
        return $this->profileImage;
    }

    public function setprofileImage(?string $profileImage): static
    {
        $this->profileImage = $profileImage;

        return $this;
    }

}
