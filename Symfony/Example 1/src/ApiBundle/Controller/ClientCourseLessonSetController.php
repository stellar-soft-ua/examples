<?php

namespace ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ClientCourseLessonSetController extends Controller
{
    /**
     * @Rest\Get("/api/clientCourseLessonSet/{id}")
     */
    public function idAction(int $id)
    {
        $clientCourseLessonSet = $this->getDoctrine()->getRepository('AppBundle:ClientCourseLessonSet')->find($id);

        if ($clientCourseLessonSet === null) {
            return new View("client course lesson set not found", Response::HTTP_NOT_FOUND);
        }

        $lessonCancellations = $this->getDoctrine()->getRepository('AppBundle:LessonCancellation')->getAll($clientCourseLessonSet);

        return [
            'id' => $clientCourseLessonSet->getId(),
            'cancellations' => [
                'client' => count($lessonCancellations)
            ],
            'course_lesson_set' => ($courseLessonSet = $clientCourseLessonSet->getCourseLessonSet()) ?
                [
                    'id' => $courseLessonSet->getId(),
                    'title' => $courseLessonSet->getTitle(),
                    'type' => $courseLessonSet->getType(),
                    'number_of_lessons' => $courseLessonSet->getNumberOfLessons(),
                    'number_of_cancels' => $courseLessonSet->getNumberOfCancels()
                ] : null
        ];
    }
}
