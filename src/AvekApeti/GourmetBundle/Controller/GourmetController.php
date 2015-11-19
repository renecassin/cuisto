<?php

namespace AvekApeti\GourmetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GourmetController extends Controller
{
    public function gourmetInscriptionAction()
    {
        return $this->render('GourmetBundle:Gourmet:gourmet-inscription.html.twig');
    }
}
