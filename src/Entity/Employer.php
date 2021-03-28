<?php

namespace App\Entity;

use App\Repository\EmployerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=EmployerRepository::class)
 */
class Employer extends User
{


    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"employers"})
     */
    private $company;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"employers"})
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity=Formation::class, mappedBy="employer")
     */
    private $formation;

    /**
     * @ORM\OneToMany(targetEntity=Evenements::class, mappedBy="employer")
     */
    private $evenements;


    public function __construct()
    {
        parent::__construct();
        $this->formation = new ArrayCollection();
        $this->evenements = new ArrayCollection();
    }



    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection|Formation[]
     */
    public function getFormation(): Collection
    {
        return $this->formation;
    }

    public function addFormation(Formation $formation): self
    {
        if (!$this->formation->contains($formation)) {
            $this->formation[] = $formation;
            $formation->setEmployer($this);
        }

        return $this;
    }

    public function removeFormation(Formation $formation): self
    {
        if ($this->formation->removeElement($formation)) {
            // set the owning side to null (unless already changed)
            if ($formation->getEmployer() === $this) {
                $formation->setEmployer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Evenements[]
     */
    public function getEvenements(): Collection
    {
        return $this->evenements;
    }

    public function addEvenement(Evenements $evenement): self
    {
        if (!$this->evenements->contains($evenement)) {
            $this->evenements[] = $evenement;
            $evenement->setEmployer($this);
        }

        return $this;
    }

    public function removeEvenement(Evenements $evenement): self
    {
        if ($this->evenements->removeElement($evenement)) {
            // set the owning side to null (unless already changed)
            if ($evenement->getEmployer() === $this) {
                $evenement->setEmployer(null);
            }
        }

        return $this;
    }




}