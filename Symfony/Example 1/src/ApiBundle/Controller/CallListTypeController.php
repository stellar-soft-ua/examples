<?php

namespace ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CallListTypeController extends Controller
{
    /**
     * @Rest\Get("/api/callListType")
     */
    public function getAction(ParamFetcher $paramFetcher)
    {
        $callListTypes = $this->getDoctrine()->getRepository('AppBundle:CallListType')->findAll();

        return array_map(function ($callListType) {
            return ['id' => $callListType->getId(),
                'title' => $callListType->getTitle(),
                'color' => $callListType->getColor(),
                'number' => $callListType->getNumber()
            ];
        }, $callListTypes);
    }
}
