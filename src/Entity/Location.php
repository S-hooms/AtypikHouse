<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LocationRepository")
 * @UniqueEntity("titre")
 * @Vich\Uploadable
 */
class Location
{
    const Chauffage = [
        0 => 'Electric',
        1 => 'Gaz'
    ];
    
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    /**
     * @var File|null
     * @Assert\Image(
     *  mimeTypes="image/jpeg")
     * @Vich\UploadableField(mapping="location_image", fileNameProperty="filename")
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=5, max=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(min=10, max=400)
     */
    private $surface;

    /**
     * @ORM\Column(type="integer")
     */
    private $pieces;

    /**
     * @ORM\Column(type="integer")
     */
    private $chambres;

    /**
     * @ORM\Column(type="integer")
     */
    private $etage;

    /**
     * @ORM\Column(type="integer")
     */
    private $prix;

    /**
     * @ORM\Column(type="integer")
     */
    private $chauffage;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $addresse;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("/^[0-9]{5}$/")
     */
    private $code_postal;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $louer = false;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Option", inversedBy="locations")
     */
    private $options;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->options = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSlug(): string
    {
        return (new Slugify())->slugify($this->titre); // hello-world
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSurface(): ?int
    {
        return $this->surface;
    }

    public function setSurface(int $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getPieces(): ?int
    {
        return $this->pieces;
    }

    public function setPieces(int $pieces): self
    {
        $this->pieces = $pieces;

        return $this;
    }

    public function getChambres(): ?int
    {
        return $this->chambres;
    }

    public function setChambres(int $chambres): self
    {
        $this->chambres = $chambres;

        return $this;
    }

    public function getEtage(): ?int
    {
        return $this->etage;
    }

    public function setEtage(int $etage): self
    {
        $this->etage = $etage;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }
    public function getFormattedPrix(): string
    {
        return number_format($this->prix, 0, '', ' ');
    }

    public function getChauffage(): ?int
    {
        return $this->chauffage;
    }

    public function setChauffage(int $chauffage): self
    {
        $this->chauffage = $chauffage;

        return $this;
    }

    public function getChauffageType(): string
    {
        return self::Chauffage[$this->chauffage];
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getAddresse(): ?string
    {
        return $this->addresse;
    }

    public function setAddresse(string $addresse): self
    {
        $this->addresse = $addresse;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    public function setCodePostal(string $code_postal): self
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function getLouer(): ?bool
    {
        return $this->louer;
    }

    public function setLouer(bool $louer): self
    {
        $this->louer = $louer;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection|Option[]
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(Option $option): self
    {
        if (!$this->options->contains($option)) {
            $this->options[] = $option;
            $option->addLocation($this);
        }

        return $this;
    }

    public function removeOption(Option $option): self
    {
        if ($this->options->contains($option))
        {
            $this->options->removeElement($option);
            $option->removeLocation($this);
        }

        return $this;
    }

    /**
     * @return null|string
     */
    public function getFilename(): ?string
    {
        return $this->filename;
    }

    /**
     * @param null|string $filename
     * @return Location
     */
    public function setFilename(?string $filename): Location
      {
          $this->filename = $filename;
          return $this;
      }

      /**
       * @return null|File
       */
      public function getImageFile(): ?File
      {
          return $this->imageFile;
      }

      /**
       * @param null|File $imageFile
       * @return Location
       */
      public function setImageFile(?File $imageFile): Location
      {
          $this->imageFile = $imageFile;
          if( $this->imageFile instanceof UploadedFile)
          {
              $this->updated_at = new \DateTime('now');
          }
          return $this;
      }

      public function getUpdatedAt(): ?\DateTimeInterface
      {
          return $this->updated_at;
      }

      public function setUpdatedAt(\DateTimeInterface $updated_at): self
      {
          $this->updated_at = $updated_at;

          return $this;
      }
    
}
