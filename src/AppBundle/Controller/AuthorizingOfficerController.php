<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\AuthorizingOfficer;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AuthorizingOfficerController extends Controller{

    /**
     * @Route("/authorizingOfficer/", name="authOfficer_home")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('authorizingOfficer/create.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }

    /**
     * @Route("/authorizingOfficer/create", name="authOfficer_home")
     */
    public function createAction(Request $request)
    {

        $authorizingOfficer = new AuthorizingOfficer();

        $form = $this->createFormBuilder($authorizingOfficer)
            ->add('name', TextType::class)
            ->add('contactNu', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Authorizing Officer'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database

            $authorizingOfficer->save();

            return $this->redirectToRoute('task_success');
        }


        // replace this example code with whatever you need
        return $this->render('authorizingOfficer/create.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/authorizingOfficer/view", name="authOfficer_view")
     */
    public function viewAction(Request $request)
    {
        //give the id of the person we need to view
        //$au = AuthorizingOfficer::getOne(1);

        $officers = AuthorizingOfficer::getAll();
        //die($au->getName().$au->getContactNu());
        //return $this->render('authorizingOfficer/view.html.twig', array('officer' => $au));

        return $this->render('authorizingOfficer/viewall.html.twig', array('officers' => $officers));

    }
}