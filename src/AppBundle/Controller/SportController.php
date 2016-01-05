<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Sport;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SportController extends Controller
{
    /**
     * @Route("/sport/", name="sport_home")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }


    /**
     * @Route("/sport/create", name="sport_create")
     */
    public function createAction(Request $request)
    {

        $sport = new Sport(); 




        $form = $this->createFormBuilder($sport)
            ->add('name', TextType::class)
            ->add('description', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Sport'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database

            $sport->save();
            /*$em = $this->getDoctrine()->getManager();

            $em->persist($sport);
            $em->flush();*/

            return $this->redirectToRoute('task_success');
        }


        // replace this example code with whatever you need
        return $this->render('sport/create.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/sport/view/{id}", name="sport_view")
     */
    public function viewAction($id, Request $request)
    {
        $sport = Sport::getOne($id);
        //die($au->getName().$au->getContactNu());
        return $this->render('sport/view.html.twig', array('sport' => $sport));
        //return $this->render('sport/viewall.html.twig', array('depts' => $depts));
    }

    /**
     * @Route("/sport/view", name="sport_viewall")
     */
    public function viewallAction(Request $request)
    {
        $sports = Sport::getAll();
        //die($au->getName().$au->getContactNu());
        return $this->render('sport/viewall.html.twig', array('sports' => $sports));
        //return $this->render('sport/viewall.html.twig', array('depts' => $depts));
    }


}