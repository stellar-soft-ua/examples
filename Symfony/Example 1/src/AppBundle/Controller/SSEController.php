<?php

namespace AppBundle\Controller;

use Hhxsv5\SSE\SSE;
use Hhxsv5\SSE\Update;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SSEController extends Controller
{


    private $lastIds;

    public function __construct()
    {

        $this->lastIds = [
            'client' => null,
            'client_call' => null,
            'client_comment' => null,
            'client_substatus_log' => null,
            'log_item_id' => null
        ];

    }

    /**
     *
     * @Route("/sse")
     */
    public function newMsgs()
    {


        $response = new StreamedResponse();
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');
        $response->headers->set('X-Accel-Buffering', 'no');//Nginx: unbuffered responses suitable for Comet and HTTP streaming applications
        $response->setCallback(function () {
            (new SSE())->start(new Update(function () {


                if ($this->hasUpdates()) {
                    return true;
                }
                return false;//return false if no new messages
            }, 5), 'new-msgs');
        });
        return $response;
    }

    private function hasUpdates()
    {


        $lastClient = $this->getDoctrine()->getRepository("AppBundle:Client")->findOneBy([], ['id' => 'DESC']);
        $lastClientCall = $this->getDoctrine()->getRepository("AppBundle:ClientCall")->findOneBy([], ['id' => 'DESC']);
        $lastClientComment = $this->getDoctrine()->getRepository("AppBundle:ClientComment")->findOneBy([], ['id' => 'DESC']);
        $lastClientSubstatusLog = $this->getDoctrine()->getRepository("AppBundle:ClientSubstatusLog")->findOneBy([], ['id' => 'DESC']);
        $lastLogItem = $this->getDoctrine()->getRepository("AppBundle:LogItem")->findOneBy([], ['id' => 'DESC']);

        $newLastIds = [
            'client' => $lastClient->getId(),
            'client_call' => $lastClientCall->getId(),
            'client_comment' => $lastClientComment->getId(),
            'client_substatus_log' => $lastClientSubstatusLog->getId(),
            'log_item_id' => $lastLogItem->getId()
        ];

        $hasNew = false;

        if ($this->lastIds['client'] && $this->lastIds['client'] != $newLastIds['client']) {
            $hasNew = true;
        } elseif ($this->lastIds['client_call'] && $this->lastIds['client_call'] != $newLastIds['client_call']) {
            $hasNew = true;
        } elseif ($this->lastIds['client_comment'] && $this->lastIds['client_comment'] != $newLastIds['client_comment']) {
            $hasNew = true;
        } elseif ($this->lastIds['client_substatus_log'] && $this->lastIds['client_substatus_log'] != $newLastIds['client_substatus_log']) {
            $hasNew = true;
        } elseif ($this->lastIds['log_item_id'] && $this->lastIds['log_item_id'] != $newLastIds['log_item_id']) {
            $hasNew = true;
        }

        $this->lastIds = $newLastIds;


        return $hasNew;
    }

}





