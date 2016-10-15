<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Post
 *
 * @ORM\Table(name="post")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PostRepository")
 */
class Post
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
     * @ORM\Column(name="nomimage", type="string", length=255)
     */
    private $nomimage;

    /**
     * @var string
     *
     * @ORM\Column(name="descriptionimage", type="string", length=255)
     */
    private $descriptionimage;

    /**
     * @var string
     *
     * @ORM\Column(name="blobimage", type="blob")
     */
    private $blobimage;

    /**
     * @var float
     *
     * @ORM\Column(name="tailleimage", type="float")
     */
    private $tailleimage;

    /**
     * @var string
     *
     * @ORM\Column(name="typeimage", type="string", length=255)
     */
    private $typeimage;


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
     * Set nomimage
     *
     * @param string $nomimage
     *
     * @return Post
     */
    public function setNomimage($nomimage)
    {
        $this->nomimage = $nomimage;

        return $this;
    }

    /**
     * Get nomimage
     *
     * @return string
     */
    public function getNomimage()
    {
        return $this->nomimage;
    }

    /**
     * Set descriptionimage
     *
     * @param string $descriptionimage
     *
     * @return Post
     */
    public function setDescriptionimage($descriptionimage)
    {
        $this->descriptionimage = $descriptionimage;

        return $this;
    }

    /**
     * Get descriptionimage
     *
     * @return string
     */
    public function getDescriptionimage()
    {
        return $this->descriptionimage;
    }

    /**
     * Set blobimage
     *
     * @param string $blobimage
     *
     * @return Post
     */
    public function setBlobimage($blobimage)
    {
        $this->blobimage = $blobimage;

        return $this;
    }

    /**
     * Get blobimage
     *
     * @return string
     */
    public function getBlobimage()
    {
        return $this->blobimage;
    }

    /**
     * Set tailleimage
     *
     * @param float $tailleimage
     *
     * @return Post
     */
    public function setTailleimage($tailleimage)
    {
        $this->tailleimage = $tailleimage;

        return $this;
    }

    /**
     * Get tailleimage
     *
     * @return float
     */
    public function getTailleimage()
    {
        return $this->tailleimage;
    }

    /**
     * Set typeimage
     *
     * @param string $typeimage
     *
     * @return Post
     */
    public function setTypeimage($typeimage)
    {
        $this->typeimage = $typeimage;

        return $this;
    }

    /**
     * Get typeimage
     *
     * @return string
     */
    public function getTypeimage()
    {
        return $this->typeimage;
    }
}

