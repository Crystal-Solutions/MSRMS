<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
            ->add('contactNu', IntegerType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Authorizing Officer'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database

            $em = $this->getDoctrine()->getManager();

            $em->persist($player);
            $em->flush();

            return $this->redirectToRoute('task_success');
        }


        // replace this example code with whatever you need
        return $this->render('authorizingOfficer/create.html.twig', array('form' => $form->createView()));
    }
}