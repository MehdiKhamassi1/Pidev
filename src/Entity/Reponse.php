<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\ReponseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReponseRepository::class)]
class Reponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[ORM\ManyToOne(inversedBy: 'reponses',cascade: ['remove'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'Le contenu ne peut pas etre vide')]
    private ?string $response = null;

    #[ORM\ManyToOne(inversedBy: 'reponses')]
    private ?Reclamation $Reclamation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getResponse(): ?string
    {
        return $this->response;
    }

    public function setResponse(string $response): static
    {
        $this->response = $response;

        return $this;
    }

    public function getReclamation(): ?Reclamation
    {
        return $this->Reclamation;
    }

    public function setReclamation(?Reclamation $Reclamation): static
    {
        $this->Reclamation = $Reclamation;

        return $this;
    }
    public function __toString()
    {
        return $this->getResponse();
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }
}
