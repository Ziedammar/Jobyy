<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
class Categorie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="this field is required");
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\NotBlank(message="this field is required");
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=Formation::class, mappedBy="idcategorie")
     */
    private $idformation;

    /**
     * @ORM\Column(type="string", length=7, nullable=true)
     */
    private $color;

    public function __construct()
    {
        $this->idformation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Formation[]
     */
    public function getIdFormation(): Collection
    {
        return $this->idformation;
    }

    public function addIdFormation(Formation $idFormation): self
    {
        if (!$this->idformation->contains($idFormation)) {
            $this->idformation[] = $idFormation;
            $idFormation->setIdCategorie($this);
        }

        return $this;
    }

    public function removeIdFormation(Formation $idFormation): self
    {
        if ($this->idformation->removeElement($idFormation)) {
            // set the owning side to null (unless already changed)
            if ($idFormation->getIdCategorie() === $this) {
                $idFormation->setIdCategorie(null);
            }
        }

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }
}
