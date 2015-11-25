<?php

namespace AvekApeti\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        return $this->render('AvekApetiBackBundle:Main:index.html.twig', array(
                // ...
            ));    }

}
