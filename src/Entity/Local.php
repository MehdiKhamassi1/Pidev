<?php

namespace App\Entity;

use App\Repository\LocalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: LocalRepository::class)]
class Local
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[ORM\ManyToOne(inversedBy: 'Local',cascade: ['remove'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'Le nom ne peut pas etre vide')]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'L adresse ne peut pas etre vide')]
    private ?string $adresse = null;

    #[ORM\OneToMany(targetEntity: Rendezvouz::class, mappedBy: 'local')]
    private Collection $rendezvouzs;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    public function __construct()
    {
        $this->rendezvouzs = new ArrayCollection();
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

    /**
     * @return Collection<int, Rendezvouz>
     */
    public function getRendezvouzs(): Collection
    {
        return $this->rendezvouzs;
    }

    public function addRendezvouz(Rendezvouz $rendezvouz): static
    {
        if (!$this->rendezvouzs->contains($rendezvouz)) {
            $this->rendezvouzs->add($rendezvouz);
            $rendezvouz->setLocal($this);
        }

        return $this;
    }

    public function removeRendezvouz(Rendezvouz $rendezvouz): static
    {
        if ($this->rendezvouzs->removeElement($rendezvouz)) {
            // set the owning side to null (unless already changed)
            if ($rendezvouz->getLocal() === $this) {
                $rendezvouz->setLocal(null);
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
