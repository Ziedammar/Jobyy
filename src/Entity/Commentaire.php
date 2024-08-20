<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=CommentaireRepository::class)
 */
class Commentaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")

     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)

     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)

     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255)

     */
    private $subject;

    /**
     * @ORM\Column(type="integer")

     */
    private $mobile;

    /**
     * @ORM\Column(type="string", length=255)
     *@Assert\NotBlank(message="commentaire is required")

     */
    private $commentaire;

    /**
     * @ORM\Column(type="date")

     */
    private $date;



    /**
     * @return mixed
     */
    public function getBlogId()
    {
        return $this->blog_id;
    }

    /**
     * @param mixed $blog_id
     */
    public function setBlogId($blog_id): void
    {
        $this->blog_id = $blog_id;
    }
    /**
     * @ORM\Column(type="integer")

     */
    private $blog_id;
    /**
     * @ORM\Column(type="integer")

     */
    private $rate;


    public function getRate()
    {
        return $this->rate;
    }

    /**
     * @param mixed $rate
     */
    public function setRate($rate): void
    {
        $this->rate = $rate;
    }
    /**
     * @ORM\ManyToMany(targetEntity=Candidate::class, mappedBy="commentaire")
     */
    private $candidate;

    public function __construct()
    {
        $this->candidate = new ArrayCollection();
    }

    public function getId(): ?int
    {

        return $this->id;
    }

    public function getUser(): ?int
    {
        return $this->user;
    }

    public function setUser(int $user): self
    {
        $this->user = $user;

        return $this;
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

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getMobile(): ?int
    {
        return $this->mobile;
    }

    public function setMobile(int $mobile): self
    {
        $this->mobile = $mobile;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

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


    /**
     * @return Collection|Candidate[]
     */
    public function getCandidate(): Collection
    {
        return $this->candidate;
    }

    public function addCandidate(Candidate $candidate): self
    {
        if (!$this->candidate->contains($candidate)) {
            $this->candidate[] = $candidate;
            $candidate->addCommentaire($this);
        }

        return $this;
    }

    public function removeCandidate(Candidate $candidate): self
    {
        if ($this->candidate->removeElement($candidate)) {
            $candidate->removeCommentaire($this);
        }

        return $this;
    }
}
