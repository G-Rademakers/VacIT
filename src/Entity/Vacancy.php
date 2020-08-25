<?php

namespace App\Entity;

use App\Repository\VacancyRepository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VacancyRepository::class)
 */

class Vacancy
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="vacancies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Platform::class, inversedBy="vacancies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $platform;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $function;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $level;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $location;

    /**
     * @ORM\Column(type="text")
     */
    private $job_description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Logo;

    /**
     * @ORM\OneToMany(targetEntity=Application::class, mappedBy="vacancy", cascade={"remove"})
     */
    private $applications;

    /**
     * @ORM\Column(type="datetime")
     */
    private $vacancy_date;

    public function __construct()
    {
        $this->applications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPlatform(): ?Platform
    {
        return $this->platform;
    }

    public function setPlatform(?Platform $platform): self
    {
        $this->platform = $platform;

        return $this;
    }

    public function getFunction(): ?string
    {
        return $this->function;
    }

    public function setFunction(string $function): self
    {
        $this->function = $function;

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(string $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getJobDescription(): ?string
    {
        return $this->job_description;
    }

    public function setJobDescription(string $job_description): self
    {
        $this->job_description = $job_description;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->Logo;
    }

    public function setLogo(?string $Logo): self
    {
        $this->Logo = $Logo;

        return $this;
    }

    public function getVacancyDate(): ?\DateTimeInterface
    {
        return $this->vacancy_date;
    }

    public function setVacancyDate(\DateTimeInterface $vacancy_date): self
    {
        $this->vacancy_date = $vacancy_date;

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
            $application->setVacancy($this);
        }
        return $this;
    }

    public function removeApplication(Application $application): self
    {
        if ($this->applications->contains($application)) {
            $this->applications->removeElement($application);
            // set the owning side to null (unless already changed)
            if ($application->getVacancy() === $this) {
                $application->setVacancy(null);
            }
        }
        return $this;
    }
}
