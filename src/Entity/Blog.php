<?php

namespace App\Entity;

use App\Repository\BlogRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BlogRepository::class)
 */
class Blog
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
     *@Assert\NotBlank(message="categorie is required")

     */
    private $cat;

    /**
     * @ORM\Column(type="date")
     *@Assert\NotBlank(message="Date is required")

     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     *@Assert\NotBlank(message="Contenu is required")

     */
    private $contenu;
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Titre is required")

     */
    private $titre;

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }



    /**
     * @param mixed $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
    }
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;


    /**
     * @return mixed
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param mixed $titire
     */
    public function setTitre($titre): void
    {
        $this->titre = $titre;
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

    public function getCat(): ?string
    {
        return $this->cat;
    }

    public function setCat(string $cat): self
    {
        $this->cat = $cat;

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

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }



}
