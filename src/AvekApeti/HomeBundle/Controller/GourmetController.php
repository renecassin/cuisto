<?php

namespace AvekApeti\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GourmetController extends Controller
{
    public function gourmetAction()
    {
        return $this->render('HomeBundle:Home:gourmet.html.twig');
    }
}
