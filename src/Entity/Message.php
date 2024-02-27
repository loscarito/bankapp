<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 */
class Message
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fromu;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fromemail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $smalldesc;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $toa;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $subject;
    /**
     * @ORM\Column(type="boolean", length=255)
     */
    private $isRead;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;



    /**
     *@ORM\ManyToOne(targetEntity="App\Entity\User",inversedBy="user")
     *@ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime", length=255)
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFromu(): ?string
    {
        return $this->fromu;
    }

    public function setFromu(string $fromu): self
    {
        $this->fromu = $fromu;

        return $this;
    }

    public function getToa(): ?string
    {
        return $this->toa;
    }

    public function setToa(string $toa): self
    {
        $this->toa = $toa;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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

    public function getFromemail(): ?string
    {
        return $this->fromemail;
    }

    public function setFromemail(string $fromemail): self
    {
        $this->fromemail = $fromemail;

        return $this;
    }

    public function getSmalldesc(): ?string
    {
        return $this->smalldesc;
    }

    public function setSmalldesc(string $smalldesc): self
    {
        $this->smalldesc = $smalldesc;

        return $this;
    }

    public function getIsRead(): ?bool
    {
        return $this->isRead;
    }

    public function setIsRead(bool $isRead): self
    {
        $this->isRead = $isRead;

        return $this;
    }


}
