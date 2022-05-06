<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vu
 *
 * @ORM\Entity
 */
class Vu
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_vu", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idVu;



 

    public function getIdVu(): ?int
    {
        return $this->idVu;
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
