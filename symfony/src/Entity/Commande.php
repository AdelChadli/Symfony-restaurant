<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: Lignecommande::class)]
    private $lgnCommande;

    #[ORM\ManyToOne(targetEntity: Restaurant::class, inversedBy: 'commandes')]
    private $rstCommande;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $prixTT;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    private $commanditaire;

    public function __construct()
    {
        $this->lgnCommande = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Lignecommande[]
     */
    public function getLgnCommande(): Collection
    {
        return $this->lgnCommande;
    }

    public function addLgnCommande(Lignecommande $lgnCommande): self
    {
        if (!$this->lgnCommande->contains($lgnCommande)) {
            $this->lgnCommande[] = $lgnCommande;
            $lgnCommande->setCommande($this);
        }

        return $this;
    }

    public function removeLgnCommande(Lignecommande $lgnCommande): self
    {
        if ($this->lgnCommande->removeElement($lgnCommande)) {
            // set the owning side to null (unless already changed)
            if ($lgnCommande->getCommande() === $this) {
                $lgnCommande->setCommande(null);
            }
        }

        return $this;
    }

    public function getRstCommande(): ?Restaurant
    {
        return $this->rstCommande;
    }

    public function setRstCommande(?Restaurant $rstCommande): self
    {
        $this->rstCommande = $rstCommande;

        return $this;
    }

    public function getPrixTT(): ?int
    {
        return $this->prixTT;
    }

    public function setPrixTT(?int $prixTT): self
    {
        $this->prixTT = $prixTT;

        return $this;
    }

    public function getCommanditaire(): ?User
    {
        return $this->commanditaire;
    }

    public function setCommanditaire(?User $commanditaire): self
    {
        $this->commanditaire = $commanditaire;

        return $this;
    }
}
