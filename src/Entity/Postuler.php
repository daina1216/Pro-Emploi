<?php

namespace App\Entity;

use App\Repository\PostulerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostulerRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Postuler
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $createAt = null;

    #[ORM\ManyToOne(inversedBy: 'postuler')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $auteur = null;

    #[ORM\ManyToOne(inversedBy: 'postuler')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Jobs $offres = null;

    #[ORM\Column(length: 255)]
    private ?string $uploaderCV = null;

    #[ORM\Column(length: 255)]
    private ?string $localisation = null;

    #[ORM\Column]
    private ?int $salaireDesire = null;

    #[ORM\Column(nullable: true)]
    private ?bool $accept = null;

    #[ORM\Column(nullable: true)]
    private ?bool $refuse = null;


    #[ORM\PrePersist]
    public function onPrePersist(){
        $this->createAt = new \DateTime();
        
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): static
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getAuteur(): ?User
    {
        return $this->auteur;
    }

    public function setAuteur(?User $auteur): static
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getOffres(): ?Jobs
    {
        return $this->offres;
    }

    public function setOffres(?Jobs $offres): static
    {
        $this->offres = $offres;

        return $this;
    }

    public function getUploaderCV(): ?string
    {
        return $this->uploaderCV;
    }

    public function setUploaderCV(string $uploaderCV): static
    {
        $this->uploaderCV = $uploaderCV;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(string $localisation): static
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getSalaireDesire(): ?int
    {
        return $this->salaireDesire;
    }

    public function setSalaireDesire(int $salaireDesire): static
    {
        $this->salaireDesire = $salaireDesire;

        return $this;
    }

    public function isAccept(): ?bool
    {
        return $this->accept;
    }

    public function setAccept(?bool $accept): static
    {
        $this->accept = $accept;

        return $this;
    }

    public function isRefuse(): ?bool
    {
        return $this->refuse;
    }

    public function setRefuse(?bool $refuse): static
    {
        $this->refuse = $refuse;

        return $this;
    }


}
