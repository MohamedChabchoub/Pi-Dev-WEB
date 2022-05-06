<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * Article
 *
 * @ORM\Entity
 */
class Article
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
     * @var \DateTime
     *
     * @ORM\Column(name="Date_publication", type="date", nullable=false)
     */
    private $datePublication;

    

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255,nullable=false)

    * @Assert\NotBlank
    * @Assert\Length(
    *      min = 4,
    *      max = 15,
    *      minMessage = "L'etat  d'un article doit comporter au moins {{ limit }} caractères",
    *      maxMessage = "L'etat  d'un article doit comporter au plus {{ limit }} caractères"
    * )
    */
    private $etat;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=255,nullable=false)
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 4,
     *      max = 100000000000000000,
     *      minMessage = "La description d'un article doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "La description d'un article doit comporter au plus {{ limit }} caractères"
     * )
     */
    private $description;

    /**
     * @var string
     * 
     * @ORM\Column(name="titre", type="string", length=255,nullable=false)

     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 4,
     *      max = 50,
     *      minMessage = "Le nom d'un article doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "Le nom d'un article doit comporter au plus {{ limit }} caractères"
     * )
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255,nullable=false)
     */
    private $image;

/**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="idAdd")
     * @ORM\JoinColumn(nullable=true)
     */
    private $idProprietaire;


     /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CategorieArticle", inversedBy="idAdd")
     * @ORM\JoinColumn(nullable=true)
     */
    private $idCategorie;

   

     /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Gouvernorat", inversedBy="idAdd")
     * @ORM\JoinColumn(nullable=true)
     */
    private $idGouvernorat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEchangeCrossCat(): ?int
    {
        return $this->echangeCrossCat;
    }

    public function setEchangeCrossCat(?int $echangeCrossCat): self
    {
        $this->echangeCrossCat = $echangeCrossCat;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getIdProprietaire(): ?User
    {
        return $this->idProprietaire;
    }

    public function setIdProprietaire(?User $idProprietaire): self
    {
        $this->idProprietaire = $idProprietaire;

        return $this;
    }


    

    public function getIdCategorie(): ?CategorieArticle
    {
        return $this->idCategorie;
    }

    public function setIdCategorie(?CategorieArticle $idCategorie): self
    {
        $this->idCategorie = $idCategorie;

        return $this;
    }

    public function getBoost(): ?Boost
    {
        return $this->boost;
    }

    public function setBoost(?Boost $boost): self
    {
        $this->boost = $boost;

        return $this;
    }

    public function getIdGouvernorat(): ?Gouvernorat
    {
        return $this->idGouvernorat;
    }

    public function setIdGouvernorat(?Gouvernorat $idGouvernorat): self
    {
        $this->idGouvernorat = $idGouvernorat;

        return $this;
    }

    public function getDatePublication(): ?\DateTimeInterface
    {
        return $this->datePublication;
    }

    public function setDatePublication(\DateTimeInterface $datePublication): self
    {
        $this->datePublication = $datePublication;

        return $this;
    }


}
