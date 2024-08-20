<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=FormationRepository::class)
 */
class Formation
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
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="this field is required");
     */
    private $prix;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $secteur;

    /**
     * @ORM\ManyToMany(targetEntity=User::class)
     */
    private $iduser;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="idformation")
     */
    private $idcategorie;

    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThanOrEqual("today ")
     */
    private $date;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThan(propertyPath="date")
     */
    private $datefin;

    /**
     * @ORM\OneToMany(targetEntity=FormationLike::class, mappedBy="formation")
     */
    private $likes;


    /**
     * @ORM\OneToMany(targetEntity=FormationDislike::class, mappedBy="formation")
     */
    private $dislikes;
    /**
     * @ORM\Column(type="string", length=7)
     */
    private $backcolor;

    /**
     * @ORM\Column(type="string", length=7)
     */
    private $bordercolor;

    /**
     * @ORM\Column(type="string", length=7)
     */
    private $textcolor;




    public function __construct()
    {
        $this->iduser = new ArrayCollection();
        $this->likes = new ArrayCollection();
        $this->dislikes = new ArrayCollection();
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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

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

    public function getSecteur(): ?string
    {
        return $this->secteur;
    }

    public function setSecteur(string $secteur): self
    {
        $this->secteur = $secteur;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getIdUser(): Collection
    {
        return $this->iduser;
    }

    public function addIdUser(User $idUser): self
    {
        if (!$this->iduser->contains($idUser)) {
            $this->iduser[] = $idUser;
        }

        return $this;
    }

    public function removeIdUser(User $idUser): self
    {
        $this->id_user->removeElement($idUser);

        return $this;
    }

    public function getIdCategorie(): ?Categorie
    {
        return $this->idcategorie;
    }

    public function setIdCategorie(?Categorie $idcategorie): self
    {
        $this->idcategorie = $idcategorie;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getDatefin(): ?\DateTimeInterface
    {
        return $this->datefin;
    }

    public function setDatefin(\DateTimeInterface $datefin): self
    {
        $this->datefin = $datefin;

        return $this;
    }

    /**
     * @param \App\Entity\User $user
     * @return boolean
     * */
    public function isconn(User $user): bool
    {
        foreach ($this->iduser as $id){
            if($id=== $user)
                return true;
        }
        return false;
    }

    /**
     * @return Collection|FormationLike[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(FormationLike $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setFormation($this);
        }

        return $this;
    }

    public function removeLike(FormationLike $like): self
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getFormation() === $this) {
                $like->setFormation(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection|FormationDislike[]
     */
    public function getDislikes(): Collection
    {
        return $this->dislikes;
    }

    public function addDislike(FormationDislike  $dislike): self
    {
        if (!$this->dislikes->contains($dislike)) {
            $this->dislikes[] = $dislike;
            $dislike->setFormation($this);
        }

        return $this;
    }

    public function removeDislike(FormationDislike $dislike): self
    {
        if ($this->dislikes->removeElement($dislike)) {
            // set the owning side to null (unless already changed)
            if ($dislike->getFormation() === $this) {
                $dislike->setFormation(null);
            }
        }

        return $this;
    }




    /**
     * @param \App\Entity\User $user
     * @return boolean
     * */
    public function islikedbyUser(User $user): bool
    {
        foreach ($this->likes as $like){
            if($like->getUser() === $user)
                return true;
        }
        return false;
    }



    /**
     * @param \App\Entity\User $user
     * @return boolean
     * */
    public function isdislikedbyUser(User $user): bool
    {
        foreach ($this->dislikes as $dislike){
            if($dislike->getUser() === $user)
                return true;
        }
        return false;
    }



    public function getBackcolor(): ?string
    {
        return $this->backcolor;
    }

    public function setBackcolor(string $backcolor): self
    {
        $this->backcolor = $backcolor;

        return $this;
    }

    public function getBordercolor(): ?string
    {
        return $this->bordercolor;
    }

    public function setBordercolor(string $bordercolor): self
    {
        $this->bordercolor = $bordercolor;

        return $this;
    }

    public function getTextcolor(): ?string
    {
        return $this->textcolor;
    }

    public function setTextcolor(string $textcolor): self
    {
        $this->textcolor = $textcolor;

        return $this;
    }

}
