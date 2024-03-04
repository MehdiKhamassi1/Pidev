<?php

namespace App\Entity;

use App\Repository\DocteurRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DocteurRepository::class)]
class Docteur extends User
{
   

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'Le contenu ne peut pas etre vide')]

    private ?string $specialite = null;

   
    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(string $specialite): static
    {
        $this->specialite = $specialite;

        return $this;
    }
}
