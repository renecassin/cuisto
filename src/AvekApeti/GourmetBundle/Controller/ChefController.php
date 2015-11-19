<?php

namespace AvekApeti\GourmetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ChefController extends Controller
{
    public function chefInscriptionAction()
    {
        return $this->render('GourmetBundle:Chef:chef-inscription.html.twig');
    }
}
