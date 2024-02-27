<?php

namespace App\Entity;

use App\Repository\IntlTransactionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=IntlTransactionRepository::class)
 */
class IntlTransaction extends Transaction
{
    /**
     * @ORM\ManyToOne(targetEntity=Receptor::class, inversedBy="transactions")
     */
    private $recipient;


    public function getRecipient(): ?Receptor
    {
        return $this->recipient;
    }

    public function setRecipient(?Receptor $recipient): self
    {
        $this->recipient = $recipient;

        return $this;
    }
	

    
}
