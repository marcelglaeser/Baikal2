<?php

namespace Netgusto\Baikal\AdminBundle\Controller\Calendar;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;

use Sabre\DAV\UUIDUtil;

use Netgusto\Baikal\DavServicesBundle\Entity\User;
use Netgusto\Baikal\DavServicesBundle\Entity\Calendar;

class FormController extends Controller
{

    public function newAction(Request $request, User $user) {

        $formBuilder = $this->getFormBase();
        $form = $formBuilder->setData(array())->getForm();
        $form->handleRequest($request);

        if($form->isValid()) {

            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();

            # Persisting calendar
            $calendar = new Calendar();
            $calendar->setPrincipaluri($user->getIdentityPrincipal()->getUri());
            $calendar->setSynctoken('1');
            $calendar->setUri(UUIDUtil::getUUID());

            $calendar->setCalendarorder(0);
            $calendar->setCalendarcolor('');
            $calendar->setTimezone('');
            $calendar->setComponents('VEVENT');

            $calendar->setTodos((bool)$data['todos']);
            $calendar->setDisplayname($data['displayname']);
            $calendar->setDescription($data['description']);

            $em->persist($calendar);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Calendar <i class="fa fa-calendar"></i> <strong>' . htmlspecialchars($calendar->getDisplayname()) . '</strong> has been created.');
            return $this->redirect($this->generateUrl('netgusto_baikal_admin_user_calendar_list', array('id' => $user->getId())));
        }

        return $this->render('NetgustoBaikalAdminBundle:Calendar/Form:new+edit.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));
    }

    public function editAction(Request $request, User $user, Calendar $calendar) {

        $formBuilder = $this->getFormBase();

        $form = $formBuilder->setData(array(
            'displayname' => $calendar->getDisplayname(),
            'description' => $calendar->getDescription(),
            'todos' => $calendar->getTodos(),
        ))->getForm();
        $form->handleRequest($request);

        if($form->isValid()) {

            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();

            # Persisting calendar
            $calendar->setTodos((bool)$data['todos']);
            $calendar->setDisplayname($data['displayname']);
            $calendar->setDescription($data['description']);

            $em->persist($calendar);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Calendar <i class="fa fa-calendar"></i> <strong>' . htmlspecialchars($calendar->getDisplayname()) . '</strong> has been updated.');
            return $this->redirect($this->generateUrl('netgusto_baikal_admin_user_calendar_list', array('id' => $user->getId())));
        }

        $events = $this->getDoctrine()->getManager()
            ->getRepository('\Netgusto\Baikal\DavServicesBundle\Entity\CalendarEvent')
            ->findByCalendarAndTimeRange($calendar, new \DateTime('2013-09-06 00:00:00 UTC'), new \DateTime('2013-09-07 00:00:00 UTC'));

        $aHtml = array();
        foreach($events as $event) {
            if(!$event->isCalendarEvent()) {
                continue;
            }

            $calendardata = '<strong>' . htmlentities($event->getSummary()) . '</strong><br />' . htmlentities($event->getDescription()) . '<br />';
            $calendardata .= '<em>' . $event->getStart()->format(\DateTime::RFC850) . ':' . $event->getEnd()->format(\DateTime::RFC850) . '</em><br />';
            $calendardata .= '<pre>' . print_r($event->getVObject()->jsonSerialize(), TRUE) . '</pre>';
            $aHtml[] = $calendardata;
        }

        return $this->render('NetgustoBaikalAdminBundle:Calendar/Form:new+edit.html.twig', array(
            'form' => $form->createView(),
            'user' => $user,
            'calendar' => $calendar,
            'events' => implode('<hr />', $aHtml),
        ));
    }

    protected function getFormBase() {

        return $this->createFormBuilder()
            ->add('displayname', 'text', array(
                "label" => "Display name",
                'constraints' => array(
                    new NotBlank(),
                )
            ))
            ->add('description', 'text', array(
                "label" => "Description",
                'constraints' => array(
                    new NotBlank(),
                )
            ))
            ->add('todos', 'checkbox', array(
                "label" => "Todos",
            ));
    }
}
