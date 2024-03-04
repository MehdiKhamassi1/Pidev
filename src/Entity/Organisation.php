<?php

namespace App\Entity;

use App\Repository\OrganisationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: OrganisationRepository::class)]
class Organisation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[ORM\OneToMany(mappedBy: 'organisation', targetEntity: Don::class, cascade: ['remove'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'Le nom ne peut pas etre vide')]
    #[Assert\Regex(
          pattern:"/^[^\d]*$/",
          message:"Ce champ ne peut pas contenir des chiffres"
      )]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'L adresse ne peut pas etre vide')]
    private ?string $adresse = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'L email ne peut pas etre vide')]
    #[Assert\Regex(
            pattern:"/^[^@]+@[^@]+\.[^@]+$/",
            message:"L'email '{{ value }}' n'est pas valide. Le format attendu est 'user@example.com'"
        )]
    private ?string $email = null;
   
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'Ce champ ne peut pas etre vide')]
    #[Assert\Regex(
            pattern:"/^\d{8}$/",
            message:"Le numéro doit être composé exactement de 8 chiffres"
         )]
    private ?string $num_tel=null;

    // Getters and setters
    public function getNumTel(): ?string
    {
        return $this->num_tel;
    }

    public function setNumTel(string $num_tel): static
    {
        $this->num_tel = $num_tel;

        return $this;
    }

    #[ORM\OneToMany(targetEntity: Don::class, mappedBy: 'Organisation')]
    private Collection $dons;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

   

 

    public function __construct()
    {
        $this->dons = new ArrayCollection();
    }

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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

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



    /**
     * @return Collection<int, Don>
     */
    public function getDons(): Collection
    {
        return $this->dons;
    }

    public function addDon(Don $don): static
    {
        if (!$this->dons->contains($don)) {
            $this->dons->add($don);
            $don->setOrganisation($this);
        }

        return $this;
    }

    public function removeDon(Don $don): static
    {
        if ($this->dons->removeElement($don)) {
            // set the owning side to null (unless already changed)
            if ($don->getOrganisation() === $this) {
                $don->setOrganisation(null);
            }
        }

        return $this;
    }
    
    public function __toString()
    {
        return $this->getNom();
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

   

  
}
