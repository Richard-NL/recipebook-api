<?php
namespace Rsh\Bundle\RecipeBookBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

use Rsh\Bundle\RecipeBookBundle\Entity\Recipe;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class LoadRecipeData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    private $container;

    public function getOrder()
    {
        return 10;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $recipe = new Recipe();
        $recipe->setName('Pea Soup');
        $recipe->setCreatedAt(new \DateTime());
        $recipe->addIngredient($this->getReference('ingredient-green-lentils'));
        $recipe->addIngredient($this->getReference('ingredient-potato'));
        $recipe->addIngredient($this->getReference('ingredient-carrot'));
        $recipe->addIngredient($this->getReference('ingredient-celeriac'));
        $recipe->addIngredient($this->getReference('ingredient-leek'));
        $manager->persist($recipe);

        $recipeNames = [
            'Sweet Potato Mash',
            'Bread',
            'Saoto Soup',
            'Gumbo',
            'Banana Bread',
            'Paella',
            'Pancakes',
            'Apple Pie',
            'Mojito',
            'Roti',
            'jambalaya',
            'Hutspot'
        ];

        foreach ($recipeNames as $recipeName) {
            $recipe = new Recipe();
            $recipe->setName($recipeName);
            $recipe->setCreatedAt(new \DateTime());
            $manager->persist($recipe);
        }


        $manager->flush();
    }
}