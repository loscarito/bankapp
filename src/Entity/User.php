<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="integer")
     */
    private $tel;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $countries;

    
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $states;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $cities;

    /**
     * @ORM\Column(type="datetime", length=255)
     */
    private $date;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="boolean")
     */
    private $eligible;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $employer;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $employee;

    /**
     * @ORM\Column(type="integer")
     */
    private $salary;

    /**
     *@ORM\Column(type="string", length=255)
     */
    private $security1;

    /**
     *@ORM\Column(type="string", length=255)
     */
    private $security2;

    /**
     *@ORM\Column(type="string", length=255)
     */
    private $security3;

    /**
     *@ORM\Column(type="string", length=255)
     */
    private $answer1;

    /**
     *@ORM\Column(type="string", length=255)
     */
    private $answer2;

    /**
     *@ORM\Column(type="string", length=255)
     */
    private $answer3;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $postal;


    /**
     * @ORM\Column(type="integer")
     */
    private $pin;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Account", mappedBy="user")
     */
    private $account;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Image")
     */
    private $image;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Compte",cascade={"persist"})
     */
    private $compte;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="user")
     */
    private $messages;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Notification", mappedBy="user")
     */
    private $notifications;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Receptor", mappedBy="user")
     */
    private $receptors;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Loan", mappedBy="user")
     */
    private $loan;

   
    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->notifications = new ArrayCollection();
        $this->loan = new ArrayCollection();
        $this->receptors = new ArrayCollection();
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTel(): ?int
    {
        return $this->tel;
    }

    public function setTel(int $tel): self
    {
        $this->tel = $tel;

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

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getPostal(): ?string
    {
        return $this->postal;
    }

    public function setPostal(string $postal): self
    {
        $this->postal = $postal;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getPin(): ?int
    {
        return $this->pin;
    }

    public function setPin(int $pin): self
    {
        $this->pin = $pin;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(?Account $account): self
    {
        $this->account = $account;

        // set (or unset) the owning side of the relation if necessary
        $newUser = null === $account ? null : $this;
        if ($account->getUser() !== $newUser) {
            $account->setUser($newUser);
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setUser($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getUser() === $this) {
                $message->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Notification[]
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(Notification $notification): self
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications[] = $notification;
            $notification->setUser($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): self
    {
        if ($this->notifications->contains($notification)) {
            $this->notifications->removeElement($notification);
            // set the owning side to null (unless already changed)
            if ($notification->getUser() === $this) {
                $notification->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Loan[]
     */
    public function getLoan(): Collection
    {
        return $this->loan;
    }

    public function addLoan(Loan $loan): self
    {
        if (!$this->loan->contains($loan)) {
            $this->loan[] = $loan;
            $loan->setUser($this);
        }

        return $this;
    }

    public function removeLoan(Loan $loan): self
    {
        if ($this->loan->contains($loan)) {
            $this->loan->removeElement($loan);
            // set the owning side to null (unless already changed)
            if ($loan->getUser() === $this) {
                $loan->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Receptor[]
     */
    public function getReceptors(): Collection
    {
        return $this->receptors;
    }

    public function addReceptor(Receptor $receptor): self
    {
        if (!$this->receptors->contains($receptor)) {
            $this->receptors[] = $receptor;
            $receptor->setUser($this);
        }

        return $this;
    }

    public function removeReceptor(Receptor $receptor): self
    {
        if ($this->receptors->contains($receptor)) {
            $this->receptors->removeElement($receptor);
            // set the owning side to null (unless already changed)
            if ($receptor->getUser() === $this) {
                $receptor->setUser(null);
            }
        }

        return $this;
    }

    public function getCompte(): ?Compte
    {
        return $this->compte;
    }

    public function setCompte(?Compte $compte): self
    {
        $this->compte = $compte;

        return $this;
    }

    
    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getEligible(): ?bool
    {
        return $this->eligible;
    }

    public function setEligible(bool $eligible): self
    {
        $this->eligible = $eligible;

        return $this;
    }

    public function getEmployer(): ?string
    {
        return $this->employer;
    }

    public function setEmployer(string $employer): self
    {
        $this->employer = $employer;

        return $this;
    }

    public function getEmployee(): ?string
    {
        return $this->employee;
    }

    public function setEmployee(string $employee): self
    {
        $this->employee = $employee;

        return $this;
    }

    public function getSalary(): ?int
    {
        return $this->salary;
    }

    public function setSalary(int $salary): self
    {
        $this->salary = $salary;

        return $this;
    }

    public function getSecurity1(): ?string
    {
        return $this->security1;
    }

    public function setSecurity1(string $security1): self
    {
        $this->security1 = $security1;

        return $this;
    }

    public function getSecurity2(): ?string
    {
        return $this->security2;
    }

    public function setSecurity2(string $security2): self
    {
        $this->security2 = $security2;

        return $this;
    }

    public function getSecurity3(): ?string
    {
        return $this->security3;
    }

    public function setSecurity3(string $security3): self
    {
        $this->security3 = $security3;

        return $this;
    }

    public function getAnswer1(): ?string
    {
        return $this->answer1;
    }

    public function setAnswer1(string $answer1): self
    {
        $this->answer1 = $answer1;

        return $this;
    }

    public function getAnswer2(): ?string
    {
        return $this->answer2;
    }

    public function setAnswer2(string $answer2): self
    {
        $this->answer2 = $answer2;

        return $this;
    }

    public function getAnswer3(): ?string
    {
        return $this->answer3;
    }

    public function setAnswer3(string $answer3): self
    {
        $this->answer3 = $answer3;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCountries(): ?string
    {
        return $this->countries;
    }

    public function setCountries(string $countries): self
    {
        $this->countries = $countries;

        return $this;
    }

    public function getStates(): ?string
    {
        return $this->states;
    }

    public function setStates(string $states): self
    {
        $this->states = $states;

        return $this;
    }

    public function getCities(): ?string
    {
        return $this->cities;
    }

    public function setCities(string $cities): self
    {
        $this->cities = $cities;

        return $this;
    }
}
