<?php

namespace App\Entity;

use App\Repository\CandidatureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CandidatureRepository::class)
 */
class Candidature
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etat;

    /**
     * @ORM\Column(type="string", length=255 ,nullable=true)
     */
    private $commentaire;

   

    /**
     * @ORM\ManyToOne(targetEntity=Candidate::class, inversedBy="candidatures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $candidate_id;

    /**
     * @ORM\Column(type="date")
     */
    private $date_postuler;

    /**
     * @ORM\OneToMany(targetEntity=Interview::class, mappedBy="cand")
     */
    private $interviews;

    /**
     * @ORM\ManyToOne(targetEntity=Offre::class, inversedBy="yes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $offre;

    public function __construct()
    {
        $this->interviews = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

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


    public function getCandidateId(): ?Candidate
    {
        return $this->candidate_id;
    }

    public function setCandidateId(?Candidate $candidate_id): self
    {
        $this->candidate_id = $candidate_id;

        return $this;
    }

    public function getDatePostuler(): ?\DateTimeInterface
    {
        return $this->date_postuler;
    }

    public function setDatePostuler(\DateTimeInterface $date_postuler): self
    {
        $this->date_postuler = $date_postuler;

        return $this;
    }

    /**
     * @return Collection|Interview[]
     */
    public function getInterviews(): Collection
    {
        return $this->interviews;
    }

    public function addInterview(Interview $interview): self
    {
        if (!$this->interviews->contains($interview)) {
            $this->interviews[] = $interview;
            $interview->setCand($this);
        }

        return $this;
    }

    public function removeInterview(Interview $interview): self
    {
        if ($this->interviews->removeElement($interview)) {
            // set the owning side to null (unless already changed)
            if ($interview->getCand() === $this) {
                $interview->setCand(null);
            }
        }

        return $this;
    }

    public function getOffre(): ?Offre
    {
        return $this->offre;
    }

    public function setOffre(?Offre $offre): self
    {
        $this->offre = $offre;

        return $this;
    }
}
