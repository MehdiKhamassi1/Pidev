<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorColumn(name: "user_type", type: "string")]
  /** 
 * @ORM\DiscriminatorMap({"patient" = "Patient", "docteur" = "Docteur", "admin"="Admin"})
 */

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank(message:'L email ne peut pas etre vide')]
    #[Assert\Regex(
            pattern:"/^[^@]+@[^@]+.[^@]+$/",
            message:"L'email '{{ value }}' n'est pas valide. Le format attendu est 'user@example.com'"
        )]   
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\Regex(
        pattern:"/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W)/",
        message:"Le mot de passe doit contenir au moins un chiffre, une lettre majuscule, une lettre minuscule et un symbole."
    )]   

    private ?string $password = null;

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
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le contenu ne peut pas être vide')]
    #[Assert\Regex(
        pattern: '/^[a-zA-ZÀ-ÿ\s]+$/',
        message: 'Le prenom ne peut contenir que des lettres.'
    )]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Le prenom ne peut pas dépasser {{ limit }} caractères.'
    )] 
    private ?string $prenom = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:'Ce champ ne peut pas etre vide')]
    #[Assert\Regex(
            pattern:"/^\d{8}$/",
            message:"Le numéro doit être composé exactement de 8 chiffres"
         )]
    private ?int $numtel = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank(message: 'Please enter your birth date.')]
    #[Assert\LessThanOrEqual('today', message: 'Please enter a birth date in the past.')]
    private ?\DateTimeInterface $birth = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'Le contenu ne peut pas etre vide')]

    private ?string $profile_image = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'Le contenu ne peut pas etre vide')]

    private ?string $gender = null;

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // garantir que chaque utilisateur a au moins ROLE_USER
        
        // ajouter d'autres rôles si l'utilisateur a des rôles supplémentaires
        if (in_array('ROLE_PATIENT', $this->roles)) {
            $roles[] = 'ROLE_PATIENT';
        }
        if (in_array('ROLE_DOCTEUR', $this->roles)) {
            $roles[] = 'ROLE_DOCTEUR';
        }
        if (in_array('ROLE_ADMIN', $this->roles)) {
            $roles[] = 'ROLE_ADMIN';
        }
    
        return array_unique($roles);
    }
    

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getNumtel(): ?int
    {
        return $this->numtel;
    }

    public function setNumtel(int $numtel): static
    {
        $this->numtel = $numtel;

        return $this;
    }

    public function getBirth(): ?\DateTimeInterface
    {
        return $this->birth;
    }

    public function setBirth(\DateTimeInterface $birth): static
    {
        $this->birth = $birth;

        return $this;
    }

    public function getProfileImage(): ?string
    {
        return $this->profile_image;
    }

    public function setProfileImage(string $profile_image): static
    {
        $this->profile_image = $profile_image;

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
    public function __toString()
    {
        return $this->getId(); 
    }
}
