<?php

namespace App\Entity;

use App\Repository\UserRepository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use FOS\UserBundle\Model\User as BaseUser;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="user")
 */

class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
    * @ORM\Column(type="string", length=30, nullable = true)
    */
    private $first_name;

    /**
    * @ORM\Column(type="string", length=30, nullable = true)
    */
    private $last_name;

    /**
     * @ORM\Column(type="string", length=30, nullable = true)
     */
    private $company_name;

    /**
    * @ORM\Column(type="string", length=50, nullable = true)
    */
    private $address;

    /**
    * @ORM\Column(type="string", length=15, nullable = true)
    */
    private $zipcode;

    /**
    * @ORM\Column(type="string", length=30, nullable = true)
    */
    private $city;

    /**
    * @ORM\Column(type="string", length=25, nullable = true)
    */
    private $phone_number;

    /**
    * @ORM\Column(type="string", length=20, nullable = true)
    */
    private $date_of_birth;

    /**
    * @ORM\Column(type="text", nullable=true)
    */
    private $description;

    /**
    * @ORM\Column(type="string", length=255, nullable=true)
    */
    private $profile_picture_url;

    /**
    * @ORM\Column(type="string", length=255, nullable=true)
    */
    private $cv_url;

    /**
     * @ORM\OneToMany(targetEntity=Vacancy::class, mappedBy="user", orphanRemoval=true)
     */
    private $vacancies;

    /**
     * @ORM\OneToMany(targetEntity=Application::class, mappedBy="user")
     */
    private $applications;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $type;

    public function __construct()
    {
        parent::__construct();
        // your own logic
        $this->roles = array( 'ROLE_CANDIDATE');
        $this->vacancies = new ArrayCollection();
        $this->applications = new ArrayCollection();
    }

    public function getID(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string 
    { 
        return $this->last_name;
    }

    public function setLastName(string $last_name): self 
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getCompanyName(): ?string 
    {
        return $this->company_name;
    }

    public function setCompanyName(string $company_name): self
    {
        $this->company_name = $company_name;

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

    public function getZipcode(): ?string 
    {
        return $this->zipcode;
    }

    public function setZipcode(string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getCity(): ?string 
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPhoneNumber(): ?string 
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(string $phone_number): self
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getDateOfBirth(): ?string
    {
        return $this->date_of_birth;
    }

    public function setDateOfBirth(string $date_of_birth): self
    {
        $this->date_of_birth = $date_of_birth;

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

    public function getProfilePictureURL(): ?string 
    {
        return $this->profile_picture_url;
    }

    public function setProfilePictureURL(string $profile_picture_url): self
    {
        $this->profile_picture_url = $profile_picture_url;

        return $this;
    }

    public function getCV(): ?string 
    {
        return $this->cv_url;
    }

    public function setCV(string $cv_url): self
    {
        $this->cv_url = $cv_url;
        
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

    /**
     * @return Collection|Vacancy[]
     */
    public function getVacancies(): Collection
    {
        return $this->vacancies;
    }

    public function addVacancy(Vacancy $vacancy): self
    {
        if (!$this->vacancies->contains($vacancy)) {
            $this->vacancies[] = $vacancy;
            $vacancy->setUser($this);
        }

        return $this;
    }

    public function removeVacancy(Vacancy $vacancy): self
    {
        if ($this->vacancies->contains($vacancy)) {
            $this->vacancies->removeElement($vacancy);
            // set the owning side to null (unless already changed)
            if ($vacancy->getUser() === $this) {
                $vacancy->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Application[]
     */
    public function getApplications(): Collection
    {
        return $this->applications;
    }

    public function addApplication(Application $application): self
    {
        if (!$this->applications->contains($application)) {
            $this->applications[] = $application;
            $application->setUser($this);
        }

        return $this;
    }

    public function removeApplication(Application $application): self
    {
        if ($this->applications->contains($application)) {
            $this->applications->removeElement($application);
            // set the owning side to null (unless already changed)
            if ($application->getUser() === $this) {
                $application->setUser(null);
            }
        }

        return $this;
    }
}
