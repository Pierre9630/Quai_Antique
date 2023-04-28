<?php

namespace App\Entity;

use App\Repository\FormulasRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormulasRepository::class)]
class Formulas
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?float $formula_price = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $formula_description = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $image = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getFormulaPrice(): ?float
    {
        return $this->formula_price;
    }

    public function setFormulaPrice(float $formula_price): self
    {
        $this->formula_price = $formula_price;

        return $this;
    }

    public function getFormulaDescription(): ?string
    {
        return $this->formula_description;
    }

    public function setFormulaDescription(?string $formula_description): self
    {
        $this->formula_description = $formula_description;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }
}
