<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Symfony\Component\Validator\Constraints as Assert;

class LocationRecherche
{
    /**
     * @var int|null
     */
    private $prixMax;

    /**
     * @var int|null
     * @Assert\Range(min=10, max=400)
     */
    private $surfaceMin;

    /**
     * @var ArrayCollection
     */
    private $options;

    public function __construct()
    {
        $this->options = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getPrixMax(): ?int
    {
        return $this->prixMax;
    }

    /**
     * @param int|null $prixMax
     * @return LocationRecherche
     */
    public function setPrixMax(int $prixMax): LocationRecherche
    {
        $this->prixMax = $prixMax;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getSurfaceMin(): ?int
    {
        return $this->surfaceMin;
    }

    /**
     * @param int|null $surfaceMin
     * @return LocationRecherche
     */
    public function setSurfaceMin(int $surfaceMin): LocationRecherche
    {
        $this->surfaceMin = $surfaceMin;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getOptions(): ArrayCollection
    {
        return $this->options;
    }

    /**
     * @param ArrayCollection
     */
    public function setOptions(ArrayColletion $options): void
    {
        $this->options = $options;
    }
}