<?php

namespace AvekApeti\GourmetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;

class PlatController extends Controller
{
    public function indexAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AvekApetiBackBundle:Plat')->find($id);

        $entities = $em->getRepository('AvekApetiBackBundle:Plat')->findIfChef($entity->getUtilisateur()->getId());

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Plat entity.');
        }

        return $this->render('GourmetBundle:Plat:index-plat.html.twig', array(
            'entities'      => $entities,
            'entityChef'      => $entity->getUtilisateur(),
            'entity'      => $entity,
        ));
    }

    public function selectionAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if ($request->isXmlHttpRequest())
        {
            $entities = $em->getRepository('AvekApetiBackBundle:Plat')->findAllPlatWithGeoloc($request->query->get('lat'), $request->query->get('lng'));
        }
        else {
            $address = $request->query->get('q');
            $entities = [];

            $urlGoogle = 'http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address);
            if ($this->get_http_response_code($urlGoogle) == '200') {
                $json = file_get_contents($urlGoogle);
                $parsedjson = json_decode($json, true);
                if (!empty($parsedjson['status']) && 'OK' == $parsedjson['status']) {
                    $curl = new \Ivory\HttpAdapter\CurlHttpAdapter();
                    $geocoder = new \Geocoder\Provider\GoogleMaps($curl);
                    $dataGeo = $geocoder->geocode($address)->first();
                    $entities = $em->getRepository('AvekApetiBackBundle:Plat')->findAllPlatWithGeoloc($dataGeo->getLatitude(), $dataGeo->getLongitude());
                }
            }
        }


        if (!$entities)
        {
            // center of Paris (longitude and latitude)
            $entities = $em->getRepository('AvekApetiBackBundle:Plat')->findAllPlatWithGeoloc(48.856614, 2.3522219);
        }

        if ($request->isXmlHttpRequest())
        {
            return new JsonResponse(['html' => $this->renderView('GourmetBundle:Plat:include-selection-plat.html.twig', ['entities' => $entities])]);
        }

        return $this->render('GourmetBundle:Plat:selection-plat.html.twig', array(
            'entities' => $entities
        ));
    }

    private function get_http_response_code($url) {
        $headers = get_headers($url);
        return substr($headers[0], 9, 3);
    }
}
