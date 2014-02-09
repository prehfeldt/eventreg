<?php

namespace EventReg\EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use EventReg\EventBundle\Entity\Event;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use dflydev\markdown\MarkdownExtraParser;

class EventController extends Controller
{
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository('EventBundle:Event')->findAllOrderedByDate();

        return $this->render('EventBundle:Default:index.html.twig', array(
            'events' => $events
        ));
    }

    public function detailAction($id) {
        $em = $this->getDoctrine()->getManager();

        $event = $em->getRepository('EventBundle:Event')->findOneById($id);

        return $this->render('EventBundle:Default:details.html.twig', array(
            'event'     => $event
        ));
    }

    public function addAction() {
        $eventForm = $this->get('event.form');
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();

        $event = new Event();

        $form = $eventForm->getEventForm($event);

        if (true == $request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                $event->setOwner($this->get('security.context')->getToken()->getUser());

                $em->persist($event);
                $em->flush();

                return $this->redirect($this->generateUrl('_event_homepage'));
            }
        }

        return $this->render('EventBundle:Default:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function attendAction($id) {
        $token = $this->get('security.context')->getToken();
        $em = $this->getDoctrine()->getManager();

        $user = $token->getUser();
        $event = $em->getRepository('EventBundle:Event')->findOneById($id);

        $event->addAttendee($user);

        $em->persist($event);
        $em->flush();

        return $this->redirect($this->generateUrl('_event_details', array('id' => $event->getId())));
    }

    public function cancelAttendanceAction($id) {
        $token = $this->get('security.context')->getToken();
        $em = $this->getDoctrine()->getManager();

        $user = $token->getUser();
        $event = $em->getRepository('EventBundle:Event')->findOneById($id);

        $event->removeAttendee($user);

        $em->persist($event);
        $em->flush();

        return $this->redirect($this->generateUrl('_event_details', array('id' => $event->getId())));
    }

    public function removeAttendeeAction($eventId, $userId) {
        $em = $this->getDoctrine()->getManager();

        $event = $em->getRepository('EventBundle:Event')->findOneById($eventId);
        $user = $em->getRepository('UserBundle:User')->findOneById($userId);

        $event->removeAttendee($user);

        $em->persist($event);
        $em->flush();

        return $this->redirect($this->generateUrl('_event_details', array('id' => $event->getId())));
    }

    public function removeAction($id) {
        $securityContext = $this->get('security.context');
        $em = $this->getDoctrine()->getManager();

        $user = $securityContext->getToken()->getUser();
        $event = $em->getRepository('EventBundle:Event')->findOneById($id);

        if (false == $securityContext->isGranted('ROLE_ADMIN') && $user->getId() != $event->getOwner()->getId()) {
            throw new HttpException(403);
        }

        $em->remove($event);
        $em->flush();

        return $this->redirect($this->generateUrl('_event_homepage'));
    }

    public function editAction($id) {
        $eventForm = $this->get('event.form');
        $securityContext = $this->get('security.context');
        $em = $this->getDoctrine()->getManager();
        $request = $this->getRequest();

        $user = $securityContext->getToken()->getUser();
        $event = $em->getRepository('EventBundle:Event')->findOneById($id);

        $form = $eventForm->getEventForm($event);

        if (true == $request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                $em->persist($event);
                $em->flush();

                return $this->redirect($this->generateUrl('_event_details', array('id' => $event->getId())));
            }
        }

        return $this->render('EventBundle:Default:edit.html.twig', array(
            'event' => $event,
            'form'  => $form->createView()
        ));
    }

    public function markdownPreviewAction() {
        $request = $this->getRequest();
        $description = $request->request->get('description', '');

        $description = htmlentities($description);

        $markdownParser = new MarkdownExtraParser();
        $markdown = $markdownParser->transformMarkdown($description);

        $result = array('description' => $markdown);

        return new JsonResponse($result);
    }
}
