<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=OffreRepository::class)
 */
class Offre
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
     * @Assert\Email(message="Put valid mail");
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $logo;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="this field is required");
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="this field is required");
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=CategorieOffre::class, inversedBy="offres")
     */
    private $idcategorie;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="offres")
     */
    private $iduser;

    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class, inversedBy="yes")
     */
    private $enteprise;

    /**
     * @ORM\OneToMany(targetEntity=Candidature::class, mappedBy="offre", orphanRemoval=true)
     */
    private $yes;

    public function __construct()
    {
        $this->yes = new ArrayCollection();
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIdcategorie(): ?categorieoffre
    {
        return $this->idcategorie;
    }

    public function setIdcategorie(?categorieoffre $idcategorie): self
    {
        $this->idcategorie = $idcategorie;

        return $this;
    }

    public function getIduser(): ?User
    {
        return $this->iduser;
    }

    public function setIduser(?User $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }

    public function getEnteprise(): ?Entreprise
    {
        return $this->enteprise;
    }

    public function setEnteprise(?Entreprise $enteprise): self
    {
        $this->enteprise = $enteprise;

        return $this;
    }

    /**
     * @return Collection|Candidature[]
     */
    public function getYes(): Collection
    {
        return $this->yes;
    }

    public function addYe(Candidature $ye): self
    {
        if (!$this->yes->contains($ye)) {
            $this->yes[] = $ye;
            $ye->setOffre($this);
        }

        return $this;
    }

    public function removeYe(Candidature $ye): self
    {
        if ($this->yes->removeElement($ye)) {
            // set the owning side to null (unless already changed)
            if ($ye->getOffre() === $this) {
                $ye->setOffre(null);
            }
        }

        return $this;
    }
}
