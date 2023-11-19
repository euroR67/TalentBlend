<?php

namespace App\Entity;

use App\Repository\EmploiRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmploiRepository::class)]
class Emploi
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 40)]
    private ?string $poste = null;

    #[ORM\Column(length: 40)]
    private ?string $disponibilite = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $salaire = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateOffre = null;

    #[ORM\ManyToOne(inversedBy: 'emplois')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $categories = null;

    #[ORM\ManyToOne(inversedBy: 'emplois')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Contrat $contrats = null;

    #[ORM\OneToMany(mappedBy: 'emploi', targetEntity: Postule::class)]
    private Collection $postulations;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'emploiSauvegarder')]
    private Collection $users;

    #[ORM\ManyToOne(inversedBy: 'emplois')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ville $ville = null;

    #[ORM\ManyToOne(inversedBy: 'emplois')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Niveau $niveau = null;

    #[ORM\ManyToOne(inversedBy: 'emplois')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Entreprise $entreprise = null;

    #[ORM\ManyToOne(inversedBy: 'emplois')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeEmploi $types = null;

    #[ORM\ManyToOne(inversedBy: 'emplois')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function __construct()
    {
        $this->postulations = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPoste(): ?string
    {
        return $this->poste;
    }

    public function setPoste(string $poste): static
    {
        $this->poste = $poste;

        return $this;
    }

    public function getDisponibilite(): ?string
    {
        return $this->disponibilite;
    }

    public function setDisponibilite(string $disponibilite): static
    {
        $this->disponibilite = $disponibilite;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getSalaire(): ?int
    {
        return $this->salaire;
    }

    public function setSalaire(int $salaire): static
    {
        $this->salaire = $salaire;

        return $this;
    }

    public function getDateOffre(): ?\DateTimeInterface
    {
        return $this->dateOffre;
    }

    public function setDateOffre(\DateTimeInterface $dateOffre): static
    {
        $this->dateOffre = $dateOffre;

        return $this;
    }

    public function getCategories(): ?Categorie
    {
        return $this->categories;
    }

    public function setCategories(?Categorie $categories): static
    {
        $this->categories = $categories;

        return $this;
    }

    public function getContrats(): ?Contrat
    {
        return $this->contrats;
    }

    public function setContrats(?Contrat $contrats): static
    {
        $this->contrats = $contrats;

        return $this;
    }

    /**
     * @return Collection<int, Postule>
     */
    public function getPostulations(): Collection
    {
        return $this->postulations;
    }

    public function addPostulation(Postule $postulation): static
    {
        if (!$this->postulations->contains($postulation)) {
            $this->postulations->add($postulation);
            $postulation->setEmploi($this);
        }

        return $this;
    }

    public function removePostulation(Postule $postulation): static
    {
        if ($this->postulations->removeElement($postulation)) {
            // set the owning side to null (unless already changed)
            if ($postulation->getEmploi() === $this) {
                $postulation->setEmploi(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addEmploiSauvegarder($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeEmploiSauvegarder($this);
        }

        return $this;
    }

    public function getVille(): ?Ville
    {
        return $this->ville;
    }

    public function setVille(?Ville $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getNiveau(): ?Niveau
    {
        return $this->niveau;
    }

    public function setNiveau(?Niveau $niveau): static
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): static
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function getTypes(): ?TypeEmploi
    {
        return $this->types;
    }

    public function setTypes(?TypeEmploi $types): static
    {
        $this->types = $types;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
