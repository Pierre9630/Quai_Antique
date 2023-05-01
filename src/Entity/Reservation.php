<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_res = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_res = null;

    #[ORM\Column]
    private ?int $nb_cutlery = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $allergies = null;

    #[ORM\Column]
    #[Assert\DateTime]
    private ?\DateTimeImmutable $reservation_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserRes(): ?User
    {
        return $this->user_res;
    }

    public function setUserRes(?User $user_res): self
    {
        $this->user_res = $user_res;

        return $this;
    }

    public function getDateRes(): ?\DateTimeInterface
    {
        return $this->date_res;
    }

    public function setDateRes(\DateTimeInterface $date_res): self
    {
        $this->date_res = $date_res;

        return $this;
    }

    public function getNbCutlery(): ?int
    {
        return $this->nb_cutlery;
    }

    public function setNbCutlery(int $nb_cutlery): self
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

    public function getReservationAt(): ?\DateTimeImmutable
    {
        return $this->reservation_at;
    }

    public function setReservationAt(\DateTimeImmutable $reservation_at): self
    {
        $this->reservation_at = $reservation_at;

        return $this;
    }
}
