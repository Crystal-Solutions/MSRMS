<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Faculty;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FacultyController extends Controller
{
    /**
     * @Route("/faculty/", name="faculty_home")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }


    /**
     * @Route("/faculty/create", name="faculty_home")
     */
    public function createAction(Request $request)
    {

        $faculty = new Faculty(); 




        $form = $this->createFormBuilder($faculty)
            ->add('name', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Faculty'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database

            $faculty->save();
            /*$em = $this->getDoctrine()->getManager();

            $em->persist($faculty);
            $em->flush();*/

            return $this->redirectToRoute("task_success");
        }


        // replace this example code with whatever you need
        return $this->render('faculty/create.html.twig', array('form' => $form->createView()));
    }
 
}
