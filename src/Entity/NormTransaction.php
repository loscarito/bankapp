<?php

namespace App\Entity;

use App\Repository\NormTransactionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NormTransactionRepository::class)
 */
class NormTransaction extends Transaction
{

}
