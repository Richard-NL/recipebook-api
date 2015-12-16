<?php

namespace Rsh\Bundle\RecipeBookBundle\Controller;

use Hateoas\Representation\Factory\PagerfantaFactory;
use Pagerfanta\Adapter\DoctrineORMAdapter;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Hateoas\Configuration\Route;
use Pagerfanta\Pagerfanta;


class RecipeController extends Controller
{
    public function indexAction(Request $request)
    {
        $queryBuilder = $this->getDoctrine()->getManager()->createQueryBuilder()
            ->select('r')
            ->from('RshRecipeBookBundle:Recipe', 'r');

        $adapter = new DoctrineORMAdapter($queryBuilder);
        $pager = new Pagerfanta($adapter);

        $currentPage = 1;
        if ($request->query->get('page') !== null) {
            $currentPage = $request->query->get('page');
        }
        $pager->setCurrentPage($currentPage);
        $pagerfantaFactory   = new PagerfantaFactory(); // you can pass the page,
        // and limit parameters name
        $paginatedCollection = $pagerfantaFactory->createRepresentation(
            $pager,
            new Route('rsh_recipe_book_recipe', [])
        );

        $json = $this->container->get('serializer')->serialize($paginatedCollection, 'json');
        return new Response($json, 200, ['application/json']);
    }

    public function postAction(Request $request)
    {
        $data = $request->getContent();
        $recipe = $this->container->get('serializer')->deserialize($data, 'Rsh\Bundle\RecipeBookBundle\Entity\Recipe', 'json');
        $entityManager = $this->getDoctrine()->getManager();
        $recipe->setCreatedAt(new \DateTime());

        $ingredients = $recipe->getIngredients();

        if (!empty($ingredients)) {
            $ids = [];
            foreach ($ingredients as $ingredient) {
                $ids []= $ingredient->getId();
            }
            $queryBuilder = $entityManager->createQueryBuilder();
            $queryBuilder->select('i')
                ->from('Rsh\Bundle\RecipeBookBundle\Entity\Ingredient', 'i')
                ->where('i.id IN (:ids)')
                ->setParameter('ids', $ids);
            $query = $queryBuilder->getQuery();

            $fetchedIngredients = $query->getResult();
            $recipe->setIngredients($fetchedIngredients);
        }
        $entityManager->persist($recipe);
        $entityManager->flush();
        $json = $this->container->get('serializer')->serialize($recipe, 'json');
        return new Response($json, 200, ['application/json']);
    }
}
