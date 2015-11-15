<?php

namespace AvekApeti\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ChefController extends Controller
{
    public function chefAction()
    {
        return $this->render('HomeBundle:Home:chef.html.twig');
    }
}
