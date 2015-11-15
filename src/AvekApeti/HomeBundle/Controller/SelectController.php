<?php

namespace AvekApeti\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SelectController extends Controller
{
    public function indexAction()
    {
        return $this->render('HomeBundle:Select:index.html.twig');
    }
}
