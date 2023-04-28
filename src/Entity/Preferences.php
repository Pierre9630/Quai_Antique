<?php

namespace App\Entity;

use App\Repository\PreferencesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PreferencesRepository::class)]
class Preferences
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'preferences', cascade: ['persist', 'remove'])]
    private ?User $user_preferences = null;

    #[ORM\Column(nullable: true)]
    private ?int $nb_cutlery = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $allergies = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserPreferences(): ?User
    {
        return $this->user_preferences;
    }

    public function setUserPreferences(?User $user_preferences): self
    {
        $this->user_preferences = $user_preferences;

        return $this;
    }

    public function getNbCutlery(): ?int
    {
        return $this->nb_cutlery;
    }

    public function setNbCutlery(?int $nb_cutlery): self
    {
        $this->nb_cutlery = $nb_cutlery;

        return $this;
    }

    public function getAllergies(): ?string
    {
        return $this->allergies;
    }

    public function setAllergies(?string $allergies): self
    {
        $this->allergies = $allergies;

        return $this;
    }
}
