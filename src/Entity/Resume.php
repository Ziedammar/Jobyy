<?php

namespace App\Entity;

use App\Repository\ResumeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResumeRepository::class)
 */
class Resume
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
    private $martial;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $military;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $education;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $skills;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $experience;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $projects;

    /**
     * @ORM\Column(type="integer")
     */
    private $user_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $interests;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMartial(): ?string
    {
        return $this->martial;
    }

    public function setMartial(string $martial): self
    {
        $this->martial = $martial;

        return $this;
    }

    public function getMilitary(): ?string
    {
        return $this->military;
    }

    public function setMilitary(string $military): self
    {
        $this->military = $military;

        return $this;
    }

    public function getEducation(): ?string
    {
        return $this->education;
    }

    public function setEducation(string $education): self
    {
        $this->education = $education;

        return $this;
    }

    public function getSkills(): ?string
    {
        return $this->skills;
    }

    public function setSkills(string $skills): self
    {
        $this->skills = $skills;

        return $this;
    }

    public function getExperience(): ?string
    {
        return $this->experience;
    }

    public function setExperience(string $experience): self
    {
        $this->experience = $experience;

        return $this;
    }

    public function getProjects(): ?string
    {
        return $this->projects;
    }

    public function setProjects(string $projects): self
    {
        $this->projects = $projects;

        return $this;
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

    public function getInterests(): ?string
    {
        return $this->interests;
    }

    public function setInterests(string $interests): self
    {
        $this->interests = $interests;

        return $this;
    }
}
