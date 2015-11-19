<?php

namespace AvekApeti\GourmetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PlatController extends Controller
{
    public function indexAction()
    {
        return $this->render('GourmetBundle:Plat:index-plat.html.twig');
    }

    public function selectionAction()
    {
        return $this->render('GourmetBundle:Plat:selection-plat.html.twig');
    }
}
