<?php

namespace App\Entity;

use App\Repository\ModuleSessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModuleSessionRepository::class)]
class ModuleSession
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['show_product', 'list_product'])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['show_product', 'list_product'])]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'modules_session')]
    #[Groups(['show_product', 'list_product'])]
    private ?Categorie $categorie = null;

    #[ORM\OneToMany(mappedBy: 'module_session', targetEntity: Programme::class, orphanRemoval: true)]
    #[Groups(['show_product', 'list_product'])]
    private Collection $programmes;

    public function __construct()
    {
        $this->programmes = new ArrayCollection();
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

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
            $programme->setModuleSession($this);
        }

        return $this;
    }

    public function removeProgramme(Programme $programme): static
    {
        if ($this->programmes->removeElement($programme)) {
            // set the owning side to null (unless already changed)
            if ($programme->getModuleSession() === $this) {
                $programme->setModuleSession(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nom;
    }
}
