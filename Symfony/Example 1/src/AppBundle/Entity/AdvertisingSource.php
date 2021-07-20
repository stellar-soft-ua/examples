<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdvertisingSource
 *
 * @ORM\Table(name="advertising_source")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AdvertisingSourceRepository")
 */
class AdvertisingSource
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity="ClientAdvertisingSource", mappedBy="advertisingSources")
     */
    private $clientAdvertisingSources;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return AdvertisingSource
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }
}

