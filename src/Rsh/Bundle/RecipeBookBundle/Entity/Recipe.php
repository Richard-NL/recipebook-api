<?php

namespace Rsh\Bundle\RecipeBookBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * Recipe
 * @Serializer\XmlRoot("ingredient")
 *
 * @Hateoas\Relation("self", href = "expr('/api/recipes/' ~ object.getId())")
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Rsh\Bundle\RecipeBookBundle\Entity\RecipeRepository")
 */
class Recipe
{
    /**
     * @var integer
     * @Serializer\XmlAttribute
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    protected $createdAt;

    /**
     * @var
     * @Serializer\Expose
     * @Serializer\Type("ArrayCollection<Rsh\Bundle\RecipeBookBundle\Entity\Ingredient>")
     * @ORM\ManyToMany(targetEntity="Ingredient")
     */
    protected $ingredients;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Recipe
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Recipe
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
    }


    public function addIngredient(Ingredient $ingredient)
    {
        $this->ingredients->add($ingredient);
        return $this;
    }
    /**
     * @param $ingredients
     * @return $this
     */
    public function setIngredients($ingredients)
    {
        $this->ingredients = $ingredients;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }
}

