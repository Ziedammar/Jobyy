<?php

namespace App\Entity;

use App\Repository\TestRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TestRepository::class)
 */
class Test
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
    private $haja;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHaja(): ?int
    {
        return $this->haja;
    }

    public function setHaja(int $haja): self
    {
        $this->haja = $haja;

        return $this;
    }
}
