<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nomCategorie = null;

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: ModuleSession::class, orphanRemoval:true)]
    private Collection $modules_session;

    public function __construct()
    {
        $this->modules_session = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCategorie(): ?string
    {
        return $this->nomCategorie;
    }

    public function setNomCategorie(string $nomCategorie): static
    {
        $this->nomCategorie = $nomCategorie;

        return $this;
    }

    /**
     * @return Collection<int, ModuleSession>
     */
    public function getModulesSession(): Collection
    {
        return $this->modules_session;
    }

    public function addModulesSession(ModuleSession $modulesSession): static
    {
        if (!$this->modules_session->contains($modulesSession)) {
            $this->modules_session->add($modulesSession);
            $modulesSession->setCategorie($this);
        }

        return $this;
    }

    public function removeModulesSession(ModuleSession $modulesSession): static
    {
        if ($this->modules_session->removeElement($modulesSession)) {
            // set the owning side to null (unless already changed)
            if ($modulesSession->getCategorie() === $this) {
                $modulesSession->setCategorie(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nomCategorie;
    }
}
