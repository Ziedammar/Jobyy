<?php

namespace App\Entity;

use App\Repository\FriendshipRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FriendshipRepository::class)
 */
class Friendship
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
     * @ORM\Column(type="integer")
     */
    private $friend;

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

    public function getFriend(): ?int
    {
        return $this->friend;
    }

    public function setFriend(int $friend): self
    {
        $this->friend = $friend;

        return $this;
    }
}
