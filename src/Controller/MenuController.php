<?php
/**
 * Created by PhpStorm.
 * User: Janis
 * Date: 2018.11.08.
 * Time: 11:58
 */

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\Passanger;
use App\Entity\Ticket;
use App\Entity\Trip;
use App\Form\Type\PassangerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class MenuController extends AbstractController
{

    const ENTITIES = [
        'passanger' => Passanger::class,
        'trip' => Trip::class,
        'customer' => Customer::class,
        'ticket' => Ticket::class
    ];

    /**
     * @Route("/", name="menu")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function menuAction()
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('login');
        }
        $passangers = $this->getDoctrine()
            ->getRepository(self::ENTITIES['passanger'])
            ->findAll();
        $trips = $this->getDoctrine()
            ->getRepository(self::ENTITIES['trip'])
            ->findAll();

        return $this->render('menu/index.html.twig', array(
            'passangers' => $passangers,
            'trips' => $trips
        ));
    }

    /**
     * @Route("/", name="menu")
     *  Method({"GET","POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cusstomerUpdate(Request $request)
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('login');
        }

        $customer = $this->get('security.token_storage')->getToken()->getUser();

        $form = $this->createFormBuilder($customer)
            ->add('email', EmailType::class, array(
                'attr' => array('class' => 'form-control')
            ))
            ->add('name', TextType::class, array(
                'attr' => array('class' => 'form-control')
            ))
            ->add('address', TextType::class, array(
                'attr' => array('class' => 'form-control')
            ))
            ->add('city', TextType::class, array(
                'attr' => array('class' => 'form-control')
            ))
            ->add('country', TextType::class, array(
                'attr' => array('class' => 'form-control')
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Save',
                'attr' => array('class' => 'btn btn-primary')
            ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $customer = $form->getData();

            $passangerManager = $this->getDoctrine()->getManager();
            $passangerManager->flush();
            return $this->redirectToRoute('menu');
        }
        $passangers = $this->getDoctrine()
            ->getRepository(self::ENTITIES['passanger'])
            ->findAll();
        $trips = $this->getDoctrine()
            ->getRepository(self::ENTITIES['trip'])
            ->findAll();

        return $this->render('menu/index.html.twig', array(
            'passangers' => $passangers,
            'trips' => $trips,
            'label' => 'Basic Info',
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/passanger", name="new_passanger")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function passangerNew(Request $request)
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('login');
        }

        $passanger = new Passanger();

        $form = $this->createFormBuilder($passanger)
            ->add('title', ChoiceType::class, array(
                'choices' => array('Mr' => 'Mr', 'Mrs' => 'Mrs'),
                'attr' => array('class' => 'form-control')
            ))
            ->add('name', TextType::class, array(
                'attr' => array('class' => 'form-control')
            ))
            ->add('surname', TextType::class, array(
                'attr' => array('class' => 'form-control')
            ))
            ->add('passport_id', TextType::class, array(
                'attr' => array('class' => 'form-control')
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Add',
                'attr' => array('class' => 'btn btn-primary')
            ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $passangerManager = $this->getDoctrine()->getManager();
            $passangerManager->persist($passanger);
            $passangerManager->flush();

            return $this->redirectToRoute('menu');
        }

        return $this->render('menu/add.html.twig', array(
            'label' => 'Add Passanger',
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/trip", name="new_trip")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function tripNew(Request $request)
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('login');
        }

        $data = [];
        $form = $this->createFormBuilder($data)
            ->add('where_from', TextType::class, array(
                'attr' => array('class' => 'form-control')
            ))
            ->add('where_to', TextType::class, array(
                'attr' => array('class' => 'form-control')
            ))
            ->add('departure', DateTimeType::class, array(
                'placeholder' => array(
                    'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                    'hour' => 'Hour', 'minute' => 'Minute', 'second' => 'Second',
                ),
                'with_minutes' => true
            ))
            ->add('arrival', DateTimeType::class, array(
                'placeholder' => array(
                    'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                    'hour' => 'Hour', 'minute' => 'Minute', 'second' => 'Second',
                ),
                'with_minutes' => true
            ))
            ->add('passangers', EntityType::class, [
                'class' => self::ENTITIES['passanger'],
                'choice_label' => function (Passanger $passanger) {
                    return $passanger->getTitle() . ' ' . $passanger->getName() . ' ' . $passanger->getSurname();
                },
                'required' => false,
                'multiple' => true,
                'expanded' => true
            ])
            ->add('save', SubmitType::class, array(
                'label' => 'Save',
                'attr' => array('class' => 'btn btn-primary')
            ))
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $trip = new Trip();
            $trip->setArrival($data['arrival'])
                ->setDeparture($data['departure'])
                ->setWhereFrom($data['where_from'])
                ->setWhereTo($data['where_to']);

            foreach ($data['passangers'] as $passanger) {
                $ticket = new Ticket();
                $ticket->setTrip($trip);
                $ticket->setPassanger($passanger);
                $entityManager->persist($ticket);

            }
            $entityManager->persist($trip);
            $entityManager->flush();
            return $this->redirectToRoute('menu');
        }

        return $this->render('menu/add.html.twig', array(
            'label' => 'Add Trip',
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/delete/{entity}/{id}")
     * @Method({"DELETE"})
     * @param Request $request
     * @param $entity
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Request $request, $entity, $id)
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('login');
        }

        $entity = $this->getDoctrine()->getRepository(self::ENTITIES[$entity])->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($entity);
        $entityManager->flush();

        $response = new Response();
        $response->send();
    }


}