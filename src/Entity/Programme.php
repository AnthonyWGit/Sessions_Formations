<?php

namespace App\Entity;

use App\Repository\ProgrammeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProgrammeRepository::class)]
class Programme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $nbjours = null;

    #[ORM\ManyToOne(inversedBy: 'programmes')]
    private ?Session $session = null;

    #[ORM\ManyToOne(inversedBy: 'programmes')]
    private ?ModuleSession $module_session = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbjours(): ?int
    {
        return $this->nbjours;
    }

    public function setNbjours(int $nbjours): static
    {
        $this->nbjours = $nbjours;

        return $this;
    }

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function setSession(?Session $session): static
    {
        $this->session = $session;

        return $this;
    }

    public function getModuleSession(): ?ModuleSession
    {
        return $this->module_session;
    }

    public function setModuleSession(?ModuleSession $module_session): static
    {
        $this->module_session = $module_session;

        return $this;
    }

    public function __toString()
    {
        return $this->session." ".$this->module_session." "." ".$this->nbjours;
    }
}
