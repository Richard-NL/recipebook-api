<?php

namespace Rsh\Bundle\RecipeBookBundle\Listener;


use Doctrine\ORM\Event\LifecycleEventArgs;
use Rsh\Bundle\RecipeBookBundle\Entity\Ingredient;
use Rsh\Bundle\RecipeBookBundle\Entity\Recipe;

class RecipeListener
{
    public function postPersist(Recipe $recipe, LifecycleEventArgs $event)
    {
        if(count($recipe->getIngredients()) < 1) {
            return;
        }
        $entityManager = $event->getEntityManager();
        $ingredient = new Ingredient();
        $ingredient->setName('Salt');
        $ingredient->setDescription('Salt');
        $entityManager->persist($ingredient);
        $recipe->setCreatedAt(new \DateTime());
        $recipe->addIngredient($ingredient);
        $entityManager->persist($recipe);
        $entityManager->flush();

    }
} 