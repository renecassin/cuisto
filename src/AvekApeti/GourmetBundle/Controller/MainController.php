<?php

namespace AvekApeti\GourmetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        return $this->render('GourmetBundle:Main:index.html.twig');
    }

    public function loginAction()
    {
        return $this->render('GourmetBundle:Main:login.html.twig');
    }
}
