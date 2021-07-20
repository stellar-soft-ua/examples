<?php

namespace ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AgreementController extends Controller
{
    /**
     * @Rest\Get("/api/agreement")
     * @QueryParam(name="type", requirements="(group|individual|club)", strict=true, nullable=false, description="Type")
     */
    public function getAction(ParamFetcher $paramFetcher)
    {
        $type = $paramFetcher->get('type');

        $agreements = $this->getDoctrine()->getRepository("AppBundle:Agreement")->findBy(['type' => $type], ['id' => 'DESC']);

        return array_map(function ($agreement) {
            return [
                'id' => $agreement->getId(),
                'type' => $agreement->getType(),
                'img' => $agreement->getImg()
            ];
        }, $agreements);
    }
}
