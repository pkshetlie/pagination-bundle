<?php

namespace PaginationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PaginationBundle:Default:index.html.twig');
    }
}
