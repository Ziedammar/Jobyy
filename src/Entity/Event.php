<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;



    /**
     * @ORM\Column(type="integer")
     *@Assert\NotBlank(message="nbr is required")

     */
    private $nbr;
    /**
     * @ORM\Column(type="integer")

     */
    private $par_id;

    /**
     * @return mixed
     */
    public function getEntId()
    {
        return $this->ent_id;
    }

    /**
     * @param mixed $ent_id
     */
    public function setEntId($ent_id): void
    {
        $this->ent_id = $ent_id;
    }
    /**
     * @ORM\Column(type="integer")

     */
    private $ent_id;

    /**
     * @return mixed
     */
    public function getParId()
    {
        return $this->par_id;
    }

    /**
     * @param mixed $par_id
     */
    public function setParId($par_id): void
    {
        $this->par_id = $par_id;
    }

    /**
     * @ORM\Column(type="date")
     *  *@Assert\Date / DateTime(message="data is required")

     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     *@Assert\NotBlank(message="description is required")

     */
    private $description;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;
    /**
     *@ORM\ManyToOne(targetEntity="Map")
     *@ORM\JoinColumn(name="lieu", referencedColumnName="id")
     *
     */
    private $lieu;

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom): void
    {
        $this->nom = $nom;
    }
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\ManyToMany(targetEntity=Participant::class, mappedBy="event")
     */
    private $participant;

    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class, inversedBy="events")
     */
    private $entreprise;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $categorie;

    /**
     * @ORM\Column(type="date")
     */
    private $datefin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $backcolor;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bordercolor;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $textcolor;


    public function __construct()
    {
        $this->participant = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdComp(): ?int
    {
        return $this->id_comp;
    }

    public function setIdComp(int $id_comp): self
    {
        $this->id_comp = $id_comp;

        return $this;
    }

    public function getNbr(): ?int
    {
        return $this->nbr;
    }

    public function setNbr(int $nbr): self
    {
        $this->nbr = $nbr;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|Participant[]
     */
    public function getParticipant(): Collection
    {
        return $this->participant;
    }

    public function addParticipant(Participant $participant): self
    {
        if (!$this->participant->contains($participant)) {
            $this->participant[] = $participant;
            $participant->addEvent($this);
        }

        return $this;
    }

    public function removeParticipant(Participant $participant): self
    {
        if ($this->participant->removeElement($participant)) {
            $participant->removeEvent($this);
        }

        return $this;
    }

    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLieu()
    {
        return $this->lieu;
    }

    /**
     * @param mixed $lieu
     */
    public function setLieu($lieu): void
    {
        $this->lieu = $lieu;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

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
