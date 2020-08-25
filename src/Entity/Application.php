<?php

namespace App\Entity;

use App\Repository\ApplicationRepository;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ApplicationRepository::class)
 */

class Application
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="applications")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Vacancy::class, inversedBy="applications")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vacancy;

    /**
     * @ORM\Column(type="datetime")
     */
    private $application_date;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $invited;

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

    public function getVacancy(): ?Vacancy
    {
        return $this->vacancy;
    }

    public function setVacancy(?Vacancy $vacancy): self
    {
        $this->vacancy = $vacancy;

        return $this;
    }

    public function getApplicationDate(): ?\DateTimeInterface
    {
        return $this->application_date;
    }

    public function setApplicationDate(\DateTimeInterface $application_date): self
    {
        $this->application_date = $application_date;

        return $this;
    }

    public function getInvited(): ?bool
    {
        return $this->invited;
    }

    public function setInvited(?bool $invited): self
    {
        $this->invited = $invited;

        return $this;
    }
}
