<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"transaction" = "Transaction", "intlTransaction" = "IntlTransaction","normTransaction" = "NormTransaction" })
 */
class Transaction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;

    /**
     * @ORM\Column(type="integer")
     */
    protected $reference;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $description;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $isDebit;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $isCredit;

    /**
     * @ORM\Column(type="bigint")
     */
    protected $Amount;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $status;

    /**
     * @ORM\Column(type="integer")
     */
    protected $level;

    /**
     *@ORM\ManyToOne(targetEntity="App\Entity\Account",inversedBy="account")
     *@ORM\JoinColumn(nullable=true)
     */
    protected $account;

    /**
     * @ORM\OneToMany(targetEntity=InfoTr::class, mappedBy="transaction")
     */
    private $infoTrs;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $depositor;

   

    public function __construct()
    {
        $this->infoTrs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getReference(): ?int
    {
        return $this->reference;
    }

    public function setReference(int $reference): self
    {
        $this->reference = $reference;

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

    public function getIsDebit(): ?bool
    {
        return $this->isDebit;
    }

    public function setIsDebit(bool $isDebit): self
    {
        $this->isDebit = $isDebit;

        return $this;
    }

    public function getIsCredit(): ?bool
    {
        return $this->isCredit;
    }

    public function setIsCredit(bool $isCredit): self
    {
        $this->isCredit = $isCredit;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->Amount;
    }

    public function setAmount(int $Amount): self
    {
        $this->Amount = $Amount;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(?Account $account): self
    {
        $this->account = $account;

        return $this;
    }

    /**
     * @return Collection|InfoTr[]
     */
    public function getInfoTrs(): Collection
    {
        return $this->infoTrs;
    }

    public function addInfoTr(InfoTr $infoTr): self
    {
        if (!$this->infoTrs->contains($infoTr)) {
            $this->infoTrs[] = $infoTr;
            $infoTr->setTransaction($this);
        }

        return $this;
    }

    public function removeInfoTr(InfoTr $infoTr): self
    {
        if ($this->infoTrs->removeElement($infoTr)) {
            // set the owning side to null (unless already changed)
            if ($infoTr->getTransaction() === $this) {
                $infoTr->setTransaction(null);
            }
        }

        return $this;
    }

    public function getDepositor(): ?string
    {
        return $this->depositor;
    }

    public function setDepositor(string $depositor): self
    {
        $this->depositor = $depositor;

        return $this;
    }

   
}
