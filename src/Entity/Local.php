<?php

namespace App\Entity;

use App\Repository\LocalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocalRepository::class)]
class Local
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\OneToMany(targetEntity: Rendezvouz::class, mappedBy: 'local')]
    private Collection $rendezvouzs;

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
}
