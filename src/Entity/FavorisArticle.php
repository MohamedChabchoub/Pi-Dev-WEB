<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FavorisArticle
 *
 * @ORM\Entity
 */
class FavorisArticle
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_favoris", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFavoris;


    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="id_user")
      * @ORM\JoinColumn(nullable=true)
     */
    private $idUtilisateur;



    /**
     * @var \Article
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Article", inversedBy="id")
    * @ORM\JoinColumn(nullable=true)
   */
    private $idArticle;







    public function getIdFavoris(): ?int
    {
        return $this->idFavoris;
    }

    public function getIdUtilisateur(): ?User
    {
        return $this->idUtilisateur;
    }

    public function setIdUtilisateur(?User $idUtilisateur): self
    {
        $this->idUtilisateur = $idUtilisateur;

        return $this;
    }

    public function getIdArticle(): ?Article
    {
        return $this->idArticle;
    }

    public function setIdArticle(?Article $idArticle): self
    {
        $this->idArticle = $idArticle;

        return $this;
    }


}
