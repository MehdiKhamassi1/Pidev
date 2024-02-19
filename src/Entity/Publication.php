<?php

namespace App\Entity;

use App\Repository\PublicationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PublicationRepository::class)]
class Publication
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $contenu = null;

    #[ORM\OneToMany(targetEntity: Commentaire::class, mappedBy: 'publication')]
    private Collection $Publication;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Patient $Patient = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Docteur $Docteur = null;

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
}
