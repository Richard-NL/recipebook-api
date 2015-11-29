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
        return new Response($json, 200, array('application/json'));
    }
}
