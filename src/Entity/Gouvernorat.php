<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Gouvernorat
 *
 * @ORM\Table(name="gouvernorat")
 * @ORM\Entity
 */
class Gouvernorat
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idGouvernorat;

  /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="idCategorie")
     */
    private $idAdd;


    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    public function __construct()
    {
        $this->idAdd = new ArrayCollection();
    }

    public function getIdGouvernorat(): ?int
    {
        return $this->idGouvernorat;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getIdAdd(): Collection
    {
        return $this->idAdd;
    }

    public function addIdAdd(Article $idAdd): self
    {
        if (!$this->idAdd->contains($idAdd)) {
            $this->idAdd[] = $idAdd;
            $idAdd->setIdCategorie($this);
        }

        return $this;
    }

    public function removeIdAdd(Article $idAdd): self
    {
        if ($this->idAdd->removeElement($idAdd)) {
            // set the owning side to null (unless already changed)
            if ($idAdd->getIdCategorie() === $this) {
                $idAdd->setIdCategorie(null);
            }
        }

        return $this;
    }


public function __toString()
{
    return (string) $this->getNom();
}


}
