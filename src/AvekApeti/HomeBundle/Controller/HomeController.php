<?php

namespace AvekApeti\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function homeAction()
    {
        return $this->render('HomeBundle:Home:home.html.twig');
    }
}
