<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use App\Repository\PublicationRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PublicationRepository::class)]
class Publication
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[ORM\OneToMany(mappedBy: 'pub', targetEntity: Commentaire::class, cascade: ['remove'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'Le contenu ne peut pas etre vide')]
    private ?string $contenu = null;

    #[ORM\OneToMany(targetEntity: Commentaire::class, mappedBy: 'publication')]
    private Collection $Publication;

    #[ORM\ManyToOne(cascade: ['persist', 'remove'])]
    private ?Patient $Patient = null;

    #[ORM\ManyToOne(cascade: ['persist', 'remove'])]
    private ?Docteur $Docteur = null;

    #[ORM\Column(length: 255)]
    #[Assert\Regex(
        pattern:"/^[A-Z]+$/",
        message:"Ce champ doit contenir uniquement des lettres majuscules")]
    private ?string $titre = null;
    
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    public function __construct()
    {
        $this->Publication = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getPublication(): Collection
    {
        return $this->Publication;
    }

    public function addPublication(Commentaire $publication): static
    {
        if (!$this->Publication->contains($publication)) {
            $this->Publication->add($publication);
            $publication->setPublication($this);
        }

        return $this;
    }

    public function removePublication(Commentaire $publication): static
    {
        if ($this->Publication->removeElement($publication)) {
            // set the owning side to null (unless already changed)
            if ($publication->getPublication() === $this) {
                $publication->setPublication(null);
            }
        }

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
    public function __toString()
    {
        return $this->getTitre();
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

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
}