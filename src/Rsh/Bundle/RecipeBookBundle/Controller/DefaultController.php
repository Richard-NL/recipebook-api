<?php

namespace Rsh\Bundle\RecipeBookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('RshRecipeBookBundle:Default:index.html.twig', array('name' => $name));
    }
}
