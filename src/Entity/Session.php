<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
class Session
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateSessionDebut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateSessionFin = null;

    #[ORM\Column]
    private ?int $places = null;

    #[ORM\ManyToMany(targetEntity: Stagiaire::class, mappedBy: 'sessions')]
    private Collection $stagiaires;

    #[ORM\ManyToOne(inversedBy: 'session')]
    private ?Formation $formation = null;

    #[ORM\ManyToOne(inversedBy: 'sessions')]
    private ?Formateur $formateur = null;

    #[ORM\OneToMany(mappedBy: 'session', targetEntity: Programme::class)]
    private Collection $programmes;

    public function __construct()
    {
        $this->stagiaires = new ArrayCollection();
        $this->programmes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDateSessionDebut(): ?\DateTimeInterface
    {
        return $this->dateSessionDebut;
    }

    public function getDateSessionDebutFormat(): ?string
    {
        return $this->dateSessionDebut->format("Y-m-d");
    }

    public function setDateSessionDebut(\DateTimeInterface $dateSessionDebut): static
    {
        $this->dateSessionDebut = $dateSessionDebut;

        return $this;
    }

    public function getDateSessionFin(): ?\DateTimeInterface
    {
        return $this->dateSessionFin;
    }

    public function getDateSessionFinFormat(): ?string
    {
        return $this->dateSessionFin->format("Y-m-d");
    }


    public function setDateSessionFin(\DateTimeInterface $dateSessionFin): static
    {
        $this->dateSessionFin = $dateSessionFin;

        return $this;
    }

    public function getPlaces(): ?int
    {
        return $this->places;
    }

    // public function getPlacesRestantes($nbInscrits): ?int
    // {
    //     return $this->places - $nbInscrits;
    // }

    // public function setPlacesRestantes(int $places, int $nbInscrits): static
    // {
    //     $this->places = $places - $nbInscrits;

    //     return $this;
    // }

    public function setPlaces(int $places): static
    {
        $this->places = $places;

        return $this;
    }

    /**
     * @return Collection<int, Stagiaire>
     */
    public function getStagiaires(): Collection
    {
        return $this->stagiaires;
    }

    public function addStagiaire(Stagiaire $stagiaire): static
    {
        if (!$this->stagiaires->contains($stagiaire)) {
            $this->stagiaires->add($stagiaire);
            $stagiaire->addSession($this);
        }

        return $this;
    }

    public function removeStagiaire(Stagiaire $stagiaire): static
    {
        if ($this->stagiaires->removeElement($stagiaire)) {
            $stagiaire->removeSession($this);
        }

        return $this;
    }

    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    public function setFormation(?Formation $formation): static
    {
        $this->formation = $formation;

        return $this;
    }

    public function getFormateur(): ?Formateur
    {
        return $this->formateur;
    }

    public function setFormateur(?Formateur $formateur): static
    {
        $this->formateur = $formateur;

        return $this;
    }

    /**
     * @return Collection<int, Programme>
     */
    public function getProgrammes(): Collection
    {
        return $this->programmes;
    }

    public function addProgramme(Programme $programme): static
    {
        if (!$this->programmes->contains($programme)) {
            $this->programmes->add($programme);
            $programme->setSession($this);
        }

        return $this;
    }

    public function removeProgramme(Programme $programme): static
    {
        if ($this->programmes->removeElement($programme)) {
            // set the owning side to null (unless already changed)
            if ($programme->getSession() === $this) {
                $programme->setSession(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->titre;
    }
}
