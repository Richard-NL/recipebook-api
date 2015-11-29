<?php
namespace Rsh\Bundle\RecipeBookBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

use Rsh\Bundle\RecipeBookBundle\Entity\Ingredient;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class LoadIngredientData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    private $container;

    public function getOrder()
    {
        return 1;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {

        $ingredientNames = [
            'Leek',
            'Carrot',
            'Potato',
            'Green Lentils',
            'Celeriac'
        ];

        foreach ($ingredientNames as $ingredientName) {
            $ingredient = new Ingredient();
            $ingredient->setName($ingredientName);
            $ingredient->setDescription('This is yummi');
            $manager->persist($ingredient);
            $this->addReference('ingredient-' . $this->toReferenceString($ingredientName), $ingredient);
        }

        $manager->flush();
    }

    private function toReferenceString($ingredientName)
    {
        return strtolower(str_replace(' ', '-', $ingredientName));
    }
}