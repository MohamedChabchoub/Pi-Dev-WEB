<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * CategorieArticle
 *
 * @ORM\Table(name="categorie_article")
 * @ORM\Entity
 */
class CategorieArticle
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="idGouvernorat")
     */
    private $idAdd;
    /**
     * @var string
     *
     * @ORM\Column(name="type_categorie", type="string", length=255, nullable=false)
     */
    private $typeCategorie;
        /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="category")
     */
    private $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->idAdd = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeCategorie(): ?string
    {
        return $this->typeCategorie;
    }

    public function setTypeCategorie(string $typeCategorie): self
    {
        $this->typeCategorie = $typeCategorie;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setCategory($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getCategory() === $this) {
                $article->setCategory(null);
            }
        }

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
            $idAdd->setIdGouvernorat($this);
        }

        return $this;
    }

    public function removeIdAdd(Article $idAdd): self
    {
        if ($this->idAdd->removeElement($idAdd)) {
            // set the owning side to null (unless already changed)
            if ($idAdd->getIdGouvernorat() === $this) {
                $idAdd->setIdGouvernorat(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return (string) $this->getTypeCategorie();
    }


}
