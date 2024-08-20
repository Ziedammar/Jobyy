<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReclamationRepository::class)
 */
class Reclamation
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
    private $user_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $user_email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $subject;

    /**
     * @ORM\Column(type="text")
     */
    private $claim;

    /**
     * @ORM\Column(type="string")
     */
    private $SubmitDate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Cstatus;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getUserEmail(): ?string
    {
        return $this->user_email;
    }

    public function setUserEmail(string $user_email): self
    {
        $this->user_email = $user_email;

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

    public function getClaim(): ?string
    {
        return $this->claim;
    }

    public function setClaim(string $claim): self
    {
        $this->claim = $claim;

        return $this;
    }

    public function getSubmitDate(): ?string
    {
        return $this->SubmitDate;
    }

    public function setSubmitDate( $SubmitDate): self
    {
        $this->SubmitDate = $SubmitDate;

        return $this;
    }

    public function getCstatus(): ?bool
    {
        return $this->Cstatus;
    }

    public function setCstatus(bool $Cstatus): self
    {
        $this->Cstatus = $Cstatus;

        return $this;
    }
}
